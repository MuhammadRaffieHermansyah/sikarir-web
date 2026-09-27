@extends('layouts.public')

@section('title', 'Tentang BLK - siKarir UPT BLK Jember')

@section('content')

    {{-- TOP INFO BAR --}}
    <!-- <div class="bg-slate-50 border-b border-slate-200/80 text-xs py-2.5 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2 text-slate-600 font-medium">
            <nav class="flex items-center gap-1.5">
                <a href="{{ url('/') }}" class="hover:text-emerald-800 transition flex items-center gap-1">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i> Beranda
                </a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
                <span class="text-emerald-800 font-bold">Tentang BLK</span>
            </nav>
            <div class="flex items-center gap-2 text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/80">
                <i data-lucide="award" class="w-3.5 h-3.5 text-emerald-600"></i>
                <span>AKREDITASI & LISENSI RESMI BNSP RI • SK DISNAKERTRANS JATIM NO. 188/45/108.3/2023</span>
            </div>
        </div>
    </div> -->

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden bg-linear-to-br from-emerald-900 via-teal-950 to-slate-900 text-white border-b border-emerald-800/40">
        <!-- Background Accent Blur -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 py-12 md:py-16 relative z-10">
            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-7 space-y-4">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 rounded-full border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-sm">
                        <i data-lucide="building-2" class="w-4 h-4 text-emerald-400"></i>
                        LEMBAGA VOKASI PEMERINTAH PROVINSI JAWA TIMUR
                    </span>
                    <h1 class="text-2xl md:text-4xl font-black leading-tight tracking-tight text-white">
                        Profil & Komitmen Kejuruan <span class="text-emerald-400">UPT BLK Jember</span>
                    </h1>
                    <p class="text-emerald-100/80 text-xs md:text-sm leading-relaxed max-w-xl">
                        Lembaga Pelatihan Vokasi Pemerintah Provinsi Jawa Timur Pencetak Tenaga Terampil Siap Kerja, Berdaya Saing Global, dan Tersertifikasi Nasional BNSP melalui pembiayaan APBD & APBN secara gratis dan transparan.
                    </p>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-white/10">
                        @foreach ([
                            ['value' => '12+', 'label' => 'Kejuruan Unggulan'],
                            ['value' => '94.8%', 'label' => 'Kelulusan BNSP'],
                            ['value' => '180+', 'label' => 'Mitra Industri (DUDI)'],
                            ['value' => '31', 'label' => 'Kecamatan MTU Jember'],
                        ] as $s)
                            <div>
                                <p class="text-xl md:text-2xl font-black text-emerald-400">{{ $s['value'] }}</p>
                                <p class="text-[10px] md:text-xs text-emerald-100/70 font-medium mt-0.5">{{ $s['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Hero Media Preview -->
                <div class="md:col-span-5 relative">
                    <div class="relative h-72 md:h-80 rounded-2xl overflow-hidden border border-white/20 shadow-2xl bg-slate-800">
                        <img src="{{ asset('images/pembukaanblk2.jpeg') }}" class="w-full h-full object-cover" alt="Rapat Sosialisasi BLK Jember">
                        <span class="absolute top-3 left-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Rapat Sosialisasi BLK Jember
                        </span>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -bottom-4 -left-4 bg-white text-slate-800 shadow-xl rounded-2xl p-3.5 border border-slate-200/80 flex items-center gap-3">
                        <div class="p-2 bg-emerald-100 text-emerald-800 rounded-xl shrink-0">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs">LSP P1 BLK Jember</h4>
                            <p class="text-[10px] text-slate-500 font-medium">Terlisensi Penuh BNSP Republik Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT AREA -->
    <div class="max-w-7xl mx-auto px-6 py-12 space-y-12">

        {{-- SEJARAH & LANDASAN HUKUM --}}
        <div class="grid md:grid-cols-12 gap-8 items-start">
            <div class="md:col-span-5 space-y-4">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                        FONDASI REGULASI & INTEGRITAS
                    </span>
                    <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Sejarah Singkat & Landasan Hukum</h2>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Berdiri sebagai garda terdepan penyiapan SDM terampil di Kawasan Tapal Kuda Jawa Timur, UPT BLK Jember mengemban amanat pencetakan tenaga produktif, mandiri, dan bermartabat.
                </p>

                <div class="bg-emerald-50 border border-emerald-200/80 rounded-2xl p-4 flex gap-3">
                    <div class="p-2 bg-emerald-100 text-emerald-800 rounded-xl shrink-0 h-fit">
                        <i data-lucide="book-open-check" class="w-5 h-5"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-xs">Dasar Pembentukan Lembaga</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Peraturan Gubernur Jawa Timur Nomor 59 Tahun 2018 tentang Nomenklatur, Susunan Organisasi, Uraian Tugas dan Fungsi serta Tata Kerja UPT Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-7 grid sm:grid-cols-2 gap-4">
                @foreach ([
                    ['icon' => 'building', 'title' => 'Organisasi Publik Mandiri', 'desc' => 'UPT BLK Jember beroperasi di bawah binaan langsung Disnakertrans Jatim. Memiliki wewenang teknis mengelola workshop vokasi, pelatihan boarding/non-boarding, dan uji sertifikasi keahlian.', 'link' => 'Dibiayai APBD Prov. Jatim & APBN RI'],
                    ['icon' => 'circle-dollar-sign', 'title' => '100% Bebas Biaya (Gratis)', 'desc' => 'Seluruh peserta pelatihan program reguler tidak dipungut biaya pendaftaran, konsumsi, modul belajar, seragam, hingga biaya uji kompetensi BNSP pertama.', 'link' => 'Transparansi Seleksi Berbasis Merit'],
                    ['icon' => 'link-2', 'title' => 'Link & Match DUDI', 'desc' => 'Kurikulum silabus diselaraskan berkala dengan asosiasi profesi dan konsorsium industri manufaktur, bengkel resmi, garmen skala ekspor, serta industri TI agar serapan lulusan maksimal.', 'link' => 'Sinkronisasi Rutin Kurikulum Kerja'],
                    ['icon' => 'users', 'title' => 'Layanan Ramah & Inklusif', 'desc' => 'Akses pendaftaran daring melalui platform siKarir dan layanan tatap muka di PTSP Kampus BLK Jember ramah terhadap kelompok disabilitas, perempuan kepala keluarga, serta pemuda pencari kerja.', 'link' => 'Standar Pelayanan Publik Nasional'],
                ] as $item)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:border-emerald-300 transition space-y-2 flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                                <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xs">{{ $item['title'] }}</h3>
                            <p class="text-[11px] text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                        <div class="pt-2 border-t border-slate-100 flex items-center gap-1 text-[10px] font-bold text-emerald-700">
                            <i data-lucide="check" class="w-3 h-3"></i>
                            <span>{{ $item['link'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- VISI & MISI --}}
    <section class="bg-slate-50/80 border-y border-slate-200/80 py-14">
        <div class="max-w-7xl mx-auto px-6 space-y-8">
            <div class="text-center max-w-xl mx-auto space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    CITA-CITA & ARAH STRATEGI
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Visi & Misi Kelembagaan</h2>
                <p class="text-xs text-slate-500">Pedoman langkah UPT BLK Jember dalam mewujudkan kedaulatan ketenagakerjaan di Jawa Timur.</p>
            </div>

            <div class="grid md:grid-cols-12 gap-8 items-stretch">
                <!-- Visi Box -->
                <div class="md:col-span-5 bg-linear-to-br from-emerald-900 via-teal-900 to-slate-900 text-white rounded-3xl p-6 md:p-8 shadow-xl flex flex-col justify-between border border-emerald-800/40">
                    <div class="space-y-4">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-300 uppercase tracking-wider bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/30">
                            <i data-lucide="compass" class="w-3.5 h-3.5"></i> VISI UPT BLK JEMBER
                        </span>
                        <h3 class="text-lg md:text-xl font-black text-white leading-snug">
                            &ldquo;Terwujudnya Tenaga Kerja yang Kompeten, Berkarakter Industri, Mandiri, dan Berdaya Saing Global.&rdquo;
                        </h3>
                        <p class="text-xs text-emerald-100/80 leading-relaxed">
                            Menjadi pusat unggulan pelatihan vokasi Jawa Timur yang responsif terhadap otomatisasi industri, adaptif terhadap inovasi hijau, dan berakar pada etos kedisiplinan Nusantara.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-white/10 flex items-center gap-2 text-[11px] font-medium text-emerald-300">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        <span>Terintegrasi dengan Renstra Disnakertrans Jatim 2024-2029</span>
                    </div>
                </div>

                <!-- Misi List -->
                <div class="md:col-span-7 space-y-3">
                    @foreach ([
                        ['no' => '01', 'title' => 'Pelatihan Berbasis Standar SKKNI', 'desc' => 'Menyelenggarakan pelatihan vokasi terstruktur yang mengacu secara ketat pada Standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan standar internasional yang diakui.'],
                        ['no' => '02', 'title' => 'Kemitraan Strategis DUDI yang Mengikat', 'desc' => 'Memperluas kemitraan strategis dengan Dunia Usaha dan Dunia Industri (DUDI) dalam bentuk program On the Job Training (OJT), transfer instruktur tamu, dan rekrutmen langsung lulusan.'],
                        ['no' => '03', 'title' => 'Fasilitasi Uji Kompetensi & Sertifikasi BNSP', 'desc' => 'Menjamin seluruh peserta yang menuntaskan pelatihan difasilitasi mengikuti asesmen kompetensi melalui LSP-P1 UPT BLK Jember untuk memperoleh sertifikasi berlisensi negara (BNSP RI).'],
                        ['no' => '04', 'title' => 'Pemberantasan Pengangguran Terbuka di Tapal Kuda', 'desc' => 'Mendorong akselerasi penurunan Tingkat Pengangguran Terbuka (TPT) di Jember, Lumajang, Bondowoso, Situbondo, dan Banyuwangi melalui sinergi Bursa Kerja Khusus (BKK).'],
                    ] as $misi)
                        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex gap-4 items-start">
                            <span class="w-8 h-8 rounded-xl bg-emerald-900 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                                {{ $misi['no'] }}
                            </span>
                            <div class="space-y-0.5">
                                <h4 class="font-bold text-slate-800 text-xs">{{ $misi['title'] }}</h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed">{{ $misi['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- FASILITAS WORKSHOP --}}
    <div class="max-w-7xl mx-auto px-6 py-12 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    INFRASTRUKTUR & SARANA BELAJAR
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Fasilitas Workshop Berstandar Industri</h2>
                <p class="text-xs text-slate-500 mt-1 max-w-2xl">Peralatan praktik mutakhir dan lingkungan kerja simulatif yang merefleksikan kondisi riil di pabrik manufaktur, bengkel resmi, dan kantor korporat modern.</p>
            </div>
            <span class="text-xs font-bold text-slate-700 bg-slate-100 border border-slate-200 px-3.5 py-2 rounded-xl shrink-0 flex items-center gap-1.5">
                <i data-lucide="ruler" class="w-4 h-4 text-emerald-700"></i> Kampus Luas 3.8 Hektar
            </span>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['img' => 'https://images.unsplash.com/photo-1727893141025-35d62b3f4a03?q=80&w=1911&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'TEKNIK OTOMOTIF', 'title' => 'Gedung Workshop Otomotif', 'desc' => 'Dilengkapi scanner EFI multiport mutakhir, 4 unit engine stand bensin & diesel, mesin spooring-balancing digital, dan sepeda motor 4 tak terkini.', 'stats' => ['16 Workstation', 'Skema Teknisi R4/R2']],
                ['img' => 'https://images.unsplash.com/photo-1625745750125-5a072e15d1f5?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'TIK & MULTIMEDIA', 'title' => 'Lab TIK', 'desc' => 'Infrastruktur jaringan fiber optik gigabit independen, workstation berspesifikasi grafis kuat, lisensi software desain industri, serta studio podcast dan live streaming.', 'stats' => ['32 PC Unit', 'Junior Web & Desainer']],
                ['img' => 'https://plus.unsplash.com/premium_photo-1677695581626-2a75bdece138?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'GARMEN APPAREL', 'title' => 'Workshop Garmen Apparel', 'desc' => '30+ mesin jahit industri high-speed servo, mesin bordir otomatis komputer 12 kepala, mesin cutting kain vertikal, serta mesin obras standar pabrik garmen ekspor.', 'stats' => ['30+ Sewing Machines', 'Operator Garmen']],
                ['img' => 'https://images.unsplash.com/photo-1748348812466-8e29e1348f73?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'MANUFAKTUR LOGAM', 'title' => 'Workshop Las & CNC', 'desc' => 'Bilik las tertutup dengan sistem blower exhaust asap K3, unit mesin SMAW, GMAW / MIG-MAG, mesin las Argon TIG pipa, dan mesin pemotong plasma CNC.', 'stats' => ['18 Bilik Las K3', 'Plate Welder 3G/4G']],
                ['img' => 'https://images.unsplash.com/photo-1571474039046-42bc4e7f4b98?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'FASILITAS TINGGAL', 'title' => 'Asrama Peserta Pelatihan', 'desc' => 'Kapasitas 120 orang khusus peserta asal luar kecamatan atau luar kabupaten, mencakup kamar ber-AC/kipas higienis, makan 3x sehari bersubsidi, musholla, serta sarana olahraga.', 'stats' => ['Kapasitas 120 Siswa', 'Gratis Biaya Asrama']],
                ['img' => 'https://plus.unsplash.com/premium_photo-1663011474132-42003dd76fe0?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'tag' => 'WORKSHOP BAKERY', 'title' => 'Workshop Bakery', 'desc' => 'program pelatihan vokasi tata boga gratis yang dirancang untuk membekali masyarakat keterampilan praktis di bidang pengolahan makanan.', 'stats' => ['Kapasitas 50 Peserta', 'Junior Baker & Pastry Chef']],
            ] as $f)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-40 bg-slate-100">
                            <img src="{{ $f['img'] }}" class="w-full h-full object-cover" alt="{{ $f['title'] }}">
                            <span class="absolute top-2.5 left-2.5 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm shadow-sm">
                                {{ $f['tag'] }}
                            </span>
                        </div>
                        <div class="p-5 space-y-2">
                            <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug">{{ $f['title'] }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 flex justify-between text-[10px] font-bold text-slate-500">
                            <span class="flex items-center gap-1"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i> {{ $f['stats'][0] }}</span>
                            <span class="flex items-center gap-1"><i data-lucide="award" class="w-3.5 h-3.5 text-emerald-600"></i> {{ $f['stats'][1] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- BUDAYA PELATIHAN --}}
    <section class="bg-slate-50/80 border-y border-slate-200/80 py-12">
        <div class="max-w-7xl mx-auto px-6 space-y-8">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    KARAKTER & ETOS KERJA
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Budaya Pelatihan Industri & Instruktur Unggul</h2>
                <p class="text-xs text-slate-500 mt-1 max-w-2xl">Tidak hanya mengajarkan hard skills, UPT BLK Jember menanamkan nilai disiplin tinggi, K3, serta etos kerja standar korporasi internasional.</p>
            </div>

            <div class="grid md:grid-cols-12 gap-8 items-stretch">
                <div class="md:col-span-7 space-y-4">
                    <div class="grid sm:grid-cols-3 gap-4">
                        @foreach ([
                            ['icon' => 'graduation-cap', 'title' => 'Instruktur Bersertifikasi', 'desc' => '100% instruktur bersertifikat metodologi pelatihan BNSP & ToT Nasional.'],
                            ['icon' => 'shield-alert', 'title' => 'Protokol K3 Ketat', 'desc' => 'Penggunaan APD lengkap (helm, kacamata las, sepatu safety) diwajibkan sejak hari pertama.'],
                            ['icon' => 'target', 'title' => 'Pendidikan FMD', 'desc' => 'Fisik, mental, dan disiplin (FMD) bekerjasama dengan TNI di masa orientasi.'],
                        ] as $b)
                            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs space-y-2">
                                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                                    <i data-lucide="{{ $b['icon'] }}" class="w-4 h-4"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-xs">{{ $b['title'] }}</h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed">{{ $b['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-3">
                        <h4 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i data-lucide="check-square" class="w-4 h-4 text-emerald-600"></i> Penerapan Konsep 5R (5S) Industri
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['Ringkas / Seiri', 'Rapi / Seiton', 'Resik / Seiso', 'Rawat / Seiketsu', 'Rajin / Shitsuke'] as $r)
                                <span class="text-[10px] font-semibold bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg border border-slate-200">
                                    {{ $r }}
                                </span>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">Setiap sesi dimulai dan diakhiri dengan pembersihan mesin mandiri serta inspeksi alat guna membentuk kebiasaan kerja aman tanpa kompromi.</p>
                    </div>
                </div>

                <!-- Amanat Pimpinan -->
                <div class="md:col-span-5 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div class="space-y-4">
                        <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200/80 inline-block">
                            AMANAT PIMPINAN UPT
                        </span>
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/kepala.jpg') }}" class="w-12 h-12 rounded-full object-cover border border-emerald-200 shrink-0" alt="Kepala UPT BLK Jember">
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Kepala UPT BLK Jember</h4>
                                <p class="text-[10px] text-slate-400 font-medium">Disnakertrans Provinsi Jawa Timur</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 italic leading-relaxed">
                            &ldquo;Kami tidak hanya mengajarkan cara mengoperasikan mesin atau menulis kode, tetapi menempa sikap integritas dan ketangguhan mental agar para alumni kami disambut dengan penuh kepercayaan oleh industri nasional.&rdquo;
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 text-[10px] text-slate-400 font-medium">
                        Pelayanan Vokasi Berbasis Good Governance
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAM MTU --}}
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-linear-to-br from-emerald-900 to-teal-950 text-white rounded-3xl p-6 md:p-8 shadow-xl border border-emerald-800/40 grid md:grid-cols-12 gap-8 items-center">
            <div class="md:col-span-7 space-y-4">
                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-300 uppercase tracking-wider bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/30">
                    <i data-lucide="truck" class="w-3.5 h-3.5"></i> JEMPUT BOLA VOKASI DESA
                </span>
                <h2 class="text-xl md:text-2xl font-black text-white leading-tight">
                    Program Mobile Training Unit (MTU) Menjangkau 31 Kecamatan
                </h2>
                <p class="text-xs text-emerald-100/80 leading-relaxed">
                    Bagi masyarakat di pelosok pedesaan yang terkendala jarak menuju kampus induk di Sumbersari, UPT BLK Jember menghadirkan armada Mobile Training Unit (MTU). Truk workshop khusus membawa peralatan praktik lengkap ke balai desa, pondok pesantren, dan komunitas warga.
                </p>

                <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/10 text-xs text-emerald-100 font-medium space-y-1">
                    <p class="flex items-center gap-1.5 text-white font-bold">
                        <i data-lucide="map-pin" class="w-4 h-4 text-emerald-400"></i> Cakupan Wilayah Kabupaten Jember: 31 dari 31 Kecamatan (100%)
                    </p>
                    <p class="text-[11px] text-emerald-200/80">Jember Selatan (Wuluhan, Puger, Ambulu) • Jember Timur & Utara (Silo, Sukowono, Jelbuk)</p>
                </div>

                <div class="flex flex-wrap gap-2 pt-1">
                    @foreach (['Servis Sepeda Motor Injeksi', 'Pengolahan Hasil Pertanian / Barista', 'Tata Rias Pengantin & Rambut', 'Instalasi Listrik Penerangan Rumah'] as $chip)
                        <span class="text-[10px] font-semibold bg-white/10 border border-white/20 text-emerald-100 px-3 py-1 rounded-full">
                            {{ $chip }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="md:col-span-5 relative">
                <div class="relative h-56 rounded-2xl overflow-hidden border border-white/20 shadow-xl bg-slate-800">
                    <img src="{{ asset('images/MTU.jpg') }}" class="w-full h-full object-cover" alt="Mobile Training Unit BLK Jember">
                    <div class="absolute bottom-3 left-3 right-3 bg-white text-slate-800 rounded-xl p-3 shadow-lg flex justify-between items-center gap-2">
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Pengajuan Pelatihan MTU Desa</h4>
                            <p class="text-[10px] text-slate-500">Kepala Desa & Kelompok Pemuda dapat mengajukan permohonan.</p>
                        </div>
                        <a href="https://wa.me/#" target="_blank" class="bg-emerald-900 hover:bg-emerald-950 text-white text-[10px] font-bold px-3 py-2 rounded-lg shrink-0 transition">
                            Konsultasi MTU
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PTSP & LOKASI --}}
    <section class="bg-slate-50/80 border-t border-slate-200/80 py-12">
        <div class="max-w-7xl mx-auto px-6 space-y-8">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    LAYANAN PUBLIK & AKSESIBILITAS
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Pusat Pelayanan Terpadu Satu Pintu (PTSP) & Lokasi</h2>
                <p class="text-xs text-slate-500 mt-1 max-w-2xl">Kunjungi kampus UPT BLK Jember untuk pendaftaran mandiri, konsultasi sertifikasi BNSP, magang industri, atau informasi program pelatihan kejuruan terbaru.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-stretch">
                <!-- Info Box PTSP -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-5 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                <i data-lucide="clock" class="w-4 h-4 text-emerald-700"></i> Jam Operasional Pelayanan PTSP
                            </h3>
                            <div class="text-xs text-slate-600 space-y-1.5 bg-slate-50 p-3 rounded-xl border border-slate-100 font-medium">
                                <div class="flex justify-between"><span>Senin - Kamis</span><span class="font-bold text-slate-800">07.30 - 15.30 WIB (Istirahat 12.00 - 13.00)</span></div>
                                <div class="flex justify-between"><span>Jumat</span><span class="font-bold text-slate-800">07.00 - 14.30 WIB (Istirahat 11.30 - 13.00)</span></div>
                                <div class="flex justify-between items-center pt-1 border-t border-slate-200/60"><span>Sabtu, Minggu & Libur Nasional</span><span class="text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200/80 px-2 py-0.5 rounded-md">TUTUP FISIK</span></div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                <i data-lucide="phone-call" class="w-4 h-4 text-emerald-700"></i> Narahubung & Lokasi Resmi
                            </h3>
                            <div class="text-xs text-slate-600 space-y-2">
                                <p class="flex items-start gap-2">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 shrink-0 mt-0.5"></i>
                                    <span>Jl. Letjen S. Parman / Jl. Basuki Rahmat No. 58, Krajan Barat, Kec. Sumbersari, Kab. Jember, Jawa Timur 68121</span>
                                </p>
                                <p class="flex items-center gap-2">
                                    <i data-lucide="phone" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                    <span>(0331) 487771</span>
                                </p>
                                <p class="flex items-center gap-2">
                                    <i data-lucide="message-square" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                    <span>Hotline WA: 0811-3221-505 (Jam Kerja)</span>
                                </p>
                                <p class="flex items-center gap-2">
                                    <i data-lucide="mail" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                    <span>blkjember.disnakertrans@jatimprov.go.id</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <a href="https://wa.me/628113221505" target="_blank" class="flex-1 text-center bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold py-2.5 rounded-xl transition shadow-sm flex items-center justify-center gap-1.5">
                            <i data-lucide="message-circle" class="w-4 h-4"></i> Chat WhatsApp PTSP
                        </a>
                        <a href="#" class="flex-1 text-center border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-1.5">
                            <i data-lucide="download" class="w-4 h-4"></i> Brosur Profil
                        </a>
                    </div>
                </div>

                <!-- Peta Lokasi Container -->
                <div class="rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm relative min-h-75 bg-slate-100">

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.9712984336184!2d113.69429570941301!3d-8.205640491792323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd696eb9d058681%3A0x84fe5d132cd1947!2sUPT%20Balai%20Latihan%20Kerja%20Jember!5e0!3m2!1sid!2sid!4v1790125884843!5m2!1sid!2sid"
                        class="w-full h-75 border-0"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin">
                    </iframe>

                <div class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-md rounded-xl p-3 text-xs shadow-md border border-slate-200/80 flex items-center gap-2.5">
                    <div class="p-2 bg-emerald-100 text-emerald-800 rounded-lg">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900">
                            Kampus UPT BLK Jember
                        </h4>
                        <p class="text-[10px] text-slate-500 font-medium">
                            Dekat Bundaran Bangsal & Univ. Jember
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
