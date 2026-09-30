<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuanganWorkshop extends Model
{
    protected $table = 'ruangan_workshops';

    protected $fillable = [
        'nama_ruangan',
    ];
}