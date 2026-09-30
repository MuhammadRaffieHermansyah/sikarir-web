<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalPelatihan;

class RuanganWorkshop extends Model
{
    protected $table = 'ruangan_workshop';

    protected $fillable = [
        'nama_ruangan',
    ];

    public function jadwal()
    {
        return $this->hasMany(JadwalPelatihan::class, 'id_ruangan_workshop');
    }
}