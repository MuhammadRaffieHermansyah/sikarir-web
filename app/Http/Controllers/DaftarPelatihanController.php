<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDaftarPelatihanRequest;
use App\Http\Requests\UpdateDaftarPelatihanRequest;
use App\Http\Resources\DaftarPelatihanResource;
use App\Models\DaftarPelatihan;

class DaftarPelatihanController extends Controller
{
    public function index()
    {
        return DaftarPelatihanResource::collection(DaftarPelatihan::with($this->relations())->latest()->paginate(15));
    }
    public function store(StoreDaftarPelatihanRequest $request)
    {
        $pelatihan = DaftarPelatihan::create($request->validated());
        return (new DaftarPelatihanResource($pelatihan))->response()->setStatusCode(201);
    }
    public function show(int $id)
    {
        $pelatihan = DaftarPelatihan::with($this->relations())->findOrFail($id);
        return new DaftarPelatihanResource($pelatihan);
    }
    public function update(UpdateDaftarPelatihanRequest $request, int $id)
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $pelatihan->update($request->validated());
        return new DaftarPelatihanResource($pelatihan->fresh()->load($this->relations()));
    }
    public function destroy(int $id)
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $pelatihan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
    protected function relations(): array
    {
        return ['admin'];
    }
}
