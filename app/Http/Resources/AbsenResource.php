<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_absen'        => $this->id_absen,
            'id_jadwal'       => $this->id_jadwal,
            'id_peserta'      => $this->id_peserta,
            'tanggal'         => $this->tanggal?->format('Y-m-d'),
            'jam_hadir'       => $this->jam_hadir,
            'status_kehadiran'=> $this->status_kehadiran,
            'keterangan'      => $this->keterangan,
            // Kolom lokasi GPS
            'latitude'        => $this->latitude ? (float) $this->latitude : null,
            'longitude'       => $this->longitude ? (float) $this->longitude : null,
            'jarak_meter'     => $this->jarak_meter ? (float) $this->jarak_meter : null,
            // Relasi
            'peserta'         => $this->whenLoaded('peserta'),
            'jadwal'          => $this->whenLoaded('jadwal'),
        ];
    }
}
