<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreDaftarLowonganRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['id_mitra'=>'required|exists:mitras,id_mitra','id_admin'=>'required|exists:admin_blks,id_admin','judul_lowongan'=>'required|string|max:255','lokasi'=>'nullable|string|max:255','deskripsi'=>'nullable|string','kualifikasi'=>'nullable|string','tanggal_posting'=>'nullable|date','status'=>'nullable|string|max:30'];} }