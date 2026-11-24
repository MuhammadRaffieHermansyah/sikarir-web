@extends('layouts.app')

@section('title', 'Detail Profil Mitra DU/DI - ' . $mitra->nama_perusahaan)

@section('content')
  <x-ui.page-header
    title="Profil Mitra Industri DU/DI"
    description="Rincian profil badan usaha, legalitas kerjasama, penanggung jawab industri, dan lowongan aktif."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('mitras.index') }}">Mitra DU/DI</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Perusahaan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('mitras.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>

      <x-ui.button href="{{ route('mitras.edit', $mitra->id_mitra) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Data
      </x-ui.button>

      @unless ($mitra->is_verified)
        <form action="{{ route('mitras.verify', $mitra) }}" method="POST">
          @csrf
          @method('PATCH')
          <x-ui.button type="submit">
            <x-lucide-badge-check />
            Verifikasi Mitra
          </x-ui.button>
        </form>
      @endunless
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
      <div class="flex items-center gap-5">
        @if ($mitra->logo_perusahaan)
          <div class="relative shrink-0">
            <div class="size-20 overflow-hidden rounded-xl border border-border bg-card shadow-md">
              <img
                src="{{ Storage::url($mitra->logo_perusahaan) }}"
                alt="Logo {{ $mitra->nama_perusahaan }}"
                class="size-full object-cover"
              >
            </div>
            <span class="absolute -bottom-1 -end-1 grid size-5 place-items-center rounded-full border-2 border-card bg-emerald-500">
              <x-lucide-check class="size-2.5 text-white" />
            </span>
          </div>
        @else
          <span class="grid size-20 shrink-0 place-items-center rounded-2xl bg-primary text-2xl font-black text-primary-foreground">
            {{ strtoupper(substr($mitra->nama_perusahaan, 0, 2)) }}
          </span>
        @endif

        <div>
          <div class="flex flex-wrap items-center gap-2.5">
            <h2 class="text-lg font-extrabold text-foreground">{{ $mitra->nama_perusahaan }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">
              ID: #MTR-{{ str_pad((string) $mitra->id_mitra, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
            <x-ui.badge variant="secondary">{{ $mitra->jenis_mitra ?? 'Perusahaan Mitra' }}</x-ui.badge>
          </div>

          <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-muted-foreground">
            <span class="flex items-center gap-1.5">
              <x-lucide-briefcase class="size-3.5" />
              Sektor: {{ $mitra->bidang_usaha ?? 'Umum' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-map-pin class="size-3.5" />
              {{ $mitra->kota ?? 'Kota Tidak Tercatat' }}, {{ $mitra->provinsi ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-phone class="size-3.5" />
              {{ $mitra->no_telp ?? $mitra->telepon ?? '-' }}
            </span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-border sm:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">Status Verifikasi</div>
        @if ($mitra->is_verified)
          <div class="mt-1 flex items-center justify-end gap-1.5 text-xs font-bold text-primary">
            <x-lucide-badge-check class="size-4 text-blue-500" />
            Mitra Terverifikasi
          </div>
        @else
          <div class="mt-1 flex items-center justify-end gap-1.5 text-xs font-bold text-amber-600">
            <x-lucide-clock-3 class="size-4" />
            Menunggu Verifikasi
          </div>
        @endif
      </div>
    </div>
  </x-ui.card>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat label="Total Lowongan Magang" :value="count($mitra->lowongan ?? []) . ' Posisi'" icon="briefcase" />
    <x-ui.stat label="Status Akun" :value="$mitra->is_verified ? 'Terverifikasi' : 'Menunggu Review'" icon="shield-check" />
    <x-ui.stat label="PIC Penanggung Jawab" :value="$mitra->jabatan_pic ?? 'HRD / PIC Industri'" icon="user-check" />
  </div>

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-info class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Informasi Badan Usaha</x-ui.card-title>
                <x-ui.card-description>Rincian legalitas dan kontak resmi perusahaan.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('mitras.edit', $mitra->id_mitra) }}" variant="link" size="sm" class="px-0">
              <x-lucide-pencil />
              Edit
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-x-6 gap-y-4 text-xs sm:grid-cols-2">
            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Nama Perusahaan</span>
              <span class="text-sm font-bold text-foreground">{{ $mitra->nama_perusahaan }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Bidang Usaha</span>
              <span class="font-semibold text-foreground">{{ $mitra->bidang_usaha ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Nomor Izin / NIB</span>
              <span class="font-semibold text-foreground">{{ $mitra->no_izin ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Akun Pengguna Terkait</span>
              <span class="font-semibold text-foreground">
                {{ $mitra->nama ?? 'Tidak ditautkan' }}{{ $mitra->user ? ' (' . $mitra->user->email . ')' : '' }}
              </span>
            </div>

            <div class="sm:col-span-2">
              <span class="mb-1 block font-medium text-muted-foreground">Alamat Kantor / Pabrik</span>
              <span class="font-medium leading-relaxed text-foreground">{{ $mitra->alamat ?? '-' }}</span>
            </div>

            <div class="sm:col-span-2">
              <span class="mb-2 block font-medium text-muted-foreground">Dokumen Pengajuan</span>
              <div class="flex flex-wrap gap-2">
                @if ($mitra->surat_legalitas_path)
                  <x-ui.button href="{{ route('mitras.documents.download', [$mitra, 'legalitas']) }}" variant="outline" size="sm">
                    <x-lucide-file-text /> Surat Legalitas
                  </x-ui.button>
                @endif
                @if ($mitra->surat_permohonan_kerjasama_path)
                  <x-ui.button href="{{ route('mitras.documents.download', [$mitra, 'permohonan']) }}" variant="outline" size="sm">
                    <x-lucide-file-text /> Surat Permohonan Kerja Sama
                  </x-ui.button>
                @endif
              </div>
            </div>

            @if ($mitra->logo_perusahaan)
              <div class="sm:col-span-2">
                <span class="mb-3 block font-medium text-muted-foreground">Logo Perusahaan</span>
                <div class="flex items-center gap-5 rounded-xl border border-border bg-muted/40 p-4">
                  <div class="size-20 shrink-0 overflow-hidden rounded-xl border border-border bg-card shadow-md">
                    <img
                      src="{{ Storage::url($mitra->logo_perusahaan) }}"
                      alt="Logo {{ $mitra->nama_perusahaan }}"
                      class="size-full object-cover"
                    >
                  </div>

                  <div class="min-w-0 flex-1">
                    <div class="truncate text-sm font-semibold text-foreground">{{ $mitra->nama_perusahaan }}</div>
                    <div class="mt-0.5 text-xs text-muted-foreground">Logo Resmi Perusahaan</div>
                    <a
                      href="{{ Storage::url($mitra->logo_perusahaan) }}"
                      target="_blank"
                      class="mt-2.5 inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:underline"
                    >
                      <x-lucide-external-link class="size-3.5" />
                      Lihat ukuran penuh
                    </a>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
        <x-ui.card-header class="border-b pb-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-briefcase class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Lowongan Magang Industri</x-ui.card-title>
                <x-ui.card-description>Daftar posisi magang yang dipublikasikan oleh mitra ini.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('lowongan.create') }}" variant="link" size="sm" class="px-0">
              <x-lucide-plus />
              Buka Lowongan Baru
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="px-0">
          <x-ui.table>
            <x-ui.table-header>
              <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Judul Lowongan</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Lokasi Penempatan</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Tanggal Posting</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status</x-ui.table-head>
                <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
              </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
              @forelse ($mitra->lowongan ?? [] as $lowongan)
                <x-ui.table-row>
                  <x-ui.table-cell class="px-4 py-3 font-bold text-foreground">
                    {{ $lowongan->judul_lowongan }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                    {{ $lowongan->lokasi ?? '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                    {{ $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d M Y') : '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <x-ui.badge variant="secondary" class="capitalize">{{ $lowongan->status ?? 'aktif' }}</x-ui.badge>
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <div class="flex justify-end">
                      <x-ui.button href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" variant="link" size="sm">
                        Detail
                        <x-lucide-chevron-right />
                      </x-ui.button>
                    </div>
                  </x-ui.table-cell>
                </x-ui.table-row>
              @empty
                <x-ui.table-row class="hover:bg-transparent">
                  <x-ui.table-cell colspan="5" class="p-0">
                    <x-ui.empty class="border-0">
                      <x-ui.empty-header>
                        <x-ui.empty-media variant="icon">
                          <x-lucide-briefcase />
                        </x-ui.empty-media>
                        <x-ui.empty-title class="text-base">Belum Ada Lowongan</x-ui.empty-title>
                        <x-ui.empty-description>
                          Belum ada lowongan magang yang dibuka oleh mitra ini.
                        </x-ui.empty-description>
                      </x-ui.empty-header>
                    </x-ui.empty>
                  </x-ui.table-cell>
                </x-ui.table-row>
              @endforelse
            </x-ui.table-body>
          </x-ui.table>
        </x-ui.card-content>
      </x-ui.card>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-phone class="size-4 text-primary" />
            Kontak Cepat PIC
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-phone class="size-4 text-primary" />
            <span>{{ $mitra->no_telp ?? $mitra->telepon ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-user class="size-4 text-primary" />
            <span>{{ $mitra->jabatan_pic ?? 'Representatif Industri' }}</span>
          </div>
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-map-pin class="size-4 text-primary" />
            <span>{{ $mitra->kota ?? '-' }}, {{ $mitra->provinsi ?? '-' }}</span>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-sliders-horizontal class="size-4 text-primary" />
            Aksi Cepat
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-2.5">
          <x-ui.button href="{{ route('mitras.edit', $mitra->id_mitra) }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-pencil />
            Edit Data Mitra
          </x-ui.button>

          <form
            action="{{ route('mitras.destroy', $mitra->id_mitra) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Mitra
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </div>
@endsection
