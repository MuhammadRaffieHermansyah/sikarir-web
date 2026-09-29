<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelatihan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelatihan';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = ['id_pelatihan', 'tanggal_mulai', 'tanggal_selesai', 'jam_mulai', 'jam_selesai', 'id_instruktur', 'tempat', 'status'];
    protected $casts = ['tanggal_mulai' => 'date', 'tanggal_selesai' => 'date'];

    public function getIdAttribute()
    {
        return $this->getKey();
    }
    public function pelatihan()
    {
        return $this->belongsTo(DaftarPelatihan::class, 'id_pelatihan');
    }
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }
    public function kelas()
    {
        return $this->hasMany(KelasPelatihan::class, 'id_jadwal');
    }
    public function absensi()
    {
        return $this->hasMany(Absen::class, 'id_jadwal');
    }
    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'id_jadwal');
    }
}
