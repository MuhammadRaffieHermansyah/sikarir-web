<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasPelatihan extends Model
{
    protected $table = 'kelas_pelatihan';
    protected $primaryKey = 'id_kelas';
    protected $fillable = ['id_peserta', 'id_jadwal', 'status'];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelatihan::class, 'id_jadwal');
    }
}
