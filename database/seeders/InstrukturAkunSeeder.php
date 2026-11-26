<?php

namespace Database\Seeders;

use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstrukturAkunSeeder extends Seeder
{
    /** Instruktur yang ditautkan ke akun demo instruktur@sikarir.com. */
    public const NAMA_INSTRUKTUR_DEMO = 'Dedi Susanto';

    /**
     * Buat akun demo instruktur (instruktur@sikarir.com), tautkan ke instruktur demo,
     * lalu isi contoh modul & materi pada jadwal yang ia ampu (bila jadwal sudah ada).
     */
    public function run(): void
    {
        $instruktur = Instruktur::where('nama', self::NAMA_INSTRUKTUR_DEMO)->first()
            ?? Instruktur::query()->orderBy('id')->first();

        if ($instruktur === null) {
            return;
        }

        $user = User::updateOrCreate(
            ['email' => 'instruktur@sikarir.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'instruktur',
            ]
        );

        $instruktur->update(['id_user' => $user->id]);

        $jadwal = JadwalPelatihan::where('id_instruktur', $instruktur->id)
            ->orderByRaw("CASE WHEN status = 'berlangsung' THEN 0 ELSE 1 END")
            ->orderBy('id_jadwal')
            ->first();

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
