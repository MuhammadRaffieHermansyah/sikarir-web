<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Sesi presensi per pertemuan, dibuat & dibuka/ditutup oleh instruktur pengampu.
 */
class SesiPresensi extends Model
{
    protected $table = 'sesi_presensi';

    protected $primaryKey = 'id_sesi';

    protected $fillable = [
        'id_jadwal', 'id_instruktur', 'pertemuan_ke', 'tanggal',
        'jam_mulai', 'jam_selesai', 'lokasi_latitude', 'lokasi_longitude',
        'radius_meter', 'absen_dibuka',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'pertemuan_ke' => 'integer',
        'radius_meter' => 'integer',
        'absen_dibuka' => 'boolean',
        'lokasi_latitude' => 'decimal:7',
        'lokasi_longitude' => 'decimal:7',
    ];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalPelatihan::class, 'id_jadwal');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absen::class, 'id_sesi');
    }

    /** Sesi dibuka dan bertanggal hari ini. */
    public function sedangDibuka(): bool
    {
        return $this->absen_dibuka && $this->tanggal->isToday();
    }

    /** Padanan scope sudahSelesai untuk satu sesi. */
    public function sudahSelesai(): bool
    {
        if ($this->tanggal->lt(today())) {
            return true;
        }

        return $this->tanggal->isToday()
            && ! $this->absen_dibuka
            && substr((string) $this->jam_selesai, 0, 8) <= now()->format('H:i:s');
    }

    /**
     * Status setiap peserta kelas pada sesi ini.
     *
     * Catatan diambil dari presensi dengan id_sesi ini, atau presensi (izin/sakit/catatan admin)
     * pada jadwal dan tanggal yang sama. Tanpa catatan: `alpha` bila sesi sudah selesai,
     * selain itu `belum`.
     *
     * @return Collection<int, array{id_peserta: int, nama: string, status: string, jam_hadir: ?string, keterangan: ?string}>
     */
    public function statusPeserta(): Collection
    {
        $kelas = KelasPelatihan::with('peserta:id_peserta,nama')
            ->where('id_jadwal', $this->id_jadwal)
            ->get(['id_kelas', 'id_peserta', 'id_jadwal']);

        $catatan = Absen::query()
            ->where('id_jadwal', $this->id_jadwal)
            ->whereIn('id_peserta', $kelas->pluck('id_peserta'))
            ->where(fn (Builder $q) => $q->where('id_sesi', $this->id_sesi)
                ->orWhere(fn (Builder $tanpaSesi) => $tanpaSesi->whereNull('id_sesi')
                    ->whereDate('tanggal', $this->tanggal->toDateString())))
            ->orderByRaw('id_sesi is null')
            ->get()
            ->unique('id_peserta')
            ->keyBy('id_peserta');

        $tanpaCatatan = $this->sudahSelesai() ? 'alpha' : 'belum';

        return $kelas
            ->map(function (KelasPelatihan $k) use ($catatan, $tanpaCatatan): array {
                $absen = $catatan->get($k->id_peserta);

                return [
                    'id_peserta' => $k->id_peserta,
                    'nama' => $k->peserta?->nama ?? 'Peserta',
                    'status' => $absen?->status_kehadiran ?? $tanpaCatatan,
                    'jam_hadir' => $absen?->jam_hadir ? substr((string) $absen->jam_hadir, 0, 5) : null,
                    'keterangan' => $absen?->keterangan,
                ];
            })
            ->sortBy('nama', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    /**
     * Sesi yang sudah lewat: tanggalnya sebelum hari ini, atau hari ini dengan presensi
     * tertutup dan jam selesai sudah terlewati.
     */
    public function scopeSudahSelesai(Builder $query): void
    {
        $query->where(fn (Builder $q) => $q->whereDate('tanggal', '<', today())
            ->orWhere(fn (Builder $hariIni) => $hariIni->whereDate('tanggal', today())
                ->where('absen_dibuka', false)
                ->where('jam_selesai', '<=', now()->format('H:i:s'))));
    }

    /**
     * Hitung sesi yang sudah selesai tetapi tidak punya catatan presensi apa pun dari peserta
     * yang terdaftar di kelasnya. Sesi itu dihitung sebagai alpha.
     *
     * Sesi dianggap tercatat bila ada presensi dengan id_sesi tersebut, atau presensi
     * (izin/sakit/catatan admin) pada jadwal dan tanggal yang sama.
     *
     * @param  array{id_peserta?: ?int, id_jadwal?: ?int, tanggal_mulai?: ?string, tanggal_selesai?: ?string}  $filter
     * @return Collection<int, Collection<int, int>> id_peserta => (id_jadwal => jumlah alpha)
     */
    public static function alphaTanpaCatatan(array $filter = []): Collection
    {
        $sesi = static::query()
            ->sudahSelesai()
            ->when($filter['id_jadwal'] ?? null, fn (Builder $q, $v) => $q->where('id_jadwal', $v))
            ->when($filter['tanggal_mulai'] ?? null, fn (Builder $q, $v) => $q->whereDate('tanggal', '>=', $v))
            ->when($filter['tanggal_selesai'] ?? null, fn (Builder $q, $v) => $q->whereDate('tanggal', '<=', $v))
            ->get(['id_sesi', 'id_jadwal', 'tanggal'])
            ->groupBy('id_jadwal');

        if ($sesi->isEmpty()) {
            return collect();
        }

        $kelas = KelasPelatihan::query()
            ->whereIn('id_jadwal', $sesi->keys())
            ->when($filter['id_peserta'] ?? null, fn (Builder $q, $v) => $q->where('id_peserta', $v))
            ->get(['id_peserta', 'id_jadwal']);

        $catatan = Absen::query()
            ->whereIn('id_jadwal', $sesi->keys())
            ->whereIn('id_peserta', $kelas->pluck('id_peserta')->unique())
            ->get(['id_peserta', 'id_jadwal', 'id_sesi', 'tanggal'])
            ->groupBy(fn (Absen $absen): string => $absen->id_peserta.'-'.$absen->id_jadwal);

        return $kelas
            ->map(function (KelasPelatihan $k) use ($sesi, $catatan): array {
                $milik = $catatan->get($k->id_peserta.'-'.$k->id_jadwal, collect());
                $idSesiTercatat = $milik->pluck('id_sesi')->filter()->all();
                $tanggalTercatat = $milik->map(fn (Absen $a): string => $a->tanggal->toDateString())->all();

                $alpha = $sesi->get($k->id_jadwal)
                    ->reject(fn (self $s): bool => in_array($s->id_sesi, $idSesiTercatat, true)
                        || in_array($s->tanggal->toDateString(), $tanggalTercatat, true))
                    ->count();

                return ['id_peserta' => $k->id_peserta, 'id_jadwal' => $k->id_jadwal, 'alpha' => $alpha];
            })
            ->filter(fn (array $baris): bool => $baris['alpha'] > 0)
            ->groupBy('id_peserta')
            ->map(fn (Collection $baris): Collection => $baris->pluck('alpha', 'id_jadwal'));
    }
}
