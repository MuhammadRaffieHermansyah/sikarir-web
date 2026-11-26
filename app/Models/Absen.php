<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absens';

    protected $primaryKey = 'id_absen';

    protected $fillable = [
        'id_jadwal', 'id_sesi', 'id_peserta', 'tanggal', 'jam_hadir',
        'status_kehadiran', 'keterangan',
        'latitude', 'longitude', 'jarak_meter',
        'lampiran',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'jarak_meter' => 'decimal:2',
    ];

    /**
     * URL publik lampiran izin/sakit, atau null bila tidak ada.
     */
    public function getLampiranUrlAttribute(): ?string
    {
        return $this->lampiran ? Storage::disk('public')->url($this->lampiran) : null;
    }

    public function getIdAttribute()
    {
        return $this->getKey();
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelatihan::class, 'id_jadwal');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
