@extends('layouts.public')

@section('title', 'Pelatihan - siKarir UPT BLK Jember')

@section('content')

    {{-- TICKER INFO --}}
    <div class="bg-[#D3FFD5] text-xs text-[#00652C] py-2">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between gap-1">
            <p>📢 Penerimaan Siswa Pelatihan Vokasi Gelombang II Tahun Anggaran 2025 Resmi Dibuka</p>
            <p class="flex gap-4">
                <span>&bull; Pendaftaran Online Terbuka</span>
                <span>Hotline: (0331) 487771</span>
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-6">

        {{-- BREADCRUMB --}}
        <p class="text-xs text-[#3F493F] mb-4">
            <a href="{{ url('/') }}" class="hover:text-[#00652C]">🏠 Beranda</a> / <span class="text-[#131B2E] font-medium">Pelatihan</span>
        </p>

        {{-- HERO --}}
        <span class="inline-block bg-[#D3FFD5] text-[#00652C] text-xs font-semibold px-3 py-1 rounded-full mb-4">
            PENDIDIKAN VOKASI TERAKREDITASI KEMNAKER RI & BNSP
        </span>
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div class="md:col-span-2">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Katalog Program Pelatihan Kerja & Vokasi</h1>
                <p class="text-sm text-[#3F493F]">
                    Tingkatkan keahlian kerja nyata Anda tanpa biaya. Seluruh program pelatihan vokasi di UPT Balai Latihan
                    Kerja Jember didanai <span class="text-[#00652C] font-medium">100% Gratis</span> melalui pembiayaan APBD Provinsi Jawa
                    Timur dan APBN Kementerian Ketenagakerjaan RI, lengkap dengan uji kompetensi lisensi BNSP resmi.
                </p>
            </div>
            <div class="bg-[#F2F3FF] rounded-xl p-4 text-sm">
                <div class="flex justify-between mb-2">
                    <p class="font-semibold">Status Alokasi Anggaran</p>
                    <span class="text-xs font-semibold text-[#00652C]">DIPA 2025</span>
                </div>
                <p class="text-xs text-[#3F493F]">
                    Penyelenggaraan pelatihan berbasis Unit Kompetensi SKKNI dengan penjaminan mutu Lembaga Sertifikasi
                    Profesi Pihak Pertama (LSP-P1).
                </p>
            </div>
        </div>

        {{-- STAT STRIP --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            @foreach ([
                ['icon' => '🤖', 'value' => '14', 'label' => 'Kejuruan Aktif'],
                ['icon' => '👥', 'value' => '32', 'label' => 'Paket Berjalan'],
                ['icon' => '💰', 'value' => '100%', 'label' => 'Gratis Bebas Biaya'],
                ['icon' => '🏅', 'value' => 'BNSP', 'label' => 'Sertifikasi Resmi'],
            ] as $stat)
                <div class="bg-[#F5F7FA] rounded-xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#00652C] text-white flex items-center justify-center">{{ $stat['icon'] }}</div>
                    <div>
                        <p class="font-bold text-lg leading-none">{{ $stat['value'] }}</p>
                        <p class="text-[11px] text-[#3F493F]">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- FILTER --}}
        <div class="bg-[#F5F7FA] rounded-xl p-4 mb-4">
            <form method="GET" class="grid md:grid-cols-4 gap-3 mb-4">
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Ketik kejuruan, keterampilan (cth: Sepeda Motor, Web, Las, Barista, Menjahit)..."
                       class="px-3 py-2 border rounded-lg text-sm md:col-span-2">
                <select name="tipe" class="px-3 py-2 border rounded-lg text-sm">
                    <option value="">Semua Tipe Pelatihan</option>
                    <option value="PBK Reguler" @selected(request('tipe') === 'PBK Reguler')>PBK Reguler</option>
                    <option value="MTU Masuk Desa" @selected(request('tipe') === 'MTU Masuk Desa')>MTU Masuk Desa</option>
                </select>
                <div class="flex gap-2">
                    <select name="status" class="px-3 py-2 border rounded-lg text-sm w-full">
                        <option value="">Semua Status</option>
                        <option value="buka">Pendaftaran Buka</option>
                        <option value="tutup">Ditutup</option>
                    </select>
                    <button type="submit" class="border rounded-lg px-3 text-sm shrink-0" title="Cari">🔍</button>
                    <a href="{{ route('pelatihan.katalog') }}" class="border rounded-lg px-3 py-2 text-xs shrink-0">↺ Reset</a>
                </div>
            </form>

            <p class="text-[10px] font-semibold text-[#3F493F] mb-2">KATEGORI KEJURUAN:</p>
            <div class="flex flex-wrap gap-2">
                @php $kategoriAktif = request('kategori', 'Semua Bidang'); @endphp
                @foreach (['Semua Bidang', 'Teknik Otomotif', 'Teknik Komputer & IT', 'Garmen Apparel (Menjahit)', 'Teknik Las & Fabrikasi', 'Refrigerasi & AC', 'Tata Boga & Barista', 'Bisnis & Kewirausahaan'] as $kategori)
                    <a href="{{ route('pelatihan.katalog', ['kategori' => $kategori]) }}"
                       class="text-xs px-3 py-1.5 rounded-full {{ $kategoriAktif === $kategori ? 'bg-[#00652C] text-white' : 'bg-white border text-[#3F493F]' }}">
                        {{ $kategori }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between items-center mb-4 text-sm text-[#3F493F]">
            <p>Menampilkan {{ ($pelatihan ?? collect())->count() ?: 6 }} program pelatihan vokasi siap daftar</p>
            <p class="text-[#00652C] font-medium">&bull; Terverifikasi DIPA Jatim 2025</p>
        </div>

        {{-- GRID PELATIHAN --}}
        <div class="grid md:grid-cols-3 gap-6 mb-16">
            @forelse ($pelatihan ?? [] as $item)
                <div class="border rounded-xl overflow-hidden bg-white">
                    <div class="relative">
                        <img src="{{ $item->gambar_url ?? asset('images/placeholder.jpg') }}" class="w-full h-40 object-cover" alt="{{ $item->nama }}">
                        <span class="absolute top-2 left-2 bg-white/90 text-[#00652C] text-[10px] font-semibold px-2 py-1 rounded">{{ $item->sumber_dana ?? '100% Gratis APBD' }}</span>
                        <span class="absolute top-2 right-2 bg-[#131B2E] text-white text-[10px] px-2 py-1 rounded">{{ $item->tipe ?? 'PBK Reguler' }}</span>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between text-[10px] text-[#3F493F] mb-2">
                            <span>🔧 {{ $item->kategori ?? '-' }}</span>
                            <span>🗓 s/d {{ $item->batas_seleksi ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-1">
                            <p class="font-semibold">{{ $item->nama }}</p>
                            <span class="text-[10px] text-[#3F493F] shrink-0 ml-2">⏱ {{ $item->jam_pelajaran ?? '-' }} JP</span>
                        </div>
                        <p class="text-xs text-[#3F493F] mb-3 line-clamp-2">{{ $item->deskripsi }}</p>

                        <div class="flex justify-between text-[10px] mb-1">
                            <span>Kuota Kelas: {{ $item->kuota ?? 16 }} Siswa</span>
                            <span class="{{ ($item->sisa_kursi ?? 5) <= 2 ? 'text-[#BA1A1A] font-semibold' : 'text-[#3F493F]' }}">
                                Sisa {{ $item->sisa_kursi ?? '-' }} Kursi {{ ($item->sisa_kursi ?? 5) <= 2 ? '(Kritis)' : '' }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-3">
                            <div class="h-1.5 rounded-full {{ ($item->sisa_kursi ?? 5) <= 2 ? 'bg-[#BA1A1A]' : 'bg-[#00652C]' }}"
                                 style="width: {{ $item->persentase_terisi ?? 70 }}%"></div>
                        </div>

                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach ($item->fasilitas ?? ['Sertifikat BNSP', 'Uang Saku'] as $fasilitas)
                                <span class="text-[10px] bg-[#F2F3FF] text-[#3F493F] px-2 py-0.5 rounded">{{ $fasilitas }}</span>
                            @endforeach
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('pelatihan.katalog') . '#' . $item->id }}" class="flex-1 text-center text-xs border rounded-lg px-3 py-2">Lihat Silabus</a>
                            <a href="{{ route('register') }}" class="flex-1 text-center text-xs bg-[#00652C] text-white rounded-lg px-3 py-2">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#3F493F] col-span-3">Belum ada data pelatihan yang tersedia.</p>
            @endforelse
        </div>
    </div>

    {{-- HAK & FASILITAS --}}
    <section class="bg-[#F5F7FA]">
        <div class="max-w-7xl mx-auto px-6 py-14 text-center">
            <p class="text-xs font-semibold text-[#00652C] mb-1">HAK & FASILITAS PESERTA</p>
            <h2 class="text-2xl font-bold mb-2">Apa Saja yang Didapatkan Siswa Pelatihan?</h2>
            <p class="text-sm text-[#3F493F] mb-8">Semua fasilitas dijamin oleh negara tanpa pungutan biaya apapun (Gratis).</p>
            <div class="grid md:grid-cols-5 gap-5 text-left">
                @foreach ([
                    ['icon' => '🎓', 'title' => 'Sertifikasi BNSP', 'desc' => 'Uji kompetensi gratis dan sertifikat profesi berstandar nasional resmi BNSP.'],
                    ['icon' => '💵', 'title' => 'Uang Saku Transport', 'desc' => 'Bantuan biaya transportasi harian langsung disalurkan ke rekening bank peserta.'],
                    ['icon' => '🦺', 'title' => 'Pakaian Seragam & APD', 'desc' => 'Wearpack kerja, seragam batik, kemeja pelatihan, dan alat pelindung diri lengkap.'],
                    ['icon' => '📘', 'title' => 'Modul & Bahan Praktik', 'desc' => 'Modul ajar kurikulum SKKNI, toolkit praktik mandiri, dan bahan consumable latihan.'],
                    ['icon' => '🛡', 'title' => 'Asuransi BPJS TK', 'desc' => 'Perlindungan Jaminan Kecelakaan Kerja (JKK) dan Jaminan Kematian (JKM) selama masa diklat.'],
                ] as $f)
                    <div class="bg-white rounded-xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto rounded-lg bg-[#D3FFD5] flex items-center justify-center text-xl mb-3">{{ $f['icon'] }}</div>
                        <p class="font-semibold text-sm mb-1">{{ $f['title'] }}</p>
                        <p class="text-xs text-[#3F493F]">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SYARAT & JADWAL --}}
    <section class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-2 gap-10">
        {{-- Syarat --}}
        <div>
            <p class="text-xs font-semibold text-[#00652C] mb-1">PEDOMAN PENDAFTARAN</p>
            <h2 class="text-xl font-bold mb-1">Syarat Calon Peserta & Kelengkapan Berkas</h2>
            <p class="text-xs text-[#3F493F] mb-4">Pendaftaran dapat dilakukan secara daring melalui portal siKarir atau datang langsung ke Kios Siap Kerja UPT BLK Jember.</p>

            <div class="grid md:grid-cols-2 gap-4 mb-6 text-sm">
                @foreach ([
                    ['title' => 'Warga Negara Indonesia', 'desc' => 'Memiliki e-KTP / Kartu Keluarga wilayah Jawa Timur (diutamakan tapalkuda).'],
                    ['title' => 'Usia Minimal 17 Tahun', 'desc' => 'Pria/Wanita pencari kerja, fresh graduate, atau korban PHK tanpa batas usia produktif.'],
                    ['title' => 'Pendidikan Min. SMP/SMA/SMK', 'desc' => 'Salinan ijazah terakhir legalisir atau Surat Keterangan Lulus (SKL) resmi.'],
                    ['title' => 'Surat Keterangan Sehat', 'desc' => 'Dari Puskesmas/Rumah Sakit pemerintah dan tidak buta warna (khusus Otomotif, IT, Las).'],
                    ['title' => 'Pas Foto Formal (Latar Merah)', 'desc' => 'File digital ukuran 3x4 (3 lembar fisik jika daftar langsung di kantor BLK).'],
                    ['title' => 'Komitmen & Tidak Bekerja', 'desc' => 'Sanggup mengikuti seluruh jam diklat hingga tuntas ujian sertifikasi kompetensi BNSP.'],
                ] as $syarat)
                    <div class="flex gap-2">
                        <span class="text-[#00652C] mt-0.5">✔</span>
                        <div>
                            <p class="font-medium">{{ $syarat['title'] }}</p>
                            <p class="text-xs text-[#3F493F]">{{ $syarat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-xs font-semibold text-[#00652C] mb-3">↗ 4 LANGKAH MUDAH PENDAFTARAN</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ([
                    ['no' => '1', 'title' => 'Pilih Kejuruan', 'desc' => 'Tentukan program pelatihan sesuai minat keahlian Anda.'],
                    ['no' => '2', 'title' => 'Isi Formulir', 'desc' => 'Lengkapi data NIK KTP, profil diri, serta unggah berkas.'],
                    ['no' => '3', 'title' => 'Tes Seleksi', 'desc' => 'Ikuti tes potensi akademik dasar dan wawancara motivasi kerja.'],
                    ['no' => '4', 'title' => 'Mulai Pelatihan', 'desc' => 'Pengumuman kelulusan, pembagian seragam, dan masuk kelas diklat.'],
                ] as $step)
                    <div>
                        <div class="w-7 h-7 rounded-full bg-[#00652C] text-white flex items-center justify-center text-xs font-bold mb-2">{{ $step['no'] }}</div>
                        <p class="font-semibold text-xs mb-1">{{ $step['title'] }}</p>
                        <p class="text-[10px] text-[#3F493F]">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Jadwal --}}
        <div>
            <p class="text-xs font-semibold text-[#00652C] mb-1">KALENDER DIKLAT TA 2025</p>
            <h2 class="text-xl font-bold mb-1">Jadwal Gelombang Pelatihan</h2>
            <p class="text-xs text-[#3F493F] mb-4">Penyelenggaraan pelatihan terbagi dalam 4 gelombang utama sepanjang tahun 2025.</p>

            <div class="space-y-3 mb-4">
                @foreach ([
                    ['nama' => 'Gelombang I (PBK)', 'status' => 'Tutup', 'warna' => 'bg-gray-200 text-gray-600', 'detail' => 'Pelaksanaan: Jan - Feb 2025', 'icon' => '✔'],
                    ['nama' => 'Gelombang II (Aktif Sekarang)', 'status' => 'Buka', 'warna' => 'bg-[#D3FFD5] text-[#00652C]', 'detail' => null, 'icon' => '🆕'],
                    ['nama' => 'Gelombang III (APBD & APBN)', 'status' => 'Mendatang', 'warna' => 'bg-[#F2F3FF] text-[#3F493F]', 'detail' => 'Pendaftaran dibuka: 01 Juni 2025', 'icon' => '📅'],
                    ['nama' => 'Gelombang IV (Reguler Akhir Tahun)', 'status' => 'Mendatang', 'warna' => 'bg-[#F2F3FF] text-[#3F493F]', 'detail' => 'Pendaftaran dibuka: 01 September 2025', 'icon' => '📅'],
                ] as $g)
                    <div class="border rounded-xl p-4">
                        <div class="flex justify-between items-start mb-1">
                            <p class="font-semibold text-sm">{{ $g['nama'] }}</p>
                            <span class="text-[10px] px-2 py-1 rounded-full {{ $g['warna'] }}">{{ $g['status'] }}</span>
                        </div>
                        @if ($g['status'] === 'Buka')
                            <div class="text-xs text-[#3F493F] space-y-0.5">
                                <p class="flex justify-between"><span>Pendaftaran Online:</span> <span class="font-medium text-[#131B2E]">01 Mar - 28 Mar 2025</span></p>
                                <p class="flex justify-between"><span>Tes Tertulis & Wawancara:</span> <span class="font-medium text-[#131B2E]">31 Mar - 02 Apr 2025</span></p>
                                <p class="flex justify-between"><span>Pengumuman Kelulusan:</span> <span class="font-medium text-[#131B2E]">04 April 2025</span></p>
                                <p class="flex justify-between"><span>Pembukaan & Masuk Asrama/Kelas:</span> <span class="font-medium text-[#131B2E]">14 April 2025</span></p>
                            </div>
                        @else
                            <p class="text-xs text-[#3F493F]">{{ $g['detail'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="bg-[#00652C] text-white rounded-xl p-4 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-sm mb-0.5">Unduh Buku Panduan & Silabus</p>
                    <p class="text-xs text-[#D3FFD5]">Katalog kurikulum lengkap seluruh 14 kejuruan PDF.</p>
                </div>
                <a href="#" class="bg-white text-[#00652C] text-xs font-medium px-3 py-2 rounded-lg shrink-0 ml-3">⬇ PDF (8.4 MB)</a>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="bg-[#F5F7FA]">
        <div class="max-w-3xl mx-auto px-6 py-14 text-center">
            <p class="text-xs font-semibold text-[#00652C] mb-1">PUSAT BANTUAN & INFORMASI</p>
            <h2 class="text-2xl font-bold mb-2">Pertanyaan Umum (FAQ)</h2>
            <p class="text-sm text-[#3F493F] mb-8">Segala hal yang sering ditanyakan calon siswa seputar seleksi dan proses pelatihan di BLK Jember.</p>

            <div class="space-y-3 text-left">
                @foreach ([
                    'Apakah benar pelatihan ini 100% gratis tanpa pungutan biaya?' => 'Ya, seluruh biaya pelatihan ditanggung penuh oleh APBD Provinsi Jawa Timur dan APBN Kemnaker RI, termasuk sertifikasi BNSP.',
                    'Apakah peserta dari luar Kabupaten Jember diperbolehkan mendaftar?' => 'Diperbolehkan, dengan prioritas bagi warga wilayah tapalkuda sesuai kuota yang tersedia pada tiap gelombang.',
                    'Bagaimana tahapan seleksi masuknya? Apakah ada tes fisik?' => 'Seleksi terdiri dari tes potensi akademik dasar dan wawancara motivasi. Tes fisik hanya berlaku untuk kejuruan tertentu seperti Las dan Otomotif.',
                    'Setelah lulus, apakah BLK Jember membantu penyaluran kerja?' => 'Ya, alumni akan didampingi Bursa Kerja Khusus (BKK) BLK untuk penyaluran ke mitra industri dan lowongan terverifikasi.',
                ] as $q => $a)
                    <details class="bg-white rounded-xl p-4 group">
                        <summary class="flex justify-between items-center cursor-pointer text-sm font-medium list-none">
                            {{ $q }}
                            <span class="transition-transform group-open:rotate-180">⌄</span>
                        </summary>
                        <p class="text-xs text-[#3F493F] mt-2">{{ $a }}</p>
                    </details>
                @endforeach
            </div>

            <div class="bg-[#D3FFD5] rounded-xl p-4 mt-6 flex items-center justify-between text-left">
                <div class="flex items-center gap-3">
                    <span class="text-xl">💬</span>
                    <div>
                        <p class="font-semibold text-sm">Masih Memiliki Pertanyaan Lain?</p>
                        <p class="text-xs text-[#3F493F]">Konsultasikan minat kejuruan Anda bersama konselor vokasi kami setiap hari kerja.</p>
                    </div>
                </div>
                <a href="#" class="bg-[#00652C] text-white text-xs font-medium px-3 py-2 rounded-lg shrink-0 ml-3">💬 Chat WhatsApp</a>
            </div>
        </div>
    </section>

@endsection
