@extends('layouts.public')

@section('title', 'Lowongan Kerja (BKK) - siKarir UPT BLK Jember')

@section('content')

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-900 via-teal-950 to-slate-900 text-white border-b border-emerald-800/40">
        <!-- Background Accent Blur -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 py-10 md:py-14 relative z-10">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-emerald-200/80 mb-6">
                <a href="{{ url('/') }}" class="hover:text-white transition flex items-center gap-1">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i> Beranda
                </a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-emerald-500"></i>
                <span class="text-white font-bold">Lowongan Kerja (BKK)</span>
            </nav>

            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-8 space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 rounded-full border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-sm">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        PORTAL RESMI BKK UPT BLK JEMBER
                    </div>
                    <h1 class="text-2xl md:text-4xl font-black leading-tight tracking-tight text-white">
                        Bursa Kerja Khusus & Peluang Karir Mitra DUDI
                    </h1>
                    <p class="text-emerald-100/80 max-w-2xl text-xs md:text-sm leading-relaxed">
                        Platform penyaluran kerja terverifikasi dan kolaborasi DUDI Jawa Timur. Menghubungkan alumni pelatihan vokasi bersertifikat BNSP dan talenta kerja kompeten langsung dengan perusahaan kredibel.
                    </p>
                </div>

                <!-- Banner Stat Widget -->
                <div class="md:col-span-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 text-xs text-emerald-100 flex items-center gap-4 shadow-xl">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400 shrink-0">
                        <i data-lucide="building-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-black text-white text-2xl leading-none">85+</p>
                        <p class="font-bold text-emerald-200 text-xs mt-1">Mitra Industri Aktif</p>
                        <p class="text-[10px] text-emerald-100/70">Terverifikasi Disnakertrans Jatim</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT & FILTER -->
    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- SEARCH & FILTER PANEL --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-8 space-y-4">
            <form method="GET" action="{{ route('lowongan.katalog') }}" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-3 text-slate-400"></i>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari nama jabatan, posisi spesifik, skill vokasi, atau nama perusahaan..."
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                </div>
                <button type="submit" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-6 py-2.5 rounded-xl transition flex items-center justify-center gap-2 shrink-0 shadow-sm">
                    <i data-lucide="filter" class="w-4 h-4"></i> Cari Lowongan
                </button>
            </form>

            <div class="grid md:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Wilayah / Lokasi</label>
                    <select name="wilayah" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 transition">
                        <option value="">Semua Lokasi Penempatan</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kejuruan / Bidang BLK</label>
                    <select name="kejuruan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 transition">
                        <option value="">Semua Kejuruan Vokasi</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Hubungan Kerja</label>
                    <select name="jenis" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 transition">
                        <option value="">Semua Jenis Ikatan Kerja</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between md:items-center gap-3 pt-3 border-t border-slate-100">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="font-bold text-slate-500 flex items-center gap-1">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-emerald-600"></i> Populer:
                    </span>
                    @foreach (['Teknisi Las', 'Otomotif Roda 4', 'Operator Garmen', 'Web Developer', 'Barista Kopi'] as $tag)
                        <a href="{{ route('lowongan.katalog', ['q' => $tag]) }}" class="bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-200/80 rounded-lg px-2.5 py-1 text-[11px] font-semibold text-slate-600 transition">
                            {{ $tag }}
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('lowongan.katalog') }}" class="text-xs text-rose-600 font-bold hover:underline flex items-center gap-1 shrink-0">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">
            
            {{-- KOLOM KIRI: DAFTAR LOWONGAN (8 cols) --}}
            <div class="lg:col-span-8 space-y-5">
                <div class="flex justify-between items-center text-xs text-slate-500 font-medium px-1">
                    <p class="flex items-center gap-1.5 font-bold text-slate-800">
                        <i data-lucide="briefcase" class="w-4 h-4 text-emerald-700"></i>
                        Menampilkan {{ is_object($lowongan) && method_exists($lowongan, 'total') ? $lowongan->total() : (($lowongan ?? collect())->count() ?: 7) }} Lowongan Aktif
                    </p>
                    <span class="text-emerald-700 font-bold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Diperbarui Harian
                    </span>
                </div>

                {{-- LOOP CARDS LOWONGAN --}}
                <div class="space-y-4">
                    @forelse ($lowongan ?? [] as $job)
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition space-y-3">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-800 shrink-0 font-bold">
                                        <i data-lucide="building-2" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug">{{ $job->posisi }}</h3>
                                        <p class="text-xs font-semibold text-slate-500 mt-0.5 flex items-center gap-1.5">
                                            <span>{{ $job->mitra->nama ?? '-' }}</span>
                                            <span class="text-slate-300">•</span>
                                            <span class="text-emerald-700 font-bold flex items-center gap-1">
                                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Terverifikasi Disnakertrans
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full shrink-0 uppercase tracking-wider">
                                    {{ $job->tipe_kerja ?? 'Penuh Waktu' }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-slate-600 bg-slate-50/80 p-2.5 rounded-xl border border-slate-100">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $job->lokasi ?? '-' }}
                                </span>
                                <span class="flex items-center gap-1 font-bold text-slate-800">
                                    <i data-lucide="circle-dollar-sign" class="w-3.5 h-3.5 text-emerald-600"></i> {{ $job->estimasi_gaji ?? '-' }}
                                </span>
                                <span class="flex items-center gap-1 text-emerald-700 font-semibold">
                                    <i data-lucide="award" class="w-3.5 h-3.5"></i> {{ $job->prioritas ?? 'Alumni BLK' }}
                                </span>
                                <span class="flex items-center gap-1 text-rose-600 font-semibold ml-auto">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i> Batas: {{ $job->batas_lamaran ?? '-' }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $job->deskripsi }}</p>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 font-medium">Dipublikasikan: {{ $job->dipublikasikan ?? '-' }}</span>
                                <div class="flex items-center gap-2">
                                    <a href="#" class="text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl px-3.5 py-2 transition">Detail Syarat</a>
                                    <a href="{{ route('register') }}" class="text-xs font-bold bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl px-3.5 py-2 transition shadow-sm flex items-center gap-1">
                                        <span>Lamar Cepat (BKK)</span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                            <i data-lucide="briefcase" class="w-10 h-10 mx-auto text-slate-300 mb-2"></i>
                            Belum ada lowongan aktif yang sesuai dengan filter Anda.
                        </div>
                    @endforelse
                </div>

                {{-- PAGINATION COMPONENT --}}
                <div class="mt-6">
                    @if (is_object($lowongan) && method_exists($lowongan, 'links'))
                        {{ $lowongan->links('components.pagination') }}
                    @else
                        <!-- Dummy Pagination Fallback -->
                        <div class="flex items-center justify-between bg-white px-6 py-4 rounded-2xl border border-slate-200/80 text-xs text-slate-500 font-medium">
                            <span>Menampilkan 1 sampai 7 dari 28 data</span>
                            <div class="flex gap-1">
                                <button class="w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400" disabled><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
                                <button class="w-8 h-8 rounded-xl bg-emerald-900 text-white font-bold flex items-center justify-center">1</button>
                                <button class="w-8 h-8 rounded-xl border border-slate-200 hover:bg-emerald-50 text-slate-600 font-bold flex items-center justify-center">2</button>
                                <button class="w-8 h-8 rounded-xl border border-slate-200 hover:bg-emerald-50 text-slate-600 font-bold flex items-center justify-center">3</button>
                                <button class="w-8 h-8 rounded-xl border border-slate-200 hover:bg-emerald-50 text-slate-600 font-bold flex items-center justify-center"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR (4 cols) --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Foto Workshop --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm">
                    <div class="relative h-40 bg-slate-100">
                        <img src="{{ asset('images/workshop-blk.jpg') }}" class="w-full h-full object-cover" alt="Workshop Praktik Industri BLK Jember">
                        <span class="absolute bottom-2 left-2 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Workshop Praktik BLK Jember
                        </span>
                    </div>
                    <div class="p-4 space-y-1">
                        <h3 class="font-bold text-slate-900 text-sm">Siap Kerja Berstandar Industri</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Kurikulum pelatihan dirancang bersama asosiasi industri (DUDI) untuk menjamin lulusan langsung menguasai kompetensi yang dicari pasar kerja modern.</p>
                    </div>
                </div>

                {{-- Alur Penyaluran BKK --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="p-2 bg-emerald-100 text-emerald-800 rounded-xl">
                            <i data-lucide="trending-up" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm leading-none">Alur Penyaluran BKK</h3>
                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">Mekanisme Resmi Penempatan Alumni</p>
                        </div>
                    </div>

                    <div class="space-y-3.5 pt-2">
                        @foreach ([
                            ['no' => '1', 'title' => 'Registrasi & Upload Sertifikat', 'desc' => 'Lengkapi profil akun siKarir Anda, unggah sertifikat PBK BLK Jember atau lisensi kompetensi BNSP resmi.'],
                            ['no' => '2', 'title' => 'Lamar Lowongan Mitra DUDI', 'desc' => 'Pilih formasi kerja yang selaras dengan kejuruan Anda. Klik tombol "Lamar Cepat" untuk auto-verifikasi.'],
                            ['no' => '3', 'title' => 'Tes Seleksi & Wawancara', 'desc' => 'Ikuti uji praktik dan interview kerja terfasilitasi baik di aula UPT BLK Jember maupun via virtual interview.'],
                            ['no' => '4', 'title' => 'Kontrak & Monitoring', 'desc' => 'Penandatanganan PKWT/Perjanjian Kerja bersama HRD mitra serta pencatatan resmi database Disnakertrans.'],
                        ] as $step)
                            <div class="flex gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-900 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm">
                                    {{ $step['no'] }}
                                </div>
                                <div class="space-y-0.5">
                                    <h4 class="font-bold text-slate-800 text-xs">{{ $step['title'] }}</h4>
                                    <p class="text-[11px] text-slate-500 leading-relaxed">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="#" class="block text-center bg-slate-900 hover:bg-slate-950 text-white text-xs font-bold py-2.5 rounded-xl transition shadow-sm">
                        <i data-lucide="download" class="w-3.5 h-3.5 inline mr-1"></i> Unduh Panduan Penyaluran (PDF)
                    </a>
                </div>

                {{-- CTA Mitra --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-emerald-900 to-teal-950 text-white rounded-2xl p-6 shadow-md space-y-3 border border-emerald-800/40">
                    <span class="text-[10px] font-bold text-emerald-300 uppercase tracking-wider bg-emerald-500/20 px-2.5 py-1 rounded-md border border-emerald-400/30">
                        KEMITRAAN INDUSTRI
                    </span>
                    <h3 class="font-black text-white text-base leading-snug">Ingin Merekrut Tenaga Kerja Kompeten Bersertifikat?</h3>
                    <p class="text-xs text-emerald-100/80 leading-relaxed">
                        Daftarkan perusahaan Anda sebagai mitra resmi BKK UPT BLK Jember. Nikmati kemudahan rekrutmen massal talenta siap kerja, uji kompetensi di workshop BLK, dan bebas biaya administrasi.
                    </p>
                    <div class="pt-2 space-y-2">
                        <a href="#" class="block text-center bg-white text-emerald-900 hover:bg-emerald-50 text-xs font-bold py-2.5 rounded-xl transition shadow-md">
                            Daftarkan Perusahaan Anda
                        </a>
                        <a href="https://wa.me/#" target="_blank" class="block text-center text-xs font-semibold text-emerald-300 hover:underline">
                            Konsultasi Kerjasama BKK (WhatsApp PIC)
                        </a>
                    </div>
                </div>

                {{-- LSP Badge --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 flex items-center gap-3 shadow-sm">
                    <div class="p-2.5 bg-emerald-50 text-emerald-800 rounded-xl shrink-0">
                        <i data-lucide="award" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-xs">LSP P1 BLK Jember</h4>
                        <p class="text-[10px] text-slate-500">Terlisensi Resmi BNSP No. KEP.0418/BNSP/III/2021</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection