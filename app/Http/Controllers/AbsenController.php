<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\JadwalPelatihan;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AbsenController extends Controller
{
    public function index(Request $request): View
    {
        $query = Absen::with(['peserta.user', 'jadwal.pelatihan']);
        $this->scopeToOwnPeserta($query, $request);

        // Filter Pencarian (Nama Peserta, Email, atau Nama Pelatihan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('peserta.user', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('jadwal.pelatihan', function ($sub) use ($search) {
                    $sub->where('nama_pelatihan', 'like', "%{$search}%");
                });
            });
        }

        // Filter Status Kehadiran (Hadir, Izin, Sakit, Alfa)
        if ($request->filled('status')) {
            $query->where('status_kehadiran', $request->status);
        }

        $absens = $query->latest('id_absen')
            ->paginate(10)
            ->withQueryString();

        return view('absen.index', compact('absens'));
    }

    /**
     * Halaman rekapitulasi kehadiran (khusus admin BLK).
     */
    public function rekap(Request $request): View
    {
        $filters = $this->validateRekapFilters($request);
        $rekap = $this->buildRekap($filters);

        $absens = $this->rekapQuery($filters)
            ->with(['peserta.user', 'jadwal.pelatihan'])
            ->latest('tanggal')
            ->latest('id_absen')
            ->paginate(15)
            ->withQueryString();

        $jadwals = JadwalPelatihan::with('pelatihan')->orderByDesc('id_jadwal')->get();

        return view('absen.rekap', $rekap + compact('absens', 'jadwals'));
    }

    /**
     * Ekspor rekapitulasi kehadiran per peserta ke CSV (dapat dibuka di Excel).
     */
    public function export(Request $request): StreamedResponse
    {
        $rekap = $this->buildRekap($this->validateRekapFilters($request));
        $filename = 'rekap-absensi-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($rekap) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['No', 'No. Peserta', 'Nama Peserta', 'Email', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Total Sesi', 'Persentase Hadir (%)', 'Status Kelayakan']);

            foreach ($rekap['rekapPeserta'] as $i => $rp) {
                fputcsv($out, [
                    $i + 1,
                    $this->csvSafe((string) ($rp->peserta->nomor_peserta ?? '-')),
                    $this->csvSafe((string) ($rp->peserta->user->name ?? '-')),
                    $this->csvSafe((string) ($rp->peserta->user->email ?? '-')),
                    $rp->hadir,
                    $rp->izin,
                    $rp->sakit,
                    $rp->alpha,
                    $rp->total,
                    $rp->persentase,
                    $rp->status_lulus,
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Halaman cetak laporan resmi (print / simpan PDF dari browser).
     */
    public function cetak(Request $request): View
    {
        $rekap = $this->buildRekap($this->validateRekapFilters($request));

        return view('absen.cetak', $rekap);
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->orderBy('nomor_peserta')->get();
        $jadwals = JadwalPelatihan::with('pelatihan')->orderBy('id_jadwal', 'desc')->get();

        return view('absen.create', compact('pesertas', 'jadwals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_peserta' => 'required|exists:pesertas,id_peserta',
            'id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('absens')->where(fn ($query) => $query
                    ->where('id_peserta', $request->input('id_peserta'))
                    ->where('id_jadwal', $request->input('id_jadwal'))),
            ],
            'jam_hadir' => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'id_peserta.required' => 'Siswa peserta wajib dipilih.',
            'id_jadwal.required' => 'Batch jadwal kelas wajib dipilih.',
            'tanggal.required' => 'Tanggal presensi wajib diisi.',
            'tanggal.unique' => 'Data presensi untuk siswa ini pada tanggal tersebut sudah tercatat.',
            'jam_hadir.date_format' => 'Format jam hadir tidak valid (contoh: 08:00).',
            'status_kehadiran.required' => 'Status kehadiran wajib ditentukan.',
            'status_kehadiran.in' => 'Status kehadiran tidak valid.',
        ]);

        Absen::create($validated);

        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil disimpan.');
    }

    public function show(Request $request, int $id): View
    {
        $query = Absen::with(['peserta.user', 'jadwal.pelatihan']);
        $this->scopeToOwnPeserta($query, $request);
        $absen = $query->findOrFail($id);

        return view('absen.show', compact('absen'));
    }

    public function edit(int $id): View
    {
        $absen = Absen::findOrFail($id);
        $pesertas = Peserta::with('user')->orderBy('nomor_peserta')->get();
        $jadwals = JadwalPelatihan::with('pelatihan')->get();

        return view('absen.edit', compact('absen', 'pesertas', 'jadwals'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $absen = Absen::findOrFail($id);

        $validated = $request->validate([
            'id_peserta' => 'required|exists:pesertas,id_peserta',
            'id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('absens')->where(fn ($query) => $query
                    ->where('id_peserta', $request->input('id_peserta'))
                    ->where('id_jadwal', $request->input('id_jadwal'))
                )->ignore($absen->id_absen, 'id_absen'),
            ],
            'jam_hadir' => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'tanggal.unique' => 'Data presensi untuk siswa ini pada tanggal tersebut sudah tercatat.',
            'jam_hadir.date_format' => 'Format jam hadir tidak valid (contoh: 08:00).',
            'status_kehadiran.in' => 'Status kehadiran tidak valid.',
        ]);

        $absen->update($validated);

        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();

        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil dihapus.');
    }

    /**
     * Peserta hanya boleh melihat data absensinya sendiri.
     */
    private function scopeToOwnPeserta(Builder $query, Request $request): void
    {
        $user = $request->user();

        if ($user?->role === 'peserta') {
            $query->where('id_peserta', $user->peserta?->id_peserta ?? 0);
        }
    }

    /**
     * @return array{id_jadwal: ?string, tanggal_mulai: ?string, tanggal_selesai: ?string, status: ?string}
     */
    private function validateRekapFilters(Request $request): array
    {
        $validated = $request->validate([
            'id_jadwal' => 'nullable|integer|exists:jadwal_pelatihan,id_jadwal',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:hadir,izin,sakit,alpha',
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        return $validated + ['id_jadwal' => null, 'tanggal_mulai' => null, 'tanggal_selesai' => null, 'status' => null];
    }

    /**
     * @param  array<string, ?string>  $filters
     */
    private function rekapQuery(array $filters): Builder
    {
        return Absen::query()
            ->when($filters['id_jadwal'], fn (Builder $q, $v) => $q->where('id_jadwal', $v))
            ->when($filters['tanggal_mulai'], fn (Builder $q, $v) => $q->whereDate('tanggal', '>=', $v))
            ->when($filters['tanggal_selesai'], fn (Builder $q, $v) => $q->whereDate('tanggal', '<=', $v))
            ->when($filters['status'], fn (Builder $q, $v) => $q->whereIn('status_kehadiran', $v === 'alpha' ? ['alpha', 'alpa'] : [$v]));
    }

    /**
     * @param  array<string, ?string>  $filters
     * @return array<string, mixed>
     */
    private function buildRekap(array $filters): array
    {
        $records = $this->rekapQuery($filters)->with('peserta.user')->get();

        $rekapPeserta = $records->groupBy('id_peserta')->map(function ($rows) {
            $hadir = $rows->where('status_kehadiran', 'hadir')->count();
            $total = $rows->count();
            $persentase = $total > 0 ? round($hadir / $total * 100, 1) : 0;

            return (object) [
                'peserta' => $rows->first()->peserta,
                'hadir' => $hadir,
                'izin' => $rows->where('status_kehadiran', 'izin')->count(),
                'sakit' => $rows->where('status_kehadiran', 'sakit')->count(),
                'alpha' => $rows->whereIn('status_kehadiran', ['alpha', 'alpa'])->count(),
                'total' => $total,
                'persentase' => $persentase,
                'status_lulus' => $persentase >= 80 ? 'Memenuhi Syarat' : 'Perlu Perhatian',
            ];
        })->sortBy(fn ($rp) => $rp->peserta->nomor_peserta ?? '')->values();

        $total = $records->count();
        $totalHadir = $records->where('status_kehadiran', 'hadir')->count();

        return [
            'selectedJadwal' => $filters['id_jadwal']
                ? JadwalPelatihan::with(['pelatihan', 'instruktur', 'ruanganWorkshop'])->find($filters['id_jadwal'])
                : null,
            'rekapPeserta' => $rekapPeserta,
            'totalHadir' => $totalHadir,
            'totalIzin' => $records->where('status_kehadiran', 'izin')->count(),
            'totalSakit' => $records->where('status_kehadiran', 'sakit')->count(),
            'totalAlpha' => $records->whereIn('status_kehadiran', ['alpha', 'alpa'])->count(),
            'persenHadir' => $total > 0 ? round($totalHadir / $total * 100, 1) : 0,
        ];
    }

    /**
     * Cegah formula injection saat CSV dibuka di Excel.
     */
    private function csvSafe(string $value): string
    {
        return preg_match('/^[=+\-@\t\r]/', $value) ? "'".$value : $value;
    }
}
