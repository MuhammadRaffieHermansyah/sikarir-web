<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class DaftarPelatihanResource extends JsonResource { public function toArray($request):array{return ['id_pelatihan'=>$this->id_pelatihan,'id_admin'=>$this->id_admin,'nama_pelatihan'=>$this->nama_pelatihan,'deskripsi_pelatihan'=>$this->deskripsi_pelatihan,'durasi_lp'=>$this->durasi_lp,'kuota'=>$this->kuota,'admin'=>$this->whenLoaded('admin'),'jadwal'=>$this->whenLoaded('jadwal')];} }