# SIKARIR Laravel Backend

Backend REST API untuk SIKARIR berdasarkan ERD yang kamu kirim. Project ini mempertahankan Laravel Breeze/web authentication yang sudah ada, dan menambahkan REST API untuk Flutter/mobile.

## Stack
- Laravel 13
- PHP 8.3+
- MySQL/MariaDB (disarankan untuk Laragon)
- Laravel Sanctum

## 1. Database
Buat database:

```sql
CREATE DATABASE sikarir;
```

Atur `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sikarir
DB_USERNAME=root
DB_PASSWORD=
```

## 2. Install / migrate

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Base URL API: `http://127.0.0.1:8000/api`

## 3. Demo accounts

| Role | Email | Password |
|---|---|---|
| Admin BLK | admin@sikarir.test | password |
| Mitra | mitra@sikarir.test | password |
| Peserta | peserta@sikarir.test | password |

## 4. Auth API

```text
POST /api/auth/register
POST /api/auth/login
GET  /api/auth/me
POST /api/auth/logout
```

Register publik hanya menerima role `peserta` dan `mitra`; akun `admin_blk` dibuat melalui seeder/admin.

Login menghasilkan Sanctum Bearer token. Kirim token pada endpoint terproteksi:

```http
Authorization: Bearer <token>
Accept: application/json
```

## 5. Resource API

```text
/api/mitras
/api/pesertas
/api/admin-blk
/api/lowongan
/api/pelatihan
/api/jadwal-pelatihan
/api/kelas-pelatihan
/api/absen
/api/sertifikat
```

Semua resource mendukung GET list, POST, GET detail, PUT/PATCH, dan DELETE.

## 6. Business rules yang sudah disiapkan

- `kelas_pelatihan` unik berdasarkan `(id_peserta, id_jadwal)`.
- Pendaftaran kelas mengecek status jadwal.
- Pendaftaran kelas mengecek kuota pelatihan.
- Peserta tidak bisa mendaftar dua kali pada jadwal yang sama.
- Absensi unik berdasarkan `(id_jadwal, id_peserta, tanggal)`.
- Sertifikat unik berdasarkan `(id_jadwal, id_peserta)` dan `no_sertifikat`.
- File sertifikat dapat di-upload sebagai PDF ke disk `public`.
- Role middleware tersedia dengan alias `role`.

## 7. Penyesuaian ERD

Ada dua FK yang tidak tertulis sebagai atribut secara jelas tetapi dibutuhkan agar relasi ERD dapat direalisasikan:

- `mitras.id_user` → `users.id`, untuk relasi Mitra–User.
- `pesertas.id_admin` → `admin_blks.id_admin`, untuk relasi pengelolaan Peserta oleh Admin BLK.

`kelas_pelatihan` diberi `id_kelas` sebagai technical primary key karena tabel pada ERD tidak menampilkan PK tersendiri. Kombinasi `id_peserta + id_jadwal` dibuat UNIQUE.
