@extends('layouts.app')

@section('title', 'Detail Lowongan - ' . $lowongan->judul_lowongan)

@section('content')
  <x-ui.page-header
    title="Rincian Lowongan Magang Industri"
    description="Spesifikasi posisi, kualifikasi, dan informasi perusahaan mitra industri penerima magang."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('lowongan.index') }}">Lowongan Magang</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Lowongan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('lowongan.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
      <div class="flex items-center gap-5">
        <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary text-2xl font-black text-primary-foreground">
          {{ strtoupper(substr($lowongan->mitra->nama_perusahaan ?? 'M', 0, 2)) }}
        </span>

        <div>
          <div class="flex flex-wrap items-center gap-2.5">
            <h2 class="text-lg font-extrabold text-foreground">{{ $lowongan->judul_lowongan }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">
              #LWG-{{ str_pad((string) $lowongan->id_lowongan, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
          </div>

          <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-muted-foreground">
            <span class="flex items-center gap-1.5">
              <x-lucide-building-2 class="size-3.5" />
              {{ $lowongan->mitra->nama_perusahaan ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-map-pin class="size-3.5" />
              {{ $lowongan->lokasi ?? 'Lokasi Fleksibel' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-calendar class="size-3.5" />
              {{ $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-border sm:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">Status Lowongan</div>
        <div class="mt-1 flex items-center justify-end gap-1.5 text-xs font-bold">
          @if ($lowongan->status === 'aktif')
            <span class="size-2 animate-pulse rounded-full bg-emerald-500"></span>
            <span class="text-primary">Aktif</span>
          @elseif ($lowongan->status === 'draft')
            <span class="size-2 rounded-full bg-amber-400"></span>
            <span class="text-amber-700">Draft</span>
          @else
            <span class="size-2 rounded-full bg-muted-foreground"></span>
            <span class="text-muted-foreground">Ditutup</span>
          @endif
        </div>

        @if ($lowongan->lamaran)
          <div class="mt-1 text-xs text-muted-foreground">{{ $lowongan->lamaran->count() }} pelamar</div>
        @endif
      </div>
    </div>
  </x-ui.card>

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-file-text class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Deskripsi Pekerjaan &amp; Tanggung Jawab</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="whitespace-pre-line rounded-xl border border-border bg-muted/40 p-4 text-xs leading-relaxed text-foreground">
            {{ $lowongan->deskripsi ?: 'Belum ada deskripsi pekerjaan yang ditambahkan.' }}
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-check-square class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Kualifikasi &amp; Persyaratan Pendaftar</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="whitespace-pre-line rounded-xl border border-border bg-muted/40 p-4 text-xs leading-relaxed text-foreground">
            {{ $lowongan->kualifikasi ?: 'Belum ada kualifikasi yang dicantumkan.' }}
          </div>
        </x-ui.card-content>
      </x-ui.card>

      @if (auth()->user() && in_array(auth()->user()->role, ['admin_blk', 'mitra']))
        <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
          <x-ui.card-header class="border-b pb-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div class="flex items-center gap-3">
                <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                  <x-lucide-users class="size-4" />
                </span>
                <x-ui.card-title class="text-base font-bold">Daftar Pelamar</x-ui.card-title>
              </div>

              <x-ui.badge variant="secondary">{{ $lowongan->lamaran->count() }} Pelamar</x-ui.badge>
            </div>
          </x-ui.card-header>

          <x-ui.card-content class="px-0">
            @if ($lowongan->lamaran->isEmpty())
              <x-ui.empty class="border-0">
                <x-ui.empty-header>
                  <x-ui.empty-media variant="icon">
                    <x-lucide-inbox />
                  </x-ui.empty-media>
                  <x-ui.empty-title class="text-base">Belum Ada Pelamar</x-ui.empty-title>
                  <x-ui.empty-description>
                    Belum ada pelamar yang mendaftar untuk posisi ini.
                  </x-ui.empty-description>
                </x-ui.empty-header>
              </x-ui.empty>
            @else
              <x-ui.table>
                <x-ui.table-header>
                  <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                    <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Peserta</x-ui.table-head>
                    <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Nomor</x-ui.table-head>
                    <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Tanggal</x-ui.table-head>
                    <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status</x-ui.table-head>
                    <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
                  </x-ui.table-row>
                </x-ui.table-header>

                <x-ui.table-body>
                  @foreach ($lowongan->lamaran as $lam)
                    @php
                      $lamaranTone = match ($lam->status) {
                          'melamar' => 'info',
                          'diproses' => 'warning',
                          'wawancara' => 'neutral',
                          'diterima' => 'success',
                          'ditolak' => 'danger',
                          default => 'neutral',
                      };
                    @endphp

                    <x-ui.table-row>
                      <x-ui.table-cell class="px-4 py-3">
                        <div class="font-semibold text-foreground">{{ $lam->peserta->user->name ?? '-' }}</div>
                        <div class="text-xs text-muted-foreground">{{ $lam->peserta->user->email ?? '-' }}</div>
                      </x-ui.table-cell>

                      <x-ui.table-cell class="px-4 py-3 font-mono text-muted-foreground">
                        {{ $lam->peserta->nomor_peserta ?? '-' }}
                      </x-ui.table-cell>

                      <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                        {{ $lam->tanggal_melamar?->translatedFormat('d M Y') ?? '-' }}
                      </x-ui.table-cell>

                      <x-ui.table-cell class="px-4 py-3">
                        <x-ui.badge :tone="$lamaranTone">{{ ucfirst($lam->status) }}</x-ui.badge>
                      </x-ui.table-cell>

                      <x-ui.table-cell class="px-4 py-3">
                        <form
                          action="{{ route('lamaran.update-status', $lam->id_lamaran) }}"
                          method="POST"
                          class="flex items-center justify-end gap-2"
                        >
                          @csrf
                          @method('PATCH')

                          <x-ui.select name="status" native class="h-8 w-36 text-xs">
                            <option value="melamar" @selected($lam->status === 'melamar')>Melamar</option>
                            <option value="diproses" @selected($lam->status === 'diproses')>Diproses</option>
                            <option value="wawancara" @selected($lam->status === 'wawancara')>Wawancara</option>
                            <option value="diterima" @selected($lam->status === 'diterima')>Diterima</option>
                            <option value="ditolak" @selected($lam->status === 'ditolak')>Ditolak</option>
                          </x-ui.select>

                          <x-ui.button type="submit" size="sm">
                            Simpan
                          </x-ui.button>
                        </form>
                      </x-ui.table-cell>
                    </x-ui.table-row>
                  @endforeach
                </x-ui.table-body>
              </x-ui.table>
            @endif
          </x-ui.card-content>
        </x-ui.card>
      @endif
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-building-2 class="size-4 text-primary" />
            Info Mitra &amp; Perusahaan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div>
            <span class="mb-0.5 block text-muted-foreground">Perusahaan</span>
            <span class="font-bold text-foreground">{{ $lowongan->mitra->nama_perusahaan ?? '-' }}</span>
          </div>
          <div>
            <span class="mb-0.5 block text-muted-foreground">Bidang Usaha</span>
            <span class="font-semibold text-foreground">{{ $lowongan->mitra->bidang_usaha ?? '-' }}</span>
          </div>
          <div>
            <span class="mb-0.5 block text-muted-foreground">Wilayah</span>
            <span class="font-semibold text-foreground">
              {{ $lowongan->mitra->kota ?? '-' }}{{ $lowongan->mitra->provinsi ? ', ' . $lowongan->mitra->provinsi : '' }}
            </span>
          </div>
          <div>
            <span class="mb-0.5 block text-muted-foreground">Tanggal Diposting</span>
            <span class="font-semibold text-foreground">
              {{ $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d F Y') : '-' }}
            </span>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      @if (auth()->user() && in_array(auth()->user()->role, ['admin_blk', 'mitra']))
        <x-ui.card variant="sectioned">
          <x-ui.card-header class="border-b">
            <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
              <x-lucide-sliders-horizontal class="size-4 text-primary" />
              Aksi Administratif
            </x-ui.card-title>
          </x-ui.card-header>

          <x-ui.card-content class="space-y-2.5">
            <x-ui.button href="{{ route('lowongan.edit', $lowongan->id_lowongan) }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              <x-lucide-pencil />
              Edit Lowongan
            </x-ui.button>

            <form
              action="{{ route('lowongan.destroy', $lowongan->id_lowongan) }}"
              method="POST"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')"
            >
              @csrf
              @method('DELETE')

              <x-ui.button type="submit" variant="destructive" class="w-full">
                <x-lucide-trash-2 />
                Hapus Lowongan
              </x-ui.button>
            </form>
          </x-ui.card-content>
        </x-ui.card>
      @endif
    </div>
  </div>
@endsection
