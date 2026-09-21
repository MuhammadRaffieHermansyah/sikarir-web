<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarLowongan extends Model
{
    protected $table = 'daftar_lowongan';
    protected $primaryKey = 'id_lowongan';
    protected $fillable = ['id_mitra', 'id_admin', 'judul_lowongan', 'lokasi', 'deskripsi', 'kualifikasi', 'tanggal_posting', 'status'];
    protected $casts = ['tanggal_posting' => 'date'];
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }
    public function admin()
    {
        return $this->belongsTo(AdminBlk::class, 'id_admin');
    }
}
