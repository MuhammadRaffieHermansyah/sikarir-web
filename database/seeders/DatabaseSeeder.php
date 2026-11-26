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
use App\Models\SesiPresensi;
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
            BidangKeahlianSeeder::class,
            InstrukturSeeder::class,
            RuanganWorkshopSeeder::class,
            // Akun instruktur@sikarir.com ditautkan sejak awal agar seluruh
            // pelatihan & jadwal miliknya langsung terhubung ke akun tersebut.
            InstrukturAkunSeeder::class,
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
                'password' => Hash::make('password'),
                'role' => 'admin_blk',
            ]
        );
        $demoAdmin = AdminBlk::firstOrCreate(['id_user' => $demoAdminUser->id], ['nama' => 'Admin BLK Pusat']);

        // Tambah Admin lain
        $otherAdminUsers = User::factory(2)->adminBlk()->create();
        $admins = collect([$demoAdmin]);
        foreach ($otherAdminUsers as $u) {
            $admins->push(AdminBlk::firstOrCreate(['id_user' => $u->id], ['nama' => fake()->name()]));
        }

        // Mitra Demo Utama
        $demoMitraUser = User::updateOrCreate(
            ['email' => 'mitra@sikarir.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'mitra',
            ]
        );
        $demoMitra = Mitra::updateOrCreate(
            ['id_user' => $demoMitraUser->id],
            [
                'nama' => 'HRD PT Midtrans Indonesia',
                'nama_perusahaan' => 'PT Midtrans Indonesia',
                'jenis_mitra' => 'Perusahaan Nasional',
                'logo_perusahaan' => null,
                'provinsi' => 'DKI Jakarta',
                'kota' => 'Jakarta Selatan',
                'alamat' => 'MidPlaza 2, Lt. 4, Jl. Jend. Sudirman Kav. 10-11',
                'no_telp' => '021-50858888',
                'no_izin' => 'SK-MITRA-001/BLK/2026',
                'jabatan_pic' => 'Head of Talent Acquisition',
                'bidang_usaha' => 'Financial Technology & Software Development',
                'is_verified' => true,
                'verified_at' => now(),
            ]
        );

        // Mitra Industri Tambahan
        $mitraList = [
            [
                'name' => 'PT Astra Daihatsu Motor',
                'email' => 'recruitment@daihatsu.astra.co.id',
                'logo' => null,
                'kota' => 'Jakarta Utara',
                'bidang' => 'Manufaktur Otomotif & Perakitan Kendaraan',
            ],
            [
                'name' => 'PT Kalbe Farma Tbk',
                'email' => 'hr@kalbe.co.id',
                'logo' => null,
                'kota' => 'Surabaya',
                'bidang' => 'Farmasi, Logistik & Distribusi Medis',
            ],
            [
                'name' => 'PT Telkom Indonesia (Persero) Tbk',
                'email' => 'talent@telkom.co.id',
                'logo' => null,
                'kota' => 'Bandung',
                'bidang' => 'Telekomunikasi, Cloud & Jaringan Digital',
            ],
            [
                'name' => 'PT Komatsu Indonesia',
                'email' => 'career@komatsu.co.id',
                'logo' => null,
                'kota' => 'Bekasi',
                'bidang' => 'Alat Berat & Fabrikasi Pengelasan',
            ],
        ];

        $mitras = collect([$demoMitra]);
        foreach ($mitraList as $m) {
            $u = User::updateOrCreate(
                ['email' => $m['email']],
                [
                    'password' => Hash::make('password'),
                    'role' => 'mitra',
                ]
            );
            $mitraObj = Mitra::updateOrCreate(
                ['id_user' => $u->id],
                [
                    'nama' => 'HR '.$m['name'],
                    'nama_perusahaan' => $m['name'],
                    'jenis_mitra' => 'Perusahaan BUMN & Swasta',
                    'logo_perusahaan' => $m['logo'],
                    'provinsi' => 'Jawa Timur',
                    'kota' => $m['kota'],
                    'alamat' => 'Kawasan Industri Terpadu No. '.fake()->buildingNumber(),
                    'no_telp' => fake()->numerify('021-########'),
                    'no_izin' => 'SK-MITRA-'.fake()->numerify('###').'/2026',
                    'jabatan_pic' => 'HR Manager',
                    'bidang_usaha' => $m['bidang'],
                    'is_verified' => true,
                    'verified_at' => now(),
                ]
            );
            $mitras->push($mitraObj);
        }

        // Peserta Demo Utama (Data Lengkap)
        $demoPesertaUser = User::updateOrCreate(
            ['email' => 'peserta@sikarir.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'peserta',
            ]
        );
        $demoPeserta = Peserta::updateOrCreate(
            ['id_user' => $demoPesertaUser->id],
            [
                'nama' => 'Ahmad Syahputra',
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
                'nama' => fake()->name(),
                'id_admin' => $admins->random()->id_admin,
                'nomor_peserta' => 'PST-'.fake()->unique()->numerify('######'),
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
                'instruktur' => InstrukturAkunSeeder::NAMA_INSTRUKTUR_DEMO,
                'deskripsi' => 'Penguasaan prinsip tata letak, typography, Adobe Illustrator, Figma, dan pembuatan design system siap industri.',
                'kuota' => 20,
            ],
            [
                'nama' => 'Junior Web & Mobile Developer',
                'instruktur' => InstrukturAkunSeeder::NAMA_INSTRUKTUR_DEMO,
                'deskripsi' => 'Pemrograman web modern dengan HTML, Tailwind CSS, JavaScript, Laravel REST API, dan Flutter dasar.',
                'kuota' => 25,
            ],
            [
                'nama' => 'Teknik Las Industri 3G/4G SMAW',
                'instruktur' => 'Agus Prasetyo',
                'deskripsi' => 'Spesialisasi pengelasan pelat posisi 3G & 4G bersertifikasi BNSP dan uji standar ASME fabrikasi berat.',
                'kuota' => 16,
            ],
            [
                'nama' => 'Teknisi Kendaraan Listrik (EV) & Injeksi',
                'instruktur' => 'Hendra Gunawan',
                'deskripsi' => 'Arsitektur baterai high-voltage motor & mobil listrik, kalibrasi ECU injeksi cerdas, dan diagnosa scanner.',
                'kuota' => 20,
            ],
            [
                'nama' => 'Digital Marketing & Social Media Specialist',
                'instruktur' => 'Nurul Hidayah',
                'deskripsi' => 'Penyusunan kampanye iklan Google Ads, Meta Ads, SEO on-page/off-page, dan analisis performa metrik digital.',
                'kuota' => 30,
            ],
            [
                'nama' => 'Administrasi Perkantoran & Akuntansi Dasar',
                'instruktur' => 'Ahmad Fauzi',
                'deskripsi' => 'Pengelolaan dokumen, Microsoft Office (Word, Excel, PowerPoint), korespondensi bisnis, dan pembukuan akuntansi dasar.',
                'kuota' => 24,
            ],
            [
                'nama' => 'Teknisi Jaringan Komputer & Fiber Optik',
                'instruktur' => 'Siti Aminah',
                'deskripsi' => 'Instalasi LAN/WAN, konfigurasi router Mikrotik, crimping kabel UTP, dan splicing fiber optik untuk jaringan internet.',
                'kuota' => 20,
            ],
            [
                'nama' => 'Teknisi Otomotif Kendaraan Ringan',
                'instruktur' => 'Bambang Hermanto',
                'deskripsi' => 'Servis berkala, tune-up mesin bensin, sistem rem & kelistrikan bodi, serta diagnosa kerusakan kendaraan ringan.',
                'kuota' => 18,
            ],
        ];

        $pelatihans = collect();
        foreach ($pelatihanData as $idx => $item) {
            $durasiItem = $durations[$idx % $durations->count()] ?? $durations->first();
            $pelatihans->push(
                DaftarPelatihan::create([
                    'id_admin' => $demoAdmin->id_admin,
                    'id_instruktur' => ($instrukturs->firstWhere('nama', $item['instruktur']) ?? $instrukturs->first())->id,
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
            'id_instruktur' => $pelatihans[0]->id_instruktur,
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
            'id_instruktur' => $pelatihans[1]->id_instruktur,
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
                    'id_instruktur' => $pelatihans[$i]->id_instruktur,
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
        // Sesi presensi pertemuan 1-5 (sudah ditutup) milik instruktur pengampu,
        // lalu absensi peserta kelas aktif ditautkan ke sesi tersebut.
        // Hari ini sengaja dikosongkan: instruktur membuat & membuka sesi
        // pertemuan 6, lalu peserta melakukan presensi dari akunnya.
        $pesertaKelasAktif = KelasPelatihan::where('id_jadwal', $jadwalAktif->id_jadwal)->pluck('id_peserta');

        for ($pertemuan = 1; $pertemuan <= 5; $pertemuan++) {
            $tanggalSesi = Carbon::today()->subDays(6 - $pertemuan);

            $sesi = SesiPresensi::firstOrCreate(
                [
                    'id_jadwal' => $jadwalAktif->id_jadwal,
                    'pertemuan_ke' => $pertemuan,
                ],
                [
                    'id_instruktur' => $jadwalAktif->id_instruktur,
                    'tanggal' => $tanggalSesi->format('Y-m-d'),
                    'jam_mulai' => '08:00',
                    'jam_selesai' => '10:00',
                    'lokasi_latitude' => -8.1763,
                    'lokasi_longitude' => 113.7007,
                    'radius_meter' => 100,
                    'absen_dibuka' => false,
                ]
            );

            foreach ($pesertaKelasAktif as $idPeserta) {
                $isDemoPeserta = $idPeserta === $demoPeserta->id_peserta;
                $statusKehadiran = $isDemoPeserta ? 'hadir' : fake()->randomElement(['hadir', 'hadir', 'hadir', 'izin', 'sakit']);
                $isHadir = $statusKehadiran === 'hadir';

                Absen::firstOrCreate(
                    [
                        'id_jadwal' => $jadwalAktif->id_jadwal,
                        'id_peserta' => $idPeserta,
                        'tanggal' => $sesi->tanggal->format('Y-m-d'),
                    ],
                    [
                        'id_sesi' => $isHadir ? $sesi->id_sesi : null,
                        'jam_hadir' => $isHadir ? '07:5'.rand(2, 8).':00' : null,
                        'status_kehadiran' => $statusKehadiran,
                        'latitude' => $isHadir ? -8.1763120 : null,
                        'longitude' => $isHadir ? 113.7007150 : null,
                        'jarak_meter' => $isHadir ? rand(10, 35) : null,
                        'keterangan' => $isHadir ? 'Presensi GPS tervalidasi di Lab Komputer BLK' : 'Pengajuan '.$statusKehadiran.' peserta',
                    ]
                );
            }
        }

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

        // Contoh modul & materi untuk kelas yang diampu instruktur demo
        $this->call(InstrukturAkunSeeder::class);

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
            [
                'id_mitra' => $demoMitra->id_mitra,
                'judul' => 'Customer Service Payment Support',
                'lokasi' => 'Jakarta Selatan (Onsite)',
                'deskripsi' => 'Menangani pertanyaan merchant melalui email dan live chat serta mengeskalasi kendala transaksi ke tim teknis.',
                'kualifikasi' => 'Lulusan SMA/SMK/D3 semua jurusan, komunikasi baik, teliti, dan bersedia bekerja dengan sistem shift.',
            ],
            [
                'id_mitra' => $mitras[1]->id_mitra,
                'judul' => 'Teknisi Otomotif Quality Control',
                'lokasi' => 'Karawang, Jawa Barat',
                'deskripsi' => 'Inspeksi kualitas hasil perakitan kendaraan, pengujian fungsi kelistrikan, dan pelaporan temuan ke lini produksi.',
                'kualifikasi' => 'Lulusan Teknik Kendaraan Ringan BLK/SMK, memahami standar QC, dan siap penempatan di Karawang.',
            ],
            [
                'id_mitra' => $mitras[2]->id_mitra,
                'judul' => 'Digital Marketing Officer',
                'lokasi' => 'Surabaya (Hybrid)',
                'deskripsi' => 'Mengelola kampanye media sosial dan iklan digital untuk produk kesehatan serta melaporkan performa mingguan.',
                'kualifikasi' => 'Alumni pelatihan Digital Marketing BLK, memahami Meta Ads dan Google Analytics, serta kreatif membuat konten.',
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
                        'resume_url' => 'https://example.com/resumes/'.fake()->uuid().'.pdf',
                    ]
                );
            }
        }

        // Gambar demo (pelatihan, lowongan, logo mitra, foto) -> storage publik
        $this->call(GambarDemoSeeder::class);

        // File PDF untuk sertifikat demo -> storage publik
        $this->call(SertifikatDemoSeeder::class);
    }
}
