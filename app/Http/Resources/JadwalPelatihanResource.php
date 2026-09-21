<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class JadwalPelatihanResource extends JsonResource { public function toArray($request):array{return ['id_jadwal'=>$this->id_jadwal,'id_pelatihan'=>$this->id_pelatihan,'tanggal_mulai'=>$this->tanggal_mulai?->format('Y-m-d'),'tanggal_selesai'=>$this->tanggal_selesai?->format('Y-m-d'),'jam_mulai'=>$this->jam_mulai,'jam_selesai'=>$this->jam_selesai,'instruktur'=>$this->instruktur,'tempat'=>$this->tempat,'status'=>$this->status,'pelatihan'=>$this->whenLoaded('pelatihan')];} }