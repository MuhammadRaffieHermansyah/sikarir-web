<?php

namespace App\Models;

use Database\Factories\BidangKeahlianFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BidangKeahlian extends Model
{
    /** @use HasFactory<BidangKeahlianFactory> */
    use HasFactory;

    protected $table = 'bidang_keahlian';

    protected $fillable = [
        'nama',
    ];

    /**
     * Instruktur menyimpan nama bidang keahlian sebagai teks.
     */
    public function instruktur(): HasMany
    {
        return $this->hasMany(Instruktur::class, 'bidang_keahlian', 'nama');
    }
}
