<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMitraRequest;
use App\Http\Requests\UpdateMitraRequest;
use App\Http\Resources\MitraResource;
use App\Models\Mitra;

class MitraController extends Controller
{
    public function index()
    {
        return MitraResource::collection(Mitra::with($this->relations())->latest()->paginate(15));
    }
    public function store(StoreMitraRequest $request)
    {
        $mitra = Mitra::create($request->validated());
        return (new MitraResource($mitra))->response()->setStatusCode(201);
    }
    public function show(int $id)
    {
        $mitra = Mitra::with($this->relations())->findOrFail($id);
        return new MitraResource($mitra);
    }
    public function update(UpdateMitraRequest $request, int $id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->validated());
        return new MitraResource($mitra->fresh()->load($this->relations()));
    }
    public function destroy(int $id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
    protected function relations(): array
    {
        return ['user'];
    }
}
