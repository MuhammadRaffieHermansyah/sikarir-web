@extends('layouts.public')

@section('title', 'siKarir — Skill baru, peluang baru | UPT BLK Jember')

@section('content')
  @php
    $pelatihans = $pelatihans ?? [];
    $lowongans = $lowongans ?? [];
    $berita = $berita ?? [];
    $alumni = $alumni ?? [];
  @endphp

  {{-- Hero --}}
  <section class="relative isolate overflow-hidden bg-primary text-primary-foreground">
    <img
      src="{{ asset('images/hero-image.webp') }}"
      alt=""
      class="absolute inset-0 size-full object-cover object-center opacity-40"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-[#04281f]/95 via-[#04281f]/85 to-[#04281f]/25"></div>
    <div class="pointer-events-none absolute -bottom-24 right-[6%] size-32 rounded-full border border-sikarir-lime/40"></div>

    <div class="site-container relative py-20 md:py-28">
      <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
        <span class="size-2 rounded-full bg-sikarir-lime"></span>
        Portal resmi UPT BLK Jember
      </x-ui.badge>

      <h1 class="mt-5 max-w-3xl text-5xl font-black leading-[0.9] tracking-[-0.075em] text-white sm:text-6xl lg:text-7xl">
        Skill baru.<br>
        <span class="text-sikarir-lime">Peluang baru.</span>
      </h1>

      <p class="mt-6 max-w-xl text-sm leading-relaxed text-primary-foreground/80 sm:text-base">
        Temukan pelatihan vokasi, sertifikasi kompetensi, dan peluang kerja yang terhubung dengan industri bersama UPT BLK Jember.
      </p>

      <div class="mt-8 flex flex-wrap gap-3">
        <x-ui.button href="{{ route('pelatihan.katalog') }}" size="lg" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
          Jelajahi pelatihan
          <x-lucide-arrow-up-right />
        </x-ui.button>

        <x-ui.button href="{{ route('lowongan.katalog') }}" size="lg" variant="outline" class="border-primary-foreground/35 bg-primary-foreground/5 text-primary-foreground hover:bg-primary-foreground/15 hover:text-primary-foreground">
          Cari lowongan
          <x-lucide-arrow-right />
        </x-ui.button>
      </div>
    </div>
  </section>

  {{-- Quick search --}}
  <div class="site-container relative z-10 -mt-10">
    <form method="GET" action="{{ route('pelatihan.katalog') }}" class="grid gap-3 rounded-2xl border border-border bg-card p-4 shadow-xl shadow-primary/10 sm:grid-cols-[1fr_auto] sm:items-end">
      <x-ui.field>
        <x-ui.field-label for="home-search" class="text-[10px] font-bold uppercase tracking-[0.12em] text-muted-foreground">
          Cari pelatihan atau kejuruan
        </x-ui.field-label>
        <x-ui.input id="home-search" name="q" type="search" placeholder="Contoh: otomotif, las, tata boga...">
          <x-slot:leading>
            <x-lucide-search />
          </x-slot:leading>
        </x-ui.input>
      </x-ui.field>

      <x-ui.button type="submit" size="lg" class="font-bold">
        Temukan program
        <x-lucide-arrow-right />
      </x-ui.button>
    </form>
  </div>

  {{-- Stats --}}
  <section class="site-container py-10">
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
      @foreach ([
          ['icon' => 'book-open', 'value' => '12+', 'label' => 'Kejuruan pelatihan'],
          ['icon' => 'trending-up', 'value' => '94%', 'label' => 'Lulusan terserap kerja & wirausaha'],
          ['icon' => 'wallet', 'value' => 'Gratis', 'label' => 'Program dibiayai APBD & APBN'],
          ['icon' => 'award', 'value' => 'BNSP', 'label' => 'Sertifikasi standar kompetensi'],
      ] as $stat)
        <x-ui.stat
          :label="$stat['label']"
          :value="$stat['value']"
          :icon="$stat['icon']"
        />
      @endforeach
    </div>
  </section>

  {{-- Layanan --}}
  <section class="border-y border-border bg-muted/40 py-16 md:py-20">
    <div class="site-container">
      <div class="max-w-2xl">
        <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
          <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
          Dari belajar sampai kerja
        </x-ui.badge>
        <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
          Satu tempat buat<br>naik level.
        </h2>
      </div>

      <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ([
            ['icon' => 'user-round-check', 'title' => 'Pendaftaran pelatihan', 'desc' => 'Pelatihan Reguler Berbasis Kompetensi (PBK) dan Mobile Training Unit (MTU) pedesaan.'],
            ['icon' => 'briefcase-business', 'title' => 'Bursa kerja khusus', 'desc' => 'Peluang kerja terverifikasi bagi alumni vokasi dan pencari kerja umum.'],
            ['icon' => 'badge-check', 'title' => 'Sertifikasi kompetensi', 'desc' => 'Uji kompetensi profesi melalui LSP-P1 BLK Jember berlisensi BNSP.'],
            ['icon' => 'messages-square', 'title' => 'Konsultasi karir', 'desc' => 'Bimbingan jabatan bersama instruktur dan tenaga konseling ketenagakerjaan.'],
            ['icon' => 'building-2', 'title' => 'Magang & kemitraan', 'desc' => 'Program on-the-job training bersama Dunia Usaha dan Dunia Industri (DUDI).'],
            ['icon' => 'file-check-2', 'title' => 'Verifikasi sertifikat', 'desc' => 'Cek keaslian sertifikat kelulusan BLK dan e-Sertifikat kompetensi.'],
        ] as $layanan)
          <x-ui.card class="transition hover:border-primary/40 hover:shadow-md">
            <span class="grid size-11 place-items-center rounded-xl bg-accent text-accent-foreground">
              <x-dynamic-component :component="'lucide-'.$layanan['icon']" class="size-5" />
            </span>
            <h3 class="mt-4 text-base font-bold text-foreground">{{ $layanan['title'] }}</h3>
            <p class="mt-1.5 text-sm leading-relaxed text-muted-foreground">{{ $layanan['desc'] }}</p>
          </x-ui.card>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Program pelatihan --}}
  <section class="site-container py-16 md:py-20">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
          <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
          Belajar yang kepake
        </x-ui.badge>
        <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
          Pilih skill.<br>Mulai dari sini.
        </h2>
      </div>

      <x-ui.button href="{{ route('pelatihan.katalog') }}" variant="ghost" class="font-bold text-primary">
        Semua pelatihan
        <x-lucide-arrow-up-right />
      </x-ui.button>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      @forelse ($pelatihans as $item)
        <x-ui.card class="flex flex-col overflow-hidden p-0 transition hover:border-primary/40 hover:shadow-md">
          <div class="relative h-40 overflow-hidden bg-muted">
            <img
              src="{{ $item->gambar_url ?? asset('images/hero-image.webp') }}"
              alt="{{ $item->nama_pelatihan }}"
              loading="lazy"
              class="size-full object-cover"
            >
            <x-ui.badge class="absolute left-3 top-3 bg-primary/90 text-primary-foreground backdrop-blur">
              {{ $item->sumber_dana ?? 'Program pelatihan' }}
            </x-ui.badge>
          </div>

          <div class="flex flex-1 flex-col p-4">
            <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-primary">
              {{ $item->kategori ?? 'Kejuruan' }}
            </span>
            <h3 class="mt-1.5 text-sm font-bold leading-snug text-foreground">{{ $item->nama_pelatihan }}</h3>
            <p class="mt-1.5 line-clamp-3 text-xs leading-relaxed text-muted-foreground">{{ $item->deskripsi_pelatihan }}</p>

            <div class="mt-auto flex gap-2 pt-4">
              <x-ui.button
                href="{{ route('pelatihan.katalog') . '#' . ($item->id_pelatihan ?? $item->id) }}"
                variant="outline"
                size="xs"
                class="flex-1"
              >
                Lihat silabus
              </x-ui.button>
              <x-ui.button href="{{ route('register') }}" size="xs" class="flex-1">
                Daftar
              </x-ui.button>
            </div>
          </div>
        </x-ui.card>
      @empty
        <x-ui.empty class="sm:col-span-2 lg:col-span-4">
          <x-ui.empty-header>
            <x-ui.empty-media variant="icon">
              <x-lucide-book-open />
            </x-ui.empty-media>
            <x-ui.empty-title>Belum ada data pelatihan aktif.</x-ui.empty-title>
            <x-ui.empty-description>Silakan cek kembali katalog pelatihan beberapa waktu lagi.</x-ui.empty-description>
          </x-ui.empty-header>
        </x-ui.empty>
      @endforelse
    </div>
  </section>

  {{-- Lowongan --}}
  <section class="border-y border-border bg-muted/40 py-16 md:py-20">
    <div class="site-container">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
            <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
            Langkah berikutnya
          </x-ui.badge>
          <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
            Peluang kerja<br>buat kamu kejar.
          </h2>
        </div>

        <x-ui.button href="{{ route('lowongan.katalog') }}" variant="ghost" class="font-bold text-primary">
          Semua lowongan
          <x-lucide-arrow-up-right />
        </x-ui.button>
      </div>

      <div class="mt-8 grid gap-4 md:grid-cols-3">
        @forelse ($lowongans as $job)
          <x-ui.card class="flex flex-col overflow-hidden p-0 transition hover:border-primary/40 hover:shadow-md">
            @if ($job->gambar_url)
              <img
                src="{{ $job->gambar_url }}"
                alt="{{ $job->judul_lowongan }}"
                class="aspect-[16/9] w-full object-cover"
                loading="lazy"
              >
            @else
              <div class="grid aspect-[16/9] w-full place-items-center bg-accent text-accent-foreground">
                <x-lucide-building-2 class="size-8" />
              </div>
            @endif

            <div class="flex flex-1 flex-col p-5">
              <div class="flex items-start justify-between gap-3">
                <h3 class="text-base font-bold leading-snug text-foreground">
                  <a href="{{ route('lowongan.detail', $job->id_lowongan) }}" class="transition hover:text-primary">
                    {{ $job->judul_lowongan }}
                  </a>
                </h3>
                <x-ui.badge tone="success" class="shrink-0 capitalize">{{ $job->status }}</x-ui.badge>
              </div>

              <div class="mt-3 space-y-1.5 text-xs text-muted-foreground">
                <p class="flex items-center gap-2">
                  <x-lucide-building-2 class="size-3.5 text-primary" />
                  {{ $job->mitra->nama_perusahaan ?? '-' }}
                </p>
                <p class="flex items-center gap-2">
                  <x-lucide-map-pin class="size-3.5 text-primary" />
                  {{ $job->lokasi ?? '-' }}
                </p>
              </div>

              <p class="mt-4 line-clamp-3 text-xs leading-relaxed text-muted-foreground">
                {{ $job->deskripsi ?? 'Tidak ada deskripsi.' }}
              </p>

              <div class="mt-auto flex items-center justify-between gap-3 border-t border-border pt-4">
                <div class="text-[10px] text-muted-foreground">
                  Diposting
                  <span class="mt-0.5 block text-xs font-bold text-foreground">
                    {{ $job->tanggal_posting ? \Carbon\Carbon::parse($job->tanggal_posting)->format('d M Y') : '-' }}
                  </span>
                </div>

                <x-ui.button href="{{ route('lowongan.detail', $job->id_lowongan) }}" size="sm">
                  Lihat selengkapnya
                  <x-lucide-arrow-right />
                </x-ui.button>
              </div>
            </div>
          </x-ui.card>
        @empty
          <x-ui.empty class="md:col-span-3">
            <x-ui.empty-header>
              <x-ui.empty-media variant="icon">
                <x-lucide-briefcase-business />
              </x-ui.empty-media>
              <x-ui.empty-title>Belum ada lowongan aktif saat ini.</x-ui.empty-title>
              <x-ui.empty-description>Lowongan baru dari mitra industri akan tampil di sini.</x-ui.empty-description>
            </x-ui.empty-header>
          </x-ui.empty>
        @endforelse
      </div>
    </div>
  </section>

  {{-- Alur pendaftaran --}}
  <section class="site-container py-16 md:py-20">
    <div class="max-w-2xl">
      <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
        <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
        Alurnya transparan
      </x-ui.badge>
      <h2 class="mt-4 text-3xl font-black tracking-tight text-foreground sm:text-4xl">
        Empat langkah buat<br>mulai perjalananmu.
      </h2>
    </div>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ([
          ['title' => 'Buat akun', 'desc' => 'Daftarkan akun siKarir menggunakan NIK yang valid dan lengkapi profil.'],
          ['title' => 'Pilih kejuruan', 'desc' => 'Cari program aktif yang sesuai minat, jadwal, dan kuota.'],
          ['title' => 'Ikuti seleksi', 'desc' => 'Jalani tes tertulis online dan verifikasi wawancara di workshop BLK.'],
          ['title' => 'Belajar & sertifikasi', 'desc' => 'Ikuti pelatihan hingga uji kompetensi resmi BNSP.'],
      ] as $step)
        <div class="relative">
          <span class="grid size-11 place-items-center rounded-full border border-border bg-card text-xs font-black text-primary shadow-sm">
            {{ sprintf('%02d', $loop->iteration) }}
          </span>
          <h3 class="mt-4 text-base font-bold text-foreground">{{ $step['title'] }}</h3>
          <p class="mt-1.5 text-xs leading-relaxed text-muted-foreground">{{ $step['desc'] }}</p>
        </div>
      @endforeach
    </div>
  </section>

  {{-- Warta & alumni --}}
  <section class="border-y border-border bg-muted/40 py-16 md:py-20">
    <div class="site-container grid gap-10 lg:grid-cols-2">
      <div>
        <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
          <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
          Info terbaru
        </x-ui.badge>
        <h2 class="mt-4 text-2xl font-black tracking-tight text-foreground sm:text-3xl">Warta & agenda BLK.</h2>

        <div class="mt-6 space-y-3">
          @forelse ($berita as $b)
            <x-ui.card class="flex gap-4 p-3">
              <img
                src="{{ $b->gambar_url ?? asset('images/hero-image.webp') }}"
                alt=""
                loading="lazy"
                class="size-24 shrink-0 rounded-lg object-cover"
              >
              <div class="min-w-0">
                <div class="text-[10px] font-bold uppercase tracking-[0.09em] text-primary">
                  {{ $b->kategori ?? 'Pengumuman' }} · {{ $b->tanggal ?? '' }}
                </div>
                <h3 class="mt-1 line-clamp-2 text-sm font-bold leading-snug text-foreground">{{ $b->judul }}</h3>
                <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-muted-foreground">{{ $b->ringkasan }}</p>
              </div>
            </x-ui.card>
          @empty
            <x-ui.empty>
              <x-ui.empty-header>
                <x-ui.empty-media variant="icon">
                  <x-lucide-newspaper />
                </x-ui.empty-media>
                <x-ui.empty-title class="text-base">Belum ada warta terbaru.</x-ui.empty-title>
              </x-ui.empty-header>
            </x-ui.empty>
          @endforelse
        </div>
      </div>

      <div>
        <x-ui.badge variant="secondary" class="gap-2 uppercase tracking-wide">
          <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
          Cerita lulusan
        </x-ui.badge>
        <h2 class="mt-4 text-2xl font-black tracking-tight text-foreground sm:text-3xl">Dari BLK ke dunia kerja.</h2>

        <div class="mt-6 space-y-3">
          @forelse ($alumni as $a)
            <x-ui.card class="p-5">
              <div class="mb-3 flex items-center gap-3">
                <x-ui.avatar class="size-10">
                  <x-ui.avatar-image src="{{ $a->foto_url ?? asset('images/logo-sikarir.png') }}" alt="{{ $a->nama }}" />
                  <x-ui.avatar-fallback>{{ mb_strtoupper(mb_substr($a->nama, 0, 1)) }}</x-ui.avatar-fallback>
                </x-ui.avatar>
                <div>
                  <div class="text-xs font-bold text-foreground">{{ $a->nama }}</div>
                  <div class="text-[10px] text-muted-foreground">{{ $a->profesi }}</div>
                </div>
              </div>
              <blockquote class="text-xs leading-relaxed text-muted-foreground">“{{ $a->testimoni }}”</blockquote>
            </x-ui.card>
          @empty
            <x-ui.empty>
              <x-ui.empty-header>
                <x-ui.empty-media variant="icon">
                  <x-lucide-message-square-quote />
                </x-ui.empty-media>
                <x-ui.empty-title class="text-base">Belum ada testimoni alumni.</x-ui.empty-title>
              </x-ui.empty-header>
            </x-ui.empty>
          @endforelse

          <div class="flex items-center justify-between gap-4 rounded-xl bg-accent px-5 py-4">
            <div>
              <div class="text-xs font-bold text-foreground">Tentang UPT BLK Jember</div>
              <p class="mt-1 text-[11px] leading-relaxed text-muted-foreground">Lembaga pelatihan vokasi Disnakertrans Jatim dengan fasilitas workshop.</p>
            </div>
            <x-ui.button href="{{ route('tentang.index') }}" variant="ghost" size="sm" class="shrink-0 font-bold text-primary">
              Kenali BLK
              <x-lucide-arrow-up-right />
            </x-ui.button>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA --}}
  <section class="site-container py-16 md:py-20">
    <x-ui.card class="relative overflow-hidden border-primary/30 bg-gradient-to-br from-primary via-[#0d4335] to-[#0a2f26] text-primary-foreground">
      <div class="pointer-events-none absolute -right-16 -top-16 size-56 rounded-full bg-sikarir-lime/10 blur-3xl"></div>

      <div class="relative flex flex-col items-start gap-8 md:flex-row md:items-center md:justify-between">
        <div class="max-w-2xl">
          <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
            <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
            Masa depan dimulai dari skill
          </x-ui.badge>
          <h2 class="mt-4 text-3xl font-black tracking-tight text-white sm:text-4xl">Siap mulai langkah barumu?</h2>
          <p class="mt-3 text-sm leading-relaxed text-primary-foreground/75">
            Daftar akun siKarir, temukan program yang cocok, dan siapkan diri untuk peluang berikutnya.
          </p>
        </div>

        <x-ui.button href="{{ route('register') }}" size="lg" class="shrink-0 bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
          Buat akun siKarir
          <x-lucide-arrow-up-right />
        </x-ui.button>
      </div>
    </x-ui.card>
  </section>
@endsection
