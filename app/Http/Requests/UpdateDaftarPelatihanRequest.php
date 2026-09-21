<?php
namespace App\Http\Requests;
class UpdateDaftarPelatihanRequest extends StoreDaftarPelatihanRequest { public function rules():array{return array_map(fn($r)=>str_replace('required|','sometimes|',$r),parent::rules());} }