<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absens';
    protected $primaryKey = 'id_absen';
    protected $fillable = ['id_jadwal', 'id_peserta', 'tanggal', 'jam_hadir', 'status_kehadiran', 'keterangan'];
    protected $casts = ['tanggal' => 'date'];

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
