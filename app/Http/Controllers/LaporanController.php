<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ExportsXlsx;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\LamaranLowongan;
use App\Models\Peserta;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Pusat laporan admin BLK: ekspor data peserta, pendaftaran kelas,
 * sertifikat, dan lamaran kerja ke file Excel (.xlsx) berformat tabel.
 */
class LaporanController extends Controller
{
    use ExportsXlsx;

    /** @var list<string> */
    public const STATUS_LAMARAN = ['melamar', 'diproses', 'wawancara', 'diterima', 'ditolak'];

    public function index(): View
    {
        $jadwals = JadwalPelatihan::with('pelatihan:id_pelatihan,nama_pelatihan')->orderByDesc('id_jadwal')->get();

        $jumlah = [
            'peserta' => Peserta::count(),
            'pendaftaran' => KelasPelatihan::count(),
            'sertifikat' => Sertifikat::count(),
            'lamaran' => LamaranLowongan::count(),
        ];

        return view('laporan.index', [
            'jadwals' => $jadwals,
            'jumlah' => $jumlah,
            'statusLamaran' => self::STATUS_LAMARAN,
        ]);
    }

    public function peserta(): BinaryFileResponse
    {
        $pesertas = Peserta::with('user:id,email')->withCount(['kelas', 'sertifikat'])->orderBy('nomor_peserta')->get();

        return $this->xlsx('laporan-data-peserta', 'Laporan Data Peserta', [
            'No', 'No. Peserta', 'Nama', 'Email', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'No. WA',
            'Pendidikan Terakhir', 'Jurusan', 'Disabilitas', 'Alamat', 'Jumlah Kelas', 'Jumlah Sertifikat',
        ], $pesertas->map(fn (Peserta $p, int $i): array => [
            $i + 1,
            $p->nomor_peserta,
            $p->nama,
            $p->user?->email,
            $p->jenis_kelamin,
            $p->tempat_lahir,
            $p->tanggal_lahir?->format('d/m/Y'),
            $p->nomor_wa,
            $p->pendidikan_terakhir,
            $p->jurusan,
            $p->is_disabilitas ? 'Ya'.($p->jenis_disabilitas ? " ({$p->jenis_disabilitas})" : '') : 'Tidak',
            $p->alamat_lengkap,
            $p->kelas_count,
            $p->sertifikat_count,
        ])->all());
    }

    public function pendaftaran(Request $request): BinaryFileResponse
    {
        $filters = $request->validate(['id_jadwal' => 'nullable|exists:jadwal_pelatihan,id_jadwal']);

        $kelas = KelasPelatihan::with(['peserta.user:id,email', 'jadwal.pelatihan:id_pelatihan,nama_pelatihan', 'jadwal.instruktur:id,nama'])
            ->when($filters['id_jadwal'] ?? null, fn ($q, $id) => $q->where('id_jadwal', $id))
            ->orderBy('id_jadwal')
            ->orderBy('id_kelas')
            ->get();

        return $this->xlsx('laporan-pendaftaran-kelas', 'Laporan Pendaftaran Kelas Pelatihan', [
            'No', 'Program Pelatihan', 'Periode', 'Instruktur', 'No. Peserta', 'Nama Peserta', 'Email', 'Status', 'Tanggal Daftar',
        ], $kelas->map(fn (KelasPelatihan $k, int $i): array => [
            $i + 1,
            $k->jadwal?->pelatihan?->nama_pelatihan,
            $this->periode($k->jadwal),
            $k->jadwal?->instruktur?->nama,
            $k->peserta?->nomor_peserta,
            $k->peserta?->nama,
            $k->peserta?->user?->email,
            ucfirst((string) $k->status),
            $k->created_at?->format('d/m/Y'),
        ])->all(), $this->keteranganJadwal($filters['id_jadwal'] ?? null));
    }

    public function sertifikat(Request $request): BinaryFileResponse
    {
        $filters = $request->validate(['id_jadwal' => 'nullable|exists:jadwal_pelatihan,id_jadwal']);

        $sertifikats = Sertifikat::with(['peserta.user:id,email', 'jadwal.pelatihan:id_pelatihan,nama_pelatihan'])
            ->when($filters['id_jadwal'] ?? null, fn ($q, $id) => $q->where('id_jadwal', $id))
            ->orderBy('tanggal_terbit')
            ->get();

        return $this->xlsx('laporan-sertifikat', 'Laporan Sertifikat Terbit', [
            'No', 'No. Sertifikat', 'Tanggal Terbit', 'No. Peserta', 'Nama Peserta', 'Email', 'Program Pelatihan', 'Periode',
        ], $sertifikats->map(fn (Sertifikat $s, int $i): array => [
            $i + 1,
            $s->no_sertifikat,
            $s->tanggal_terbit?->format('d/m/Y'),
            $s->peserta?->nomor_peserta,
            $s->peserta?->nama,
            $s->peserta?->user?->email,
            $s->jadwal?->pelatihan?->nama_pelatihan,
            $this->periode($s->jadwal),
        ])->all(), $this->keteranganJadwal($filters['id_jadwal'] ?? null));
    }

    public function lamaran(Request $request): BinaryFileResponse
    {
        $filters = $request->validate(['status' => 'nullable|in:'.implode(',', self::STATUS_LAMARAN)]);

        $lamarans = LamaranLowongan::with(['peserta.user:id,email', 'lowongan.mitra:id_mitra,nama_perusahaan'])
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->orderByDesc('tanggal_melamar')
            ->get();

        return $this->xlsx('laporan-lamaran-kerja', 'Laporan Lamaran Kerja', [
            'No', 'Tanggal Melamar', 'Posisi Lowongan', 'Perusahaan', 'Lokasi', 'No. Peserta', 'Nama Pelamar', 'Email', 'Status',
        ], $lamarans->map(fn (LamaranLowongan $l, int $i): array => [
            $i + 1,
            $l->tanggal_melamar?->format('d/m/Y'),
            $l->lowongan?->judul_lowongan,
            $l->lowongan?->mitra?->nama_perusahaan,
            $l->lowongan?->lokasi,
            $l->peserta?->nomor_peserta,
            $l->peserta?->nama,
            $l->peserta?->user?->email,
            ucfirst((string) $l->status),
        ])->all(), isset($filters['status']) ? 'Status: '.ucfirst($filters['status']) : null);
    }

    private function keteranganJadwal(int|string|null $idJadwal): ?string
    {
        if (! $idJadwal) {
            return null;
        }

        $jadwal = JadwalPelatihan::with('pelatihan:id_pelatihan,nama_pelatihan')->find($idJadwal);

        return 'Jadwal: '.($jadwal?->pelatihan?->nama_pelatihan ?? '-').' ('.$this->periode($jadwal).')';
    }

    private function periode(?JadwalPelatihan $jadwal): string
    {
        if (! $jadwal) {
            return '-';
        }

        return ($jadwal->tanggal_mulai?->format('d/m/Y') ?? '-').' s/d '.($jadwal->tanggal_selesai?->format('d/m/Y') ?? '-');
    }
}
