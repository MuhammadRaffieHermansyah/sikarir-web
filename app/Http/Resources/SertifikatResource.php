<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SertifikatResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id_sertifikat' => $this->id_sertifikat, 'id_jadwal' => $this->id_jadwal, 'id_peserta' => $this->id_peserta, 'no_sertifikat' => $this->no_sertifikat, 'tanggal_terbit' => $this->tanggal_terbit?->format('Y-m-d'), 'file_sertifikat' => $this->file_sertifikat, 'id_admin' => $this->id_admin, 'peserta' => $this->whenLoaded('peserta'), 'jadwal' => $this->whenLoaded('jadwal'), 'admin' => $this->whenLoaded('admin')];
    }
}
