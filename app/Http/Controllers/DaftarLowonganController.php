<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDaftarLowonganRequest;
use App\Http\Requests\UpdateDaftarLowonganRequest;
use App\Http\Resources\DaftarLowonganResource;
use App\Models\DaftarLowongan;

class DaftarLowonganController extends Controller
{
    public function index()
    {
        return DaftarLowonganResource::collection(DaftarLowongan::with($this->relations())->latest()->paginate(15));
    }
    public function store(StoreDaftarLowonganRequest $request)
    {
        $lowongan = DaftarLowongan::create($request->validated());
        return (new DaftarLowonganResource($lowongan))->response()->setStatusCode(201);
    }
    public function show(int $id)
    {
        $lowongan = DaftarLowongan::with($this->relations())->findOrFail($id);
        return new DaftarLowonganResource($lowongan);
    }
    public function update(UpdateDaftarLowonganRequest $request, int $id)
    {
        $lowongan = DaftarLowongan::findOrFail($id);
        $lowongan->update($request->validated());
        return new DaftarLowonganResource($lowongan->fresh()->load($this->relations()));
    }
    public function destroy(int $id)
    {
        $lowongan = DaftarLowongan::findOrFail($id);
        $lowongan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
    protected function relations(): array
    {
        return ['mitra', 'admin'];
    }
}
