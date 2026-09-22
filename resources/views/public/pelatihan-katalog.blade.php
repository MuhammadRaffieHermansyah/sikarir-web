@extends('layouts.public')

@section('title', 'Katalog Pelatihan Vokasi - siKarir UPT BLK Jember')

@section('content')

    {{-- TICKER INFO ANNOUNCEMENT --}}
    <!-- <div class="bg-emerald-900 text-white text-xs font-medium py-2.5 px-6 border-b border-emerald-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="font-bold text-emerald-300">INFO PENDAFTARAN:</span>
                <span>Penerimaan Siswa Pelatihan Vokasi Gelombang II TA 2026 Resmi Dibuka</span>
            </div>
            <div class="flex items-center gap-4 text-emerald-200/80 text-[11px]">
                <span class="flex items-center gap-1"><i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-400"></i> Online Terbuka</span>
                <span class="flex items-center gap-1"><i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-400"></i> Hotline: (0331) 487771</span>
            </div>
        </div>
    </div> -->

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
                <span class="text-white font-bold">Katalog Pelatihan</span>
            </nav>

            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-8 space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 rounded-full border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-sm">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        PENDIDIKAN VOKASI TERAKREDITASI KEMNAKER RI & BNSP
                    </div>
                    <h1 class="text-2xl md:text-4xl font-black leading-tight tracking-tight text-white">
                        Katalog Program Pelatihan Kerja & Vokasi
                    </h1>
                    <p class="text-emerald-100/80 max-w-2xl text-xs md:text-sm leading-relaxed">
                        Tingkatkan keahlian kerja nyata Anda tanpa biaya. Seluruh program pelatihan vokasi di UPT Balai Latihan Kerja Jember didanai <span class="text-emerald-300 font-bold">100% Gratis</span> melalui pembiayaan APBD Provinsi Jawa Timur dan APBN Kemnaker RI.
                    </p>
                </div>

                <!-- Banner Stat Widget -->
                <div class="md:col-span-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 text-xs text-emerald-100 space-y-2 shadow-xl">
                    <div class="flex items-center justify-between font-bold text-white text-sm pb-2 border-b border-white/10">
                        <span class="flex items-center gap-1.5"><i data-lucide="wallet" class="w-4 h-4 text-emerald-400"></i> Alokasi Anggaran</span>
                        <span class="text-xs bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 px-2 py-0.5 rounded-full">DIPA 2026</span>
                    </div>
                    <p class="text-[11px] leading-relaxed text-emerald-100/80 pt-1">
                        Penyelenggaraan pelatihan berbasis Unit Kompetensi SKKNI dengan penjaminan mutu Lembaga Sertifikasi Profesi Pihak Pertama (LSP-P1).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT AREA -->
    <div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

        {{-- STAT STRIP --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ([
                ['icon' => 'cpu', 'value' => '14', 'label' => 'Kejuruan Aktif'],
                ['icon' => 'users', 'value' => '32', 'label' => 'Paket Berjalan'],
                ['icon' => 'circle-dollar-sign', 'value' => '100%', 'label' => 'Gratis Bebas Biaya'],
                ['icon' => 'award', 'value' => 'BNSP', 'label' => 'Sertifikasi Resmi'],
            ] as $stat)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 flex items-center gap-3.5 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-emerald-900 text-white flex items-center justify-center shrink-0 shadow-md">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-900 text-base leading-none">{{ $stat['value'] }}</p>
                        <p class="text-[11px] font-medium text-slate-500 mt-1">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- SEARCH & FILTER PANEL --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4">
            <form method="GET" action="{{ route('pelatihan.katalog') }}" class="grid md:grid-cols-12 gap-3">
                <div class="relative md:col-span-6">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-3 text-slate-400"></i>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Ketik kejuruan, keterampilan (cth: Sepeda Motor, Web, Las, Barista)..."
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
                </div>
                <div class="md:col-span-3">
                    <select name="tipe" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 transition">
                        <option value="">Semua Tipe Pelatihan</option>
                        <option value="PBK Reguler" @selected(request('tipe') === 'PBK Reguler')>PBK Reguler</option>
                        <option value="MTU Masuk Desa" @selected(request('tipe') === 'MTU Masuk Desa')>MTU Masuk Desa</option>
                    </select>
                </div>
                <div class="md:col-span-3 flex gap-2">
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-600 transition">
                        <option value="">Semua Status</option>
                        <option value="buka" @selected(request('status') === 'buka')>Pendaftaran Buka</option>
                        <option value="tutup" @selected(request('status') === 'tutup')>Ditutup</option>
                    </select>
                    <button type="submit" class="bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl px-4 py-2.5 text-xs font-bold transition shrink-0 shadow-sm" title="Cari">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                    <a href="{{ route('pelatihan.katalog') }}" class="border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl px-3.5 py-2.5 text-xs font-semibold shrink-0 flex items-center gap-1 transition">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset
                    </a>
                </div>
            </form>

            <div class="pt-3 border-t border-slate-100 space-y-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori Kejuruan:</p>
                <div class="flex flex-wrap gap-2">
                    @php $kategoriAktif = request('kategori', 'Semua Bidang'); @endphp
                    @foreach (['Semua Bidang', 'Teknik Otomotif', 'Teknik Komputer & IT', 'Garmen Apparel (Menjahit)', 'Teknik Las & Fabrikasi', 'Refrigerasi & AC', 'Tata Boga & Barista', 'Bisnis & Kewirausahaan'] as $kategori)
                        <a href="{{ route('pelatihan.katalog', ['kategori' => $kategori]) }}"
                           class="text-xs px-3 py-1.5 rounded-xl font-semibold transition {{ $kategoriAktif === $kategori ? 'bg-emerald-900 text-white shadow-sm' : 'bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-slate-600 border border-slate-200/80' }}">
                            {{ $kategori }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RESULT COUNTER --}}
        <div class="flex justify-between items-center text-xs text-slate-500 font-medium px-1">
            <p class="flex items-center gap-1.5 font-bold text-slate-800">
                <i data-lucide="book-open" class="w-4 h-4 text-emerald-700"></i>
                Menampilkan {{ is_object($pelatihan) && method_exists($pelatihan, 'total') ? $pelatihan->total() : (($pelatihan ?? collect())->count() ?: 6) }} Program Pelatihan Vokasi
            </p>
            <span class="text-emerald-700 font-bold flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terverifikasi DIPA 2026
            </span>
        </div>

        {{-- GRID PELATIHAN --}}
        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($pelatihan ?? [] as $item)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-44 bg-slate-100">
                            <img src="{{ $item->gambar_url ?? asset('images/placeholder.jpg') }}" class="w-full h-full object-cover" alt="{{ $item->nama }}">
                            <span class="absolute top-2.5 left-2.5 bg-emerald-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm shadow-sm">
                                {{ $item->sumber_dana ?? '100% Gratis APBD' }}
                            </span>
                            <span class="absolute top-2.5 right-2.5 bg-slate-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm shadow-sm">
                                {{ $item->tipe ?? 'PBK Reguler' }}
                            </span>
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                <span class="flex items-center gap-1 text-emerald-700">
                                    <i data-lucide="wrench" class="w-3.5 h-3.5"></i> {{ $item->kategori ?? 'Kejuruan' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i> s/d {{ $item->batas_seleksi ?? '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-start gap-2">
                                <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-1">{{ $item->nama }}</h3>
                                <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md shrink-0 border border-slate-200">
                                    {{ $item->jam_pelajaran ?? '240' }} JP
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $item->deskripsi }}</p>

                            <!-- Progress Bars Kursi -->
                            <!-- <div class="space-y-1.5 pt-1">
                                <div class="flex justify-between text-[11px] font-semibold">
                                    <span class="text-slate-500">Kuota: {{ $item->kuota ?? 16 }} Siswa</span>
                                    <span class="{{ ($item->sisa_kursi ?? 5) <= 2 ? 'text-rose-600 font-bold' : 'text-slate-700' }}">
                                        Sisa {{ $item->sisa_kursi ?? '-' }} Kursi {{ ($item->sisa_kursi ?? 5) <= 2 ? '(Kritis)' : '' }}
                                    </span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200/60">
                                    <div class="h-full rounded-full transition-all duration-300 {{ ($item->sisa_kursi ?? 5) <= 2 ? 'bg-rose-500' : 'bg-emerald-600' }}"
                                         style="width: {{ $item->persentase_terisi ?? 70 }}%"></div>
                                </div>
                            </div> -->

                            <!-- Badges Fasilitas -->
                            <div class="flex flex-wrap gap-1.5 pt-1">
                                @foreach ($item->fasilitas ?? ['Sertifikat BNSP', 'Uang Saku'] as $fasilitas)
                                    <span class="text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded-md flex items-center gap-1">
                                        <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i> {{ $fasilitas }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0 flex gap-2">
                        <a href="{{ route('pelatihan.katalog') . '#' . $item->id }}" class="w-1/2 text-center text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl py-2.5 transition">Silabus</a>
                        <a href="{{ route('register') }}" class="w-1/2 text-center text-xs font-bold bg-emerald-900 hover:bg-emerald-950 text-white rounded-xl py-2.5 transition shadow-sm flex items-center justify-center gap-1">
                            <span>Daftar</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-10 bg-white rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                    <i data-lucide="book-open" class="w-10 h-10 mx-auto text-slate-300 mb-2"></i>
                    Belum ada data pelatihan yang tersedia saat ini.
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-8">
            @if (is_object($pelatihan) && method_exists($pelatihan, 'links'))
                {{ $pelatihan->links('components.pagination') }}
            @else
                <!-- Fallback Pagination jika pke array/collect biasa -->
                <div class="flex items-center justify-between bg-white px-6 py-4 rounded-2xl border border-slate-200/80 text-xs text-slate-500 font-medium">
                    <span>Menampilkan 1 sampai 6 dari 18 data</span>
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

    {{-- HAK & FASILITAS PESERTA --}}
    <section class="bg-slate-50/80 border-y border-slate-200/80 py-14">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                HAK & FASILITAS PESERTA
            </span>
            <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2 mb-1">Apa Saja yang Didapatkan Siswa Pelatihan?</h2>
            <p class="text-xs text-slate-500 max-w-lg mx-auto mb-10">Semua fasilitas dijamin oleh negara tanpa pungutan biaya apapun (100% Gratis).</p>

            <div class="grid md:grid-cols-5 gap-5 text-left">
                @foreach ([
                    ['icon' => 'award', 'title' => 'Sertifikasi BNSP', 'desc' => 'Uji kompetensi gratis dan sertifikat profesi berstandar nasional resmi BNSP.'],
                    ['icon' => 'wallet', 'title' => 'Uang Saku Transport', 'desc' => 'Bantuan biaya transportasi harian langsung disalurkan ke rekening bank peserta.'],
                    ['icon' => 'shirt', 'title' => 'Pakaian Seragam & APD', 'desc' => 'Wearpack kerja, seragam batik, kemeja pelatihan, dan alat pelindung diri lengkap.'],
                    ['icon' => 'book-marked', 'title' => 'Modul & Bahan Praktik', 'desc' => 'Modul ajar kurikulum SKKNI, toolkit praktik mandiri, dan bahan consumable latihan.'],
                    ['icon' => 'shield-check', 'title' => 'Asuransi BPJS TK', 'desc' => 'Perlindungan Jaminan Kecelakaan Kerja (JKK) dan Jaminan Kematian (JKM) selama diklat.'],
                ] as $f)
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:border-emerald-300 transition space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                            <i data-lucide="{{ $f['icon'] }}" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">{{ $f['title'] }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SYARAT & JADWAL --}}
    <section class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-2 gap-10">
        {{-- Syarat --}}
        <div class="space-y-6">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    PEDOMAN PENDAFTARAN
                </span>
                <h2 class="text-xl font-black text-slate-900 tracking-tight mt-2">Syarat Calon Peserta & Kelengkapan Berkas</h2>
                <p class="text-xs text-slate-500 mt-1">Pendaftaran dapat dilakukan daring via portal siKarir atau datang langsung ke Kios Siap Kerja UPT BLK Jember.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-4 text-xs">
                @foreach ([
                    ['title' => 'Warga Negara Indonesia', 'desc' => 'Memiliki e-KTP / Kartu Keluarga wilayah Jawa Timur (diutamakan Tapalkuda).'],
                    ['title' => 'Usia Minimal 17 Tahun', 'desc' => 'Pria/Wanita pencari kerja, fresh graduate, atau korban PHK tanpa batas usia produktif.'],
                    ['title' => 'Pendidikan Min. SMP/SMA/SMK', 'desc' => 'Salinan ijazah terakhir legalisir atau Surat Keterangan Lulus (SKL) resmi.'],
                    ['title' => 'Surat Keterangan Sehat', 'desc' => 'Dari Puskesmas/Rumah Sakit pemerintah dan tidak buta warna (khusus Otomotif, IT, Las).'],
                    ['title' => 'Pas Foto Formal (Latar Merah)', 'desc' => 'File digital ukuran 3x4 (3 lembar fisik jika daftar langsung di kantor BLK).'],
                    ['title' => 'Komitmen & Tidak Bekerja', 'desc' => 'Sanggup mengikuti seluruh jam diklat hingga tuntas ujian sertifikasi kompetensi BNSP.'],
                ] as $syarat)
                    <div class="flex gap-2.5 p-3 bg-white rounded-xl border border-slate-200/80 shadow-xs">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                        <div>
                            <h4 class="font-bold text-slate-800 text-xs">{{ $syarat['title'] }}</h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">{{ $syarat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-2">
                <h3 class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-3 flex items-center gap-1">
                    <i data-lucide="arrow-right-circle" class="w-4 h-4"></i> 4 Langkah Mudah Pendaftaran
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach ([
                        ['no' => '1', 'title' => 'Pilih Kejuruan', 'desc' => 'Tentukan program pelatihan sesuai minat Anda.'],
                        ['no' => '2', 'title' => 'Isi Formulir', 'desc' => 'Lengkapi NIK KTP & unggah berkas.'],
                        ['no' => '3', 'title' => 'Tes Seleksi', 'desc' => 'Tes potensi akademik & wawancara.'],
                        ['no' => '4', 'title' => 'Mulai Diklat', 'desc' => 'Kelulusan, pembagian seragam, & kelas.'],
                    ] as $step)
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80 space-y-1">
                            <div class="w-6 h-6 rounded-full bg-emerald-900 text-white font-black text-[11px] flex items-center justify-center">
                                {{ $step['no'] }}
                            </div>
                            <h4 class="font-bold text-slate-800 text-xs">{{ $step['title'] }}</h4>
                            <p class="text-[10px] text-slate-500 leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Jadwal Gelombang --}}
        <div class="space-y-6">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-purple-700 bg-purple-50 px-2.5 py-1 rounded-md border border-purple-100">
                    KALENDER DIKLAT TA 2026
                </span>
                <h2 class="text-xl font-black text-slate-900 tracking-tight mt-2">Jadwal Gelombang Pelatihan</h2>
                <p class="text-xs text-slate-500 mt-1">Penyelenggaraan pelatihan terbagi dalam 4 gelombang utama sepanjang tahun 2026.</p>
            </div>

            <div class="space-y-3">
                @foreach ([
                    ['nama' => 'Gelombang I (PBK)', 'status' => 'Tutup', 'warna' => 'bg-slate-100 text-slate-500 border-slate-200', 'detail' => 'Pelaksanaan: Jan - Feb 2026', 'icon' => 'check-circle'],
                    ['nama' => 'Gelombang II (Aktif Sekarang)', 'status' => 'Buka', 'warna' => 'bg-emerald-50 text-emerald-800 border-emerald-200/80 font-bold', 'detail' => null, 'icon' => 'sparkles'],
                    ['nama' => 'Gelombang III (APBD & APBN)', 'status' => 'Mendatang', 'warna' => 'bg-slate-50 text-slate-600 border-slate-200', 'detail' => 'Pendaftaran dibuka: 01 Juni 2026', 'icon' => 'calendar'],
                    ['nama' => 'Gelombang IV (Reguler Akhir Tahun)', 'status' => 'Mendatang', 'warna' => 'bg-slate-50 text-slate-600 border-slate-200', 'detail' => 'Pendaftaran dibuka: 01 September 2026', 'icon' => 'calendar'],
                ] as $g)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 space-y-2 shadow-xs">
                        <div class="flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                                <i data-lucide="{{ $g['icon'] }}" class="w-4 h-4 text-emerald-700"></i> {{ $g['nama'] }}
                            </h3>
                            <span class="text-[10px] px-2.5 py-0.5 rounded-full border {{ $g['warna'] }}">{{ $g['status'] }}</span>
                        </div>
                        @if ($g['status'] === 'Buka')
                            <div class="text-xs text-slate-600 space-y-1 bg-slate-50 p-3 rounded-xl border border-slate-100 font-medium">
                                <p class="flex justify-between"><span>Pendaftaran Online:</span> <span class="font-bold text-slate-800">01 Mar - 28 Mar 2026</span></p>
                                <p class="flex justify-between"><span>Tes Tertulis & Wawancara:</span> <span class="font-bold text-slate-800">31 Mar - 02 Apr 2026</span></p>
                                <p class="flex justify-between"><span>Pengumuman Kelulusan:</span> <span class="font-bold text-slate-800">04 April 2026</span></p>
                                <p class="flex justify-between"><span>Pembukaan & Masuk Kelas:</span> <span class="font-bold text-slate-800">14 April 2026</span></p>
                            </div>
                        @else
                            <p class="text-xs text-slate-500 font-medium">{{ $g['detail'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="bg-emerald-900 text-white rounded-2xl p-5 flex justify-between items-center shadow-md">
                <div>
                    <h4 class="font-bold text-sm">Unduh Buku Panduan & Silabus</h4>
                    <p class="text-xs text-emerald-200 mt-0.5">Katalog kurikulum lengkap seluruh 14 kejuruan PDF.</p>
                </div>
                <a href="#" class="bg-white text-emerald-900 hover:bg-emerald-50 text-xs font-bold px-3.5 py-2 rounded-xl shrink-0 ml-3 transition shadow-sm flex items-center gap-1">
                    <i data-lucide="download" class="w-4 h-4"></i> PDF (8.4 MB)
                </a>
            </div>
        </div>
    </section>

    {{-- FAQ SECTION --}}
    <section class="bg-slate-50/80 border-t border-slate-200/80 py-14">
        <div class="max-w-3xl mx-auto px-6 text-center space-y-8">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                    PUSAT BANTUAN & INFORMASI
                </span>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-2 mb-1">Pertanyaan Umum (FAQ)</h2>
                <p class="text-xs text-slate-500">Segala hal yang sering ditanyakan calon siswa seputar seleksi dan proses pelatihan di BLK Jember.</p>
            </div>

            <div class="space-y-3 text-left">
                @foreach ([
                    'Apakah benar pelatihan ini 100% gratis tanpa pungutan biaya?' => 'Ya, seluruh biaya pelatihan ditanggung penuh oleh APBD Provinsi Jawa Timur dan APBN Kemnaker RI, termasuk sertifikasi BNSP.',
                    'Apakah peserta dari luar Kabupaten Jember diperbolehkan mendaftar?' => 'Diperbolehkan, dengan prioritas bagi warga wilayah Tapalkuda sesuai kuota yang tersedia pada tiap gelombang.',
                    'Bagaimana tahapan seleksi masuknya? Apakah ada tes fisik?' => 'Seleksi terdiri dari tes potensi akademik dasar dan wawancara motivasi. Tes fisik hanya berlaku untuk kejuruan tertentu seperti Las dan Otomotif.',
                    'Setelah lulus, apakah BLK Jember membantu penyaluran kerja?' => 'Ya, alumni akan didampingi Bursa Kerja Khusus (BKK) BLK untuk penyaluran ke mitra industri dan lowongan terverifikasi.',
                ] as $q => $a)
                    <details class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs group">
                        <summary class="flex justify-between items-center cursor-pointer text-xs font-bold text-slate-800 list-none">
                            <span>{{ $q }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform group-open:rotate-180"></i>
                        </summary>
                        <p class="text-xs text-slate-500 mt-2.5 pt-2 border-t border-slate-100 leading-relaxed">{{ $a }}</p>
                    </details>
                @endforeach
            </div>

            <div class="bg-emerald-50 border border-emerald-200/80 rounded-2xl p-4 flex items-center justify-between text-left shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-100 text-emerald-800 rounded-xl shrink-0">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-xs">Masih Memiliki Pertanyaan Lain?</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Konsultasikan minat kejuruan Anda bersama konselor vokasi kami setiap hari kerja.</p>
                    </div>
                </div>
                <a href="https://wa.me/#" target="_blank" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl shrink-0 ml-3 transition shadow-sm flex items-center gap-1.5">
                    <i data-lucide="message-circle" class="w-4 h-4"></i> WhatsApp
                </a>
            </div>
        </div>
    </section>

@endsection