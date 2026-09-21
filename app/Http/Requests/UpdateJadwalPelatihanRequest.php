<?php
namespace App\Http\Requests;
class UpdateJadwalPelatihanRequest extends StoreJadwalPelatihanRequest { public function rules():array{return array_map(fn($r)=>str_replace('required|','sometimes|',$r),parent::rules());} }