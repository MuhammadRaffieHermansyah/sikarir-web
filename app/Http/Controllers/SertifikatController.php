<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSertifikatRequest;
use App\Http\Requests\UpdateSertifikatRequest;
use App\Http\Resources\SertifikatResource;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index()
    {
        return SertifikatResource::collection(Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user'])->latest()->paginate(15));
    }
    public function store(StoreSertifikatRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('file_sertifikat')) {
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        $item = Sertifikat::create($data);
        return (new SertifikatResource($item->load(['peserta.user', 'jadwal.pelatihan', 'admin.user'])))->response()->setStatusCode(201);
    }
    public function show(int $id)
    {
        return new SertifikatResource(Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user'])->findOrFail($id));
    }
    public function update(UpdateSertifikatRequest $request, int $id)
    {
        $item = Sertifikat::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('file_sertifikat')) {
            if ($item->file_sertifikat) Storage::disk('public')->delete($item->file_sertifikat);
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        $item->update($data);
        return new SertifikatResource($item->fresh()->load(['peserta.user', 'jadwal.pelatihan', 'admin.user']));
    }
    public function destroy(int $id)
    {
        $item = Sertifikat::findOrFail($id);
        if ($item->file_sertifikat) Storage::disk('public')->delete($item->file_sertifikat);
        $item->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
