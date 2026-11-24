<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'foto', 'must_change_password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'must_change_password' => 'boolean'];
    }

    public function peserta()
    {
        return $this->hasOne(Peserta::class, 'id_user');
    }

    public function mitra()
    {
        return $this->hasOne(Mitra::class, 'id_user');
    }

    public function instruktur()
    {
        return $this->hasOne(Instruktur::class, 'id_user');
    }

    public function adminBlk()
    {
        return $this->hasOne(AdminBlk::class, 'id_user');
    }
}
