@extends('layouts.public')

@section('title', 'Tentang BLK - siKarir UPT BLK Jember')

@php
  $wa = 'https://wa.me/' . config('blk.wa');    
  $waBtn = 'bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]';
  $glass = 'border-primary-foreground/25 bg-primary-foreground/10';

  $stats = [
    ['1980', 'Tahun Berdiri'], ['BNSP', 'Uji Kompetensi'],
    ['MTU', 'Pelatihan Keliling Desa'], ['Jatim', 'Di Bawah Disnakertrans'],
  ];

  $pilar = [
    ['building', 'Lembaga Pelatihan Pemerintah', 'UPT BLK Jember berada di bawah Disnakertrans Provinsi Jawa Timur dan menyelenggarakan pelatihan kerja bagi masyarakat.', 'Di bawah Disnakertrans Provinsi Jatim'],
    ['circle-dollar-sign', 'Informasi Biaya & Pendaftaran', 'Biaya, persyaratan, kuota, dan jadwal setiap angkatan pelatihan mengikuti pengumuman resmi UPT BLK Jember.', 'Hubungi PTSP untuk info terbaru'],
    ['link-2', 'Pelatihan Berbasis Kompetensi', 'Pelatihan menekankan keterampilan praktis dan penilaian kompetensi, agar lulusan siap bekerja sesuai bidangnya atau membuka usaha mandiri.', 'Penilaian oleh BLK dan BNSP'],
    ['users', 'Terbuka bagi Penyandang Disabilitas', 'BLK Jember pernah menyelenggarakan pelatihan menjahit dengan mesin yang khusus diikuti peserta penyandang disabilitas.', 'Program menjahit inklusif'],
  ];

  $misi = [
    ['Tenaga Kerja Kompeten', 'Melaksanakan pelatihan untuk mencetak tenaga kerja yang kompeten.'],
    ['Disiplin & Produktif', 'Pelatihan berbasis kompetensi dan uji keterampilan sesuai standar.'],
    ['Kapasitas Pelatihan', 'Meningkatkan kapasitas sumber daya pelatihan sesuai perkembangan teknologi.'],
    ['Informasi yang Akurat', 'Menyediakan sistem informasi pelatihan kerja yang akurat.'],
    ['Produksi & Konsultasi', 'Mengembangkan jasa produksi dan layanan konsultasi pelatihan.'],
  ];

  $workshops = [
    ['https://images.unsplash.com/photo-1727893141025-35d62b3f4a03?q=80&w=800&auto=format&fit=crop', 'OTOMOTIF', 'Workshop Otomotif', 'Praktik perawatan dan perbaikan kendaraan bagi peserta pelatihan otomotif.'],
    ['https://images.unsplash.com/photo-1673201229733-69d19c5c4a87?q=80&w=800&auto=format&fit=crop', 'MENJAHIT & BORDIR', 'Workshop Menjahit & Bordir', 'Praktik menjahit dengan mesin dan pelatihan operator bordir untuk bekerja atau berwirausaha.'],
    ['https://images.unsplash.com/photo-1604973104381-870c92f10343?q=80&w=800&auto=format&fit=crop', 'MEMBATIK', 'Workshop Membatik', 'Pelatihan membatik untuk meningkatkan keterampilan sekaligus peluang usaha mandiri.'],
  ];

  $budaya = [
    ['graduation-cap', 'Pelatihan Berbasis Kompetensi', 'Materi dan penilaian mengacu pada standar keterampilan kerja.'],
    ['shield-alert', 'Uji Kompetensi', 'Peserta dinilai oleh BLK dan BNSP pada program yang menyelenggarakannya.'],
    ['target', 'Siap Kerja & Mandiri', 'Lulusan dibekali keterampilan untuk bekerja sesuai bidang atau membuka usaha sendiri.'],
  ];

  $jam = [
    ['Senin - Kamis', '08.00 - 15.00 WIB (Istirahat 12.00 - 13.00)'],
    ['Jumat', '08.00 - 15.00 WIB (Istirahat 11.00 - 13.00)'],
  ];

  $kontak = [
    ['map-pin', config('blk.address')],
    ['phone', config('blk.phone')],
    ['message-square', 'WhatsApp: ' . config('blk.wa_label')],
    ['mail', config('blk.email')],
  ];
@endphp

@section('content')
  {{-- HERO --}}
  <section class="relative isolate overflow-hidden bg-primary text-primary-foreground">
    <img src="{{ asset('images/hero-image.webp') }}" alt="" decoding="async"
         class="absolute inset-0 size-full object-cover object-center opacity-30">
    <div class="absolute inset-0 bg-gradient-to-r from-[#04281f]/95 via-[#04281f]/88 to-[#04281f]/30"></div>
    <div class="pointer-events-none absolute -bottom-24 right-[6%] size-32 rounded-full border border-sikarir-lime/40"></div>

    <div class="site-container relative py-16 md:py-20">
      <x-ui.badge class="gap-2 text-primary-foreground {{ $glass }}">
        <x-lucide-building-2 class="text-sikarir-lime" />
        Lembaga vokasi Pemerintah Provinsi Jawa Timur
      </x-ui.badge>

      <h1 class="mt-6 max-w-3xl text-4xl font-black leading-[0.95] tracking-[-0.06em] text-white sm:text-5xl lg:text-6xl">
        Profil &amp; komitmen kejuruan.<br>
        <span class="text-sikarir-lime">UPT BLK Jember.</span>
      </h1>

      <p class="mt-5 max-w-2xl text-sm leading-relaxed text-primary-foreground/80 sm:text-base">
        Lembaga pelatihan vokasi di bawah Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur yang membekali masyarakat dengan
        keterampilan kerja berbasis kompetensi, agar siap
        <span class="font-bold text-sikarir-lime">bekerja atau berwirausaha</span>.
      </p>

      <div class="mt-8 grid grid-cols-2 gap-4 border-t border-primary-foreground/15 pt-6 sm:grid-cols-4">
        @foreach ($stats as [$value, $label])
          <div>
            <p class="text-2xl font-black text-sikarir-lime md:text-3xl">{{ $value }}</p>
            <p class="mt-0.5 text-[10px] font-medium text-primary-foreground/65 md:text-xs">{{ $label }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- SEJARAH & LANDASAN HUKUM --}}
  <section class="site-container grid items-start gap-8 py-12 md:grid-cols-12 md:py-16">
    <div class="space-y-4 md:col-span-5">
      <x-section-head badge="Fondasi Regulasi & Integritas" title="Sejarah singkat & landasan hukum" />

      <p class="text-sm leading-relaxed text-muted-foreground">
        UPT BLK Jember berdiri tahun 1980 sebagai Balai Latihan Kerja Industri dan Pertanian (BLKIP). Namanya beberapa kali berubah,
        hingga sejak 2018 resmi bernama Balai Latihan Kerja (BLK) Jember.
      </p>

      <x-ui.card class="flex gap-3 border-primary/25 bg-accent">
        <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-primary text-primary-foreground">
          <x-lucide-book-open-check class="size-5" />
        </span>
        <div class="space-y-1">
          <h4 class="text-xs font-bold text-foreground">Dasar Pembentukan Lembaga</h4>
          <p class="text-[11px] leading-relaxed text-muted-foreground">
            Peraturan Gubernur Jawa Timur Nomor 62 Tahun 2018 tentang Nomenklatur, Susunan Organisasi,
            Uraian Tugas dan Fungsi serta Tata Kerja UPT Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.
          </p>
        </div>
      </x-ui.card>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 md:col-span-7">
      @foreach ($pilar as [$icon, $title, $desc, $note])
        <x-ui.card class="flex flex-col justify-between gap-3 transition hover:border-primary/40">
          <div class="space-y-2">
            <span class="grid size-9 place-items-center rounded-xl bg-accent text-accent-foreground">
              <x-dynamic-component :component="'lucide-'.$icon" class="size-4" />
            </span>
            <h3 class="text-xs font-bold text-foreground">{{ $title }}</h3>
            <p class="text-[11px] leading-relaxed text-muted-foreground">{{ $desc }}</p>
          </div>
          <div class="flex items-center gap-1 border-t border-border pt-2 text-[10px] font-bold text-primary">
            <x-lucide-check class="size-3" />
            <span>{{ $note }}</span>
          </div>
        </x-ui.card>
      @endforeach
    </div>
  </section>

  {{-- VISI & MISI --}}
  <section class="border-y border-border bg-muted/40 py-14">
    <div class="site-container space-y-8">
      <x-section-head center badge="Cita-cita & Arah Strategi" title="Visi & misi kelembagaan">
        Arah dan komitmen UPT BLK Jember dalam menyelenggarakan pelatihan kerja bagi masyarakat.
      </x-section-head>

      <div class="grid items-stretch gap-8 md:grid-cols-12">
        <x-ui.card class="flex flex-col justify-between gap-6 border-primary bg-gradient-to-br from-primary via-[#0c3f31] to-[#0a2b23] p-6 text-primary-foreground md:col-span-5 md:p-8">
          <div class="space-y-4">
            <x-ui.badge class="uppercase tracking-wide text-sikarir-lime {{ $glass }}">
              <x-lucide-compass class="size-3.5" />
              Visi UPT BLK Jember
            </x-ui.badge>
            <h3 class="text-xl font-black leading-snug text-white md:text-2xl">
              &ldquo;Menjadi pusat pelatihan keterampilan, uji kompetensi, konsultasi pelatihan, serta penyedia jasa produksi yang ramah lingkungan dan berorientasi pada pasar kerja serta kemandirian.&rdquo;
            </h3>
          </div>
          <div class="flex items-center gap-2 border-t border-primary-foreground/15 pt-6 text-[11px] font-medium text-sikarir-lime">
            <x-lucide-building-2 class="size-4" />
            <span>UPT Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur</span>
          </div>
        </x-ui.card>

        <div class="space-y-3 md:col-span-7">
          @foreach ($misi as $i => [$title, $desc])
            <x-ui.card class="flex items-start gap-4 p-4">
              <span class="mt-0.5 grid size-8 shrink-0 place-items-center rounded-xl bg-primary text-xs font-black text-primary-foreground">
                {{ sprintf('%02d', $i + 1) }}
              </span>
              <div class="space-y-0.5">
                <h4 class="text-xs font-bold text-foreground">{{ $title }}</h4>
                <p class="text-[11px] leading-relaxed text-muted-foreground">{{ $desc }}</p>
              </div>
            </x-ui.card>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- FASILITAS WORKSHOP --}}
  <section class="site-container space-y-8 py-12">
    <x-section-head badge="Infrastruktur & Sarana Belajar" title="Workshop praktik untuk setiap program pelatihan">
      Pelatihan dilakukan dengan praktik langsung di workshop sesuai bidang keahlian yang dipilih.
    </x-section-head>

    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
      @foreach ($workshops as [$img, $tag, $title, $desc])
        <x-ui.card class="flex flex-col justify-between overflow-hidden p-0 transition hover:border-primary/40 hover:shadow-md">
          <div>
            <div class="relative aspect-[16/9] overflow-hidden bg-muted">
              <img src="{{ $img }}" class="size-full object-cover" alt="{{ $title }}" loading="lazy" decoding="async">
              <x-ui.badge variant="solid" tone="neutral" class="absolute left-3 top-3 uppercase tracking-wide backdrop-blur-sm">{{ $tag }}</x-ui.badge>
            </div>
            <div class="space-y-2 p-5">
              <h3 class="text-sm font-bold leading-snug text-foreground md:text-base">{{ $title }}</h3>
              <p class="text-xs leading-relaxed text-muted-foreground">{{ $desc }}</p>
            </div>
          </div>
          <div class="flex justify-between gap-3 border-t border-border px-5 py-3 text-[10px] font-bold text-muted-foreground">
            <span class="flex items-center gap-1"><x-lucide-circle-check-big class="size-3.5 text-primary" /> Praktik Langsung</span>
            <span class="flex items-center gap-1"><x-lucide-award class="size-3.5 text-primary" /> Berbasis Kompetensi</span>
          </div>
        </x-ui.card>
      @endforeach
    </div>
  </section>

  {{-- BUDAYA PELATIHAN --}}
  <section class="border-y border-border bg-muted/40 py-12">
    <div class="site-container space-y-8">
      <x-section-head badge="Karakter & Etos Kerja" title="Pelatihan berbasis kompetensi, siap kerja dan mandiri">
        UPT BLK Jember menyelenggarakan pelatihan berbasis kompetensi yang menekankan keterampilan praktis, disiplin, dan kesiapan menghadapi dunia kerja.
      </x-section-head>

      <div class="grid gap-4 sm:grid-cols-3">
        @foreach ($budaya as [$icon, $title, $desc])
          <x-ui.card class="space-y-2 p-4">
            <span class="grid size-9 place-items-center rounded-xl bg-accent text-accent-foreground">
              <x-dynamic-component :component="'lucide-'.$icon" class="size-4" />
            </span>
            <h4 class="text-xs font-bold text-foreground">{{ $title }}</h4>
            <p class="text-[11px] leading-relaxed text-muted-foreground">{{ $desc }}</p>
          </x-ui.card>
        @endforeach
      </div>
    </div>
  </section>

  {{-- PROGRAM MTU --}}
  <section class="site-container py-12">
    <x-ui.card class="grid items-center gap-8 border-primary bg-gradient-to-br from-primary to-[#0a3b2e] p-6 text-primary-foreground md:grid-cols-12 md:p-8">
      <div class="space-y-4 md:col-span-7">
        <x-ui.badge class="uppercase tracking-wide text-sikarir-lime {{ $glass }}">
          <x-lucide-truck class="size-3.5" />
          Jemput Bola Vokasi Desa
        </x-ui.badge>

        <h2 class="text-2xl font-black leading-tight text-white">Program Mobile Training Unit (MTU): Pelatihan Keliling ke Desa</h2>

        <p class="text-xs leading-relaxed text-primary-foreground/75">
          Bagi masyarakat di desa yang sulit menjangkau lokasi pelatihan, UPT BLK Jember menghadirkan Mobile Training Unit (MTU).
          Pelatihan dibawa langsung ke desa, pondok pesantren, atau komunitas warga, sehingga pencari kerja bisa belajar keterampilan tanpa harus datang ke kantor BLK.
        </p>

        <div class="space-y-1 rounded-xl border border-primary-foreground/15 bg-primary-foreground/10 p-3 text-xs font-medium text-primary-foreground/80 backdrop-blur-md">
          <p class="flex items-center gap-1.5 font-bold text-white">
            <x-lucide-map-pin class="size-4 text-sikarir-lime" />
            Menjangkau desa binaan di Kabupaten Jember
          </p>
          <p class="text-[11px] text-primary-foreground/60">Prioritas untuk desa pelosok yang belum banyak tersentuh pelatihan</p>
        </div>

        <div class="flex flex-wrap gap-2 pt-1">
          @foreach (['Budidaya Jamur', 'Pengolahan Makanan', 'Pembuatan Batako & Paving'] as $chip)
            <x-ui.badge class="text-primary-foreground/85 {{ $glass }}">{{ $chip }}</x-ui.badge>
          @endforeach
        </div>
      </div>

      <div class="relative md:col-span-5">
        <div class="relative min-h-[19rem] overflow-hidden rounded-2xl border border-primary-foreground/20 bg-[#0a2b23] shadow-xl">
          <img src="{{ asset('images/MTU.jpg') }}" class="size-full object-cover" alt="Mobile Training Unit BLK Jember" loading="lazy" decoding="async">

          <div class="absolute inset-x-3 bottom-3 flex flex-col gap-2 rounded-xl bg-card p-3 text-card-foreground shadow-lg sm:flex-row sm:items-center sm:justify-between">
            <div>
              <h4 class="text-xs font-bold text-foreground">Pengajuan Pelatihan MTU Desa</h4>
              <p class="text-[10px] text-muted-foreground">Perangkat desa atau kelompok masyarakat dapat berkonsultasi dengan BLK Jember untuk mengajukan pelatihan.</p>
            </div>
            <x-ui.button href="{{ $wa }}" target="_blank" rel="noopener" size="xs" class="shrink-0 {{ $waBtn }}">
              Konsultasi MTU
            </x-ui.button>
          </div>
        </div>
      </div>
    </x-ui.card>
  </section>

  {{-- PTSP & LOKASI --}}
  <section class="border-t border-border bg-muted/40 py-12">
    <div class="site-container space-y-8">
      <x-section-head badge="Layanan Publik & Aksesibilitas" title="Pusat Pelayanan Terpadu Satu Pintu (PTSP) & lokasi">
        Kunjungi atau hubungi UPT BLK Jember untuk informasi pendaftaran, program pelatihan, uji kompetensi, dan jadwal pelatihan terbaru.
      </x-section-head>

      <div class="grid items-stretch gap-8 md:grid-cols-2">
        <x-ui.card class="flex flex-col justify-between gap-5">
          <div class="space-y-4">
            <div class="space-y-2">
              <h3 class="flex items-center gap-2 text-sm font-bold text-foreground">
                <x-lucide-clock class="size-4 text-primary" />
                Jam Operasional Pelayanan PTSP
              </h3>
              <div class="space-y-1.5 rounded-xl border border-border bg-muted/40 p-3 text-xs font-medium text-muted-foreground">
                @foreach ($jam as [$hari, $waktu])
                  <div class="flex flex-wrap justify-between gap-2">
                    <span>{{ $hari }}</span>
                    <span class="font-bold text-foreground">{{ $waktu }}</span>
                  </div>
                @endforeach
                <div class="flex flex-wrap items-center justify-between gap-2 border-t border-border pt-1.5">
                  <span>Sabtu, Minggu &amp; Libur Nasional</span>
                  <x-ui.badge tone="danger">TUTUP</x-ui.badge>
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <h3 class="flex items-center gap-2 text-sm font-bold text-foreground">
                <x-lucide-phone-call class="size-4 text-primary" />
                Narahubung &amp; Lokasi Resmi
              </h3>
              <div class="space-y-2 text-xs text-muted-foreground">
                @foreach ($kontak as [$icon, $text])
                  <p class="flex items-start gap-2">
                    <x-dynamic-component :component="'lucide-'.$icon" class="mt-0.5 size-4 shrink-0" />
                    <span>{{ $text }}</span>
                  </p>
                @endforeach
              </div>
            </div>
          </div>

          <div class="flex gap-2 pt-2">
            <x-ui.button href="{{ $wa }}" target="_blank" rel="noopener" class="flex-1 {{ $waBtn }}">
              <x-lucide-message-circle />
              Chat WhatsApp PTSP
            </x-ui.button>
            <x-ui.button href="{{ asset('storage/download/Brosur_Profil_BLK_Jember.pdf') }}" download="Profile_BLK_Jember.pdf" variant="outline" class="flex-1">
              <x-lucide-download />
              Unduh Brosur Profil
            </x-ui.button>
          </div>
        </x-ui.card>

        <div class="relative min-h-[19rem] overflow-hidden rounded-xl border border-border bg-muted shadow-sm">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.9712984336184!2d113.69429570941301!3d-8.205640491792323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd696eb9d058681%3A0x84fe5d132cd1947!2sUPT%20Balai%20Latihan%20Kerja%20Jember!5e0!3m2!1sid!2sid!4v1790125884843!5m2!1sid!2sid"
            class="h-full min-h-[19rem] w-full border-0"
            allowfullscreen loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"
            title="Peta lokasi UPT BLK Jember"></iframe>

          <div class="absolute bottom-3 left-3 flex items-center gap-2.5 rounded-xl border border-border bg-card/95 p-3 text-xs shadow-md backdrop-blur-md">
            <span class="grid size-9 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-map-pin class="size-5" />
            </span>
            <div>
              <h4 class="font-bold text-foreground">UPT BLK Jember</h4>
              <p class="text-[10px] font-medium text-muted-foreground">Kabupaten Jember, Jawa Timur</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
