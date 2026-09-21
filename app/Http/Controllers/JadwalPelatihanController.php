<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreJadwalPelatihanRequest;
use App\Http\Requests\UpdateJadwalPelatihanRequest;
use App\Http\Resources\JadwalPelatihanResource;
use App\Models\JadwalPelatihan;
class JadwalPelatihanController extends Controller {
 public function index(){return JadwalPelatihanResource::collection(JadwalPelatihan::with($this->relations())->latest()->paginate(15));}
 public function store(StoreJadwalPelatihanRequest $request){$jadwal=JadwalPelatihan::create($request->validated());return (new JadwalPelatihanResource($jadwal))->response()->setStatusCode(201);}
 public function show(int $id){$jadwal=JadwalPelatihan::with($this->relations())->findOrFail($id);return new JadwalPelatihanResource($jadwal);}
 public function update(UpdateJadwalPelatihanRequest $request,int $id){$jadwal=JadwalPelatihan::findOrFail($id);$jadwal->update($request->validated());return new JadwalPelatihanResource($jadwal->fresh()->load($this->relations()));}
 public function destroy(int $id){$jadwal=JadwalPelatihan::findOrFail($id);$jadwal->delete();return response()->json(['message'=>'Data berhasil dihapus']);}
 protected function relations():array{return ['pelatihan'];}
}