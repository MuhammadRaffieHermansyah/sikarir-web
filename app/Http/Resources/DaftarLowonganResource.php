<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DaftarLowonganResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id_lowongan' => $this->id_lowongan, 'id_mitra' => $this->id_mitra, 'id_admin' => $this->id_admin, 'judul_lowongan' => $this->judul_lowongan, 'lokasi' => $this->lokasi, 'deskripsi' => $this->deskripsi, 'kualifikasi' => $this->kualifikasi, 'tanggal_posting' => $this->tanggal_posting?->format('Y-m-d'), 'status' => $this->status, 'mitra' => $this->whenLoaded('mitra'), 'admin' => $this->whenLoaded('admin')];
    }
}
