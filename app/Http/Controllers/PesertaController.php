<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesertaRequest;
use App\Http\Requests\UpdatePesertaRequest;
use App\Http\Resources\PesertaResource;
use App\Models\Peserta;

class PesertaController extends Controller
{
    public function index()
    {
        return PesertaResource::collection(Peserta::with($this->relations())->latest()->paginate(15));
    }
    public function store(StorePesertaRequest $request)
    {
        $peserta = Peserta::create($request->validated());
        return (new PesertaResource($peserta))->response()->setStatusCode(201);
    }
    public function show(int $id)
    {
        $peserta = Peserta::with($this->relations())->findOrFail($id);
        return new PesertaResource($peserta);
    }
    public function update(UpdatePesertaRequest $request, int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->update($request->validated());
        return new PesertaResource($peserta->fresh()->load($this->relations()));
    }
    public function destroy(int $id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
    protected function relations(): array
    {
        return ['user', 'admin'];
    }
}
