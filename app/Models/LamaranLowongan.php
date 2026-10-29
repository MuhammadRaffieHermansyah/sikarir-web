<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LamaranLowongan extends Model
{
    use HasFactory;

    protected $table = 'lamaran_lowongan';
    protected $primaryKey = 'id_lamaran';

    protected $fillable = [
        'id_lowongan',
        'id_peserta',
        'tanggal_melamar',
        'status',
        'catatan_pelamar',
        'catatan_mitra',
        'resume_url',
    ];

    protected $casts = [
        'tanggal_melamar' => 'date',
    ];

    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(DaftarLowongan::class, 'id_lowongan');
    }

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}

