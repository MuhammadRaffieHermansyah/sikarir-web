<?php

namespace Database\Seeders;

use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstrukturAkunSeeder extends Seeder
{
    /**
     * Buat akun demo instruktur (instruktur@sikarir.com), tautkan ke instruktur pertama,
     * lalu isi contoh modul & materi pada jadwal yang ia ampu.
     */
    public function run(): void
    {
        $instruktur = Instruktur::query()->orderBy('id')->first();

        if ($instruktur === null) {
            return;
        }

        $user = User::updateOrCreate(
            ['email' => 'instruktur@sikarir.com'],
            [
                'name' => $instruktur->nama,
                'password' => Hash::make('password'),
                'role' => 'instruktur',
            ]
        );

        $instruktur->update(['id_user' => $user->id]);

        $jadwal = JadwalPelatihan::where('id_instruktur', $instruktur->id)->orderBy('id_jadwal')->first();

        if ($jadwal === null) {
            return;
        }

        $modul = $jadwal->modul()->firstOrCreate(
            ['pertemuan_ke' => 1],
            ['judul' => 'Pengantar & Persiapan', 'deskripsi' => 'Gambaran umum pelatihan dan persiapan perangkat.']
        );

        if ($modul->materi()->doesntExist()) {
            $modul->materi()->createMany([
                ['judul' => 'Video Pengantar', 'tipe' => 'link', 'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
                ['judul' => 'Catatan Pertemuan 1', 'tipe' => 'teks', 'konten' => 'Siapkan laptop dan instal aplikasi yang dibutuhkan sebelum pertemuan berikutnya.'],
            ]);
        }
    }
}
