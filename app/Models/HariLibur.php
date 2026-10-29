<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'hari_libur';
    protected $fillable = ['tanggal', 'keterangan', 'sumber'];
    protected $casts = ['tanggal' => 'date'];
}
