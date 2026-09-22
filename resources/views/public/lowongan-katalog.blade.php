@extends('layouts.public')

@section('title', 'Lowongan Kerja - siKarir UPT BLK Jember')

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-6">

        {{-- BREADCRUMB --}}
        <p class="text-xs text-[#3F493F] mb-4">
            <a href="{{ url('/') }}" class="hover:text-[#00652C]">🏠 Beranda</a> &rsaquo; <span class="text-[#00652C] font-medium">Lowongan Kerja (BKK)</span>
        </p>

        {{-- HERO --}}
        <span class="inline-block bg-[#D3FFD5] text-[#00652C] text-xs font-semibold px-3 py-1 rounded-full mb-4">
            ✔ PORTAL RESMI BKK UPT BLK JEMBER
        </span>
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div class="md:col-span-2">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Bursa Kerja Khusus (BKK) & Peluang Karir Mitra UPT BLK Jember</h1>
                <p class="text-sm text-[#3F493F]">
                    Platform penyaluran kerja terverifikasi dan kolaborasi DUDI Jawa Timur. Menghubungkan alumni pelatihan
                    vokasi bersertifikat BNSP dan talenta kerja kompeten langsung dengan perusahaan kredibel.
                </p>
            </div>
            <div class="bg-[#F5F7FA] rounded-xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#D3FFD5] flex items-center justify-center text-[#00652C]">✅</div>
                <div>
                    <p class="font-bold text-lg leading-none">85+</p>
                    <p class="text-xs text-[#3F493F]">Mitra Industri Aktif</p>
                    <p class="text-[10px] text-[#3F493F]">Terverifikasi Disnakertrans</p>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="bg-[#F5F7FA] rounded-xl p-4 mb-4">
            <form method="GET" class="flex flex-col md:flex-row gap-3 mb-4">
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari nama jabatan, posisi spesifik, skill vokasi, atau nama perusahaan..."
                       class="flex-1 px-3 py-2.5 border rounded-lg text-sm">
                <button type="submit" class="bg-[#00652C] text-white text-sm font-medium px-5 py-2.5 rounded-lg shrink-0">
                    ⚙ Cari Lowongan
                </button>
            </form>

            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <p class="text-[10px] font-semibold text-[#3F493F] mb-1">WILAYAH / LOKASI</p>
                    <select name="wilayah" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option>Semua Lokasi Penempatan</option>
                    </select>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-[#3F493F] mb-1">KEJURUAN / BIDANG BLK</p>
                    <select name="kejuruan" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option>Semua Kejuruan Vokasi</option>
                    </select>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-[#3F493F] mb-1">JENIS HUBUNGAN KERJA</p>
                    <select name="jenis" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option>Semua Jenis Ikatan Kerja</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between md:items-center gap-2">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="font-semibold text-[#3F493F]">Pencarian Populer:</span>
                    @foreach (['Teknisi Las', 'Otomotif Roda 4', 'Operator Garmen', 'Web Developer', 'Barista Kopi'] as $tag)
                        <a href="{{ route('lowongan.katalog', ['q' => $tag]) }}" class="bg-white border rounded-full px-3 py-1">{{ $tag }}</a>
                    @endforeach
                </div>
                <a href="{{ route('lowongan.katalog') }}" class="text-xs text-[#00652C] font-medium shrink-0">↺ Reset Filter</a>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- KOLOM KIRI: DAFTAR LOWONGAN --}}
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-4 text-sm text-[#3F493F]">
                    <p>🕐 Menampilkan {{ ($lowongan ?? collect())->count() ?: 7 }} Lowongan Aktif</p>
                    <p class="text-[#00652C] font-medium">&bull; Diperbarui Harian oleh BKK</p>
                </div>

                <div class="space-y-5">
                    @forelse ($lowongan ?? [] as $job)
                        <div class="border rounded-xl p-5">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#F2F3FF] flex items-center justify-center text-lg shrink-0">{{ $job->ikon ?? '🏢' }}</div>
                                    <div>
                                        <p class="font-semibold">{{ $job->posisi }}</p>
                                        <p class="text-xs text-[#3F493F]">
                                            {{ $job->mitra->nama ?? '-' }} &bull;
                                            <span class="text-[#00652C]">✓ {{ $job->status_verifikasi ?? 'Terverifikasi Disnakertrans' }}</span>
                                        </p>
                                    </div>
                                </div>
                                <span class="text-[10px] bg-[#F2F3FF] text-[#3F493F] px-2 py-1 rounded-full shrink-0">{{ $job->tipe_kerja ?? 'Penuh Waktu' }}</span>
                            </div>

                            <div class="flex flex-wrap gap-4 text-xs text-[#3F493F] mb-2">
                                <span>📍 {{ $job->lokasi ?? '-' }}</span>
                                <span>💰 {{ $job->estimasi_gaji ?? '-' }}</span>
                                <span class="text-[#00652C]">✔ {{ $job->prioritas ?? '-' }}</span>
                                <span>🗓 Batas: {{ $job->batas_lamaran ?? '-' }}</span>
                            </div>

                            <p class="text-xs text-[#3F493F] mb-3">{{ $job->deskripsi }}</p>

                            <div class="flex justify-between items-center">
                                <p class="text-[10px] text-[#3F493F]">Dipublikasikan: {{ $job->dipublikasikan ?? '-' }}</p>
                                <div class="flex gap-2">
                                    <a href="#" class="text-xs border rounded-lg px-3 py-2">Detail Syarat</a>
                                    <a href="{{ route('register') }}" class="text-xs bg-[#00652C] text-white rounded-lg px-3 py-2">Lamar Cepat (BKK)</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#3F493F]">Belum ada lowongan aktif saat ini.</p>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                <div class="flex justify-between items-center mt-8 text-sm">
                    <p class="text-[#3F493F]">Menampilkan halaman 1 dari 4</p>
                    <div class="flex items-center gap-2">
                        <button class="w-8 h-8 border rounded-lg">&lsaquo;</button>
                        @foreach ([1, 2, 3, 4] as $page)
                            <button class="w-8 h-8 rounded-lg {{ $page === 1 ? 'bg-[#00652C] text-white' : 'border text-[#3F493F]' }}">{{ $page }}</button>
                        @endforeach
                        <button class="w-8 h-8 border rounded-lg">&rsaquo;</button>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <div class="space-y-6">
                {{-- Foto workshop --}}
                <div class="border rounded-xl overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('images/workshop-blk.jpg') }}" class="w-full h-40 object-cover" alt="Workshop Praktik Industri BLK Jember">
                        <span class="absolute bottom-2 left-2 bg-black/60 text-white text-[10px] px-2 py-1 rounded">&bull; Workshop Praktik Industri BLK Jember</span>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-sm mb-1">Siap Kerja Berstandar Industri</p>
                        <p class="text-xs text-[#3F493F]">Kurikulum pelatihan dirancang bersama asosiasi industri (DUDI) untuk menjamin lulusan langsung menguasai kompetensi yang dicari pasar kerja modern.</p>
                    </div>
                </div>

                {{-- Alur Penyaluran BKK --}}
                <div class="border rounded-xl p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-lg">📈</span>
                        <p class="font-semibold text-sm">Alur Penyaluran BKK</p>
                    </div>
                    <p class="text-[10px] text-[#3F493F] mb-4 -mt-3">Mekanisme Resmi Penempatan Alumni</p>
                    <div class="space-y-4">
                        @foreach ([
                            ['no' => '1', 'title' => 'Registrasi & Upload Sertifikat', 'desc' => 'Lengkapi profil akun siKarir Anda, unggah sertifikat PBK BLK Jember atau lisensi kompetensi BNSP resmi.'],
                            ['no' => '2', 'title' => 'Lamar Lowongan Mitra DUDI', 'desc' => 'Pilih formasi kerja yang selaras dengan kejuruan Anda. Klik tombol "Lamar Cepat" untuk auto-verifikasi sertifikat.'],
                            ['no' => '3', 'title' => 'Tes Seleksi & Wawancara', 'desc' => 'Ikuti uji praktik dan interview kerja terfasilitasi baik di aula UPT BLK Jember maupun via virtual interview.'],
                            ['no' => '4', 'title' => 'Kontrak & Monitoring Pasca Pelatihan', 'desc' => 'Penandatanganan PKWT/Perjanjian Kerja bersama HRD mitra serta pencatatan resmi database ketenagakerjaan Disnakertrans.'],
                        ] as $step)
                            <div class="flex gap-3">
                                <div class="w-6 h-6 rounded-full bg-[#00652C] text-white text-xs flex items-center justify-center shrink-0">{{ $step['no'] }}</div>
                                <div>
                                    <p class="font-medium text-xs mb-0.5">{{ $step['title'] }}</p>
                                    <p class="text-[11px] text-[#3F493F]">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="#" class="block text-center mt-4 bg-[#131B2E] text-white text-xs font-medium py-2.5 rounded-lg">⬇ Unduh Panduan Penyaluran (PDF)</a>
                </div>

                {{-- CTA Mitra --}}
                <div class="bg-[#00652C] text-white rounded-xl p-5">
                    <p class="text-[10px] text-[#D3FFD5] mb-2">🏭 KEMITRAAN INDUSTRI</p>
                    <p class="font-semibold mb-2">Ingin Merekrut Tenaga Kerja Kompeten Bersertifikat?</p>
                    <p class="text-xs text-[#D3FFD5] mb-4">Daftarkan perusahaan Anda sebagai mitra resmi BKK UPT BLK Jember. Nikmati kemudahan rekrutmen massal talenta siap kerja, uji kompetensi di workshop BLK, dan bebas biaya administrasi penempatan kerja.</p>
                    <a href="#" class="block text-center bg-white text-[#00652C] text-sm font-medium py-2.5 rounded-lg mb-2">🏢 Daftarkan Perusahaan Anda</a>
                    <a href="#" class="block text-center text-xs text-[#D3FFD5]">Konsultasi Kerjasama BKK (WhatsApp PIC)</a>
                </div>

                {{-- LSP Badge --}}
                <div class="flex items-center gap-3 text-xs text-[#3F493F]">
                    <span class="text-lg">🥇</span>
                    <div>
                        <p class="font-semibold text-[#131B2E]">LSP P1 BLK Jember</p>
                        <p>Terlisensi Resmi BNSP No. KEP.0418/BNSP/III/2021</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
