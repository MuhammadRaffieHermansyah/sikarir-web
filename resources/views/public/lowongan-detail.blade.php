@extends('layouts.public')

@section('title', $lowongan->judul_lowongan . ' - Lowongan siKarir UPT BLK Jember')

@section('content')
  @php
    $mitra = $lowongan->mitra;
    $telp = $mitra->no_telp ?? null;
    $wa = $telp ? preg_replace('/^0/', '62', preg_replace('/\D+/', '', $telp)) : null;
    $email = $mitra->user->email ?? null;
    $tgl = $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d F Y') : '-';
    $wilayah = trim(($mitra->kota ?? '') . ($mitra->provinsi ? ', ' . $mitra->provinsi : ''), ', ');
  @endphp

  <div class="site-container space-y-6 py-8 md:py-12">
    <x-ui.breadcrumb>
      <x-ui.breadcrumb-list>
        <x-ui.breadcrumb-item>
          <x-ui.breadcrumb-link href="{{ url('/') }}">Beranda</x-ui.breadcrumb-link>
        </x-ui.breadcrumb-item>
        <x-ui.breadcrumb-separator />
        <x-ui.breadcrumb-item>
          <x-ui.breadcrumb-link href="{{ route('lowongan.katalog') }}">Lowongan Kerja</x-ui.breadcrumb-link>
        </x-ui.breadcrumb-item>
        <x-ui.breadcrumb-separator />
        <x-ui.breadcrumb-item>
          <x-ui.breadcrumb-page class="max-w-[18rem] truncate">{{ $lowongan->judul_lowongan }}</x-ui.breadcrumb-page>
        </x-ui.breadcrumb-item>
      </x-ui.breadcrumb-list>
    </x-ui.breadcrumb>

    <div class="grid items-start gap-6 lg:grid-cols-12">
      {{-- KOLOM KIRI --}}
      <div class="space-y-6 lg:col-span-8">
        {{-- Header lowongan --}}
        <x-ui.card class="overflow-hidden p-0">
          @if ($lowongan->gambar_url)
            <img
              src="{{ $lowongan->gambar_url }}"
              alt="Foto {{ $lowongan->judul_lowongan }}"
              class="max-h-80 w-full object-cover"
            >
          @endif

          <div class="space-y-4 p-6">
            <div class="flex items-start justify-between gap-3">
              <div class="space-y-1.5">
                <span class="text-[10px] font-bold uppercase tracking-wider text-primary">
                  {{ $mitra->bidang_usaha ?? 'Lowongan Mitra' }}
                </span>
                <h1 class="text-xl font-black leading-snug text-foreground md:text-2xl">
                  {{ $lowongan->judul_lowongan }}
                </h1>
              </div>

              <x-ui.badge tone="success" class="shrink-0 uppercase tracking-wide">
                {{ ucfirst($lowongan->status) }}
              </x-ui.badge>
            </div>

            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 border-t border-border pt-4 text-xs font-medium text-muted-foreground">
              <span class="flex items-center gap-1.5">
                <x-lucide-building-2 class="size-4" />
                {{ $mitra->nama_perusahaan ?? '-' }}
              </span>
              <span class="flex items-center gap-1.5">
                <x-lucide-map-pin class="size-4" />
                {{ $lowongan->lokasi ?? 'Lokasi Fleksibel' }}
              </span>
              <span class="flex items-center gap-1.5">
                <x-lucide-calendar class="size-4" />
                Diposting {{ $tgl }}
              </span>
            </div>
          </div>
        </x-ui.card>

        {{-- Deskripsi --}}
        <x-ui.card>
          <div class="flex items-center gap-2.5 border-b border-border pb-4">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-file-text class="size-4" />
            </span>
            <h2 class="text-sm font-bold text-foreground">Deskripsi Pekerjaan &amp; Tanggung Jawab</h2>
          </div>

          <div class="whitespace-pre-line pt-4 text-xs leading-relaxed text-muted-foreground">
            {{ $lowongan->deskripsi ?: 'Belum ada deskripsi pekerjaan yang ditambahkan.' }}
          </div>
        </x-ui.card>

        {{-- Kualifikasi --}}
        <x-ui.card>
          <div class="flex items-center gap-2.5 border-b border-border pb-4">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-list-checks class="size-4" />
            </span>
            <h2 class="text-sm font-bold text-foreground">Kualifikasi &amp; Persyaratan</h2>
          </div>

          <div class="whitespace-pre-line pt-4 text-xs leading-relaxed text-muted-foreground">
            {{ $lowongan->kualifikasi ?: 'Belum ada kualifikasi yang dicantumkan.' }}
          </div>
        </x-ui.card>
      </div>

      {{-- KOLOM KANAN --}}
      <div class="space-y-6 lg:col-span-4">
        {{-- Info perusahaan --}}
        <x-ui.card class="space-y-4">
          <h3 class="border-b border-border pb-2 text-xs font-bold text-foreground">Info Perusahaan</h3>

          <div class="space-y-3 text-xs">
            <div>
              <span class="mb-0.5 block text-muted-foreground">Perusahaan</span>
              <span class="font-bold text-foreground">{{ $mitra->nama_perusahaan ?? '-' }}</span>
            </div>
            <div>
              <span class="mb-0.5 block text-muted-foreground">Bidang Usaha</span>
              <span class="font-semibold text-foreground">{{ $mitra->bidang_usaha ?? '-' }}</span>
            </div>
            <div>
              <span class="mb-0.5 block text-muted-foreground">Wilayah</span>
              <span class="font-semibold text-foreground">{{ $wilayah !== '' ? $wilayah : '-' }}</span>
            </div>
          </div>
        </x-ui.card>

        {{-- Kontak --}}
        <x-ui.card class="space-y-3">
          <h3 class="border-b border-border pb-2 text-xs font-bold text-foreground">Berminat? Hubungi Perusahaan</h3>

          <p class="text-xs leading-relaxed text-muted-foreground">
            Lowongan ini bersifat informasi. Pendaftaran dilakukan langsung melalui kontak perusahaan di bawah.
          </p>

          <div class="space-y-2">
            @if ($wa)
              <x-ui.button href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="w-full">
                <x-lucide-phone />
                {{ $telp }}
              </x-ui.button>
            @endif

            @if ($email)
              <x-ui.button
                href="mailto:{{ $email }}?subject={{ rawurlencode('Minat Lowongan: ' . $lowongan->judul_lowongan) }}"
                variant="secondary"
                class="w-full break-all"
              >
                <x-lucide-mail class="shrink-0" />
                {{ $email }}
              </x-ui.button>
            @endif

            @if (! $wa && ! $email)
              <p class="text-xs text-muted-foreground">Kontak perusahaan belum dicantumkan.</p>
            @endif
          </div>
        </x-ui.card>

        {{-- Lowongan lainnya --}}
        @if ($lainnya->isNotEmpty())
          <x-ui.card class="space-y-3">
            <h3 class="border-b border-border pb-2 text-xs font-bold text-foreground">Lowongan Lainnya</h3>

            <div class="space-y-3">
              @foreach ($lainnya as $lain)
                <a href="{{ route('lowongan.detail', $lain->id_lowongan) }}" class="group flex items-center gap-3">
                  @if ($lain->gambar_url)
                    <img
                      src="{{ $lain->gambar_url }}"
                      alt=""
                      class="size-11 shrink-0 rounded-lg border border-border object-cover"
                      loading="lazy"
                    >
                  @else
                    <span class="grid size-11 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                      <x-lucide-building-2 class="size-5" />
                    </span>
                  @endif

                  <div class="min-w-0">
                    <div class="truncate text-xs font-bold text-foreground transition group-hover:text-primary">
                      {{ $lain->judul_lowongan }}
                    </div>
                    <div class="truncate text-[11px] text-muted-foreground">
                      {{ $lain->mitra->nama_perusahaan ?? '-' }}
                    </div>
                  </div>
                </a>
              @endforeach
            </div>
          </x-ui.card>
        @endif

        <x-ui.button href="{{ route('lowongan.katalog') }}" variant="outline" class="w-full">
          <x-lucide-arrow-left />
          Kembali ke Daftar Lowongan
        </x-ui.button>
      </div>
    </div>
  </div>
@endsection
