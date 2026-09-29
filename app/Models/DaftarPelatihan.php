<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaftarPelatihan extends Model
{
    use HasFactory;

    protected $table = 'daftar_pelatihan';
    protected $primaryKey = 'id_pelatihan';
    protected $fillable = ['id_admin', 'nama_pelatihan', 'deskripsi_pelatihan', 'id_durasi', 'kuota'];
    protected $casts = ['kuota' => 'integer'];

    public function getIdAttribute()
    {
        return $this->getKey();
    }
    public function admin()
    {
        return $this->belongsTo(AdminBlk::class, 'id_admin');
    }
    public function durasi(): BelongsTo
    {
        return $this->belongsTo(DurasiPelatihan::class, 'id_durasi');
    }
    public function jadwal()
    {
        return $this->hasMany(JadwalPelatihan::class, 'id_pelatihan');
    }

    public function getDurasiLabelAttribute(): ?string
    {
        return $this->durasi?->durasi_label;
    }
}
