<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Peserta extends Model {
    protected $primaryKey='id_peserta';
    protected $fillable=['id_user','id_admin','nomor_peserta','jenis_kelamin','nomor_kk','nomor_wa','tanggal_lahir','tempat_lahir','alamat_lengkap','pendidikan_terakhir','pendidikan_sekarang','pas_foto','jurusan'];
    protected $casts=['tanggal_lahir'=>'date'];
    public function user(){return $this->belongsTo(User::class,'id_user');}
    public function admin(){return $this->belongsTo(AdminBlk::class,'id_admin');}
    public function kelas(){return $this->hasMany(KelasPelatihan::class,'id_peserta');}
    public function absensi(){return $this->hasMany(Absen::class,'id_peserta');}
    public function sertifikat(){return $this->hasMany(Sertifikat::class,'id_peserta');}
}