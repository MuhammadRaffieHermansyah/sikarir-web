<?php

namespace App\Models;

use App\Models\Concerns\HasImageThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarLowongan extends Model
{
    use HasFactory, HasImageThumbnail;

    protected $table = 'daftar_lowongan';

    protected $primaryKey = 'id_lowongan';

    protected $fillable = ['id_mitra', 'judul_lowongan', 'lokasi', 'deskripsi', 'kualifikasi', 'gambar', 'tanggal_posting', 'status'];

    protected $casts = ['tanggal_posting' => 'date'];

    public function getIdAttribute()
    {
        return $this->getKey();
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }

    public function lamaran()
    {
        return $this->hasMany(LamaranLowongan::class, 'id_lowongan');
    }

    public function getGambarUrlAttribute(): ?string
    {
        return $this->gambar ? asset('storage/'.$this->gambar) : null;
    }
}
