<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    use HasFactory;

    protected $table = 'instruktur';

    protected $fillable = [
        'nama',
        'bidang_keahlian',
    ];

    public function jadwal()
    {
        return $this->hasMany(JadwalPelatihan::class, 'id_instruktur');
    }
}
