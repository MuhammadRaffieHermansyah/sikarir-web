<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreAdminBlkRequest;
use App\Http\Requests\UpdateAdminBlkRequest;
use App\Http\Resources\AdminBlkResource;
use App\Models\AdminBlk;
class AdminBlkController extends Controller {
 public function index(){return AdminBlkResource::collection(AdminBlk::with($this->relations())->latest()->paginate(15));}
 public function store(StoreAdminBlkRequest $request){$admin=AdminBlk::create($request->validated());return (new AdminBlkResource($admin))->response()->setStatusCode(201);}
 public function show(int $id){$admin=AdminBlk::with($this->relations())->findOrFail($id);return new AdminBlkResource($admin);}
 public function update(UpdateAdminBlkRequest $request,int $id){$admin=AdminBlk::findOrFail($id);$admin->update($request->validated());return new AdminBlkResource($admin->fresh()->load($this->relations()));}
 public function destroy(int $id){$admin=AdminBlk::findOrFail($id);$admin->delete();return response()->json(['message'=>'Data berhasil dihapus']);}
 protected function relations():array{return ['user'];}
}