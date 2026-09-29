<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DurasiPelatihanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_durasi' => $this->id_durasi,
            'hari'      => $this->hari,
            'jam'       => $this->jam,
            'durasi_label' => $this->durasi_label,
            'pelatihan' => $this->whenLoaded('pelatihan'),
        ];
    }
}