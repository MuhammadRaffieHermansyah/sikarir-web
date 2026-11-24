<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'modul';

    protected $primaryKey = 'id_modul';

    protected $fillable = ['id_jadwal', 'judul', 'deskripsi', 'pertemuan_ke'];

    protected $casts = ['pertemuan_ke' => 'integer'];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalPelatihan::class, 'id_jadwal');
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class, 'id_modul');
    }
}
