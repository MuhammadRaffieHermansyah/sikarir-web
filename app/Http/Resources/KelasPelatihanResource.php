<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class KelasPelatihanResource extends JsonResource { public function toArray($request):array{return ['id_kelas'=>$this->id_kelas,'id_peserta'=>$this->id_peserta,'id_jadwal'=>$this->id_jadwal,'status'=>$this->status,'peserta'=>$this->whenLoaded('peserta'),'jadwal'=>$this->whenLoaded('jadwal')];} }