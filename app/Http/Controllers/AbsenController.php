<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreAbsenRequest;
use App\Http\Requests\UpdateAbsenRequest;
use App\Http\Resources\AbsenResource;
use App\Models\Absen;
class AbsenController extends Controller {
 public function index(){return AbsenResource::collection(Absen::with($this->relations())->latest()->paginate(15));}
 public function store(StoreAbsenRequest $request){$absen=Absen::create($request->validated());return (new AbsenResource($absen))->response()->setStatusCode(201);}
 public function show(int $id){$absen=Absen::with($this->relations())->findOrFail($id);return new AbsenResource($absen);}
 public function update(UpdateAbsenRequest $request,int $id){$absen=Absen::findOrFail($id);$absen->update($request->validated());return new AbsenResource($absen->fresh()->load($this->relations()));}
 public function destroy(int $id){$absen=Absen::findOrFail($id);$absen->delete();return response()->json(['message'=>'Data berhasil dihapus']);}
 protected function relations():array{return ['peserta','jadwal'];}
}