<?php

namespace App\Http\Requests;

class UpdateInstrukturRequest extends StoreInstrukturRequest
{
    public function rules(): array
    {
        return [
            'nama' => 'sometimes|required|string|max:150',
            'bidang_keahlian' => 'sometimes|required|string|max:150',
        ];
    }
}
