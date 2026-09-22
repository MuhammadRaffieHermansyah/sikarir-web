@extends('layouts.public')

@section('title', 'Tentang BLK - siKarir UPT BLK Jember')

@section('content')

    {{-- TOP INFO BAR --}}
    <div class="bg-[#F5F7FA] border-b text-xs">
        <div class="max-w-7xl mx-auto px-6 py-2 flex flex-col md:flex-row justify-between gap-1 text-[#3F493F]">
            <p><a href="{{ url('/') }}" class="hover:text-[#00652C]">Beranda</a> &rsaquo; <span class="text-[#00652C] font-medium">Tentang BLK</span></p>
            <p>&bull; AKREDITASI & LISENSI RESMI BNSP &nbsp; SK DISNAKERTRANS JATIM NO. 188/45/108.3/2023</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- HERO --}}
        <span class="inline-block bg-[#D3FFD5] text-[#00652C] text-xs font-semibold px-3 py-1 rounded-full mb-4">
            🏛 LEMBAGA VOKASI PEMERINTAH PROVINSI JAWA TIMUR
        </span>
        <div class="grid md:grid-cols-2 gap-8 items-start mb-10">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Profil & Komitmen Kejuruan <span class="text-[#00652C]">UPT BLK Jember</span></h1>
                <p class="text-sm text-[#3F493F] mb-6">
                    Lembaga Pelatihan Vokasi Pemerintah Provinsi Jawa Timur Pencetak Tenaga Terampil Siap Kerja,
                    Berdaya Saing Global, dan Tersertifikasi Nasional BNSP melalui pembiayaan APBD & APBN secara
                    gratis dan transparan.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ([
                        ['value' => '12+', 'label' => 'Kejuruan Unggulan'],
                        ['value' => '94.8%', 'label' => 'Kelulusan BNSP'],
                        ['value' => '180+', 'label' => 'Mitra Industri (DUDI)'],
                        ['value' => '31', 'label' => 'Kecamatan MTU Jember'],
                    ] as $s)
                        <div>
                            <p class="text-2xl font-bold text-[#00652C]">{{ $s['value'] }}</p>
                            <p class="text-xs text-[#3F493F]">{{ $s['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <img src="{{ asset('images/lab-terpadu-vokasi.jpg') }}" class="w-full h-72 object-cover rounded-xl" alt="Laboratorium Terpadu Vokasi">
                <span class="absolute top-3 left-3 bg-black/60 text-white text-[10px] px-2 py-1 rounded">Laboratorium Terpadu Vokasi &bull; Standar DUDI & K3</span>
                <div class="absolute -bottom-4 left-4 bg-white shadow-md rounded-xl px-4 py-2 flex items-center gap-2 text-xs">
                    <span class="text-[#00652C]">✅</span>
                    <div>
                        <p class="font-semibold">LSP P1 BLK Jember</p>
                        <p class="text-[10px] text-[#3F493F]">Terlisensi Penuh BNSP Republik Indonesia</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEJARAH & LANDASAN HUKUM --}}
        <div class="grid md:grid-cols-2 gap-8 mb-16 mt-10">
            <div>
                <p class="text-xs font-semibold text-[#00652C] mb-1">FONDASI REGULASI & INTEGRITAS</p>
                <h2 class="text-xl font-bold mb-3">Sejarah Singkat & Landasan Hukum</h2>
                <p class="text-sm text-[#3F493F] mb-4">
                    Berdiri sebagai garda terdepan penyiapan SDM terampil di Kawasan Tapal Kuda Jawa Timur, UPT BLK
                    Jember mengemban amanat pencetakan tenaga produktif, mandiri, dan bermartabat.
                </p>
                <div class="bg-[#F5F7FA] rounded-xl p-4 flex gap-3">
                    <span class="text-lg">📖</span>
                    <div>
                        <p class="font-semibold text-sm mb-1">Dasar Pembentukan</p>
                        <p class="text-xs text-[#3F493F]">Peraturan Gubernur Jawa Timur Nomor 59 Tahun 2018 tentang Nomenklatur, Susunan Organisasi, Uraian Tugas dan Fungsi serta Tata Kerja Unit Pelaksana Teknis Dinas Tenaga Kerja dan Transmigrasi Jawa Timur.</p>
                    </div>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                @foreach ([
                    ['icon' => '🏢', 'title' => 'Organisasi Publik Mandiri', 'desc' => 'UPT BLK Jember beroperasi di bawah binaan langsung Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur. Memiliki wewenang teknis mengelola workshop vokasi, pelatihan boarding/non-boarding, dan uji sertifikasi keahlian.', 'link' => 'Dibiayai APBD Prov. Jatim & APBN RI'],
                    ['icon' => '💯', 'title' => '100% Bebas Biaya (Gratis)', 'desc' => 'Seluruh peserta pelatihan program reguler tidak dipungut biaya pendaftaran, konsumsi pelatihan, modul belajar, pakaian seragam, hingga biaya uji kompetensi BNSP pertama. Mengusung prinsip Zona Integritas Wilayah Bebas dari Korupsi (WBK).', 'link' => 'Transparansi Seleksi Berbasis Merit'],
                    ['icon' => '🔗', 'title' => 'Link & Match DUDI', 'desc' => 'Kurikulum silabus diselaraskan berkala dengan asosiasi profesi dan konsorsium industri manufaktur, bengkel resmi, garmen skala ekspor, serta industri teknologi informasi agar serapan lulusan maksimal.', 'link' => 'Sinkronisasi Rutin Kurikulum Kerja'],
                    ['icon' => '🤝', 'title' => 'Layanan Ramah & Inklusif', 'desc' => 'Akses pendaftaran daring melalui platform siKarir dan layanan tatap muka di PTSP Kampus BLK Jember ramah terhadap kelompok disabilitas, perempuan kepala keluarga, serta pemuda pencari kerja awal.', 'link' => 'Standar Pelayanan Publik Nasional'],
                ] as $item)
                    <div class="border rounded-xl p-4">
                        <div class="w-9 h-9 rounded-lg bg-[#D3FFD5] flex items-center justify-center mb-2">{{ $item['icon'] }}</div>
                        <p class="font-semibold text-sm mb-1">{{ $item['title'] }}</p>
                        <p class="text-xs text-[#3F493F] mb-2">{{ $item['desc'] }}</p>
                        <p class="text-[10px] text-[#00652C] font-medium">&#10003; {{ $item['link'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- VISI & MISI --}}
    <section class="bg-[#F5F7FA]">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <div class="text-center mb-8">
                <p class="text-xs font-semibold text-[#00652C] mb-1">CITA-CITA & ARAH STRATEGI</p>
                <h2 class="text-2xl font-bold mb-1">Visi & Misi Kelembagaan</h2>
                <p class="text-sm text-[#3F493F]">Pedoman langkah UPT BLK Jember dalam mewujudkan kedaulatan ketenagakerjaan dan pertumbuhan ekonomi inklusif di Provinsi Jawa Timur.</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-[#00652C] text-white rounded-xl p-6 flex flex-col justify-between">
                    <div>
                        <p class="text-xs text-[#D3FFD5] mb-3">✔ VISI UPT BLK JEMBER</p>
                        <p class="text-lg font-semibold mb-4">&ldquo;Terwujudnya Tenaga Kerja yang Kompeten, Berkarakter Industri, Mandiri, dan Berdaya Saing Global.&rdquo;</p>
                        <p class="text-xs text-[#D3FFD5]">Menjadi pusat unggulan pelatihan vokasi Jawa Timur yang responsif terhadap otomatisasi industri, adaptif terhadap inovasi hijau, dan berakar pada etos kedisiplinan Nusantara.</p>
                    </div>
                    <p class="text-xs text-[#D3FFD5] mt-4">✔ Terintegrasi dengan Renstra Disnakertrans Jatim 2024-2029</p>
                </div>
                <div class="space-y-4">
                    @foreach ([
                        ['no' => '01', 'title' => 'Pelatihan Berbasis Standar SKKNI', 'desc' => 'Menyelenggarakan pelatihan vokasi terstruktur yang mengacu secara ketat pada Standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan standar internasional yang diakui.'],
                        ['no' => '02', 'title' => 'Kemitraan Strategis DUDI yang Mengikat', 'desc' => 'Memperluas kemitraan strategis dengan Dunia Usaha dan Dunia Industri (DUDI) dalam bentuk program On the Job Training (OJT), transfer instruktur tamu, dan rekrutmen langsung lulusan.'],
                        ['no' => '03', 'title' => 'Fasilitasi Uji Kompetensi & Sertifikasi BNSP', 'desc' => 'Menjamin seluruh peserta yang menuntaskan pelatihan difasilitasi mengikuti asesmen kompetensi melalui LSP-P1 UPT BLK Jember untuk memperoleh sertifikasi berlisensi negara (BNSP RI).'],
                        ['no' => '04', 'title' => 'Pemberantasan Pengangguran Terbuka di Tapal Kuda', 'desc' => 'Mendorong akselerasi penurunan Tingkat Pengangguran Terbuka (TPT) di Jember, Lumajang, Bondowoso, Situbondo, dan Banyuwangi melalui sinergi Bursa Kerja Khusus (BKK).'],
                    ] as $misi)
                        <div class="bg-white rounded-xl p-4 flex gap-4">
                            <span class="text-xl font-bold text-[#00652C] shrink-0">{{ $misi['no'] }}</span>
                            <div>
                                <p class="font-semibold text-sm mb-1">{{ $misi['title'] }}</p>
                                <p class="text-xs text-[#3F493F]">{{ $misi['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- FASILITAS WORKSHOP --}}
    <div class="max-w-7xl mx-auto px-6 py-14">
        <div class="flex justify-between items-end mb-8">
            <div>
                <p class="text-xs font-semibold text-[#00652C] mb-1">INFRASTRUKTUR & SARANA BELAJAR</p>
                <h2 class="text-2xl font-bold mb-1">Fasilitas Workshop Berstandar Industri</h2>
                <p class="text-sm text-[#3F493F]">Peralatan praktek mutakhir dan lingkungan kerja simulatif yang merefleksikan kondisi riil di pabrik manufaktur, bengkel resmi, dan kantor korporat modern.</p>
            </div>
            <span class="text-xs bg-[#F2F3FF] text-[#3F493F] px-3 py-1.5 rounded-full shrink-0">📐 Kampus Luas 3.8 Hektar</span>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['img' => 'workshop-otomotif.jpg', 'tag' => 'TEKNIK OTOMOTIF', 'title' => 'Gedung Workshop Otomotif', 'desc' => 'Dilengkapi scanner EFI multiport mutakhir, 4 unit engine stand bensin & diesel, mesin spooring-balancing digital, dan sepeda motor 4 tak terkini.', 'stats' => ['🛠 16 Workstation', '📋 Skema Teknisi R4/R2']],
                ['img' => 'lab-komputer.jpg', 'tag' => 'TIK & MULTIMEDIA', 'title' => 'Lab Komputer & Multimedia', 'desc' => 'Infrastruktur jaringan fiber optik gigabit independen, workstation berspesifikasi grafis kuat, lisensi perangkat lunak desain industri, serta studio podcast dan multimedia live streaming.', 'stats' => ['🖥 32 PC Unit', '💻 Junior Web & Desainer']],
                ['img' => 'workshop-garmen.jpg', 'tag' => 'GARMEN APPAREL', 'title' => 'Workshop Garmen Apparel', 'desc' => '30+ mesin jahit industri high-speed servo, mesin bordir otomatis komputer 12 kepala, mesin cutting kain vertikal, serta mesin obras dan overlock berkecepatan tinggi standar pabrik garmen ekspor.', 'stats' => ['🧵 30+ Sewing Machines', '👗 Operator Garmen']],
                ['img' => 'workshop-las.jpg', 'tag' => 'MANUFAKTUR LOGAM', 'title' => 'Workshop Las & Fabrikasi', 'desc' => 'Bilik las tertutup dengan sistem blower exhaust asap K3, unit mesin SMAW (Shielded Metal Arc), GMAW / MIG-MAG, mesin las Argon TIG pipa, dan mesin pemotong plasma CNC.', 'stats' => ['🔥 18 Bilik Las K3', '⚙ Plate Welder 3G/4G']],
                ['img' => 'asrama-blk.jpg', 'tag' => 'FASILITAS TINGGAL', 'title' => 'Asrama Peserta Pelatihan (Boarding)', 'desc' => 'Kapasitas 120 orang khusus peserta asal luar kecamatan atau luar kabupaten, mencakup kamar ber-AC/kipas higienis, makan 3x sehari bersubsidi, musholla, serta sarana olahraga.', 'stats' => ['🛏 Kapasitas 120 Siswa', '🍽 Gratis Biaya Asrama']],
                ['img' => 'lsp-blk.jpg', 'tag' => 'SERTIFIKASI NASIONAL', 'title' => 'LSP-P1 UPT BLK Jember', 'desc' => 'Badan sertifikasi internal terlisensi resmi oleh Badan Nasional Sertifikasi Profesi (BNSP) RI dengan 24 asesor kompetensi bersertifikat Master Assessor di berbagai bidang keahlian.', 'stats' => ['📜 Lisensi BNSP RI', '🏅 Sertifikat Garuda Emas']],
            ] as $f)
                <div class="border rounded-xl overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('images/'.$f['img']) }}" class="w-full h-36 object-cover" alt="{{ $f['title'] }}">
                        <span class="absolute top-2 left-2 bg-black/60 text-white text-[9px] font-semibold px-2 py-1 rounded">{{ $f['tag'] }}</span>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-sm mb-1">{{ $f['title'] }}</p>
                        <p class="text-xs text-[#3F493F] mb-3">{{ $f['desc'] }}</p>
                        <div class="flex justify-between text-[10px] text-[#3F493F] border-t pt-2">
                            <span>{{ $f['stats'][0] }}</span>
                            <span>{{ $f['stats'][1] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- BUDAYA PELATIHAN --}}
    <section class="bg-[#F5F7FA]">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <p class="text-xs font-semibold text-[#00652C] mb-1">KARAKTER & ETOS KERJA</p>
            <h2 class="text-2xl font-bold mb-2">Budaya Pelatihan Industri & Instruktur Unggul</h2>
            <p class="text-sm text-[#3F493F] mb-8 max-w-2xl">Tidak hanya mengajarkan kompetensi teknis (hard skills), UPT BLK Jember menanamkan nilai disiplin tinggi, budaya keselamatan kerja K3, serta etos kerja standar korporasi internasional.</p>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <div class="grid sm:grid-cols-3 gap-4 mb-6">
                        @foreach ([
                            ['icon' => '🎓', 'title' => 'Instruktur Bersertifikasi', 'desc' => '100% instruktur telah bersertifikat instruktur metodologi pelatihan BNSP dan ToT Nasional.'],
                            ['icon' => '🦺', 'title' => 'Protokol K3 Ketat', 'desc' => 'Penggunaan APD lengkap (helm, kacamata las, sepatu safety) diwajibkan sejak hari pertama workshop.'],
                            ['icon' => '🎯', 'title' => 'Pendidikan Karakter (FMD)', 'desc' => 'Pelatihan fisik, mental, dan disiplin (FMD) bekerjasama dengan institusi TNI di masa orientasi.'],
                        ] as $b)
                            <div class="bg-white rounded-xl p-4">
                                <div class="w-9 h-9 rounded-lg bg-[#D3FFD5] flex items-center justify-center mb-2">{{ $b['icon'] }}</div>
                                <p class="font-semibold text-xs mb-1">{{ $b['title'] }}</p>
                                <p class="text-[11px] text-[#3F493F]">{{ $b['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-white rounded-xl p-4">
                        <p class="text-xs font-semibold text-[#00652C] mb-2">📌 Penerapan Konsep 5R (5S)</p>
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach (['Ringkas / Seiri', 'Rapi / Seiton', 'Resik / Seiso', 'Rawat / Seiketsu', 'Rajin / Shitsuke'] as $r)
                                <span class="text-[10px] bg-[#F2F3FF] text-[#3F493F] px-2 py-1 rounded">{{ $r }}</span>
                            @endforeach
                        </div>
                        <p class="text-xs text-[#3F493F]">Setiap sesi dimulai dan diakhiri dengan pekerjaan mesin mandiri, dan inspeksi alat guna membentuk kebiasaan kerja aman tanpa kompromi.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6">
                    <p class="text-xs font-semibold text-[#00652C] mb-4">AMANAT PIMPINAN UPT</p>
                    <div class="flex items-start gap-4 mb-4">
                        <img src="{{ asset('images/kepala-blk.jpg') }}" class="w-14 h-14 rounded-full object-cover shrink-0" alt="Kepala UPT BLK Jember">
                        <div>
                            <p class="font-semibold text-sm mb-1">Kepala UPT BLK Jember</p>
                            <p class="text-sm text-[#3F493F] italic mb-2">&ldquo;Kami tidak hanya mengajarkan cara mengoperasikan mesin atau menulis kode, tetapi menempa sikap integritas dan ketangguhan mental agar para alumni kami disambut dengan penuh kepercayaan oleh industri nasional.&rdquo;</p>
                            <p class="text-xs text-[#3F493F]">Dinas Tenaga Kerja & Transmigrasi &bull; Pemerintah Provinsi Jawa Timur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAM MTU --}}
    <div class="max-w-7xl mx-auto px-6 py-14">
        <span class="inline-block bg-[#D3FFD5] text-[#00652C] text-xs font-semibold px-3 py-1 rounded-full mb-4">🚚 JEMPUT BOLA VOKASI</span>
        <div class="bg-[#F5F7FA] rounded-2xl p-8 grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h2 class="text-2xl font-bold mb-3">Program Mobile Training Unit (MTU) Menjangkau 31 Kecamatan</h2>
                <p class="text-sm text-[#3F493F] mb-4">Bagi masyarakat di pelosok pedesaan yang terkendala jarak untuk menuju kampus induk di Sumbersari, UPT BLK Jember menghadirkan armada Mobile Training Unit (MTU). Truk workshop khusus membawa peralatan praktek lengkap ke balai desa, pondok pesantren, dan komunitas warga.</p>
                <div class="grid grid-cols-2 gap-3 mb-4 text-xs text-[#3F493F]">
                    <p>📍 Cakupan Wilayah Kabupaten Jember: <span class="font-semibold text-[#131B2E]">31 dari 31 Kecamatan (100%)</span></p>
                    <p>Jember Selatan (Wuluhan, Puger, Ambulu) &bull; Jember Timur & Utara (Silo, Sukowono, Jelbuk)</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['Servis Sepeda Motor Injeksi', 'Pengolahan Hasil Pertanian / Barista', 'Tata Rias Pengantin & Rambut', 'Instalasi Listrik Penerangan Rumah'] as $chip)
                        <span class="text-[10px] bg-white border rounded-full px-3 py-1 text-[#3F493F]">{{ $chip }}</span>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <img src="{{ asset('images/mtu-blk.jpg') }}" class="w-full h-56 object-cover rounded-xl" alt="Mobile Training Unit BLK Jember">
                <div class="absolute bottom-3 left-3 right-3 bg-white rounded-lg p-3 flex justify-between items-center gap-2">
                    <div>
                        <p class="font-semibold text-xs">Pengajuan Pelatihan MTU Desa</p>
                        <p class="text-[10px] text-[#3F493F]">Kepala Desa & Kelompok Pemuda dapat mengajukan permohonan tertulis.</p>
                    </div>
                    <a href="#" class="bg-[#00652C] text-white text-[10px] font-medium px-3 py-2 rounded-lg shrink-0">Konsultasi MTU</a>
                </div>
            </div>
        </div>
    </div>

    {{-- PTSP & LOKASI --}}
    <section class="bg-[#F5F7FA]">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <p class="text-xs font-semibold text-[#00652C] mb-1">LAYANAN PUBLIK & AKSESIBILITAS</p>
            <h2 class="text-2xl font-bold mb-2">Pusat Pelayanan Terpadu Satu Pintu (PTSP) & Lokasi</h2>
            <p class="text-sm text-[#3F493F] mb-8 max-w-2xl">Kunjungi kampus UPT BLK Jember untuk pendaftaran mandiri, konsultasi uji sertifikasi BNSP, magang industri, atau informasi program pelatihan kejuruan terbaru.</p>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl p-5">
                    <p class="font-semibold text-sm mb-3">🕐 Jam Operasional Pelayanan PTSP</p>
                    <div class="text-xs text-[#3F493F] space-y-2 mb-4">
                        <div class="flex justify-between"><span>Senin - Kamis</span><span class="font-medium text-[#131B2E]">07.30 - 15.30 WIB (Istirahat 12.00 - 13.00)</span></div>
                        <div class="flex justify-between"><span>Jumat</span><span class="font-medium text-[#131B2E]">07.00 - 14.30 WIB (Istirahat 11.30 - 13.00)</span></div>
                        <div class="flex justify-between items-center"><span>Sabtu, Minggu & Libur Nasional</span><span class="text-[10px] bg-[#FFE5E5] text-[#BA1A1A] px-2 py-1 rounded">TUTUP PELAYANAN FISIK</span></div>
                    </div>
                    <p class="font-semibold text-sm mb-2">📞 Narahubung & Lokasi Resmi</p>
                    <div class="text-xs text-[#3F493F] space-y-1 mb-4">
                        <p>📍 Alamat Kampus Induk: Jl. Letjen S. Parman / Jl. Basuki Rahmat No. 58, Lingkungan Krajan Barat, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121</p>
                        <p>☎ Telepon Kantor: (0331) 487771</p>
                        <p>💬 Hotline WhatsApp: 0811-3221-505 (Jam Kerja)</p>
                        <p>✉ Surel Resmi: blkjember.disnakertrans@jatimprov.go.id</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="#" class="flex-1 text-center bg-[#00652C] text-white text-xs font-medium py-2.5 rounded-lg">💬 Chat WhatsApp PTSP</a>
                        <a href="#" class="flex-1 text-center border text-xs font-medium py-2.5 rounded-lg">⬇ Unduh Brosur Profil</a>
                    </div>
                </div>

                <div class="rounded-xl overflow-hidden border relative">
                    <img src="{{ asset('images/peta-lokasi-blk.jpg') }}" class="w-full h-full object-cover min-h-[280px]" alt="Peta Lokasi UPT BLK Jember">
                    <div class="absolute bottom-3 left-3 bg-white rounded-lg px-3 py-2 text-xs flex items-center gap-2">
                        <span class="text-[#00652C]">📍</span>
                        <div>
                            <p class="font-semibold">Kampus UPT BLK Jember</p>
                            <p class="text-[10px] text-[#3F493F]">Strategis dekat Bundaran Bangsal & Univ. Jember</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
