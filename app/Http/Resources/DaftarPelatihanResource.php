<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DaftarPelatihanResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id_pelatihan' => $this->id_pelatihan, 'id_admin' => $this->id_admin, 'nama_pelatihan' => $this->nama_pelatihan, 'deskripsi_pelatihan' => $this->deskripsi_pelatihan, 'id_durasi' => $this->id_durasi, 'durasi' => $this->whenLoaded('durasi'), 'kuota' => $this->kuota, 'admin' => $this->whenLoaded('admin'), 'jadwal' => $this->whenLoaded('jadwal')];
    }
}
