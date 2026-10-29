<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_peserta';
    protected $fillable = ['id_user', 'id_admin', 'nomor_peserta', 'jenis_kelamin', 'nomor_kk', 'nomor_wa', 'tanggal_lahir', 'tempat_lahir', 'alamat_lengkap', 'pendidikan_terakhir', 'pendidikan_sekarang', 'pas_foto', 'jurusan'];
    protected $casts = ['tanggal_lahir' => 'date'];
    protected $appends = ['is_profile_complete'];

    public function isProfileComplete(): bool
    {
        return !empty($this->nomor_wa)
            && !empty($this->nomor_kk)
            && !empty($this->tanggal_lahir)
            && !empty($this->tempat_lahir)
            && !empty($this->jenis_kelamin)
            && !empty($this->alamat_lengkap)
            && !empty($this->pendidikan_terakhir);
    }

    public function getIsProfileCompleteAttribute(): bool
    {
        return $this->isProfileComplete();
    }

    public function getIdAttribute()
    {
        return $this->getKey();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(AdminBlk::class, 'id_admin');
    }

    public function kelas()
    {
        return $this->hasMany(KelasPelatihan::class, 'id_peserta');
    }

    public function absensi()
    {
        return $this->hasMany(Absen::class, 'id_peserta');
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'id_peserta');
    }

    public function lamaran()
    {
        return $this->hasMany(LamaranLowongan::class, 'id_peserta');
    }
}
