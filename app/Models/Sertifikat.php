<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sertifikat extends Model {
    protected $primaryKey='id_sertifikat';
    protected $fillable=['id_jadwal','id_peserta','no_sertifikat','tanggal_terbit','file_sertifikat','id_admin'];
    protected $casts=['tanggal_terbit'=>'date'];
    public function jadwal(){return $this->belongsTo(JadwalPelatihan::class,'id_jadwal');}
    public function peserta(){return $this->belongsTo(Peserta::class,'id_peserta');}
    public function admin(){return $this->belongsTo(AdminBlk::class,'id_admin');}
}