<?php

namespace Database\Seeders;

use App\Models\AdminBlk;
use App\Models\Absen;
use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        // Admin BLK
        $adminUsers = User::factory(3)->create();

        $admins = collect();

        foreach ($adminUsers as $user) {
            $admins->push(
                AdminBlk::create([
                    'id_user' => $user->id,
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MITRA
        |--------------------------------------------------------------------------
        */

        $mitras = Mitra::factory(10)->create();

        /*
        |--------------------------------------------------------------------------
        | PESERTA
        |--------------------------------------------------------------------------
        */

        $pesertaUsers = User::factory(30)->create();

        $pesertas = collect();

        foreach ($pesertaUsers as $user) {
            $pesertas->push(
                Peserta::create([
                    'id_user' => $user->id,

                    'id_admin' => $admins->random()->id_admin,

                    'nomor_peserta' =>
                        'PST-' . fake()->unique()->numerify('######'),

                    'jenis_kelamin' => fake()->randomElement([
                        'Laki-laki',
                        'Perempuan',
                    ]),

                    'nomor_kk' =>
                        fake()->numerify('35################'),

                    'nomor_wa' =>
                        fake()->numerify('08##########'),

                    'tanggal_lahir' =>
                        fake()->dateTimeBetween(
                            '-35 years',
                            '-18 years'
                        )->format('Y-m-d'),

                    'tempat_lahir' =>
                        fake()->city(),

                    'alamat_lengkap' =>
                        fake()->address(),

                    'pendidikan_terakhir' =>
                        fake()->randomElement([
                            'SMA',
                            'SMK',
                            'D3',
                            'D4',
                            'S1',
                        ]),

                    'pendidikan_sekarang' =>
                        fake()->randomElement([
                            'Tidak sedang kuliah',
                            'Mahasiswa',
                        ]),

                    'pas_foto' => null,

                    'jurusan' =>
                        fake()->randomElement([
                            'Teknik Komputer dan Jaringan',
                            'Rekayasa Perangkat Lunak',
                            'Teknik Informatika',
                            'Multimedia',
                            'Akuntansi',
                            'Administrasi Perkantoran',
                        ]),
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | LOWONGAN
        |--------------------------------------------------------------------------
        */

        foreach (range(1, 15) as $i) {
            DaftarLowongan::create([
                'id_mitra' => $mitras->random()->id_mitra,

                'id_admin' => $admins->random()->id_admin,

                'judul_lowongan' => fake()->randomElement([
                    'Web Developer',
                    'Frontend Developer',
                    'Backend Developer',
                    'UI/UX Designer',
                    'Staff Administrasi',
                    'Digital Marketing',
                    'Teknisi Komputer',
                    'Customer Service',
                ]),

                'lokasi' => fake()->city(),

                'deskripsi' => fake()->paragraph(3),

                'kualifikasi' => fake()->paragraph(2),

                'tanggal_posting' =>
                    fake()->dateTimeBetween(
                        '-3 months',
                        'now'
                    )->format('Y-m-d'),

                'status' => fake()->randomElement([
                    'aktif',
                    'nonaktif',
                ]),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PELATIHAN
        |--------------------------------------------------------------------------
        */

        $pelatihans = collect();

        foreach (range(1, 10) as $i) {
            $pelatihans->push(
                DaftarPelatihan::create([
                    'id_admin' =>
                        $admins->random()->id_admin,

                    'nama_pelatihan' =>
                        fake()->randomElement([
                            'Pelatihan Web Development',
                            'Pelatihan Digital Marketing',
                            'Pelatihan Desain Grafis',
                            'Pelatihan Microsoft Office',
                            'Pelatihan Teknik Komputer',
                            'Pelatihan UI/UX Design',
                            'Pelatihan Bahasa Inggris',
                            'Pelatihan Administrasi Perkantoran',
                        ]),

                    'deskripsi_pelatihan' =>
                        fake()->paragraph(3),

                    'durasi_lp' =>
                        fake()->randomElement([
                            '40 JP',
                            '80 JP',
                            '120 JP',
                            '160 JP',
                        ]),

                    'kuota' =>
                        fake()->numberBetween(10, 30),
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | JADWAL PELATIHAN
        |--------------------------------------------------------------------------
        */

        $jadwals = collect();

        foreach ($pelatihans as $pelatihan) {
            $tanggalMulai = fake()->dateTimeBetween(
                'now',
                '+3 months'
            );

            $tanggalSelesai = clone $tanggalMulai;
            $tanggalSelesai->modify('+30 days');

            $jadwals->push(
                JadwalPelatihan::create([
                    'id_pelatihan' =>
                        $pelatihan->id_pelatihan,

                    'tanggal_mulai' =>
                        $tanggalMulai->format('Y-m-d'),

                    'tanggal_selesai' =>
                        $tanggalSelesai->format('Y-m-d'),

                    'jam_mulai' => '08:00:00',

                    'jam_selesai' => '16:00:00',

                    'instruktur' =>
                        fake()->name(),

                    'tempat' =>
                        fake()->randomElement([
                            'Ruang Pelatihan 1',
                            'Ruang Pelatihan 2',
                            'Laboratorium Komputer',
                            'Aula BLK',
                        ]),

                    'status' =>
                        fake()->randomElement([
                            'tersedia',
                            'berlangsung',
                            'selesai',
                        ]),
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KELAS PELATIHAN
        |--------------------------------------------------------------------------
        */

        foreach ($jadwals as $jadwal) {

            // Ambil 5 peserta untuk setiap kelas
            $selectedPesertas = $pesertas
                ->random(min(5, $pesertas->count()));

            foreach ($selectedPesertas as $peserta) {

                KelasPelatihan::firstOrCreate(
                    [
                        'id_peserta' =>
                            $peserta->id_peserta,

                        'id_jadwal' =>
                            $jadwal->id_jadwal,
                    ],
                    [
                        'status' =>
                            fake()->randomElement([
                                'terdaftar',
                                'aktif',
                                'selesai',
                            ]),
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ABSENSI
        |--------------------------------------------------------------------------
        */

        foreach ($jadwals as $jadwal) {

            $kelas = KelasPelatihan::where(
                'id_jadwal',
                $jadwal->id_jadwal
            )->get();

            foreach ($kelas as $dataKelas) {

                // Buat 5 hari absensi
                for ($i = 0; $i < 5; $i++) {

                    $tanggal = fake()
                        ->dateTimeBetween(
                            $jadwal->tanggal_mulai,
                            $jadwal->tanggal_selesai
                        )
                        ->format('Y-m-d');

                    Absen::firstOrCreate(
                        [
                            'id_jadwal' =>
                                $jadwal->id_jadwal,

                            'id_peserta' =>
                                $dataKelas->id_peserta,

                            'tanggal' =>
                                $tanggal,
                        ],
                        [
                            'jam_hadir' =>
                                fake()->randomElement([
                                    '07:45:00',
                                    '08:00:00',
                                    '08:15:00',
                                    null,
                                ]),

                            'status_kehadiran' =>
                                fake()->randomElement([
                                    'hadir',
                                    'hadir',
                                    'hadir',
                                    'izin',
                                    'sakit',
                                    'alpa',
                                ]),

                            'keterangan' =>
                                fake()->optional()->sentence(),
                        ]
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SERTIFIKAT
        |--------------------------------------------------------------------------
        */

        foreach ($jadwals as $jadwal) {

            $kelas = KelasPelatihan::where(
                'id_jadwal',
                $jadwal->id_jadwal
            )
            ->where('status', 'selesai')
            ->get();

            foreach ($kelas as $dataKelas) {

                Sertifikat::firstOrCreate(
                    [
                        'id_jadwal' =>
                            $jadwal->id_jadwal,

                        'id_peserta' =>
                            $dataKelas->id_peserta,
                    ],
                    [
                        'no_sertifikat' =>
                            'SRT-' .
                            fake()->unique()->numerify('########'),

                        'tanggal_terbit' =>
                            now()->format('Y-m-d'),

                        'file_sertifikat' => null,

                        'id_admin' =>
                            $admins->random()->id_admin,
                    ]
                );
            }
        }
    }
}