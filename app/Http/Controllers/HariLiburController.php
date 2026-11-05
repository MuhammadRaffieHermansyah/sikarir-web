<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HariLiburController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tahun = (int) $request->input('tahun', $request->input('year', now()->year));

        // Hanya mencegah input ngawur, bukan batas ketersediaan data.
        if ($tahun < 1900 || $tahun > 9999) {
            return response()->json(['error' => 'Tahun tidak valid.'], 422);
        }

        if (! $this->adaData($tahun)) {
            $this->sinkronDariApi($tahun);
        }

        $tanggal = HariLibur::whereBetween('tanggal', ["{$tahun}-01-01", "{$tahun}-12-31"])
            ->orderBy('tanggal')
            ->get()
            ->map(fn ($h) => $h->tanggal->format('Y-m-d'))
            ->all();

        return response()->json([
            'tahun'      => $tahun,
            'hari_libur' => $tanggal,
            'tersedia'   => count($tanggal) > 0,
        ]);
    }

    private function adaData(int $tahun): bool
    {
        return HariLibur::whereBetween('tanggal', ["{$tahun}-01-01", "{$tahun}-12-31"])->exists();
    }

    private function sinkronDariApi(int $tahun): void
    {
        // Maksimal 1x percobaan per 6 jam per tahun, supaya tahun yang
        // memang belum ada datanya tidak memanggil API terus-menerus.
        if (! Cache::add("sinkron_libur_{$tahun}", true, now()->addHours(6))) {
            return;
        }

        try {
            $response = Http::timeout(8)->retry(2, 300)->acceptJson()
                ->get('https://tanggalmerah.upset.dev/api/holidays', ['year' => $tahun]);

            if (! $response->successful()) {
                Log::warning("HariLibur: API membalas {$response->status()} untuk tahun {$tahun}");
                return;
            }

            $rows = collect($response->json('data', []))
                ->filter(fn ($i) => isset($i['date']))
                // Mau cuti bersama TIDAK dihitung? Tambahkan:
                // ->filter(fn ($i) => ($i['type'] ?? '') === 'holiday')
                ->map(fn ($i) => [
                    'tanggal'    => Carbon::parse($i['date'])->toDateString(),
                    'keterangan' => ($i['name'] ?? 'Hari libur')
                                    . (($i['type'] ?? '') === 'leave' ? ' (Cuti Bersama)' : ''),
                    'sumber'     => 'api',
                ])
                ->unique('tanggal')
                ->values()
                ->all();

            if ($rows) {
                HariLibur::upsert($rows, ['tanggal'], ['keterangan']);
            } else {
                Log::warning("HariLibur: API tidak mengembalikan data untuk tahun {$tahun}");
            }
        } catch (\Throwable $e) {
            Log::warning("HariLibur: sinkron gagal tahun {$tahun}: " . $e->getMessage());
        }
    }
}
