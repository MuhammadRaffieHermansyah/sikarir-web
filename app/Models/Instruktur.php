<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    use HasFactory;

    protected $table = 'instruktur';

    protected $fillable = [
        'id_user',
        'nama',
        'bidang_keahlian',
        'nomor_wa',
        'bio',
        'keahlian',
    ];

    public function jadwal()
    {
        return $this->hasMany(JadwalPelatihan::class, 'id_instruktur');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
