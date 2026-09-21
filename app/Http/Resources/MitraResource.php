<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MitraResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id_mitra' => $this->id_mitra, 'id_user' => $this->id_user, 'nama_perusahaan' => $this->nama_perusahaan, 'jenis_mitra' => $this->jenis_mitra, 'logo_perusahaan' => $this->logo_perusahaan, 'provinsi' => $this->provinsi, 'kota' => $this->kota, 'alamat' => $this->alamat, 'no_telp' => $this->no_telp, 'no_izin' => $this->no_izin, 'jabatan_pic' => $this->jabatan_pic, 'bidang_usaha' => $this->bidang_usaha, 'user' => new UserResource($this->whenLoaded('user'))];
    }
}
