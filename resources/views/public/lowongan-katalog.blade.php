@extends('layouts.public')

@section('title', 'Lowongan Kerja (BKK) - siKarir UPT BLK Jember')

@section('content')
  {{-- HERO --}}
  <section class="relative isolate overflow-hidden bg-primary text-primary-foreground">
    <img
      src="{{ asset('images/hero-image.webp') }}"
      alt=""
      class="absolute inset-0 size-full object-cover object-center opacity-25"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-[#04281f]/95 via-[#04281f]/88 to-[#04281f]/30"></div>
    <div class="pointer-events-none absolute -bottom-24 right-[6%] size-32 rounded-full border border-sikarir-lime/40"></div>

    <div class="site-container relative py-16 md:py-20">
      <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
        <x-lucide-shield-check class="text-sikarir-lime" />
        Portal resmi BKK UPT BLK Jember
      </x-ui.badge>

      <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-end">
        <div>
          <h1 class="max-w-3xl text-4xl font-black leading-[0.95] tracking-[-0.06em] text-white sm:text-5xl lg:text-6xl">
            Bursa kerja khusus.<br>
            <span class="text-sikarir-lime">Peluang karir mitra DUDI.</span>
          </h1>

          <p class="mt-5 max-w-2xl text-sm leading-relaxed text-primary-foreground/80 sm:text-base">
            Platform penyaluran kerja terverifikasi dan kolaborasi DUDI Jawa Timur. Menghubungkan alumni pelatihan vokasi bersertifikat BNSP
            dan talenta kerja kompeten langsung dengan perusahaan kredibel.
          </p>
        </div>

        <x-ui.card class="hidden items-center gap-4 border-primary-foreground/15 bg-primary-foreground/10 text-primary-foreground backdrop-blur-md lg:flex">
          <span class="grid size-12 shrink-0 place-items-center rounded-xl border border-primary-foreground/20 bg-primary-foreground/15 text-sikarir-lime">
            <x-lucide-building-2 class="size-6" />
          </span>

          <div>
            <p class="text-2xl font-black leading-none text-white">{{ $totalMitra ?? 0 }}</p>
            <p class="mt-1 text-xs font-bold text-primary-foreground/90">Mitra Industri Aktif</p>
            <p class="text-[10px] text-primary-foreground/60">Terverifikasi Disnakertrans Jatim</p>
          </div>
        </x-ui.card>
      </div>
    </div>
  </section>

  <div class="site-container space-y-8 py-10 md:py-14">
    {{-- SEARCH & FILTER --}}
    @php
      $lokasiTersedia = collect(is_array($daftarLokasi ?? null) ? $daftarLokasi : [])
          ->filter(fn ($lokasi) => is_string($lokasi))
          ->values();
      $anchorHasil = '#daftar-lowongan';
    @endphp
    <x-ui.card>
      <form method="GET" action="{{ route('lowongan.katalog') }}{{ $anchorHasil }}" class="space-y-4">
        <div class="flex flex-col gap-3 md:flex-row">
          <div class="min-w-0 flex-1">
            <x-ui.field>
              <x-ui.field-label for="lowongan-q" class="sr-only">Cari lowongan</x-ui.field-label>
              <x-ui.input
                id="lowongan-q"
                name="q"
                type="search"
                :value="request('q')"
                placeholder="Cari nama jabatan, posisi spesifik, skill vokasi, atau nama perusahaan..."
              >
                <x-slot:leading>
                  <x-lucide-search />
                </x-slot:leading>
              </x-ui.input>
            </x-ui.field>
          </div>

          <x-ui.button type="submit" class="shrink-0">
            <x-lucide-filter />
            Cari Lowongan
          </x-ui.button>
        </div>

        <div class="grid gap-4 border-t border-border pt-4 md:max-w-sm">
          <x-ui.field>
            <x-ui.field-label for="lowongan-wilayah" class="text-[10px] font-bold uppercase tracking-[0.12em] text-muted-foreground">
              Wilayah / Lokasi
            </x-ui.field-label>
            <x-ui.select name="wilayah" id="lowongan-wilayah" native class="w-full" onchange="this.form.submit()">
              <option value="">Semua Lokasi Penempatan</option>
              @foreach ($lokasiTersedia as $lokasi)
                <option value="{{ $lokasi }}" @selected(request('wilayah') === $lokasi)>{{ $lokasi }}</option>
              @endforeach
            </x-ui.select>
          </x-ui.field>
        </div>

        <div class="flex flex-col justify-between gap-3 border-t border-border pt-4 md:flex-row md:items-center">
          <div class="flex flex-wrap items-center gap-2 text-xs">
            @if ($lokasiTersedia->isNotEmpty())
              <span class="flex items-center gap-1 font-bold text-muted-foreground">
                <x-lucide-map-pin class="size-3.5 text-primary" />
                Lokasi:
              </span>

              @foreach ($lokasiTersedia->take(5) as $lokasi)
                <x-ui.badge
                  :href="route('lowongan.katalog', ['wilayah' => $lokasi]).$anchorHasil"
                  variant="outline"
                  size="lg"
                  class="rounded-full"
                >
                  {{ $lokasi }}
                </x-ui.badge>
              @endforeach
            @else
              <span class="flex items-center gap-1 font-bold text-muted-foreground">
                <x-lucide-sparkles class="size-3.5 text-primary" />
                Populer:
              </span>

              @foreach (['Teknisi Las', 'Otomotif Roda 4', 'Operator Garmen', 'Web Developer', 'Barista Kopi'] as $tag)
                <x-ui.badge :href="route('lowongan.katalog', ['q' => $tag]).$anchorHasil" variant="outline" size="lg" class="rounded-full">
                  {{ $tag }}
                </x-ui.badge>
              @endforeach
            @endif
          </div>

          <x-ui.button href="{{ route('lowongan.katalog') }}{{ $anchorHasil }}" variant="link" size="sm" class="shrink-0 px-0 text-destructive">
            <x-lucide-rotate-ccw />
            Reset Filter
          </x-ui.button>
        </div>
      </form>
    </x-ui.card>

    <div class="grid gap-8 lg:grid-cols-12">
      {{-- KOLOM KIRI: DAFTAR LOWONGAN --}}
      <div id="daftar-lowongan" class="space-y-5 scroll-mt-6 lg:col-span-8">
        <div class="flex flex-wrap items-center justify-between gap-2 px-1 text-xs font-medium text-muted-foreground">
          <p class="flex items-center gap-1.5 font-bold text-foreground">
            <x-lucide-briefcase class="size-4 text-primary" />
            Menampilkan
            {{ is_object($lowongan) && method_exists($lowongan, 'total') ? $lowongan->total() : ($lowongan ?? collect())->count() }}
            Lowongan Aktif
          </p>

          <span class="flex items-center gap-1.5 font-bold text-primary">
            <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
            Diperbarui Harian
          </span>
        </div>

        <div class="space-y-4">
          @forelse ($lowongan ?? [] as $job)
            <x-ui.card class="space-y-3 p-5 transition hover:border-primary/40 hover:shadow-md">
              @php($tgl = $job->tanggal_posting ? $job->tanggal_posting->translatedFormat('d M Y') : '-')

              <div class="flex items-start justify-between gap-3">
                <div class="flex min-w-0 gap-3.5">
                  @if ($job->gambar_url)
                    <img
                      src="{{ $job->gambar_thumb_url }}"
                      alt="{{ $job->judul_lowongan }}"
                      class="size-14 shrink-0 rounded-xl border border-border object-cover"
                      loading="lazy"
                    >
                  @else
                    <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-accent text-accent-foreground">
                      <x-lucide-building-2 class="size-6" />
                    </span>
                  @endif

                  <div class="min-w-0">
                    <h3 class="text-sm font-bold leading-snug text-foreground md:text-base">
                      <a href="{{ route('lowongan.detail', $job->id_lowongan) }}" class="transition hover:text-primary">
                        {{ $job->judul_lowongan }}
                      </a>
                    </h3>

                    <p class="mt-0.5 text-xs font-semibold text-muted-foreground">{{ $job->mitra->nama_perusahaan ?? '-' }}</p>
                  </div>
                </div>

              </div>

              <div class="flex flex-wrap items-center gap-4 rounded-xl border border-border bg-muted/40 p-2.5 text-xs font-medium text-muted-foreground">
                <span class="flex items-center gap-1">
                  <x-lucide-map-pin class="size-3.5 text-muted-foreground" />
                  {{ $job->lokasi ?? '-' }}
                </span>

                <span class="ml-auto flex items-center gap-1 font-semibold">
                  <x-lucide-calendar class="size-3.5" />
                  {{ $tgl }}
                </span>
              </div>

              <p class="line-clamp-2 text-xs leading-relaxed text-muted-foreground">{{ $job->deskripsi ?: 'Tidak ada deskripsi.' }}</p>

              <div class="flex flex-wrap items-center justify-between gap-3 border-t border-border pt-3">
                <span class="text-[10px] font-medium text-muted-foreground">
                  Dipublikasikan: {{ $tgl }}
                </span>

                <div class="flex items-center gap-2">
                  <x-ui.button href="{{ route('lowongan.detail', $job->id_lowongan) }}" variant="outline" size="sm">
                    Info Selengkapnya
                  </x-ui.button>
                </div>
              </div>
            </x-ui.card>
          @empty
            <x-ui.empty class="bg-card">
              <x-ui.empty-header>
                <x-ui.empty-media variant="icon">
                  <x-lucide-briefcase />
                </x-ui.empty-media>
                <x-ui.empty-title>Belum ada lowongan aktif</x-ui.empty-title>
                <x-ui.empty-description>
                  Belum ada lowongan aktif yang sesuai dengan filter Anda. Coba ubah kata kunci atau reset filter.
                </x-ui.empty-description>
              </x-ui.empty-header>

              <x-ui.button href="{{ route('lowongan.katalog') }}{{ $anchorHasil }}" variant="outline" size="sm">
                <x-lucide-rotate-ccw />
                Reset Filter
              </x-ui.button>
            </x-ui.empty>
          @endforelse
        </div>

        {{-- PAGINATION --}}
        @if (is_object($lowongan) && method_exists($lowongan, 'hasPages') && $lowongan->hasPages())
          <div>
            {{ $lowongan->links('components.pagination') }}
          </div>
        @endif
      </div>

      {{-- KOLOM KANAN: SIDEBAR --}}
      <div class="space-y-6 lg:col-span-4">
        {{-- Foto Workshop --}}
        <x-ui.card class="overflow-hidden p-0">
          <div class="relative aspect-[16/9] bg-muted">
            <img
              src="https://images.unsplash.com/photo-1654703680007-d5d9699cddfd?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
              class="size-full object-cover"
              alt="Workshop Praktik Industri BLK Jember"
              loading="lazy"
            >

            <x-ui.badge
              variant="solid"
              tone="neutral"
              class="absolute bottom-2 left-2 gap-1.5 backdrop-blur-sm"
            >
              <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
              Workshop Praktik BLK Jember
            </x-ui.badge>
          </div>

          <div class="space-y-1 p-4">
            <h3 class="text-sm font-bold text-foreground">Siap Kerja Berstandar Industri</h3>
            <p class="text-xs leading-relaxed text-muted-foreground">
              Kurikulum pelatihan dirancang bersama asosiasi industri (DUDI) untuk menjamin lulusan langsung menguasai kompetensi yang dicari
              pasar kerja modern.
            </p>
          </div>
        </x-ui.card>

        {{-- CTA Mitra --}}
        <x-ui.card class="space-y-3 border-primary bg-gradient-to-br from-primary to-[#0a3b2e] p-6 text-primary-foreground">
          <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 uppercase tracking-wide text-sikarir-lime">
            Kemitraan Industri
          </x-ui.badge>

          <h3 class="text-base font-black leading-snug text-white">
            Ingin merekrut tenaga kerja kompeten bersertifikat?
          </h3>

          <p class="text-xs leading-relaxed text-primary-foreground/75">
            Daftarkan perusahaan Anda sebagai mitra resmi BKK UPT BLK Jember. Nikmati kemudahan rekrutmen massal talenta siap kerja, uji
            kompetensi di workshop BLK, dan bebas biaya administrasi.
          </p>

          <div class="space-y-2 pt-2">
            <x-ui.button href="{{ route('register.mitra') }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              Daftarkan Perusahaan Anda
            </x-ui.button>

            <a
              href="https://wa.me/{{ config('blk.wa') }}"
              target="_blank"
              rel="noopener"
              class="block text-center text-xs font-semibold text-sikarir-lime hover:underline"
            >
              Konsultasi Kerjasama BKK (WhatsApp PIC)
            </a>
          </div>
        </x-ui.card>

      </div>
    </div>
  </div>
@endsection
