<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminBlkResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id_admin' => $this->id_admin, 'id_user' => $this->id_user, 'user' => new UserResource($this->whenLoaded('user'))];
    }
}
