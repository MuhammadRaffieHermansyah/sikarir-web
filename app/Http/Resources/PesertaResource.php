<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PesertaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_peserta'       => $this->id_peserta,
            'id_user'          => $this->id_user,
            'id_admin'         => $this->id_admin,
            'nomor_peserta'    => $this->nomor_peserta,
            'jenis_kelamin'    => $this->jenis_kelamin,
            'nomor_kk'         => $this->nomor_kk,
            'nomor_wa'         => $this->nomor_wa,
            'tanggal_lahir'    => $this->tanggal_lahir?->format('Y-m-d'),
            'tempat_lahir'     => $this->tempat_lahir,
            'alamat_lengkap'   => $this->alamat_lengkap,
            'pendidikan_terakhir'  => $this->pendidikan_terakhir,
            'pendidikan_sekarang'  => $this->pendidikan_sekarang,
            'status_pendidikan'    => $this->status_pendidikan,
            'jurusan'          => $this->jurusan,
            'is_disabilitas'   => (bool) $this->is_disabilitas,
            'jenis_disabilitas'=> $this->jenis_disabilitas,
            'pas_foto'         => $this->pas_foto
                ? asset('storage/' . $this->pas_foto)
                : null,
            'is_profile_complete' => $this->isProfileComplete(),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
