<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPelatihan extends Model
{
    protected $table = 'daftar_pelatihan';
    protected $primaryKey = 'id_pelatihan';
    protected $fillable = ['id_admin', 'nama_pelatihan', 'deskripsi_pelatihan', 'durasi_lp', 'kuota'];
    protected $casts = ['kuota' => 'integer'];
    public function admin()
    {
        return $this->belongsTo(AdminBlk::class, 'id_admin');
    }
    public function jadwal()
    {
        return $this->hasMany(JadwalPelatihan::class, 'id_pelatihan');
    }
}
