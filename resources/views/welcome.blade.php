@extends('layouts.public')


@section('title', 'siKarir - UPT BLK Jember | Beranda Portal Pelatihan & Karir')

@section('content')

    {{-- ANIMASI: CSS + JS --}}
    <script>document.documentElement.classList.add('js-anim');</script>
    <style>
        /* Animasi saat halaman dimuat (hero) */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-up { animation: fadeUp .7s ease-out var(--d, 0ms) both; }

        /* Animasi saat elemen masuk layar (scroll reveal) */
        @keyframes revealUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .js-anim .reveal { opacity: 0; }
        .js-anim .reveal.is-visible {
            opacity: 1;
            animation: revealUp .6s ease-out var(--d, 0ms) backwards;
        }

        /* Blob hero melayang pelan */
        @keyframes floatSlow {
            0%, 100% { transform: translate(0, 0); }
            50%      { transform: translate(18px, -22px); }
        }
        .float-slow { animation: floatSlow 9s ease-in-out infinite; }
        .float-slow-2 { animation: floatSlow 11s ease-in-out infinite reverse; }

        /* Kilau tipis pada tombol CTA utama */
        @keyframes shine {
            from { transform: translateX(-120%) skewX(-20deg); }
            to   { transform: translateX(320%) skewX(-20deg); }
        }
        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: '';
            position: absolute; top: 0; bottom: 0; left: 0; width: 35%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            transform: translateX(-120%) skewX(-20deg);
        }
        .btn-shine:hover::after { animation: shine .9s ease-out; }

        @media (prefers-reduced-motion: reduce) {
            .anim-up, .float-slow, .float-slow-2,
            .js-anim .reveal.is-visible { animation: none; }
            .js-anim .reveal { opacity: 1; }
            .btn-shine:hover::after { animation: none; }
        }
    </style>

    {{-- HERO SECTION --}}
    <section
        class="relative overflow-hidden min-h-[520px] sm:min-h-[600px] text-white border-b border-emerald-800/40
           bg-emerald-950 bg-cover bg-center"
    style="background-image: url('{{ asset('images/hero-image.png') }}');">
        <!-- Background Accent Blur -->
        <div class="float-slow absolute -top-24 -left-24 w-64 h-64 sm:w-96 sm:h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="float-slow-2 absolute -bottom-24 -right-24 w-64 h-64 sm:w-96 sm:h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 md:py-16 relative z-10">
            <!-- Top Announcement Badge -->
            <div
                class="anim-up inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 rounded-full border border-emerald-400/30 text-emerald-200 text-[10px] sm:text-xs font-semibold leading-snug backdrop-blur-sm mb-4 mt-4 sm:mt-8 md:mt-20 max-w-full">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                PORTAL RESMI UPT BLK JEMBER DISNAKERTRANS JATIM
            </div>
            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-8 space-y-3 sm:space-y-4">
                    <h1 class="anim-up text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-white" style="--d: 120ms">
                        Portal Pelatihan Vokasi & Bursa Karir Resmi <span class="text-emerald-400">siKarir</span>
                    </h1>
                    <p class="anim-up text-emerald-100/80 max-w-2xl text-xs md:text-sm leading-relaxed" style="--d: 240ms">
                        Tingkatkan keahlian kerja bersertifikasi BNSP dan raih peluang karir terverifikasi bersama UPT Balai
                        Latihan Kerja (BLK) Jember - Dinas Tenaga Kerja & Transmigrasi Provinsi Jawa Timur. Siap mencetak
                        talenta vokasi unggul berdaya saing industri.
                    </p>
                </div>
            </div>

            {{-- Search Bar: 3 kolom + tombol submit --}}
            <form method="GET" action="{{ route('pelatihan.katalog') }}"
                style="--d: 380ms"
                class="anim-up bg-white rounded-2xl shadow-xl mt-10 sm:mt-20 md:mt-32 lg:mt-[12.5rem] p-3 md:p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-3 items-center text-slate-800 border border-slate-200/80">
                <div class="sm:col-span-2 md:col-span-4 space-y-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Cari Pelatihan /
                        Kejuruan</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-slate-400"></i>
                        <input type="text" name="q" placeholder="Otomotif, Las SMAW, IT Python..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-sm md:text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                    </div>
                </div>

                <div class="sm:col-span-1 md:col-span-3 space-y-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Kategori
                        Program</label>
                    <select name="kategori"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm md:text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                        <option value="">Semua Program & Lowongan</option>
                    </select>
                </div>

                <div class="sm:col-span-1 md:col-span-3 space-y-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Lokasi /
                        Kampus</label>
                    <select name="wilayah"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm md:text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                        <option value="">Kampus UPT BLK Jember</option>
                    </select>
                </div>

                <div class="sm:col-span-2 md:col-span-2 self-end">
                    <button type="submit"
                        class="btn-shine w-full bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl py-2.5 px-4 font-bold text-xs transition active:scale-[0.98] flex items-center justify-center gap-1.5 shadow-md">
                        <i data-lucide="search" class="w-4 h-4"></i> Temukan
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- STAT STRIP (Kartu Putih Floating) --}}
    <section class="bg-slate-50 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 -mt-8 pt-2 pb-10 sm:pb-12 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 relative z-20">
            @foreach ([
                ['icon' => 'graduation-cap', 'count' => 12, 'suffix' => '+', 'value' => '12+', 'label' => 'Kejuruan', 'sub' => 'Pelatihan Berstandar Nasional'],
                ['icon' => 'trending-up', 'count' => 94, 'suffix' => '%', 'value' => '94%', 'label' => 'Lulusan', 'sub' => 'Terserap Bekerja & Wirausaha'],
                ['icon' => 'zap', 'count' => 100, 'suffix' => '%', 'value' => '100%', 'label' => 'Gratis', 'sub' => 'Dibiayai APBD & APBN Penuh'],
                ['icon' => 'award', 'count' => null, 'suffix' => '', 'value' => 'BNSP', 'label' => 'Resmi', 'sub' => 'Sertifikasi Standar Industri'],
            ] as $stat)
                <div style="--d: {{ $loop->index * 100 }}ms"
                    class="reveal group bg-white rounded-2xl border border-slate-200/80 shadow-sm p-3 sm:p-4 md:p-5 flex flex-col items-start sm:flex-row sm:items-center gap-2.5 sm:gap-3.5 hover:border-emerald-300 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div
                        class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0 group-hover:bg-emerald-900 group-hover:text-white group-hover:scale-110 transition duration-300">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="font-black text-slate-900 text-sm md:text-base leading-tight">
                            @if ($stat['count'])
                                <span data-count="{{ $stat['count'] }}" data-suffix="{{ $stat['suffix'] }}">{{ $stat['value'] }}</span>
                            @else
                                <span>{{ $stat['value'] }}</span>
                            @endif
                            {{ $stat['label'] }}
                        </p>
                        <p class="text-[10px] font-medium text-slate-500 mt-0.5 leading-snug">{{ $stat['sub'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- LAYANAN UNGGULAN --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-14">
        <div class="reveal flex flex-col sm:flex-row sm:items-end justify-between mb-6 sm:mb-8 gap-2">
            <div>
                <span
                    class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    Layanan Mandiri Publik
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Layanan Unggulan siKarir</h2>
            </div>
            <a href="#" class="group text-xs font-bold text-emerald-800 hover:underline flex items-center gap-1 shrink-0">
                Semua Menu Layanan <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach ([
            ['icon' => 'user-check', 'title' => 'Pendaftaran Pelatihan', 'desc' => 'Pelatihan Reguler Berbasis Kompetensi (PBK) & Mobile Training Unit (MTU) pedesaan.', 'highlight' => false],
            ['icon' => 'briefcase', 'title' => 'Bursa Kerja Khusus (BKK)', 'desc' => 'Peluang kerja resmi terverifikasi dinas bagi alumni vokasi dan pencari kerja umum.', 'highlight' => false],
            ['icon' => 'award', 'title' => 'Uji Kompetensi & Sertifikasi', 'desc' => 'Jadwal asesmen kompetensi profesi LSP-P1 BLK Jember terlisensi resmi BNSP.', 'highlight' => false],
            ['icon' => 'messages-square', 'title' => 'Konsultasi & Bimbingan Jabatan', 'desc' => 'Konseling karir cuma-cuma bersama instruktur dan psikolog ketenagakerjaan.', 'highlight' => false],
            ['icon' => 'building-2', 'title' => 'Magang & Kemitraan DUDI', 'desc' => 'Sinergi Dunia Usaha dan Dunia Industri (DUDI) untuk program on-the-job training.', 'highlight' => false],
            ['icon' => 'file-check-2', 'title' => 'Verifikasi Sertifikat Digital', 'desc' => 'Cek keaslian sertifikat kelulusan BLK dan e-Sertifikat kompetensi via kode unik.', 'highlight' => false],
        ] as $layanan)
                <div style="--d: {{ ($loop->index % 3) * 100 }}ms"
                    class="reveal group bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm hover:shadow-lg hover:border-emerald-300 hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                    <div>
                        <div
                            class="w-10 h-10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition duration-300 {{ $layanan['highlight'] ? 'bg-slate-900 text-white' : 'bg-emerald-50 text-emerald-800 group-hover:bg-emerald-900 group-hover:text-white' }}">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-14">
            <div class="reveal flex flex-col md:flex-row md:items-end justify-between mb-6 sm:mb-8 gap-4">
                <div>
                    <span
                        class="inline-block text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100/80 px-2.5 py-1 rounded-md border border-emerald-200/80">
                        PENDAFTARAN GELOMBANG II TA 2026
                    </span>
                    <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Program Pelatihan Kejuruan
                        UPT BLK Jember</h2>
                </div>
                <a href="{{ route('pelatihan.katalog') }}"
                    class="group w-full sm:w-auto justify-center bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition active:scale-[0.98] inline-flex items-center gap-1.5 shrink-0 shadow-sm">
                    <span>Lihat Semua Pelatihan</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @forelse ($pelatihans ?? [] as $item)
                    <div style="--d: {{ ($loop->index % 4) * 100 }}ms"
                        class="reveal group bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-lg hover:border-emerald-300 hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative h-40 sm:h-36 bg-slate-100 overflow-hidden">
                                <img src="{{ $item->gambar_url ?? asset('images/placeholder.jpg') }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $item->nama }}">
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
                                class="w-1/2 text-center text-xs font-bold bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl py-2 transition active:scale-[0.98] shadow-sm">Daftar</a>
                        </div>
                    </div>
                @empty
                    <div
                        class="reveal sm:col-span-2 lg:col-span-4 p-8 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                        <i data-lucide="book-open" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                        Belum ada data pelatihan aktif.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- BURSA KERJA --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-14">
        <div class="reveal flex flex-col md:flex-row md:items-end justify-between mb-6 sm:mb-8 gap-4">
            <div>
                <span
                    class="inline-block text-[11px] font-bold uppercase tracking-wider text-purple-700 bg-purple-50 px-2.5 py-1 rounded-md border border-purple-100">
                    KONEKSI KARIR & INDUSTRI
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2">Bursa Kerja Khusus (BKK) &
                    Lowongan Kerja</h2>
            </div>
            <a href="{{ route('lowongan.katalog') }}"
                class="group w-full sm:w-auto justify-center bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition active:scale-[0.98] inline-flex items-center gap-1.5 shrink-0 shadow-sm">
                <span>Lihat Semua Lowongan</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse ($lowongans ?? [] as $job)
                <div style="--d: {{ ($loop->index % 3) * 100 }}ms"
                    class="reveal bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-lg hover:border-emerald-300 hover:-translate-y-1 transition duration-300 flex flex-col justify-between">

                    <div>
                        {{-- Judul & Status --}}
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h3 class="font-bold text-slate-900 text-sm min-w-0 break-words">
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
                            <i data-lucide="building-2" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                            <span class="min-w-0 break-words">{{ $job->mitra->nama ?? '-' }}</span>
                        </p>

                        {{-- Lokasi --}}
                        <p class="text-xs font-medium text-slate-500 flex items-center gap-1 mb-4">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                            <span class="min-w-0 break-words">{{ $job->lokasi ?? '-' }}</span>
                        </p>

                        {{-- Deskripsi --}}
                        <p class="text-xs text-slate-500 line-clamp-2">
                            {{ $job->deskripsi ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>

                    {{-- Footer --}}
                    <div class="pt-3 mt-4 border-t border-slate-100 flex items-center justify-between gap-3">

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
                            class="text-xs font-bold bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl px-3.5 py-2 transition active:scale-[0.98] shadow-sm shrink-0">
                            Lamar
                        </a>
                    </div>

                </div>

            @empty

                <div
                    class="reveal sm:col-span-2 lg:col-span-3 p-8 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                    <i data-lucide="briefcase" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                    Belum ada lowongan aktif saat ini.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ALUR PENDAFTARAN --}}
    <section class="bg-slate-50/80 border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-14">
            <div class="reveal text-center max-w-xl mx-auto mb-8 sm:mb-10 space-y-1">
                <span
                    class="inline-block text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    TRANSPARAN & MUDAH
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Alur Pendaftaran Pelatihan siKarir
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach ([
                    ['no' => '01', 'title' => 'Buat Akun & NIK', 'desc' => 'Daftarkan akun siKarir menggunakan NIK KTP yang valid, lengkapi profil pribadi.', 'note' => 'Validasi Dispendukcapil'],
                    ['no' => '02', 'title' => 'Pilih Kejuruan', 'desc' => 'Eksplorasi katalog pelatihan aktif sesuai minat karir, jadwal, dan kuota.', 'note' => '1 Peserta 1 Program Aktif'],
                    ['no' => '03', 'title' => 'Tes Minat & Wawancara', 'desc' => 'Ikuti tes tertulis online serta verifikasi wawancara tatap muka di workshop BLK.', 'note' => 'Pengumuman Transparan'],
                    ['no' => '04', 'title' => 'Pelatihan & Sertifikasi', 'desc' => 'Jalani pelatihan intensif gratis hingga ujian kompetensi resmi BNSP RI.', 'note' => 'Terhubung ke DUDI'],
                ] as $step)
                    <div style="--d: {{ $loop->index * 120 }}ms"
                        class="reveal group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-emerald-300 hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                        <div>
                            <div
                                class="w-9 h-9 rounded-xl bg-emerald-900 text-white flex items-center justify-center font-black text-xs mb-3 shadow-md group-hover:scale-110 group-hover:-rotate-6 transition duration-300">
                                {{ $step['no'] }}
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1">{{ $step['title'] }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-3">{{ $step['desc'] }}</p>
                        </div>
                        <div
                            class="pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 shrink-0"></i>
                            <span>{{ $step['note'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- WARTA & ALUMNI --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-14 grid lg:grid-cols-2 gap-8 lg:gap-10">
        {{-- Warta --}}
        <div class="reveal">
            <div class="flex justify-between items-center mb-5 sm:mb-6 gap-3">
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Warta & Agenda BLK</h2>
                <a href="#" class="group text-xs font-bold text-emerald-800 hover:underline flex items-center gap-1 shrink-0">
                    Lihat Arsip <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="space-y-4">
                @forelse ($berita ?? [] as $b)
                    <div style="--d: {{ $loop->index * 100 }}ms"
                        class="reveal group bg-white rounded-2xl border border-slate-200/80 p-3 flex gap-3 sm:gap-4 shadow-sm hover:shadow-md hover:border-emerald-300 hover:-translate-y-0.5 transition duration-300">
                        <div class="w-20 h-16 sm:w-24 sm:h-20 rounded-xl overflow-hidden shrink-0">
                            <img src="{{ $b->gambar_url ?? asset('images/placeholder.jpg') }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        <div class="space-y-1 min-w-0">
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
        <div class="reveal space-y-5 sm:space-y-6" style="--d: 150ms">
            <h2 class="text-lg font-black text-slate-900 tracking-tight">Kisah Alumni Sukses</h2>

            @forelse ($alumni ?? [] as $a)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ $a->foto_url ?? asset('images/avatar-placeholder.jpg') }}"
                            class="w-10 h-10 rounded-full object-cover border border-emerald-200 shrink-0">
                        <div class="min-w-0">
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

            <div class="bg-emerald-50 border border-emerald-200/80 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-800 text-xs">Tentang UPT BLK Jember</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Lembaga pelatihan vokasi Disnakertrans Jatim berfasilitas
                        workshop modern.</p>
                </div>
                <a href="{{ route('tentang.index') }}"
                    class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-3 py-2 rounded-xl shrink-0 text-center transition active:scale-[0.98] shadow-sm">Profil
                    Lengkap</a>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 pb-10 sm:pb-14">
        <div
            class="reveal relative overflow-hidden bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-10 flex flex-col md:flex-row justify-between md:items-center gap-6 shadow-xl border border-emerald-800/40">
            <!-- Aksen melayang -->
            <div class="float-slow absolute -top-16 -right-10 w-56 h-56 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="float-slow-2 absolute -bottom-16 left-10 w-56 h-56 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative space-y-2 max-w-xl">
                <span
                    class="inline-block text-[10px] sm:text-[11px] font-bold text-emerald-300 uppercase tracking-wider bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-400/30">
                    INVESTASI MASA DEPAN JAWA TIMUR
                </span>
                <h2 class="text-xl md:text-2xl font-black tracking-tight text-white">Siap Memulai Karir Impian Anda?</h2>
                <p class="text-xs md:text-sm text-emerald-100/80 leading-relaxed">
                    Pendaftaran dibuka setiap bulan. Bebas biaya pendaftaran, bebas uang gedung, dan didukung penuh
                    fasilitas modern standar industri.
                </p>
            </div>
            <div class="relative flex flex-col sm:flex-row gap-3 w-full md:w-auto shrink-0">
                <a href="{{ route('register') }}"
                    class="btn-shine bg-white text-emerald-900 hover:bg-emerald-50 px-4 py-2.5 rounded-xl font-bold text-xs transition active:scale-[0.98] shadow-md flex items-center justify-center gap-1.5">
                    <i data-lucide="user-plus" class="w-4 h-4 text-emerald-700"></i> Daftar Akun siKarir
                </a>
                <a href="#"
                    class="border border-white/40 hover:bg-white/10 text-white px-4 py-2.5 rounded-xl font-semibold text-xs transition active:scale-[0.98] flex items-center justify-center gap-1.5">
                    <i data-lucide="download" class="w-4 h-4"></i> Unduh Brosur PBK
                </a>
            </div>
        </div>
    </section>

    {{-- ANIMASI: JS (scroll reveal + hitung angka statistik) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Animasi hitung angka
            function countUp(el) {
                const target = parseInt(el.dataset.count, 10);
                const suffix = el.dataset.suffix || '';
                if (reduceMotion || isNaN(target)) { el.textContent = target + suffix; return; }

                const duration = 1400;
                const start = performance.now();
                function tick(now) {
                    const p = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - p, 3);
                    el.textContent = Math.round(target * eased) + suffix;
                    if (p < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            }

            const items = document.querySelectorAll('.reveal');

            if (!('IntersectionObserver' in window)) {
                items.forEach(el => el.classList.add('is-visible'));
                document.querySelectorAll('[data-count]').forEach(countUp);
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    el.classList.add('is-visible');
                    el.querySelectorAll('[data-count]').forEach(countUp);
                    observer.unobserve(el);
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            items.forEach(el => observer.observe(el));
        });
    </script>

@endsection
