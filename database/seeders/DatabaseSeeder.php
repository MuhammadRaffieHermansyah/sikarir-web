<?php

namespace Database\Seeders;

use App\Models\Absen;
use App\Models\AdminBlk;
use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\DurasiPelatihan;
use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\LamaranLowongan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\RuanganWorkshop;
use App\Models\Sertifikat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. MASTER DATA: DURASI, INSTRUKTUR, RUANGAN
        |--------------------------------------------------------------------------
        */
        $this->call([
            DurasiPelatihanSeeder::class,
            InstrukturSeeder::class,
            RuanganWorkshopSeeder::class,
        ]);

        $durations = DurasiPelatihan::all();
        $instrukturs = Instruktur::all();
        $ruanganWorkshops = RuanganWorkshop::all();

        /*
        |--------------------------------------------------------------------------
        | 2. USERS: AKUN DEMO RESMI & AKUN TAMBAHAN
        |--------------------------------------------------------------------------
        */

        // Admin Demo Utama
        $demoAdminUser = User::updateOrCreate(
            ['email' => 'admin@sikarir.com'],
            [
                'name' => 'Admin BLK Pusat',
                'password' => Hash::make('password'),
                'role' => 'admin_blk',
            ]
        );
        $demoAdmin = AdminBlk::firstOrCreate(['id_user' => $demoAdminUser->id]);

        // Tambah Admin lain
        $otherAdminUsers = User::factory(2)->adminBlk()->create();
        $admins = collect([$demoAdmin]);
        foreach ($otherAdminUsers as $u) {
            $admins->push(AdminBlk::firstOrCreate(['id_user' => $u->id]));
        }

        // Mitra Demo Utama
        $demoMitraUser = User::updateOrCreate(
            ['email' => 'mitra@sikarir.com'],
            [
                'name' => 'HRD PT Midtrans Indonesia',
                'password' => Hash::make('password'),
                'role' => 'mitra',
            ]
        );
        $demoMitra = Mitra::updateOrCreate(
            ['id_user' => $demoMitraUser->id],
            [
                'nama_perusahaan' => 'PT Midtrans Indonesia',
                'jenis_mitra' => 'Perusahaan Nasional',
                'logo_perusahaan' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=200&auto=format&fit=crop&q=80',
                'provinsi' => 'DKI Jakarta',
                'kota' => 'Jakarta Selatan',
                'alamat' => 'MidPlaza 2, Lt. 4, Jl. Jend. Sudirman Kav. 10-11',
                'no_telp' => '021-50858888',
                'no_izin' => 'SK-MITRA-001/BLK/2026',
                'jabatan_pic' => 'Head of Talent Acquisition',
                'bidang_usaha' => 'Financial Technology & Software Development',
            ]
        );

        // Mitra Industri Tambahan
        $mitraList = [
            [
                'name' => 'PT Astra Daihatsu Motor',
                'email' => 'recruitment@daihatsu.astra.co.id',
                'logo' => 'https://images.unsplash.com/photo-1549923746-c502d488b3ea?w=200&auto=format&fit=crop&q=80',
                'kota' => 'Jakarta Utara',
                'bidang' => 'Manufaktur Otomotif & Perakitan Kendaraan',
            ],
            [
                'name' => 'PT Kalbe Farma Tbk',
                'email' => 'hr@kalbe.co.id',
                'logo' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=200&auto=format&fit=crop&q=80',
                'kota' => 'Surabaya',
                'bidang' => 'Farmasi, Logistik & Distribusi Medis',
            ],
            [
                'name' => 'PT Telkom Indonesia (Persero) Tbk',
                'email' => 'talent@telkom.co.id',
                'logo' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=200&auto=format&fit=crop&q=80',
                'kota' => 'Bandung',
                'bidang' => 'Telekomunikasi, Cloud & Jaringan Digital',
            ],
            [
                'name' => 'PT Komatsu Indonesia',
                'email' => 'career@komatsu.co.id',
                'logo' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=200&auto=format&fit=crop&q=80',
                'kota' => 'Bekasi',
                'bidang' => 'Alat Berat & Fabrikasi Pengelasan',
            ],
        ];

        $mitras = collect([$demoMitra]);
        foreach ($mitraList as $m) {
            $u = User::updateOrCreate(
                ['email' => $m['email']],
                [
                    'name' => 'HR ' . $m['name'],
                    'password' => Hash::make('password'),
                    'role' => 'mitra',
                ]
            );
            $mitraObj = Mitra::updateOrCreate(
                ['id_user' => $u->id],
                [
                    'nama_perusahaan' => $m['name'],
                    'jenis_mitra' => 'Perusahaan BUMN & Swasta',
                    'logo_perusahaan' => $m['logo'],
                    'provinsi' => 'Jawa Timur',
                    'kota' => $m['kota'],
                    'alamat' => 'Kawasan Industri Terpadu No. ' . fake()->buildingNumber(),
                    'no_telp' => fake()->numerify('021-########'),
                    'no_izin' => 'SK-MITRA-' . fake()->numerify('###') . '/2026',
                    'jabatan_pic' => 'HR Manager',
                    'bidang_usaha' => $m['bidang'],
                ]
            );
            $mitras->push($mitraObj);
        }

        // Peserta Demo Utama (Data Lengkap)
        $demoPesertaUser = User::updateOrCreate(
            ['email' => 'peserta@sikarir.com'],
            [
                'name' => 'Ahmad Syahputra',
                'password' => Hash::make('password'),
                'role' => 'peserta',
            ]
        );
        $demoPeserta = Peserta::updateOrCreate(
            ['id_user' => $demoPesertaUser->id],
            [
                'id_admin' => $demoAdmin->id_admin,
                'nomor_peserta' => 'PST-2026-0001',
                'jenis_kelamin' => 'Laki-laki',
                'nomor_kk' => '3509120101990002',
                'nomor_wa' => '081234567890',
                'tanggal_lahir' => '2001-05-15',
                'tempat_lahir' => 'Jember',
                'alamat_lengkap' => 'Jl. Kalimantan No. 37, Sumbersari, Jember, Jawa Timur',
                'pendidikan_terakhir' => 'SMK',
                'pendidikan_sekarang' => 'Alumni Pelatihan BLK',
                'pas_foto' => null,
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ]
        );

        // Peserta Tambahan
        $pesertaUsers = User::factory(8)->peserta()->create();
        $pesertas = collect([$demoPeserta]);
        foreach ($pesertaUsers as $u) {
            $peserta = Peserta::create([
                'id_user' => $u->id,
                'id_admin' => $admins->random()->id_admin,
                'nomor_peserta' => 'PST-' . fake()->unique()->numerify('######'),
                'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
                'nomor_kk' => fake()->numerify('35################'),
                'nomor_wa' => fake()->numerify('08##########'),
                'tanggal_lahir' => fake()->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
                'tempat_lahir' => fake()->city(),
                'alamat_lengkap' => fake()->address(),
                'pendidikan_terakhir' => fake()->randomElement(['SMA', 'SMK', 'D3', 'S1']),
                'pendidikan_sekarang' => 'Pencari Kerja',
                'pas_foto' => null,
                'jurusan' => fake()->randomElement(['Teknik Informatika', 'Desain Komunikasi Visual', 'Teknik Mesin', 'Administrasi Perkantoran']),
            ]);
            $pesertas->push($peserta);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. DAFTAR PELATIHAN
        |--------------------------------------------------------------------------
        */
        $pelatihanData = [
            [
                'nama' => 'Desain Grafis & UI/UX Design',
                'deskripsi' => 'Penguasaan prinsip tata letak, typography, Adobe Illustrator, Figma, dan pembuatan design system siap industri.',
                'kuota' => 20,
            ],
            [
                'nama' => 'Junior Web & Mobile Developer',
                'deskripsi' => 'Pemrograman web modern dengan HTML, Tailwind CSS, JavaScript, Laravel REST API, dan Flutter dasar.',
                'kuota' => 25,
            ],
            [
                'nama' => 'Teknik Las Industri 3G/4G SMAW',
                'deskripsi' => 'Spesialisasi pengelasan pelat posisi 3G & 4G bersertifikasi BNSP dan uji standar ASME fabrikasi berat.',
                'kuota' => 16,
            ],
            [
                'nama' => 'Teknisi Kendaraan Listrik (EV) & Injeksi',
                'deskripsi' => 'Arsitektur baterai high-voltage motor & mobil listrik, kalibrasi ECU injeksi cerdas, dan diagnosa scanner.',
                'kuota' => 20,
            ],
            [
                'nama' => 'Digital Marketing & Social Media Specialist',
                'deskripsi' => 'Penyusunan kampanye iklan Google Ads, Meta Ads, SEO on-page/off-page, dan analisis performa metrik digital.',
                'kuota' => 30,
            ],
        ];

        $pelatihans = collect();
        foreach ($pelatihanData as $idx => $item) {
            $durasiItem = $durations[$idx % $durations->count()] ?? $durations->first();
            $pelatihans->push(
                DaftarPelatihan::create([
                    'id_admin' => $demoAdmin->id_admin,
                    'nama_pelatihan' => $item['nama'],
                    'deskripsi_pelatihan' => $item['deskripsi'],
                    'id_durasi' => $durasiItem->id_durasi,
                    'kuota' => $item['kuota'],
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. JADWAL PELATIHAN DENGAN GPS BLK JEMBER
        |--------------------------------------------------------------------------
        */
        $jadwals = collect();

        // Jadwal 1: Sedang Berlangsung (Aktif hari ini)
        $jadwalAktif = JadwalPelatihan::create([
            'id_pelatihan' => $pelatihans[0]->id_pelatihan,
            'tanggal_mulai' => Carbon::now()->subDays(10)->format('Y-m-d'),
            'tanggal_selesai' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '15:00:00',
            'id_instruktur' => $instrukturs->first()->id,
            'id_ruangan_workshop' => $ruanganWorkshops->first()->id,
            'lokasi_latitude' => -8.1763,
            'lokasi_longitude' => 113.7007,
            'radius_meter' => 100,
            'status' => 'berlangsung',
        ]);
        $jadwals->push($jadwalAktif);

        // Jadwal 2: Selesai (Untuk pembuktian sertifikat)
        $jadwalSelesai = JadwalPelatihan::create([
            'id_pelatihan' => $pelatihans[1]->id_pelatihan,
            'tanggal_mulai' => Carbon::now()->subDays(60)->format('Y-m-d'),
            'tanggal_selesai' => Carbon::now()->subDays(15)->format('Y-m-d'),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '16:00:00',
            'id_instruktur' => $instrukturs[1]->id ?? $instrukturs->first()->id,
            'id_ruangan_workshop' => $ruanganWorkshops[1]->id ?? $ruanganWorkshops->first()->id,
            'lokasi_latitude' => -8.1763,
            'lokasi_longitude' => 113.7007,
            'radius_meter' => 100,
            'status' => 'selesai',
        ]);
        $jadwals->push($jadwalSelesai);

        // Jadwal 3-5: Tersedia / Akan Datang
        for ($i = 2; $i < $pelatihans->count(); $i++) {
            $jadwals->push(
                JadwalPelatihan::create([
                    'id_pelatihan' => $pelatihans[$i]->id_pelatihan,
                    'tanggal_mulai' => Carbon::now()->addDays(15 + ($i * 7))->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::now()->addDays(45 + ($i * 7))->format('Y-m-d'),
                    'jam_mulai' => '08:30:00',
                    'jam_selesai' => '15:30:00',
                    'id_instruktur' => $instrukturs[$i % $instrukturs->count()]->id,
                    'id_ruangan_workshop' => $ruanganWorkshops[$i % $ruanganWorkshops->count()]->id,
                    'lokasi_latitude' => -8.1763,
                    'lokasi_longitude' => 113.7007,
                    'radius_meter' => 100,
                    'status' => 'tersedia',
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 5. KELAS PELATIHAN SAYA (PESERTA DEMO & LAINNYA)
        |--------------------------------------------------------------------------
        */

        // Peserta demo didaftarkan ke jadwal aktif (berlangsung)
        KelasPelatihan::create([
            'id_peserta' => $demoPeserta->id_peserta,
            'id_jadwal' => $jadwalAktif->id_jadwal,
            'status' => 'berlangsung',
        ]);

        // Peserta demo didaftarkan ke jadwal selesai (lulus)
        KelasPelatihan::create([
            'id_peserta' => $demoPeserta->id_peserta,
            'id_jadwal' => $jadwalSelesai->id_jadwal,
            'status' => 'selesai',
        ]);

        // Daftarkan peserta lainnya ke jadwal-jadwal
        foreach ($jadwals as $jadwal) {
            $otherPesertas = $pesertas->where('id_peserta', '!=', $demoPeserta->id_peserta)->random(min(4, $pesertas->count() - 1));
            foreach ($otherPesertas as $p) {
                KelasPelatihan::firstOrCreate(
                    [
                        'id_peserta' => $p->id_peserta,
                        'id_jadwal' => $jadwal->id_jadwal,
                    ],
                    [
                        'status' => $jadwal->status == 'selesai' ? 'selesai' : ($jadwal->status == 'berlangsung' ? 'berlangsung' : 'terdaftar'),
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 6. RIWAYAT ABSENSI DENGAN GPS
        |--------------------------------------------------------------------------
        */
        // Buat 5 hari riwayat absensi untuk peserta demo di kelas aktif
        for ($day = 5; $day >= 1; $day--) {
            $tgl = Carbon::now()->subDays($day)->format('Y-m-d');
            Absen::firstOrCreate(
                [
                    'id_jadwal' => $jadwalAktif->id_jadwal,
                    'id_peserta' => $demoPeserta->id_peserta,
                    'tanggal' => $tgl,
                ],
                [
                    'jam_hadir' => '07:5' . rand(2, 8) . ':00',
                    'status_kehadiran' => 'hadir',
                    'latitude' => -8.1763120,
                    'longitude' => 113.7007150,
                    'jarak_meter' => rand(10, 35),
                    'keterangan' => 'Presensi GPS tervalidasi di Lab Komputer BLK',
                ]
            );
        }

        // Absensi hari ini untuk peserta demo
        Absen::firstOrCreate(
            [
                'id_jadwal' => $jadwalAktif->id_jadwal,
                'id_peserta' => $demoPeserta->id_peserta,
                'tanggal' => Carbon::today()->format('Y-m-d'),
            ],
            [
                'jam_hadir' => '07:58:30',
                'status_kehadiran' => 'hadir',
                'latitude' => -8.1762950,
                'longitude' => 113.7006980,
                'jarak_meter' => 18.5,
                'keterangan' => 'Presensi hadir tepat waktu via SIKARIR Mobile',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 7. SERTIFIKAT KELULUSAN
        |--------------------------------------------------------------------------
        */
        Sertifikat::firstOrCreate(
            [
                'id_jadwal' => $jadwalSelesai->id_jadwal,
                'id_peserta' => $demoPeserta->id_peserta,
            ],
            [
                'no_sertifikat' => 'SRT-2026-BLK-001',
                'tanggal_terbit' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'file_sertifikat' => 'sertifikat/demo_sertifikat.pdf',
                'id_admin' => $demoAdmin->id_admin,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 8. DAFTAR LOWONGAN KERJA & LAMARAN
        |--------------------------------------------------------------------------
        */
        $lowonganData = [
            [
                'id_mitra' => $demoMitra->id_mitra,
                'judul' => 'Junior Web & UI Developer',
                'lokasi' => 'Jakarta Selatan (Hybrid)',
                'deskripsi' => 'Pengembangan antarmuka dashboard pembayaran dan integrasi payment gateway Midtrans bersama tim engineering.',
                'kualifikasi' => 'Alumni BLK Jurusan TIK/RPL, menguasai HTML, CSS, JavaScript, dasar REST API, dan antusias belajar teknologi web modern.',
            ],
            [
                'id_mitra' => $mitras[1]->id_mitra,
                'judul' => 'Draftsman AutoCAD 2D/3D & Desain Cetakan',
                'lokasi' => 'Sunter, Jakarta Utara',
                'deskripsi' => 'Pembuatan rancangan gambar teknik komponen bodi mobil menggunakan AutoCAD & CATIA untuk lini produksi stamping.',
                'kualifikasi' => 'Lulusan Otomotif/Teknik Mesin BLK, mampu membaca gambar teknik, disiplin, dan memiliki sertifikat kompetensi BNSP.',
            ],
            [
                'id_mitra' => $mitras[2]->id_mitra,
                'judul' => 'Staff Administrasi Gudang & Logistik',
                'lokasi' => 'Surabaya, Jawa Timur',
                'deskripsi' => 'Pengelolaan data inventori obat, monitoring stock opname harian, dan koordinasi distribusi obat antar cabang.',
                'kualifikasi' => 'Lulusan Administrasi Perkantoran / Manajemen BLK, mahir Microsoft Excel (VLOOKUP, Pivot Table), teliti dan cekatan.',
            ],
            [
                'id_mitra' => $mitras[3]->id_mitra,
                'judul' => 'Network & Fiber Optic Technician',
                'lokasi' => 'Jember & Sekitarnya',
                'deskripsi' => 'Instalasi, maintenance, dan splicing kabel fiber optik jaringan IndiHome serta troubleshooting perangkat ODP/ONT pelanggan.',
                'kualifikasi' => 'Lulusan Teknik Komputer Jaringan BLK, memiliki sertifikat K3 dasar, tidak takut ketinggian, dan memiliki SIM C aktif.',
            ],
            [
                'id_mitra' => $mitras[4]->id_mitra,
                'judul' => 'Welder Fabrikasi 3G SMAW / GMAW',
                'lokasi' => 'Bekasi, Jawa Barat',
                'deskripsi' => 'Pengerjaan pengelasan struktur baja alat berat berstandar ASME dan ISO 9001 di workshop manufaktur Komatsu.',
                'kualifikasi' => 'Lulusan Teknik Las BLK, lolos uji visual weld test posisi 3G, siap bekerja shift dan penempatan Bekasi.',
            ],
        ];

        $lowongans = collect();
        foreach ($lowonganData as $l) {
            $lowongans->push(
                DaftarLowongan::create([
                    'id_mitra' => $l['id_mitra'],
                    'judul_lowongan' => $l['judul'],
                    'lokasi' => $l['lokasi'],
                    'deskripsi' => $l['deskripsi'],
                    'kualifikasi' => $l['kualifikasi'],
                    'tanggal_posting' => Carbon::now()->subDays(rand(3, 15))->format('Y-m-d'),
                    'status' => 'aktif',
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 9. LAMARAN LOWONGAN
        |--------------------------------------------------------------------------
        */
        // Peserta demo melamar ke lowongan 1 (Junior Web Developer)
        LamaranLowongan::firstOrCreate(
            [
                'id_lowongan' => $lowongans[0]->id_lowongan,
                'id_peserta' => $demoPeserta->id_peserta,
            ],
            [
                'tanggal_melamar' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'status' => 'diproses',
                'catatan_pelamar' => 'Saya lulusan terbaik Pelatihan Web BLK Jember dengan portofolio proyek payment dashboard.',
                'catatan_mitra' => 'Kandidat potensial, jadwalkan tes teknis online minggu depan.',
                'resume_url' => 'https://example.com/resumes/ahmad_syahputra_cv.pdf',
            ]
        );

        // Peserta demo melamar ke lowongan 4 (Network Technician)
        LamaranLowongan::firstOrCreate(
            [
                'id_lowongan' => $lowongans[3]->id_lowongan,
                'id_peserta' => $demoPeserta->id_peserta,
            ],
            [
                'tanggal_melamar' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'status' => 'melamar',
                'catatan_pelamar' => 'Berminat pada penempatan area Jember dan sekitarnya.',
                'catatan_mitra' => null,
                'resume_url' => 'https://example.com/resumes/ahmad_syahputra_cv.pdf',
            ]
        );

        // Peserta lain juga melamar ke lowongan-lowongan yang ada
        foreach ($lowongans as $lowongan) {
            $applicantPesertas = $pesertas->where('id_peserta', '!=', $demoPeserta->id_peserta)->random(min(3, $pesertas->count() - 1));
            foreach ($applicantPesertas as $p) {
                LamaranLowongan::firstOrCreate(
                    [
                        'id_lowongan' => $lowongan->id_lowongan,
                        'id_peserta' => $p->id_peserta,
                    ],
                    [
                        'tanggal_melamar' => Carbon::now()->subDays(rand(1, 10))->format('Y-m-d'),
                        'status' => fake()->randomElement(['melamar', 'diproses', 'wawancara', 'diterima', 'ditolak']),
                        'catatan_pelamar' => fake()->optional()->sentence(),
                        'catatan_mitra' => fake()->optional()->sentence(),
                        'resume_url' => 'https://example.com/resumes/' . fake()->uuid() . '.pdf',
                    ]
                );
            }
        }
    }
}
