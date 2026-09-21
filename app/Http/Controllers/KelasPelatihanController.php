<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreKelasPelatihanRequest;
use App\Http\Requests\UpdateKelasPelatihanRequest;
use App\Http\Resources\KelasPelatihanResource;
use App\Models\KelasPelatihan;
use App\Models\JadwalPelatihan;
use Illuminate\Support\Facades\DB;
class KelasPelatihanController extends Controller {
 public function index(){return KelasPelatihanResource::collection(KelasPelatihan::with(['peserta.user','jadwal.pelatihan'])->latest()->paginate(15));}
 public function store(StoreKelasPelatihanRequest $request){$data=$request->validated();$item=DB::transaction(function()use($data){$jadwal=JadwalPelatihan::with('pelatihan')->lockForUpdate()->findOrFail($data['id_jadwal']);if($jadwal->status!=='tersedia')abort(422,'Jadwal pelatihan tidak tersedia.');if(KelasPelatihan::where('id_peserta',$data['id_peserta'])->where('id_jadwal',$data['id_jadwal'])->exists())abort(422,'Peserta sudah terdaftar pada jadwal ini.');$count=KelasPelatihan::where('id_jadwal',$data['id_jadwal'])->count();if($count >= $jadwal->pelatihan->kuota)abort(422,'Kuota pelatihan sudah penuh.');return KelasPelatihan::create($data);});return (new KelasPelatihanResource($item->load(['peserta.user','jadwal.pelatihan'])))->response()->setStatusCode(201);}
 public function show(int $id){return new KelasPelatihanResource(KelasPelatihan::with(['peserta.user','jadwal.pelatihan'])->findOrFail($id));}
 public function update(UpdateKelasPelatihanRequest $request,int $id){$item=KelasPelatihan::findOrFail($id);$item->update($request->validated());return new KelasPelatihanResource($item->fresh()->load(['peserta.user','jadwal.pelatihan']));}
 public function destroy(int $id){KelasPelatihan::findOrFail($id)->delete();return response()->json(['message'=>'Data berhasil dihapus']);}
}