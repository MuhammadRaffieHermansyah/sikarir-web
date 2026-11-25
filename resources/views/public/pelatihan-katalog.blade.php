@extends('layouts.public')

@section('title', 'Katalog Pelatihan Vokasi - siKarir UPT BLK Jember')

@section('content')
  {{-- HERO --}}
  <section class="relative isolate overflow-hidden bg-primary text-primary-foreground">
    <img
      src="{{ asset('images/hero-image.webp') }}"
      alt=""
      class="absolute inset-0 size-full object-cover object-center opacity-30"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-[#04281f]/95 via-[#04281f]/88 to-[#04281f]/30"></div>
    <div class="pointer-events-none absolute -bottom-24 right-[6%] size-32 rounded-full border border-sikarir-lime/40"></div>

    <div class="site-container relative py-16 md:py-20">
      <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
        <x-lucide-shield-check class="text-sikarir-lime" />
        Pendidikan vokasi terakreditasi Kemnaker RI &amp; BNSP
      </x-ui.badge>

      <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-end">
        <div>
          <h1 class="max-w-3xl text-4xl font-black leading-[0.95] tracking-[-0.06em] text-white sm:text-5xl lg:text-6xl">
            Katalog program.<br>
            <span class="text-sikarir-lime">Pelatihan kerja &amp; vokasi.</span>
          </h1>

          <p class="mt-5 max-w-2xl text-sm leading-relaxed text-primary-foreground/80 sm:text-base">
            Tingkatkan keahlian kerja nyata Anda tanpa biaya. Seluruh program pelatihan vokasi di UPT Balai Latihan Kerja Jember didanai
            <span class="font-bold text-sikarir-lime">100% Gratis</span> melalui pembiayaan APBD Provinsi Jawa Timur dan APBN Kemnaker RI.
          </p>
        </div>

        <x-ui.card class="hidden border-primary-foreground/15 bg-primary-foreground/10 p-5 text-primary-foreground backdrop-blur-md lg:block">
          <div class="flex items-center justify-between gap-3 border-b border-primary-foreground/15 pb-3">
            <span class="flex items-center gap-2 text-sm font-bold text-white">
              <x-lucide-wallet class="text-sikarir-lime" />
              Alokasi anggaran
            </span>
            <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 text-sikarir-lime">DIPA 2026</x-ui.badge>
          </div>

          <p class="mt-3 text-xs leading-relaxed text-primary-foreground/75">
            Penyelenggaraan pelatihan berbasis Unit Kompetensi SKKNI dengan penjaminan mutu Lembaga Sertifikasi Profesi Pihak Pertama (LSP-P1).
          </p>
        </x-ui.card>
      </div>
    </div>
  </section>

  {{-- STAT STRIP --}}
  <section class="site-container relative z-10 -mt-8 mb-8"  >
    <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
      @foreach ([
          ['icon' => 'cpu', 'value' => (string) \App\Models\DaftarPelatihan::count(), 'label' => 'Kejuruan aktif'],
          ['icon' => 'users', 'value' => (string) \App\Models\JadwalPelatihan::where('status', 'berlangsung')->count(), 'label' => 'Batch berjalan'],
          ['icon' => 'circle-dollar-sign', 'value' => '100%', 'label' => 'Gratis bebas biaya'],
          ['icon' => 'award', 'value' => 'BNSP', 'label' => 'Sertifikasi resmi'],
      ] as $stat)
        <x-ui.stat
          :icon="$stat['icon']"
          :value="$stat['value']"
          :label="$stat['label']"
          class="gap-2.5 p-4 shadow-sm"
        />
      @endforeach
    </div>
  </section>

  <div class="site-container space-y-8 pb-14">
    {{-- SEARCH & FILTER --}}
    <x-ui.card>
      <form method="GET" action="{{ route('pelatihan.katalog') }}" class="grid gap-3 md:grid-cols-12">
        <div class="md:col-span-6">
          <x-ui.field>
            <x-ui.field-label for="katalog-q" class="sr-only">Cari pelatihan</x-ui.field-label>
            <x-ui.input
              id="katalog-q"
              name="q"
              type="search"
              :value="request('q')"
              placeholder="Ketik kejuruan, keterampilan (cth: Sepeda Motor, Web, Las, Barista)..."
            >
              <x-slot:leading>
                <x-lucide-search />
              </x-slot:leading>
            </x-ui.input>
          </x-ui.field>
        </div>

        <div class="md:col-span-3">
          <x-ui.field>
            <x-ui.field-label for="katalog-tipe" class="sr-only">Tipe pelatihan</x-ui.field-label>
            <x-ui.select name="tipe" id="katalog-tipe" native class="w-full">
              <option value="">Semua Tipe Pelatihan</option>
              <option value="PBK Reguler" @selected(request('tipe') === 'PBK Reguler')>PBK Reguler</option>
              <option value="MTU Masuk Desa" @selected(request('tipe') === 'MTU Masuk Desa')>MTU Masuk Desa</option>
            </x-ui.select>
          </x-ui.field>
        </div>

        <div class="flex gap-2 md:col-span-3">
          <div class="min-w-0 flex-1">
            <x-ui.field>
              <x-ui.field-label for="katalog-status" class="sr-only">Status pendaftaran</x-ui.field-label>
              <x-ui.select name="status" id="katalog-status" native class="w-full">
                <option value="">Semua Status</option>
                <option value="buka" @selected(request('status') === 'buka')>Pendaftaran Buka</option>
                <option value="tutup" @selected(request('status') === 'tutup')>Ditutup</option>
              </x-ui.select>
            </x-ui.field>
          </div>

          <x-ui.button type="submit" size="icon" aria-label="Cari pelatihan" title="Cari">
            <x-lucide-search />
          </x-ui.button>

          <x-ui.button href="{{ route('pelatihan.katalog') }}" variant="outline" aria-label="Reset filter" title="Reset filter">
            <x-lucide-rotate-ccw />
          </x-ui.button>
        </div>
      </form>

      <div class="mt-4 space-y-2 border-t border-border pt-4">
        <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-muted-foreground">Kategori kejuruan:</p>
        <div class="flex flex-wrap gap-2">
          @php $kategoriAktif = request('kategori', 'Semua Bidang'); @endphp
          @foreach (['Semua Bidang', 'Teknik Otomotif', 'Teknik Komputer & IT', 'Garmen Apparel (Menjahit)', 'Teknik Las & Fabrikasi', 'Refrigerasi & AC', 'Tata Boga & Barista', 'Bisnis & Kewirausahaan'] as $kategori)
            <x-ui.badge
              :href="route('pelatihan.katalog', ['kategori' => $kategori])"
              :variant="$kategoriAktif === $kategori ? 'default' : 'outline'"
              size="lg"
              class="rounded-lg"
            >
              {{ $kategori }}
            </x-ui.badge>
          @endforeach
        </div>
      </div>
    </x-ui.card>

    {{-- RESULT COUNTER --}}
    <div class="flex flex-wrap items-center justify-between gap-2 px-1 text-xs font-medium text-muted-foreground">
      <p class="flex items-center gap-1.5 font-bold text-foreground">
        <x-lucide-book-open class="size-4 text-primary" />
        Menampilkan
        {{ is_object($pelatihan) && method_exists($pelatihan, 'total') ? $pelatihan->total() : (($pelatihan ?? collect())->count() ?: 0) }}
        Program Pelatihan Vokasi
      </p>

      <span class="flex items-center gap-1.5 font-bold text-primary">
        <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
        Terverifikasi DIPA 2026
      </span>
    </div>

    {{-- GRID PELATIHAN --}}
    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
      @forelse ($pelatihan as $item)
        @php $jadwal = $item->jadwal_terdekat; @endphp

        <x-ui.card class="flex flex-col justify-between overflow-hidden p-0 transition hover:border-primary/40 hover:shadow-md">
          <div>
            <div class="relative aspect-[16/10] overflow-hidden bg-muted">
              <img
                src="{{ $item->gambar_url ?? asset('images/hero-image.webp') }}"
                alt="{{ $item->nama_pelatihan }}"
                class="size-full object-cover"
                loading="lazy"
              >

              @if ($jadwal)
                <x-ui.badge variant="solid" tone="success" class="absolute left-3 top-3 backdrop-blur-sm">
                  Pendaftaran Buka
                </x-ui.badge>
              @else
                <x-ui.badge variant="solid" tone="neutral" class="absolute left-3 top-3 backdrop-blur-sm">
                  Belum Ada Jadwal
                </x-ui.badge>
              @endif
            </div>

            <div class="space-y-3 p-5">
              <div class="flex items-center justify-between gap-2 text-[10px] font-bold uppercase tracking-wide text-muted-foreground">
                <span class="flex items-center gap-1 text-primary">
                  <x-lucide-users class="size-3.5" />
                  Kuota {{ $item->kuota }} siswa
                </span>
                <span class="flex items-center gap-1">
                  <x-lucide-calendar class="size-3.5" />
                  {{ $jadwal ? 'Mulai ' . $jadwal->tanggal_mulai->translatedFormat('d M Y') : 'Jadwal menyusul' }}
                </span>
              </div>

              <div class="flex items-start justify-between gap-2">
                <h3 class="line-clamp-1 text-base font-bold leading-snug text-foreground">{{ $item->nama_pelatihan }}</h3>

                @if ($item->durasi)
                  <x-ui.badge variant="secondary" class="shrink-0">
                    {{ $item->durasi->jam }} Jam
                  </x-ui.badge>
                @endif
              </div>

              <p class="line-clamp-2 text-xs leading-relaxed text-muted-foreground">
                {{ $item->deskripsi_pelatihan ?: 'Deskripsi program belum ditambahkan.' }}
              </p>

              @if ($item->durasi)
                <p class="flex items-center gap-1 text-[11px] font-semibold text-muted-foreground">
                  <x-lucide-timer class="size-3.5 text-primary" />
                  Durasi {{ $item->durasi->durasi_label }}
                </p>
              @endif
            </div>
          </div>

          <div class="flex gap-2 px-5 pb-5">
            <x-ui.button
              href="{{ route('register') }}"
              class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]"
            >
              Daftar
              <x-lucide-arrow-right />
            </x-ui.button>
          </div>
        </x-ui.card>
      @empty
        <x-ui.empty class="col-span-full bg-card">
          <x-ui.empty-header>
            <x-ui.empty-media variant="icon">
              <x-lucide-book-open />
            </x-ui.empty-media>
            <x-ui.empty-title>Belum ada data pelatihan</x-ui.empty-title>
            <x-ui.empty-description>
              Belum ada program pelatihan yang tersedia saat ini. Coba ubah kata kunci atau reset filter pencarian.
            </x-ui.empty-description>
          </x-ui.empty-header>

          <x-ui.button href="{{ route('pelatihan.katalog') }}" variant="outline" size="sm">
            <x-lucide-rotate-ccw />
            Reset Filter Pencarian
          </x-ui.button>
        </x-ui.empty>
      @endforelse
    </div>

    {{-- PAGINATION --}}
    @if (is_object($pelatihan) && method_exists($pelatihan, 'links'))
      <div>
        {{ $pelatihan->links('components.pagination') }}
      </div>
    @else
      {{-- Fallback pagination untuk data array/collection biasa --}}
      <div class="flex items-center justify-between rounded-xl border border-border bg-card px-6 py-4 text-xs font-medium text-muted-foreground">
        <span>Menampilkan 1 sampai 6 dari 18 data</span>

        <div class="flex gap-1">
          <x-ui.button variant="outline" size="icon-sm" disabled aria-label="Halaman sebelumnya">
            <x-lucide-chevron-left />
          </x-ui.button>
          <x-ui.button size="icon-sm" aria-label="Halaman 1">1</x-ui.button>
          <x-ui.button variant="outline" size="icon-sm" aria-label="Halaman 2">2</x-ui.button>
          <x-ui.button variant="outline" size="icon-sm" aria-label="Halaman 3">3</x-ui.button>
          <x-ui.button variant="outline" size="icon-sm" aria-label="Halaman berikutnya">
            <x-lucide-chevron-right />
          </x-ui.button>
        </div>
      </div>
    @endif
  </div>

  {{-- HAK & FASILITAS PESERTA --}}
  <section class="border-y border-border bg-muted/40 py-14">
    <div class="site-container text-center">
      <x-ui.badge variant="secondary" class="uppercase tracking-wide">Hak &amp; Fasilitas Peserta</x-ui.badge>

      <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground md:text-3xl">
        Apa saja yang didapatkan siswa pelatihan?
      </h2>
      <p class="mx-auto mt-2 max-w-lg text-sm text-muted-foreground">
        Semua fasilitas dijamin oleh negara tanpa pungutan biaya apapun (100% Gratis).
      </p>

      <div class="mt-10 grid gap-4 text-left md:grid-cols-3 lg:grid-cols-5">
        @foreach ([
            ['icon' => 'award', 'title' => 'Sertifikasi BNSP', 'desc' => 'Uji kompetensi gratis dan sertifikat profesi berstandar nasional resmi BNSP.'],
            ['icon' => 'wallet', 'title' => 'Uang Saku Transport', 'desc' => 'Bantuan biaya transportasi harian langsung disalurkan ke rekening bank peserta.'],
            ['icon' => 'shirt', 'title' => 'Pakaian Seragam & APD', 'desc' => 'Wearpack kerja, seragam batik, kemeja pelatihan, dan alat pelindung diri lengkap.'],
            ['icon' => 'book-marked', 'title' => 'Modul & Bahan Praktik', 'desc' => 'Modul ajar kurikulum SKKNI, toolkit praktik mandiri, dan bahan consumable latihan.'],
            ['icon' => 'shield-check', 'title' => 'Asuransi BPJS TK', 'desc' => 'Perlindungan Jaminan Kecelakaan Kerja (JKK) dan Jaminan Kematian (JKM) selama diklat.'],
        ] as $f)
          <x-ui.card class="transition hover:border-primary/40">
            <span class="grid size-10 place-items-center rounded-xl bg-accent text-accent-foreground">
              <x-dynamic-component :component="'lucide-'.$f['icon']" class="size-5" />
            </span>

            <h3 class="mt-3 text-sm font-bold text-foreground">{{ $f['title'] }}</h3>
            <p class="mt-1.5 text-xs leading-relaxed text-muted-foreground">{{ $f['desc'] }}</p>
          </x-ui.card>
        @endforeach
      </div>
    </div>
  </section>

  {{-- SYARAT & JADWAL --}}
  <section class="site-container grid gap-10 py-14 md:grid-cols-2">
    {{-- Syarat --}}
    <div class="space-y-6">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Pedoman Pendaftaran</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">
          Syarat calon peserta &amp; kelengkapan berkas
        </h2>
        <p class="mt-1.5 text-sm text-muted-foreground">
          Pendaftaran dapat dilakukan daring via portal siKarir atau datang langsung ke Kios Siap Kerja UPT BLK Jember.
        </p>
      </div>

      <div class="grid gap-3 text-xs md:grid-cols-2">
        @foreach ([
            ['title' => 'Warga Negara Indonesia', 'desc' => 'Memiliki e-KTP / Kartu Keluarga wilayah Jawa Timur (diutamakan Tapalkuda).'],
            ['title' => 'Usia Minimal 17 Tahun', 'desc' => 'Pria/Wanita pencari kerja, fresh graduate, atau korban PHK tanpa batas usia produktif.'],
            ['title' => 'Pendidikan Min. SMP/SMA/SMK', 'desc' => 'Salinan ijazah terakhir legalisir atau Surat Keterangan Lulus (SKL) resmi.'],
            ['title' => 'Surat Keterangan Sehat', 'desc' => 'Dari Puskesmas/Rumah Sakit pemerintah dan tidak buta warna (khusus Otomotif, IT, Las).'],
            ['title' => 'Pas Foto Formal (Latar Merah)', 'desc' => 'File digital ukuran 3x4 (3 lembar fisik jika daftar langsung di kantor BLK).'],
            ['title' => 'Komitmen & Tidak Bekerja', 'desc' => 'Sanggup mengikuti seluruh jam diklat hingga tuntas ujian sertifikasi kompetensi BNSP.'],
        ] as $syarat)
          <div class="flex gap-2.5 rounded-xl border border-border bg-card p-3 shadow-xs">
            <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
            <div>
              <h4 class="text-xs font-bold text-foreground">{{ $syarat['title'] }}</h4>
              <p class="mt-0.5 text-[11px] leading-relaxed text-muted-foreground">{{ $syarat['desc'] }}</p>
            </div>
          </div>
        @endforeach
      </div>

      <div class="pt-2">
        <h3 class="mb-3 flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide text-primary">
          <x-lucide-circle-arrow-right class="size-4" />
          4 Langkah Mudah Pendaftaran
        </h3>

        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
          @foreach ([
              ['no' => '1', 'title' => 'Pilih Kejuruan', 'desc' => 'Tentukan program pelatihan sesuai minat Anda.'],
              ['no' => '2', 'title' => 'Isi Formulir', 'desc' => 'Lengkapi NIK KTP & unggah berkas.'],
              ['no' => '3', 'title' => 'Tes Seleksi', 'desc' => 'Tes potensi akademik & wawancara.'],
              ['no' => '4', 'title' => 'Mulai Diklat', 'desc' => 'Kelulusan, pembagian seragam, & kelas.'],
          ] as $step)
            <div class="space-y-1 rounded-xl border border-border bg-muted/40 p-3">
              <div class="grid size-6 place-items-center rounded-full bg-primary text-[11px] font-black text-primary-foreground">
                {{ $step['no'] }}
              </div>
              <h4 class="text-xs font-bold text-foreground">{{ $step['title'] }}</h4>
              <p class="text-[10px] leading-relaxed text-muted-foreground">{{ $step['desc'] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Jadwal Gelombang --}}
    <div class="space-y-6">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Kalender Diklat TA 2026</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">Jadwal gelombang pelatihan</h2>
        <p class="mt-1.5 text-sm text-muted-foreground">
          Penyelenggaraan pelatihan terbagi dalam 4 gelombang utama sepanjang tahun 2026.
        </p>
      </div>

      <div class="space-y-3">
        @foreach ([
            ['nama' => 'Gelombang I (PBK)', 'status' => 'Tutup', 'detail' => 'Pelaksanaan: Jan - Feb 2026', 'icon' => 'circle-check-big'],
            ['nama' => 'Gelombang II (Aktif Sekarang)', 'status' => 'Buka', 'detail' => null, 'icon' => 'sparkles'],
            ['nama' => 'Gelombang III (APBD & APBN)', 'status' => 'Mendatang', 'detail' => 'Pendaftaran dibuka: 01 Juni 2026', 'icon' => 'calendar'],
            ['nama' => 'Gelombang IV (Reguler Akhir Tahun)', 'status' => 'Mendatang', 'detail' => 'Pendaftaran dibuka: 01 September 2026', 'icon' => 'calendar'],
        ] as $g)
          <x-ui.card class="p-4">
            <div class="flex items-center justify-between gap-3">
              <h3 class="flex items-center gap-1.5 text-sm font-bold text-foreground">
                <x-dynamic-component :component="'lucide-'.$g['icon']" class="size-4 text-primary" />
                {{ $g['nama'] }}
              </h3>

              @if ($g['status'] === 'Buka')
                <x-ui.badge variant="solid" tone="success">{{ $g['status'] }}</x-ui.badge>
              @elseif ($g['status'] === 'Tutup')
                <x-ui.badge variant="soft" tone="neutral">{{ $g['status'] }}</x-ui.badge>
              @else
                <x-ui.badge variant="outline" tone="info">{{ $g['status'] }}</x-ui.badge>
              @endif
            </div>

            @if ($g['status'] === 'Buka')
              <div class="mt-3 space-y-1 rounded-xl border border-border bg-muted/40 p-3 text-xs font-medium text-muted-foreground">
                <p class="flex justify-between gap-3"><span>Pendaftaran Online:</span> <span class="font-bold text-foreground">01 Mar - 28 Mar 2026</span></p>
                <p class="flex justify-between gap-3"><span>Tes Tertulis &amp; Wawancara:</span> <span class="font-bold text-foreground">31 Mar - 02 Apr 2026</span></p>
                <p class="flex justify-between gap-3"><span>Pengumuman Kelulusan:</span> <span class="font-bold text-foreground">04 April 2026</span></p>
                <p class="flex justify-between gap-3"><span>Pembukaan &amp; Masuk Kelas:</span> <span class="font-bold text-foreground">14 April 2026</span></p>
              </div>
            @else
              <p class="mt-1.5 text-xs font-medium text-muted-foreground">{{ $g['detail'] }}</p>
            @endif
          </x-ui.card>
        @endforeach
      </div>

    </div>
  </section>

  {{-- FAQ --}}
  <section class="border-t border-border bg-muted/40 py-14">
    <div class="site-container max-w-3xl space-y-8 text-center">
      <div>
        <x-ui.badge variant="secondary" class="uppercase tracking-wide">Pusat Bantuan &amp; Informasi</x-ui.badge>

        <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground md:text-3xl">Pertanyaan umum (FAQ)</h2>
        <p class="mt-2 text-sm text-muted-foreground">
          Segala hal yang sering ditanyakan calon siswa seputar seleksi dan proses pelatihan di BLK Jember.
        </p>
      </div>

      <div class="space-y-3 text-left">
        @foreach ([
            'Apakah benar pelatihan ini 100% gratis tanpa pungutan biaya?' => 'Ya, seluruh biaya pelatihan ditanggung penuh oleh APBD Provinsi Jawa Timur dan APBN Kemnaker RI, termasuk sertifikasi BNSP.',
            'Apakah peserta dari luar Kabupaten Jember diperbolehkan mendaftar?' => 'Diperbolehkan, dengan prioritas bagi warga wilayah Tapalkuda sesuai kuota yang tersedia pada tiap gelombang.',
            'Bagaimana tahapan seleksi masuknya? Apakah ada tes fisik?' => 'Seleksi terdiri dari tes potensi akademik dasar dan wawancara motivasi. Tes fisik hanya berlaku untuk kejuruan tertentu seperti Las dan Otomotif.',
            'Setelah lulus, apakah BLK Jember membantu penyaluran kerja?' => 'Ya, alumni akan didampingi Bursa Kerja Khusus (BKK) BLK untuk penyaluran ke mitra industri dan lowongan terverifikasi.',
        ] as $q => $a)
          <details class="group rounded-xl border border-border bg-card p-4 shadow-xs">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-xs font-bold text-foreground">
              <span>{{ $q }}</span>
              <x-lucide-chevron-down class="size-4 shrink-0 text-muted-foreground transition-transform group-open:rotate-180" />
            </summary>

            <p class="mt-2.5 border-t border-border pt-2.5 text-xs leading-relaxed text-muted-foreground">
              {{ $a }}
            </p>
          </details>
        @endforeach
      </div>

      <x-ui.card class="flex flex-col gap-4 border-primary/30 bg-accent text-left sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
          <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary text-primary-foreground">
            <x-lucide-message-square class="size-5" />
          </span>

          <div>
            <h4 class="text-xs font-bold text-foreground">Masih memiliki pertanyaan lain?</h4>
            <p class="mt-0.5 text-[11px] text-muted-foreground">
              Konsultasikan minat kejuruan Anda bersama konselor vokasi kami setiap hari kerja.
            </p>
          </div>
        </div>

        <x-ui.button
          href="https://wa.me/{{ config('blk.wa') }}"
          target="_blank"
          rel="noopener"
          class="shrink-0 bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]"
        >
          <x-lucide-message-circle />
          WhatsApp
        </x-ui.button>
      </x-ui.card>
    </div>
  </section>
@endsection
