<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HariLiburController extends Controller
{
    /**
     * Kembalikan daftar hari libur nasional Indonesia untuk tahun tertentu.
     * Data di-cache 24 jam supaya tidak terus-menerus hit API eksternal.
     *
     * Sumber: https://api-harilibur.vercel.app/api (gratis, no-auth)
     */
    public function index(Request $request): JsonResponse
    {
        $tahun = (int) $request->input('tahun', now()->year);

        // Validasi tahun masuk akal (2020–2050)
        if ($tahun < 2020 || $tahun > 2050) {
            return response()->json(['error' => 'Tahun tidak valid.'], 422);
        }

        $cacheKey = "hari_libur_nasional_{$tahun}";

        $hariLibur = Cache::remember($cacheKey, now()->addHours(24), function () use ($tahun) {
            return $this->fetchHariLibur($tahun);
        });

        return response()->json([
            'tahun'      => $tahun,
            'hari_libur' => $hariLibur,
        ]);
    }

    /**
     * Fetch hari libur dari dua sumber: API utama + fallback.
     * Mengembalikan array of date strings dalam format 'Y-m-d'.
     */
    private function fetchHariLibur(int $tahun): array
    {
        // Sumber 1: api-harilibur.vercel.app
        try {
            $response = Http::timeout(8)->get("https://api-harilibur.vercel.app/api", [
                'year' => $tahun,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && count($data) > 0) {
                    return collect($data)
                        ->filter(fn($item) => isset($item['holiday_date']) && (bool)($item['is_national_holiday'] ?? true))
                        ->pluck('holiday_date')
                        ->map(fn($d) => substr($d, 0, 10)) // pastikan Y-m-d
                        ->unique()
                        ->values()
                        ->toArray();
                }
            }
        } catch (\Exception $e) {
            Log::warning("HariLiburController: API utama gagal untuk tahun {$tahun}: " . $e->getMessage());
        }

        // Sumber 2: Fallback – hari libur nasional hardcoded untuk tahun berjalan
        // (ini menjadi fallback jika API tidak tersedia)
        return $this->hardcodedHolidays($tahun);
    }

    /**
     * Hari libur nasional Indonesia hardcoded sebagai fallback.
     * Berisi hari libur tetap + estimasi hari libur keagamaan umum.
     */
    private function hardcodedHolidays(int $tahun): array
    {
        // Hari libur nasional tetap (selalu di tanggal yang sama setiap tahun)
        $fixed = [
            "{$tahun}-01-01", // Tahun Baru
            "{$tahun}-02-05", // Isra Mi'raj (estimasi, berubah setiap tahun)
            "{$tahun}-03-29", // Hari Raya Nyepi (estimasi)
            "{$tahun}-03-30", // Cuti Nyepi (estimasi)
            "{$tahun}-04-18", // Jumat Agung (estimasi)
            "{$tahun}-05-01", // Hari Buruh
            "{$tahun}-05-29", // Kenaikan Isa Almasih (estimasi)
            "{$tahun}-06-01", // Hari Lahir Pancasila
            "{$tahun}-08-17", // HUT RI
            "{$tahun}-12-25", // Natal
            "{$tahun}-12-26", // Cuti Bersama Natal
        ];

        // Hari Raya Idul Fitri & Idul Adha (estimasi berubah tiap tahun)
        $variable = match ($tahun) {
            2024 => [
                '2024-03-29', '2024-04-08', '2024-04-09', '2024-04-10', '2024-04-11', '2024-04-12',
                '2024-05-10', '2024-05-24', '2024-12-26',
            ],
            2025 => [
                '2025-01-27', '2025-01-28', '2025-01-29', '2025-01-30', '2025-01-31',
                '2025-03-28', '2025-03-29', '2025-03-30', '2025-03-31',
                '2025-04-01', '2025-04-02', '2025-04-03', '2025-04-04',
                '2025-06-07', '2025-06-09',
            ],
            2026 => [
                '2026-01-19', '2026-01-20',
                '2026-03-20', '2026-03-23', '2026-03-24', '2026-03-25',
                '2026-03-26', '2026-03-27', '2026-03-30', '2026-03-31',
                '2026-05-27', '2026-05-28', '2026-05-29',
                '2026-09-15', '2026-12-28',
            ],
            default => [],
        };

        return collect(array_merge($fixed, $variable))
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }
}
