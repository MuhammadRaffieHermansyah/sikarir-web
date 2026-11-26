<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
