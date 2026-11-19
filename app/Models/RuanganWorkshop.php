<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuanganWorkshop extends Model
{
    use HasFactory;

    protected $table = 'ruangan_workshop';

    protected $fillable = [
        'nama_ruangan',
    ];

    public function jadwal()
    {
        return $this->hasMany(JadwalPelatihan::class, 'id_ruangan_workshop');
    }
}
