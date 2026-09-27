@extends('layouts.public')


@section('title', 'siKarir - UPT BLK Jember | Beranda Portal Pelatihan & Karir')

@section('content')

    {{-- HERO SECTION --}}
    <section
        class="relative overflow-hidden bg-linear-to-br from-emerald-900 via-teal-950 to-slate-900 text-white border-b border-emerald-800/40">
        <!-- Background Accent Blur -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 py-12 md:py-16 relative z-10">
            <!-- Top Announcement Badge -->
            <div
                class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 rounded-full border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-sm mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                PORTAL RESMI UPT BLK JEMBER DISNAKERTRANS JATIM
            </div>

            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-8 space-y-4">
                    <h1 class="text-3xl md:text-5xl font-black leading-tight tracking-tight text-white">
                        Portal Pelatihan Vokasi & Bursa Karir Resmi <span class="text-emerald-400">siKarir</span>
                    </h1>
                    <p class="text-emerald-100/80 max-w-2xl text-xs md:text-sm leading-relaxed">
                        Tingkatkan keahlian kerja bersertifikasi BNSP dan raih peluang karir terverifikasi bersama UPT Balai
                        Latihan Kerja (BLK) Jember - Dinas Tenaga Kerja & Transmigrasi Provinsi Jawa Timur. Siap mencetak
                        talenta vokasi unggul berdaya saing industri.
                    </p>
                </div>


            </div>

            {{-- Search Bar: 3 kolom + tombol submit --}}
            <form method="GET" action="{{ route('pelatihan.katalog') }}"
                class="bg-white rounded-2xl shadow-xl mt-10 p-3 md:p-4 grid md:grid-cols-12 gap-3 items-center text-slate-800 border border-slate-200/80">
                <div class="md:col-span-4 space-y-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Cari Pelatihan /
                        Kejuruan</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-slate-400"></i>
                        <input type="text" name="q" placeholder="Otomotif, Las SMAW, IT Python..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                    </div>
                </div>

                <div class="md:col-span-3 space-y-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Kategori
                        Program</label>
                    <select name="kategori"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                        <option value="">Semua Program & Lowongan</option>
                    </select>
                </div>

                <div class="md:col-span-3 space-y-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Lokasi /
                        Kampus</label>
                    <select name="wilayah"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                        <option value="">Kampus UPT BLK Jember</option>
                    </select>
                </div>

                <div class="md:col-span-2 self-end">
                    <button type="submit"
                        class="w-full bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl py-2.5 px-4 font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-md">
                        <i data-lucide="search" class="w-4 h-4"></i> Temukan
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- STAT STRIP (Kartu Putih Floating) --}}
    <section class="bg-slate-50 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-6 -mt-8 pt-2 pb-12 grid grid-cols-2 md:grid-cols-4 gap-4 relative z-20">
            @foreach ([['icon' => 'graduation-cap', 'value' => '12+', 'label' => 'Kejuruan', 'sub' => 'Pelatihan Berstandar Nasional'], ['icon' => 'trending-up', 'value' => '94%', 'label' => 'Lulusan', 'sub' => 'Terserap Bekerja & Wirausaha'], ['icon' => 'zap', 'value' => '100%', 'label' => 'Gratis', 'sub' => 'Dibiayai APBD & APBN Penuh'], ['icon' => 'award', 'value' => 'BNSP', 'label' => 'Resmi', 'sub' => 'Sertifikasi Standar Industri']] as $stat)
                <div
                    class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 md:p-5 flex items-center gap-3.5 hover:border-emerald-300 transition">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-900 text-sm md:text-base leading-tight">{{ $stat['value'] }}
                            {{ $stat['label'] }}</p>
                        <p class="text-[10px] font-medium text-slate-500 mt-0.5">{{ $stat['sub'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- LAYANAN UNGGULAN --}}
    <section class="max-w-7xl mx-auto px-6 py-14">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-2">
            <div>
                <span
                    class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    Layanan Mandiri Publik
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Layanan Unggulan siKarir</h2>
            </div>
            <a href="#" class="text-xs font-bold text-emerald-800 hover:underline flex items-center gap-1 shrink-0">
                Semua Menu Layanan <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
            ['icon' => 'user-check', 'title' => 'Pendaftaran Pelatihan', 'desc' => 'Pelatihan Reguler Berbasis Kompetensi (PBK) & Mobile Training Unit (MTU) pedesaan.', 'highlight' => false],
            ['icon' => 'briefcase', 'title' => 'Bursa Kerja Khusus (BKK)', 'desc' => 'Peluang kerja resmi terverifikasi dinas bagi alumni vokasi dan pencari kerja umum.', 'highlight' => false],
            ['icon' => 'award', 'title' => 'Uji Kompetensi & Sertifikasi', 'desc' => 'Jadwal asesmen kompetensi profesi LSP-P1 BLK Jember terlisensi resmi BNSP.', 'highlight' => false],
            ['icon' => 'messages-square', 'title' => 'Konsultasi & Bimbingan Jabatan', 'desc' => 'Konseling karir cuma-cuma bersama instruktur dan psikolog ketenagakerjaan.', 'highlight' => false],
            ['icon' => 'building-2', 'title' => 'Magang & Kemitraan DUDI', 'desc' => 'Sinergi Dunia Usaha dan Dunia Industri (DUDI) untuk program on-the-job training.', 'highlight' => false],
            ['icon' => 'file-check-2', 'title' => 'Verifikasi Sertifikat Digital', 'desc' => 'Cek keaslian sertifikat kelulusan BLK dan e-Sertifikat kompetensi via kode unik.', 'highlight' => false],
        ] as $layanan)
                <div
                    class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between">
                    <div>
                        <div
                            class="w-10 h-10 rounded-xl flex items-center justify-center mb-4 {{ $layanan['highlight'] ? 'bg-slate-900 text-white' : 'bg-emerald-50 text-emerald-800' }}">
                            <i data-lucide="{{ $layanan['icon'] }}" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm mb-1.5">{{ $layanan['title'] }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $layanan['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- PROGRAM PELATIHAN --}}
    <section class="bg-slate-50/80 border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <span
                        class="text-[11px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100/80 px-2.5 py-1 rounded-md border border-emerald-200/80">
                        PENDAFTARAN GELOMBANG II TA 2026
                    </span>
                    <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Program Pelatihan Kejuruan
                        UPT BLK Jember</h2>
                </div>
                <a href="{{ route('pelatihan.katalog') }}"
                    class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition inline-flex items-center gap-1.5 shrink-0 shadow-sm">
                    <span>Lihat Semua Pelatihan</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                @forelse ($pelatihans ?? [] as $item)
                    <div
                        class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between">
                        <div>
                            <div class="relative h-36 bg-slate-100">
                                <img src="{{ $item->gambar_url ?? asset('images/placeholder.jpg') }}"
                                    class="w-full h-full object-cover" alt="{{ $item->nama }}">
                                <span
                                    class="absolute top-2 left-2 bg-emerald-900/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-md backdrop-blur-sm">Buka</span>
                                <span
                                    class="absolute top-2 right-2 bg-slate-900/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-md backdrop-blur-sm">{{ $item->sumber_dana ?? 'APBN Gratis' }}</span>
                            </div>
                            <div class="p-4 space-y-2">
                                <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">
                                    {{ $item->kategori ?? 'Kategori' }}</p>
                                <h3 class="font-bold text-slate-900 text-sm leading-snug line-clamp-1">
                                    {{ $item->nama_pelatihan }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $item->deskripsi_pelatihan }}</p>
                            </div>
                        </div>
                        <div class="p-4 pt-0 flex items-center gap-2 mt-3">
                            <a href="{{ route('pelatihan.katalog') . '#' . $item->id }}"
                                class="w-1/2 text-center text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl py-2 transition">Silabus</a>
                            <a href="{{ route('register') }}"
                                class="w-1/2 text-center text-xs font-bold bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl py-2 transition shadow-sm">Daftar</a>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-4 p-8 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                        <i data-lucide="book-open" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                        Belum ada data pelatihan aktif.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- BURSA KERJA --}}
    <section class="max-w-7xl mx-auto px-6 py-14">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <span
                    class="text-[11px] font-bold uppercase tracking-wider text-purple-700 bg-purple-50 px-2.5 py-1 rounded-md border border-purple-100">
                    KONEKSI KARIR & INDUSTRI
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Bursa Kerja Khusus (BKK) &
                    Lowongan Kerja</h2>
            </div>
            <a href="{{ route('lowongan.katalog') }}"
                class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition inline-flex items-center gap-1.5 shrink-0 shadow-sm">
                <span>Lihat Semua Lowongan</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($lowongans ?? [] as $job)
                <div
                    class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between">

                    <div>
                        {{-- Judul & Status --}}
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h3 class="font-bold text-slate-900 text-sm">
                                {{ $job->judul_lowongan }}
                            </h3>

                            <span
                                class="text-[10px] font-bold
                    bg-emerald-50 text-emerald-800
                    border border-emerald-200/80
                    px-2 py-0.5 rounded-full shrink-0">
                                {{ ucfirst($job->status) }}
                            </span>
                        </div>

                        {{-- Nama Mitra --}}
                        <p class="text-xs font-medium text-slate-500 flex items-center gap-1 mb-2">
                            <i data-lucide="building-2" class="w-3.5 h-3.5 text-slate-400"></i>
                            {{ $job->mitra->nama ?? '-' }}
                        </p>

                        {{-- Lokasi --}}
                        <p class="text-xs font-medium text-slate-500 flex items-center gap-1 mb-4">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                            {{ $job->lokasi ?? '-' }}
                        </p>

                        {{-- Deskripsi --}}
                        <p class="text-xs text-slate-500 line-clamp-2">
                            {{ $job->deskripsi ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>

                    {{-- Footer --}}
                    <div class="pt-3 mt-4 border-t border-slate-100 flex items-center justify-between">

                        {{-- Tanggal Posting --}}
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-bold">
                                Diposting
                            </p>

                            <p class="font-bold text-slate-800 text-xs mt-0.5">
                                {{ $job->tanggal_posting ? \Carbon\Carbon::parse($job->tanggal_posting)->format('d M Y') : '-' }}
                            </p>
                        </div>

                        {{-- Tombol Lamar --}}
                        <a href="{{ route('lowongan.katalog') . '#' . $job->id_lowongan }}"
                            class="text-xs font-bold bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl px-3.5 py-2 transition shadow-sm">
                            Lamar
                        </a>
                    </div>

                </div>

            @empty

                <div
                    class="col-span-3 p-8 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                    <i data-lucide="briefcase" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                    Belum ada lowongan aktif saat ini.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ALUR PENDAFTARAN --}}
    <section class="bg-slate-50/80 border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <div class="text-center max-w-xl mx-auto mb-10 space-y-1">
                <span
                    class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    TRANSPARAN & MUDAH
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Alur Pendaftaran Pelatihan siKarir
                </h2>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                @foreach ([['no' => '01', 'title' => 'Buat Akun & NIK', 'desc' => 'Daftarkan akun siKarir menggunakan NIK KTP yang valid, lengkapi profil pribadi.', 'note' => 'Validasi Dispendukcapil'], ['no' => '02', 'title' => 'Pilih Kejuruan', 'desc' => 'Eksplorasi katalog pelatihan aktif sesuai minat karir, jadwal, dan kuota.', 'note' => '1 Peserta 1 Program Aktif'], ['no' => '03', 'title' => 'Tes Minat & Wawancara', 'desc' => 'Ikuti tes tertulis online serta verifikasi wawancara tatap muka di workshop BLK.', 'note' => 'Pengumuman Transparan'], ['no' => '04', 'title' => 'Pelatihan & Sertifikasi', 'desc' => 'Jalani pelatihan intensif gratis hingga ujian kompetensi resmi BNSP RI.', 'note' => 'Terhubung ke DUDI']] as $step)
                    <div
                        class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div
                                class="w-9 h-9 rounded-xl bg-emerald-900 text-white flex items-center justify-center font-black text-xs mb-3 shadow-md">
                                {{ $step['no'] }}
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1">{{ $step['title'] }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-3">{{ $step['desc'] }}</p>
                        </div>
                        <div
                            class="pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                            <span>{{ $step['note'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- WARTA & ALUMNI --}}
    <section class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-2 gap-8">
        {{-- Warta --}}
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Warta & Agenda BLK</h2>
                <a href="#" class="text-xs font-bold text-emerald-800 hover:underline flex items-center gap-1">
                    Lihat Arsip <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="space-y-4">
                @forelse ($berita ?? [] as $b)
                    <div
                        class="bg-white rounded-2xl border border-slate-200/80 p-3 flex gap-4 shadow-sm hover:border-emerald-300 transition">
                        <img src="{{ $b->gambar_url ?? asset('images/placeholder.jpg') }}"
                            class="w-24 h-20 rounded-xl object-cover shrink-0">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-emerald-700 uppercase">{{ $b->kategori ?? 'PENGUMUMAN' }}
                                &bull; {{ $b->tanggal ?? '' }}</p>
                            <h3 class="font-bold text-slate-800 text-xs leading-snug line-clamp-1">{{ $b->judul }}
                            </h3>
                            <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">{{ $b->ringkasan }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-6 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                        Belum ada warta terbaru.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Alumni & Info Profil --}}
        <div class="space-y-6">
            <h2 class="text-lg font-black text-slate-900 tracking-tight">Kisah Alumni Sukses</h2>

            @forelse ($alumni ?? [] as $a)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ $a->foto_url ?? asset('images/avatar-placeholder.jpg') }}"
                            class="w-10 h-10 rounded-full object-cover border border-emerald-200">
                        <div>
                            <p class="font-bold text-slate-800 text-xs">{{ $a->nama }}</p>
                            <p class="text-[11px] text-slate-500 font-medium">{{ $a->profesi }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 italic leading-relaxed">&ldquo;{{ $a->testimoni }}&rdquo;</p>
                </div>
            @empty
                <div class="p-6 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                    Belum ada testimoni alumni.
                </div>
            @endforelse

            <div class="bg-emerald-50 border border-emerald-200/80 rounded-2xl p-4 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-xs">Tentang UPT BLK Jember</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Lembaga pelatihan vokasi Disnakertrans Jatim berfasilitas
                        workshop modern.</p>
                </div>
                <a href="{{ route('tentang.index') }}"
                    class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-3 py-2 rounded-xl shrink-0 ml-3 transition shadow-sm">Profil
                    Lengkap</a>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-7xl mx-auto px-6 pb-14">
        <div
            class="relative overflow-hidden bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white rounded-3xl p-8 md:p-10 flex flex-col md:flex-row justify-between items-center gap-6 shadow-xl border border-emerald-800/40">
            <div class="space-y-2 max-w-xl">
                <span
                    class="text-[11px] font-bold text-emerald-300 uppercase tracking-wider bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/30">
                    INVESTASI MASA DEPAN JAWA TIMUR
                </span>
                <h2 class="text-xl md:text-2xl font-black tracking-tight text-white">Siap Memulai Karir Impian Anda?</h2>
                <p class="text-xs md:text-sm text-emerald-100/80 leading-relaxed">
                    Pendaftaran dibuka setiap bulan. Bebas biaya pendaftaran, bebas uang gedung, dan didukung penuh
                    fasilitas modern standar industri.
                </p>
            </div>
            <div class="flex flex-wrap gap-3 shrink-0">
                <a href="{{ route('register') }}"
                    class="bg-white text-emerald-900 hover:bg-emerald-50 px-4 py-2.5 rounded-xl font-bold text-xs transition shadow-md flex items-center gap-1.5">
                    <i data-lucide="user-plus" class="w-4 h-4 text-emerald-700"></i> Daftar Akun siKarir
                </a>
                <a href="#"
                    class="border border-white/40 hover:bg-white/10 text-white px-4 py-2.5 rounded-xl font-semibold text-xs transition flex items-center gap-1.5">
                    <i data-lucide="download" class="w-4 h-4"></i> Unduh Brosur PBK
                </a>
            </div>
        </div>
    </section>

@endsection
