<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBlk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_admin';
    protected $fillable = ['id_user'];

    public function getIdAttribute()
    {
        return $this->getKey();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'id_admin');
    }
    public function lowongan()
    {
        return $this->hasMany(DaftarLowongan::class, 'id_admin');
    }
    public function pelatihan()
    {
        return $this->hasMany(DaftarPelatihan::class, 'id_admin');
    }
    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'id_admin');
    }
}
