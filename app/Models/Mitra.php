<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Mitra extends Model {
    protected $primaryKey='id_mitra';
    protected $fillable=['id_user','nama_perusahaan','jenis_mitra','logo_perusahaan','provinsi','kota','alamat','no_telp','no_izin','jabatan_pic','bidang_usaha'];
    public function user(){return $this->belongsTo(User::class,'id_user');}
    public function lowongan(){return $this->hasMany(DaftarLowongan::class,'id_mitra');}
}