@extends('layouts.public')

@section('title', 'Lowongan Kerja (BKK) - siKarir UPT BLK Jember')

@section('content')

<div class="public-page">

    {{-- HERO SECTION --}}
    <section class="public-hero relative overflow-hidden text-white">
        <!-- Background Accent Blur -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-0 py-6 md:py-8 relative z-10">
            <div class="grid gap-8 items-center">
                <div class="space-y-5">
                    <div class="public-kicker">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        PORTAL RESMI BKK UPT BLK JEMBER
                    </div>
                    <h1 class="text-white">
                        Bursa Kerja Khusus.<br><span class="public-hero-accent">Peluang Karir Mitra DUDI.</span>
                    </h1>
                    <p class="text-emerald-100/80 max-w-2xl">
                        Platform penyaluran kerja terverifikasi dan kolaborasi DUDI Jawa Timur. Menghubungkan alumni pelatihan vokasi bersertifikat BNSP dan talenta kerja kompeten langsung dengan perusahaan kredibel.
                    </p>
                </div>

                <!-- Banner Stat Widget -->
                <div class="public-hero-aside md:col-span-4 rounded-[1.5rem] bg-white/8 backdrop-blur-md border border-white/15 p-5 text-xs text-emerald-100 flex items-center gap-4 shadow-2xl">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400 shrink-0">
                        <i data-lucide="building-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-black text-white text-2xl leading-none">{{ $totalMitra }}</p>
                        <p class="font-bold text-emerald-200 text-xs mt-1">Mitra Industri Aktif</p>
                        <p class="text-[10px] text-emerald-100/70">Terverifikasi Disnakertrans Jatim</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT & FILTER -->
    <div class="max-w-7xl mx-auto px-0 py-10 md:py-14">

        {{-- SEARCH & FILTER PANEL --}}
        <div class="public-filter bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-8 space-y-4">
            <form method="GET" action="{{ route('lowongan.katalog') }}" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-1">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-3 text-slate-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Cari nama posisi, deskripsi, lokasi, atau nama perusahaan..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                    </div>
                    <button type="submit" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-6 py-2.5 rounded-xl transition flex items-center justify-center gap-2 shrink-0 shadow-sm">
                        <i data-lucide="filter" class="w-4 h-4"></i> Cari Lowongan
                    </button>
                </div>

                <div class="space-y-1 pt-2 border-t border-slate-100">
                    <label for="wilayah" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Wilayah / Lokasi</label>
                    <select name="wilayah" id="wilayah" onchange="this.form.submit()"
                            class="w-full md:max-w-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 transition">
                        <option value="">Semua Lokasi Penempatan</option>
                        @foreach ($daftarLokasi as $lokasi)
                            <option value="{{ $lokasi }}" {{ request('wilayah') === $lokasi ? 'selected' : '' }}>{{ $lokasi }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="flex flex-col md:flex-row justify-between md:items-center gap-3 pt-3 border-t border-slate-100">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    @if ($daftarLokasi->isNotEmpty())
                        <span class="font-bold text-slate-500 flex items-center gap-1">
                            <i data-lucide="sparkles" class="w-3.5 h-3.5 text-emerald-600"></i> Lokasi:
                        </span>
                        @foreach ($daftarLokasi->take(5) as $lokasi)
                            <a href="{{ route('lowongan.katalog', ['wilayah' => $lokasi]) }}" class="bg-slate-100 hover:bg-lime-100 hover:text-emerald-950 border border-slate-200/80 rounded-full px-3 py-1 text-[11px] font-semibold text-slate-600 transition">
                                {{ $lokasi }}
                            </a>
                        @endforeach
                    @endif
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
                        Menampilkan {{ $lowongan->total() }} Lowongan Aktif
                    </p>
                    <span class="text-emerald-700 font-bold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Diperbarui Harian
                    </span>
                </div>

                {{-- LOOP CARDS LOWONGAN --}}
                <div class="space-y-4">
                    @forelse ($lowongan as $job)
                        @php
                            $tgl = $job->tanggal_posting ? $job->tanggal_posting->translatedFormat('d M Y') : '-';
                        @endphp
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md hover:border-emerald-300 transition space-y-3">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex gap-3.5 min-w-0">
                                    @if ($job->gambar_url)
                                        <img src="{{ $job->gambar_url }}" alt="{{ $job->judul_lowongan }}"
                                             class="w-14 h-14 rounded-xl object-cover border border-slate-100 shrink-0">
                                    @else
                                        <div class="w-14 h-14 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-800 shrink-0">
                                            <i data-lucide="building-2" class="w-6 h-6"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug">
                                            <a href="{{ route('lowongan.detail', $job->id_lowongan) }}" class="hover:text-emerald-700 transition">{{ $job->judul_lowongan }}</a>
                                        </h3>
                                        <p class="text-xs font-semibold text-slate-500 mt-0.5 flex flex-wrap items-center gap-x-1.5 gap-y-0.5">
                                            <span>{{ $job->mitra->nama_perusahaan ?? '-' }}</span>
                                            <span class="text-slate-300">•</span>
                                            <span class="text-emerald-700 font-bold flex items-center gap-1">
                                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Terverifikasi Disnakertrans
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full shrink-0 uppercase tracking-wider max-w-40 truncate">
                                    {{ $job->mitra->bidang_usaha ?? 'Lowongan' }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-slate-600 bg-slate-50/80 p-2.5 rounded-xl border border-slate-100">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $job->lokasi ?? '-' }}
                                </span>
                                <span class="flex items-center gap-1 text-emerald-700 font-semibold">
                                    <i data-lucide="award" class="w-3.5 h-3.5"></i> Alumni BLK
                                </span>
                                <span class="flex items-center gap-1 text-slate-500 font-semibold ml-auto">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $tgl }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $job->deskripsi ?: 'Tidak ada deskripsi.' }}</p>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 font-medium">Dipublikasikan: {{ $tgl }}</span>
                                <a href="{{ route('lowongan.detail', $job->id_lowongan) }}"
                                   class="text-xs font-bold bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl px-3.5 py-2 transition shadow-sm flex items-center gap-1">
                                    <span>Lihat Selengkapnya</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                            <i data-lucide="briefcase" class="w-10 h-10 mx-auto text-slate-300 mb-2"></i>
                            Belum ada lowongan aktif yang sesuai dengan filter Anda.
                        </div>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                @if ($lowongan->hasPages())
                    <div class="mt-6">
                        {{ $lowongan->links('components.pagination') }}
                    </div>
                @endif
            </div>

            {{-- KOLOM KANAN: SIDEBAR (4 cols) --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- Foto Workshop --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm">
                    <div class="relative h-40 bg-slate-100">
                        <img src="https://images.unsplash.com/photo-1654703680007-d5d9699cddfd?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="w-full h-full object-cover" alt="Workshop Praktik Industri BLK Jember">
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
                            ['no' => '2', 'title' => 'Pilih Lowongan Mitra DUDI', 'desc' => 'Pilih formasi kerja yang selaras dengan kejuruan Anda, lalu hubungi perusahaan melalui kontak yang tertera di halaman detail.'],
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
                <div class="relative overflow-hidden bg-linear-to-br from-emerald-900 to-teal-950 text-white rounded-2xl p-6 shadow-md space-y-3 border border-emerald-800/40">
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
</div>

@endsection
