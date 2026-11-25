<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $primaryKey = 'id_materi';

    protected $fillable = ['id_modul', 'judul', 'tipe', 'url', 'nama_file', 'konten'];

    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'id_modul');
    }
}
