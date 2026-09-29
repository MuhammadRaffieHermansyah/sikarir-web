<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurasiPelatihan extends Model
{
    use HasFactory;

    protected $table = 'durasi_pelatihan';
    protected $primaryKey = 'id_durasi';
    protected $fillable = ['hari', 'jam'];
    protected $casts = ['hari' => 'integer', 'jam' => 'integer'];

    public function getIdAttribute()
    {
        return $this->getKey();
    }

    public function pelatihan()
    {
        return $this->hasMany(DaftarPelatihan::class, 'id_durasi');
    }

    public function getDurasiLabelAttribute(): string
    {
        return $this->hari . ' Hari / ' . $this->jam . ' Jam';
    }
}