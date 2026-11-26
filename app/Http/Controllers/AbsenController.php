<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ExportsXlsx;
use App\Models\Absen;
use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\Peserta;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AbsenController extends Controller
{
    use ExportsXlsx;

    public function index(Request $request): View
    {
        $query = Absen::with(['peserta:id_peserta,id_user,nama', 'peserta.user:id,email', 'jadwal:id_jadwal,id_pelatihan', 'jadwal.pelatihan:id_pelatihan,nama_pelatihan']);
        $this->scopeToOwnPeserta($query, $request);

        // Filter Pencarian (Nama Peserta, Email, atau Nama Pelatihan)
        if ($request->filled('search')) {
            $like = $this->likePattern($request->string('search')->toString());
            $query->where(function ($q) use ($like) {
                $q->whereIn('id_peserta', Peserta::select('id_peserta')
                    ->where('nama', 'like', $like)
                    ->orWhereIn('id_user', User::select('id')->where('email', 'like', $like)))
                    ->orWhereIn('id_jadwal', JadwalPelatihan::select('id_jadwal')
                        ->whereIn('id_pelatihan', DaftarPelatihan::select('id_pelatihan')->where('nama_pelatihan', 'like', $like)));
            });
        }

        // Filter Status Kehadiran (Hadir, Izin, Sakit, Alfa)
        if ($request->filled('status')) {
            $query->where('status_kehadiran', $request->status);
        }

        // Ambil data terbaru berdasarkan id_absen dengan pagination & pertahankan query string URL
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

        $jadwals = JadwalPelatihan::with('pelatihan:id_pelatihan,nama_pelatihan')->orderByDesc('id_jadwal')->get();

        return view('absen.rekap', $rekap + compact('absens', 'jadwals'));
    }

    /**
     * Ekspor rekapitulasi kehadiran per peserta ke file Excel (.xlsx) berformat tabel.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $rekap = $this->buildRekap($this->validateRekapFilters($request));
        $jadwal = $rekap['selectedJadwal'];

        return $this->xlsx('rekap-absensi', 'Rekapitulasi Kehadiran Peserta', [
            'No', 'No. Peserta', 'Nama Peserta', 'Email', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Total Sesi', 'Persentase Hadir (%)', 'Status Kelayakan',
        ], $rekap['rekapPeserta']->map(fn ($rp, int $i): array => [
            $i + 1,
            $rp->peserta->nomor_peserta ?? '-',
            $rp->peserta->nama ?? '-',
            $rp->peserta->user->email ?? '-',
            $rp->hadir,
            $rp->izin,
            $rp->sakit,
            $rp->alpha,
            $rp->total,
            $rp->persentase,
            $rp->status_lulus,
        ])->all(), $jadwal ? 'Jadwal: '.($jadwal->pelatihan->nama_pelatihan ?? '-') : null);
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
            'id_peserta' => [
                'required',
                'exists:pesertas,id_peserta',
                Rule::exists('kelas_pelatihan', 'id_peserta')->where('id_jadwal', $request->input('id_jadwal')),
            ],
            'id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal' => [
                'required',
                'date',
                $this->tanggalDalamPeriodeJadwal($request->input('id_jadwal')),
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
            'id_peserta.exists' => 'Peserta belum terdaftar pada kelas jadwal yang dipilih.',
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
            'id_peserta' => [
                'required',
                'exists:pesertas,id_peserta',
                Rule::exists('kelas_pelatihan', 'id_peserta')->where('id_jadwal', $request->input('id_jadwal')),
            ],
            'id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal' => [
                'required',
                'date',
                $this->tanggalDalamPeriodeJadwal($request->input('id_jadwal')),
                Rule::unique('absens')->where(fn ($query) => $query
                    ->where('id_peserta', $request->input('id_peserta'))
                    ->where('id_jadwal', $request->input('id_jadwal'))
                )->ignore($absen->id_absen, 'id_absen'),
            ],
            'jam_hadir' => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'id_peserta.exists' => 'Peserta belum terdaftar pada kelas jadwal yang dipilih.',
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
     * Tolak tanggal presensi di luar periode pelatihan (mis. salah ketik tahun).
     */
    private function tanggalDalamPeriodeJadwal(mixed $idJadwal): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) use ($idJadwal): void {
            $jadwal = $idJadwal ? JadwalPelatihan::find($idJadwal) : null;
            $tanggal = strtotime((string) $value);

            if (! $jadwal || ! $tanggal || ! $jadwal->tanggal_mulai || ! $jadwal->tanggal_selesai) {
                return;
            }

            $tanggal = date('Y-m-d', $tanggal);
            if ($tanggal < $jadwal->tanggal_mulai->toDateString() || $tanggal > $jadwal->tanggal_selesai->toDateString()) {
                $fail('Tanggal presensi di luar periode pelatihan ('.$jadwal->tanggal_mulai->format('d/m/Y').' - '.$jadwal->tanggal_selesai->format('d/m/Y').').');
            }
        };
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
            ->when($filters['tanggal_mulai'], fn (Builder $q, $v) => $q->where('tanggal', '>=', $v))
            ->when($filters['tanggal_selesai'], fn (Builder $q, $v) => $q->where('tanggal', '<=', $v))
            ->when($filters['status'], fn (Builder $q, $v) => $q->whereIn('status_kehadiran', $v === 'alpha' ? ['alpha', 'alpa'] : [$v]));
    }

    /**
     * @param  array<string, ?string>  $filters
     * @return array<string, mixed>
     */
    private function buildRekap(array $filters): array
    {
        $alpha = "('alpha', 'alpa')";
        $rows = $this->rekapQuery($filters)
            ->selectRaw("id_peserta, COUNT(*) AS total,
                SUM(CASE WHEN status_kehadiran = 'hadir' THEN 1 ELSE 0 END) AS hadir,
                SUM(CASE WHEN status_kehadiran = 'izin' THEN 1 ELSE 0 END) AS izin,
                SUM(CASE WHEN status_kehadiran = 'sakit' THEN 1 ELSE 0 END) AS sakit,
                SUM(CASE WHEN status_kehadiran IN {$alpha} THEN 1 ELSE 0 END) AS alpha")
            ->groupBy('id_peserta')
            ->get()
            ->keyBy('id_peserta');

        // Sesi yang sudah selesai tanpa catatan presensi dihitung alpha (tidak berlaku saat
        // memfilter status hadir/izin/sakit).
        $alphaOtomatis = in_array($filters['status'], [null, 'alpha'], true)
            ? SesiPresensi::alphaTanpaCatatan($filters)->map(fn ($perJadwal): int => (int) $perJadwal->sum())
            : collect();

        $idPesertas = $rows->keys()->merge($alphaOtomatis->keys())->unique();

        $pesertas = Peserta::with('user:id,email')
            ->whereIn('id_peserta', $idPesertas)
            ->get()
            ->keyBy('id_peserta');

        $rekapPeserta = $idPesertas->map(function ($idPeserta) use ($rows, $pesertas, $alphaOtomatis) {
            $row = $rows->get($idPeserta);
            $tambahanAlpha = (int) $alphaOtomatis->get($idPeserta, 0);
            $hadir = (int) ($row->hadir ?? 0);
            $total = (int) ($row->total ?? 0) + $tambahanAlpha;
            $persentase = $total > 0 ? round($hadir / $total * 100, 1) : 0;

            return (object) [
                'peserta' => $pesertas->get($idPeserta),
                'hadir' => $hadir,
                'izin' => (int) ($row->izin ?? 0),
                'sakit' => (int) ($row->sakit ?? 0),
                'alpha' => (int) ($row->alpha ?? 0) + $tambahanAlpha,
                'total' => $total,
                'persentase' => $persentase,
                'status_lulus' => $persentase >= 80 ? 'Memenuhi Syarat' : 'Perlu Perhatian',
            ];
        })->sortBy(fn ($rp) => $rp->peserta->nomor_peserta ?? '')->values();

        $total = $rekapPeserta->sum('total');
        $totalHadir = $rekapPeserta->sum('hadir');

        return [
            'selectedJadwal' => $filters['id_jadwal']
                ? JadwalPelatihan::with(['pelatihan', 'instruktur', 'ruanganWorkshop'])->find($filters['id_jadwal'])
                : null,
            'rekapPeserta' => $rekapPeserta,
            'totalHadir' => $totalHadir,
            'totalIzin' => $rekapPeserta->sum('izin'),
            'totalSakit' => $rekapPeserta->sum('sakit'),
            'totalAlpha' => $rekapPeserta->sum('alpha'),
            'persenHadir' => $total > 0 ? round($totalHadir / $total * 100, 1) : 0,
        ];
    }
}
