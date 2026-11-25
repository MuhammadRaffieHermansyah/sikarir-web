<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['email', 'password', 'role', 'foto', 'must_change_password'];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Keep the `name` key in every serialized user so the mobile API contract stays intact.
     *
     * @var list<string>
     */
    protected $appends = ['name'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'must_change_password' => 'boolean'];
    }

    /**
     * Eager-load keempat profil peran sekaligus (4 query total) agar accessor `name`
     * tidak menjalankan query per user saat dipakai di daftar/dropdown.
     */
    public function scopeWithProfileNames(Builder $query): void
    {
        $query->with([
            'peserta:id_peserta,id_user,nama',
            'mitra:id_mitra,id_user,nama',
            'adminBlk:id_admin,id_user,nama',
            'instruktur:id,id_user,nama',
        ]);
    }

    /**
     * Resolve the person name from the profile that matches the user's role.
     *
     * The lookup must not populate the relation cache, otherwise a serialized
     * user would unexpectedly expose its role relation in the API payload.
     */
    public function getNameAttribute(): ?string
    {
        $relations = match ($this->role) {
            'mitra' => ['mitra', 'peserta', 'adminBlk', 'instruktur'],
            'admin_blk' => ['adminBlk', 'peserta', 'mitra', 'instruktur'],
            'instruktur' => ['instruktur', 'peserta', 'mitra', 'adminBlk'],
            default => ['peserta', 'mitra', 'adminBlk', 'instruktur'],
        };

        foreach ($relations as $relation) {
            $nama = $this->relationLoaded($relation)
                ? $this->getRelation($relation)?->nama
                : $this->{$relation}()->value('nama');

            if ($nama !== null) {
                return $nama;
            }
        }

        return $this->getRawOriginal('name');
    }

    /**
     * Ensure the profile row that owns the person name exists for this user's role.
     *
     * @param  array{nama_perusahaan?: string|null, jenis_kelamin?: string|null, bidang_keahlian?: string|null}  $attributes
     */
    public function ensureRoleProfile(string $nama, array $attributes = []): AdminBlk|Instruktur|Mitra|Peserta
    {
        $profile = match ($this->role) {
            'mitra' => $this->mitra()->firstOrCreate([], [
                'nama' => $nama,
                'nama_perusahaan' => $attributes['nama_perusahaan'] ?? $nama,
            ]),
            'instruktur' => $this->instruktur()->firstOrCreate([], [
                'nama' => $nama,
                'bidang_keahlian' => $attributes['bidang_keahlian'] ?? '-',
            ]),
            'peserta' => $this->peserta()->firstOrCreate([], [
                'nama' => $nama,
                'nomor_peserta' => 'PST-'.now()->format('Ymd').'-'.str_pad((string) $this->id, 4, '0', STR_PAD_LEFT),
                'jenis_kelamin' => $attributes['jenis_kelamin'] ?? 'Laki-laki',
            ]),
            default => $this->adminBlk()->firstOrCreate([], ['nama' => $nama]),
        };

        if ($profile->nama !== $nama) {
            $profile->update(['nama' => $nama]);
        }

        return $profile;
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
