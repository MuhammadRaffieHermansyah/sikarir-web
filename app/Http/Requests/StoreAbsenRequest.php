<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreAbsenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'id_jadwal' => 'nullable',
            'id_peserta' => 'nullable',
            'tanggal' => 'required|date',
            'jam_hadir' => 'nullable|string',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha,alpa',
            'keterangan' => 'nullable|string|max:255',
            // Kolom lokasi GPS (opsional / tervalidasi jika hadir)
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            // Khusus izin/sakit: rentang tanggal & lampiran (surat dokter, dll.)
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'lampiran.mimes' => 'Lampiran harus berupa JPG, PNG, atau PDF.',
            'lampiran.max' => 'Ukuran lampiran maksimal 2 MB.',
        ];
    }

    /**
     * Rentang tanggal & lampiran hanya berlaku untuk izin/sakit.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $status = $this->input('status_kehadiran');

            if (! in_array($status, ['izin', 'sakit'], true)) {
                if ($this->filled('tanggal_selesai')) {
                    $validator->errors()->add('tanggal_selesai', 'Rentang tanggal hanya untuk izin atau sakit.');
                }
                if ($this->hasFile('lampiran')) {
                    $validator->errors()->add('lampiran', 'Lampiran hanya untuk izin atau sakit.');
                }
            }
        });
    }
}
