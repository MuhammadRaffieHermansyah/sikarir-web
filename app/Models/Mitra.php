<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_mitra';

    protected $fillable = ['id_user', 'nama', 'nama_perusahaan', 'jenis_mitra', 'logo_perusahaan', 'provinsi', 'kota', 'alamat', 'no_telp', 'no_izin', 'jabatan_pic', 'bidang_usaha'];

    /**
     * Keep the internal `nama` column out of the mobile API payload.
     *
     * @var list<string>
     */
    protected $hidden = ['nama'];

    public function getIdAttribute()
    {
        return $this->getKey();
    }

    public function getTeleponAttribute()
    {
        return $this->attributes['no_telp'] ?? null;
    }

    public function setTeleponAttribute($value)
    {
        $this->attributes['no_telp'] = $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function lowongan()
    {
        return $this->hasMany(DaftarLowongan::class, 'id_mitra');
    }
}
