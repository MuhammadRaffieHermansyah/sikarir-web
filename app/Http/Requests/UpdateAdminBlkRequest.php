<?php
namespace App\Http\Requests;
class UpdateAdminBlkRequest extends StoreAdminBlkRequest { public function rules():array{return ['id_user'=>'sometimes|exists:users,id'];} }