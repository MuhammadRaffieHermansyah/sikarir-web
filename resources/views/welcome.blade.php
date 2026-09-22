@extends('layouts.public')

@section('title', 'siKarir - UPT BLK Jember | Beranda Portal Pelatihan & Karir')

@section('content')

    {{-- HERO --}}
    <section class="bg-[#00652C] text-white">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <p class="text-xs font-semibold text-[#D3FFD5] mb-3 tracking-wide">PORTAL RESMI UPT BLK JEMBER</p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-4">
                        Portal Resmi Pelatihan Vokasi & Bursa Karir siKarir - UPT BLK Jember
                    </h1>
                    <p class="text-[#EAEDFF] max-w-2xl text-sm">
                        Tingkatkan keahlian kerja bersertifikasi BNSP dan raih peluang karir terverifikasi bersama
                        UPT Balai Latihan Kerja (BLK) Jember - Dinas Tenaga Kerja & Transmigrasi Provinsi Jawa
                        Timur. Siap mencetak talenta vokasi unggul berdaya saing industri.
                    </p>
                </div>
                <div class="bg-white/10 border border-white/30 rounded-xl p-4 text-sm">
                    <p class="font-semibold mb-1">🛡 LSP-P1 BLK Jember</p>
                    <p class="text-[#EAEDFF] text-xs">Terakreditasi BNSP RI & terintegrasi SIAPkerja Kemnaker RI untuk penyaluran tenaga kerja siap pakai.</p>
                </div>
            </div>

            {{-- Search bar: 3 kolom + tombol, submit ke katalog pelatihan --}}
            <form method="GET" action="{{ route('pelatihan.katalog') }}" class="bg-white rounded-xl mt-8 p-3 grid md:grid-cols-4 gap-3 items-center text-[#131B2E]">
                <div>
                    <p class="text-[10px] text-[#3F493F] mb-1">Cari Pelatihan / Kejuruan / Profesi</p>
                    <input type="text" name="q" placeholder="Cth: Otomotif, Las SMAW, IT Python, Teknisi..." class="px-3 py-2 border rounded-lg text-sm w-full">
                </div>
                <div>
                    <p class="text-[10px] text-[#3F493F] mb-1">Kategori Lowongan / Program</p>
                    <select name="kategori" class="px-3 py-2 border rounded-lg text-sm w-full">
                        <option value="">Semua Program & Lowongan</option>
                    </select>
                </div>
                <div>
                    <p class="text-[10px] text-[#3F493F] mb-1">Wilayah Kampus & Lokasi Kerja</p>
                    <select name="wilayah" class="px-3 py-2 border rounded-lg text-sm w-full">
                        <option value="">Kampus Workshop UPT BLK Jember</option>
                    </select>
                </div>
                <button type="submit" class="bg-[#00652C] text-white rounded-lg py-2.5 font-medium text-sm self-end">🔍 Temukan</button>
            </form>
        </div>
    </section>

    {{-- STAT STRIP (kartu putih terpisah) --}}
    <section class="bg-[#F5F7FA] border-b">
        <div class="max-w-7xl mx-auto px-6 -mt-6 pt-2 pb-10 grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => '🎓', 'value' => '12+', 'label' => 'Kejuruan', 'sub' => 'Pelatihan Berstandar Nasional'],
                ['icon' => '📈', 'value' => '94%', 'label' => 'Lulusan', 'sub' => 'Terserap Bekerja & Wirausaha'],
                ['icon' => '⚡', 'value' => '100%', 'label' => 'Gratis', 'sub' => 'Dibiayai APBD & APBN Penuh'],
                ['icon' => '🛡', 'value' => 'BNSP', 'label' => 'Resmi', 'sub' => 'Sertifikasi Standar Industri'],
            ] as $stat)
                <div class="bg-white rounded-xl border shadow-sm p-5 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#D3FFD5] flex items-center justify-center shrink-0">{{ $stat['icon'] }}</div>
                    <div>
                        <p class="font-bold text-sm">{{ $stat['value'] }} {{ $stat['label'] }}</p>
                        <p class="text-[10px] text-[#3F493F] mt-0.5">{{ $stat['sub'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- LAYANAN UNGGULAN --}}
    <section class="max-w-7xl mx-auto px-6 py-14">
        <div class="flex justify-between items-end mb-8">
            <div>
                <p class="text-xs font-semibold text-[#00652C] mb-1">LAYANAN MANDIRI PUBLIK</p>
                <h2 class="text-2xl font-bold">Layanan Unggulan siKarir UPT BLK Jember</h2>
            </div>
            <a href="#" class="text-sm text-[#00652C] font-medium">Semua Menu Layanan &rarr;</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['icon' => '🧑‍🎓', 'title' => 'Pendaftaran Pelatihan', 'desc' => 'Pelatihan Reguler Berbasis Kompetensi (PBK) & Mobile Training Unit (MTU) pedesaan.', 'dark' => false],
                ['icon' => '💼', 'title' => 'Bursa Kerja Khusus (BKK)', 'desc' => 'Peluang kerja resmi terverifikasi dinas bagi alumni vokasi dan pencari kerja umum.', 'dark' => false],
                ['icon' => '🖐', 'title' => 'Uji Kompetensi & Sertifikasi', 'desc' => 'Jadwal asesmen kompetensi profesi LSP-P1 BLK Jember terlisensi resmi BNSP.', 'dark' => false],
                ['icon' => '🎓', 'title' => 'Konsultasi & Bimbingan Jabatan', 'desc' => 'Konseling karir cuma-cuma bersama instruktur dan psikolog ketenagakerjaan.', 'dark' => true],
                ['icon' => '🤝', 'title' => 'Magang & Kemitraan DUDI', 'desc' => 'Sinergi Dunia Usaha dan Dunia Industri (DUDI) untuk program on-the-job training.', 'dark' => true],
                ['icon' => '📱', 'title' => 'Verifikasi Sertifikat Digital', 'desc' => 'Cek keaslian sertifikat kelulusan BLK dan e-Sertifikat kompetensi via kode unik.', 'dark' => false],
            ] as $layanan)
                <div class="border rounded-xl p-5 bg-white">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-3 {{ $layanan['dark'] ? 'bg-[#131B2E]' : 'bg-[#D3FFD5]' }}">
                        {{ $layanan['icon'] }}
                    </div>
                    <p class="font-semibold mb-1">{{ $layanan['title'] }}</p>
                    <p class="text-sm text-[#3F493F]">{{ $layanan['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- PROGRAM PELATIHAN --}}
    <section class="bg-[#F5F7FA]">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <p class="text-xs font-semibold text-[#00652C] mb-1">PENDAFTARAN GELOMBANG II TA 2025</p>
                    <h2 class="text-2xl font-bold">Program Pelatihan Kejuruan UPT BLK Jember</h2>
                </div>
                <a href="{{ route('pelatihan.katalog') }}" class="bg-[#00652C] text-white text-sm px-4 py-2 rounded-lg shrink-0">Lihat Semua Pelatihan &rarr;</a>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                @forelse ($pelatihan ?? [] as $item)
                    <div class="border rounded-xl overflow-hidden bg-white">
                        <div class="relative">
                            <img src="{{ $item->gambar_url ?? asset('images/placeholder.jpg') }}" class="w-full h-36 object-cover" alt="{{ $item->nama }}">
                            <span class="absolute top-2 left-2 bg-[#00652C] text-white text-[10px] px-2 py-1 rounded">Pendaftaran Buka</span>
                            <span class="absolute top-2 right-2 bg-[#131B2E] text-white text-[10px] px-2 py-1 rounded">{{ $item->sumber_dana ?? 'APBN Gratis' }}</span>
                        </div>
                        <div class="p-4">
                            <p class="text-[10px] font-semibold text-[#3F493F] mb-1 uppercase">{{ $item->kategori ?? 'Kejuruan' }}</p>
                            <p class="font-semibold mb-1">{{ $item->nama }}</p>
                            <p class="text-xs text-[#3F493F] mb-3">{{ $item->deskripsi }}</p>
                            <div class="flex justify-between">
                                <a href="{{ route('pelatihan.katalog') . '#' . $item->id }}" class="text-xs border rounded-lg px-3 py-1.5">Silabus</a>
                                <a href="{{ route('register') }}" class="text-xs bg-[#00652C] text-white rounded-lg px-3 py-1.5">Daftar</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-[#3F493F] col-span-4">Belum ada data pelatihan.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- BURSA KERJA --}}
    <section class="max-w-7xl mx-auto px-6 py-14">
        <div class="flex justify-between items-end mb-6">
            <div>
                <p class="text-xs font-semibold text-[#00652C] mb-1">KONEKSI KARIR & INDUSTRI</p>
                <h2 class="text-2xl font-bold">Bursa Kerja Khusus (BKK) & Lowongan Kerja UPT BLK Jember</h2>
            </div>
            <a href="{{ route('lowongan.katalog') }}" class="bg-[#00652C] text-white text-sm px-4 py-2 rounded-lg">Lihat Semua Lowongan &rarr;</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($lowongan ?? [] as $job)
                <div class="border rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-2">
                        <p class="font-semibold">{{ $job->posisi }}</p>
                        <span class="text-[10px] bg-[#D3FFD5] text-[#00652C] px-2 py-1 rounded">Terverifikasi</span>
                    </div>
                    <p class="text-xs text-[#3F493F] mb-3">{{ $job->mitra->nama ?? '-' }}</p>
                    <p class="text-xs text-[#3F493F] mb-1">Estimasi Gaji</p>
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-sm">{{ $job->estimasi_gaji ?? '-' }}</p>
                        <a href="{{ route('lowongan.katalog') . '#' . $job->id }}" class="text-xs bg-[#00652C] text-white rounded-lg px-3 py-1.5">Lamar</a>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#3F493F] col-span-3">Belum ada lowongan aktif.</p>
            @endforelse
        </div>
    </section>

    {{-- ALUR PENDAFTARAN --}}
    <section class="bg-[#F5F7FA]">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <div class="text-center mb-8">
                <p class="text-xs font-semibold text-[#00652C] mb-1">TRANSPARAN & MUDAH</p>
                <h2 class="text-2xl font-bold">Alur Pendaftaran Pelatihan siKarir</h2>
            </div>
            <div class="grid md:grid-cols-4 gap-6">
                @foreach ([
                    ['no' => '01', 'title' => 'Buat Akun & NIK', 'desc' => 'Daftarkan akun siKarir menggunakan NIK KTP yang valid, lengkapi profil pribadi.', 'note' => 'Validasi Otomatis Dispendukcapil', 'color' => '#00652C'],
                    ['no' => '02', 'title' => 'Pilih Kejuruan', 'desc' => 'Eksplorasi katalog pelatihan aktif sesuai minat karir, jadwal, dan kuota.', 'note' => '1 Peserta 1 Program Aktif', 'color' => '#131B2E'],
                    ['no' => '03', 'title' => 'Tes Minat & Wawancara', 'desc' => 'Ikuti tes tertulis online serta verifikasi wawancara tatap muka di workshop BLK.', 'note' => 'Hasil Diumumkan Terbuka', 'color' => '#131B2E'],
                    ['no' => '04', 'title' => 'Pelatihan & Sertifikasi', 'desc' => 'Jalani pelatihan intensif gratis hingga ujian kompetensi resmi BNSP RI.', 'note' => 'Langsung Terhubung ke DUDI', 'color' => '#B99B2E'],
                ] as $step)
                    <div class="bg-white rounded-xl p-5 border">
                        <div class="w-9 h-9 rounded-lg text-white flex items-center justify-center font-bold text-sm mb-3" style="background:{{ $step['color'] }}">{{ $step['no'] }}</div>
                        <p class="font-semibold mb-1">{{ $step['title'] }}</p>
                        <p class="text-xs text-[#3F493F] mb-2">{{ $step['desc'] }}</p>
                        <p class="text-xs font-medium text-[#00652C]">&#10003; {{ $step['note'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- WARTA & ALUMNI --}}
    <section class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-2 gap-8">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Warta & Agenda BLK</h2>
                <a href="#" class="text-sm text-[#00652C]">Lihat Semua Arsip &rarr;</a>
            </div>
            @foreach ($berita ?? [] as $b)
                <div class="flex gap-4 mb-4">
                    <img src="{{ $b->gambar_url ?? asset('images/placeholder.jpg') }}" class="w-24 h-20 rounded-lg object-cover">
                    <div>
                        <p class="text-[10px] font-semibold text-[#00652C]">{{ $b->kategori ?? 'PENGUMUMAN' }} &bull; {{ $b->tanggal ?? '' }}</p>
                        <p class="font-semibold text-sm mb-1">{{ $b->judul }}</p>
                        <p class="text-xs text-[#3F493F]">{{ $b->ringkasan }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            <h2 class="text-xl font-bold mb-4">Kisah Alumni Sukses</h2>
            @foreach ($alumni ?? [] as $a)
                <div class="border rounded-xl p-5 mb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ $a->foto_url ?? asset('images/avatar-placeholder.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-sm">{{ $a->nama }}</p>
                            <p class="text-xs text-[#3F493F]">{{ $a->profesi }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-[#3F493F] italic">&ldquo;{{ $a->testimoni }}&rdquo;</p>
                </div>
            @endforeach
            <div class="bg-[#D3FFD5] rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-sm">Tentang UPT BLK Jember</p>
                    <p class="text-xs text-[#3F493F]">Lembaga pelatihan vokasi Disnakertrans Jatim berfasilitas workshop modern.</p>
                </div>
                <a href="{{ route('tentang.index') }}" class="bg-white text-xs px-3 py-1.5 rounded-lg font-medium shrink-0 ml-3">Profil Lengkap</a>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-7xl mx-auto px-6 pb-14">
        <div class="bg-[#00652C] text-white rounded-2xl p-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <p class="text-xs text-[#D3FFD5] mb-1">INVESTASI MASA DEPAN JAWA TIMUR</p>
                <h2 class="text-xl font-bold mb-1">Siap Memulai Karir Impian Anda?</h2>
                <p class="text-sm text-[#EAEDFF]">Pendaftaran dibuka setiap bulan. Bebas biaya pendaftaran, bebas uang gedung, dan didukung penuh fasilitas modern standar industri.</p>
            </div>
            <div class="flex gap-3 shrink-0">
                <a href="{{ route('register') }}" class="bg-white text-[#00652C] px-4 py-2 rounded-lg font-medium text-sm">🎓 Daftar Akun siKarir</a>
                <a href="#" class="border border-white px-4 py-2 rounded-lg font-medium text-sm">⬇ Unduh Brosur PBK 2025</a>
            </div>
        </div>
    </section>

@endsection
