<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateSertifikatRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['id_jadwal'=>'sometimes|exists:jadwal_pelatihan,id_jadwal','id_peserta'=>'sometimes|exists:pesertas,id_peserta','no_sertifikat'=>['sometimes','string','max:100',Rule::unique('sertifikats','no_sertifikat')->ignore($this->route('sertifikat'))],'tanggal_terbit'=>'sometimes|date','file_sertifikat'=>'nullable|file|mimes:pdf|max:5120','id_admin'=>'sometimes|exists:admin_blks,id_admin'];} }