@extends('layouts.app')

@section('title', 'Mitra Industri DU/DI - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Kemitraan Dunia Usaha & Industri (DU/DI)"
    description="Kelola kerjasama perusahaan mitra vokasi, ketersediaan kuota magang, dan penempatan kerja peserta."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Mitra Industri DU/DI</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('mitras.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus-circle />
        Tambah Mitra DU/DI
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  @if (session('success'))
    <x-ui.alert tone="success">
      <x-lucide-circle-check-big />
      <x-ui.alert-description>{{ session('success') }}</x-ui.alert-description>
    </x-ui.alert>
  @endif

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat label="Total Mitra DU/DI" :value="(isset($mitras) ? $mitras->total() : 0) . ' Perusahaan'" icon="building-2" />
    <x-ui.stat label="Status Kerjasama" value="100% Aktif" icon="briefcase" />
    <x-ui.stat label="Verifikasi Industri" value="Terstandarisasi BLK" icon="check-check" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Perusahaan & Industri Rekanan</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ isset($mitras) ? $mitras->total() : 0 }} Rekanan</x-ui.badge>
          </div>
          <x-ui.card-description>
            Daftar mitra industri tempat pelaksanaan program magang bersertifikat.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('mitras.index')"
          search-placeholder="Cari perusahaan, kota, PIC..."
          status-name="jenis_mitra"
          status-placeholder="Semua Jenis Mitra"
          :status-options="collect($jenisMitraList)->mapWithKeys(fn ($item) => [$item => $item])->toArray()"
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Perusahaan & Industri</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Bidang Usaha</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Wilayah / Lokasi</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Kontak & PIC</x-ui.table-head>
            <x-ui.table-head class="px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Lowongan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($mitras ?? [] as $mitra)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3.5">
                  @if ($mitra->logo_perusahaan)
                    <div class="size-11 shrink-0 overflow-hidden rounded-xl border border-border bg-card shadow-sm">
                      <img
                        src="{{ Storage::url($mitra->logo_perusahaan) }}"
                        alt="Logo {{ $mitra->nama_perusahaan }}"
                        class="size-full object-cover"
                        onerror="this.style.display='none';"
                      >
                    </div>
                  @else
                    <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary text-xs font-bold text-primary-foreground">
                      {{ strtoupper(substr($mitra->nama_perusahaan, 0, 2)) }}
                    </span>
                  @endif

                  <div class="min-w-0">
                    <a
                      href="{{ route('mitras.show', $mitra->id_mitra) }}"
                      class="font-bold text-foreground transition group-hover:text-primary"
                    >
                      {{ $mitra->nama_perusahaan }}
                    </a>
                    <div class="text-xs text-muted-foreground">
                      ID: #MTR-{{ str_pad((string) $mitra->id_mitra, 3, '0', STR_PAD_LEFT) }} • {{ $mitra->jenis_mitra ?? 'Perusahaan Swasta' }}
                    </div>
                  </div>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <x-ui.badge variant="secondary">{{ $mitra->bidang_usaha ?? 'Umum' }}</x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1 font-medium text-foreground">
                  <x-lucide-map-pin class="size-3.5 text-muted-foreground" />
                  <span>{{ $mitra->kota ?? 'Kota Tidak Tercatat' }}</span>
                </div>
                <div class="text-xs text-muted-foreground">{{ $mitra->provinsi ?? '-' }}</div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1 font-medium text-foreground">
                  <x-lucide-phone class="size-3.5 text-muted-foreground" />
                  <span>{{ $mitra->no_telp ?? $mitra->telepon ?? '-' }}</span>
                </div>
                <div class="text-xs text-muted-foreground">{{ $mitra->jabatan_pic ?? 'PIC Industri' }}</div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                <x-ui.badge tone="success" class="gap-1">
                  <x-lucide-briefcase class="size-3" />
                  {{ count($mitra->lowongan ?? []) }}
                </x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('mitras.show', $mitra->id_mitra) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Detail"
                    aria-label="Lihat detail mitra {{ $mitra->nama_perusahaan }}"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  <x-ui.button
                    href="{{ route('mitras.edit', $mitra->id_mitra) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit"
                    aria-label="Edit mitra {{ $mitra->nama_perusahaan }}"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('mitras.destroy', $mitra->id_mitra) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus"
                      aria-label="Hapus mitra {{ $mitra->nama_perusahaan }}"
                    >
                      <x-lucide-trash-2 />
                    </x-ui.button>
                  </form>
                </div>
              </x-ui.table-cell>
            </x-ui.table-row>
          @empty
            <x-ui.table-row class="hover:bg-transparent">
              <x-ui.table-cell colspan="6" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-building-2 />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Data Mitra DU/DI</x-ui.empty-title>
                    <x-ui.empty-description>Belum ada data Mitra DU/DI yang ditemukan.</x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search') || request('jenis_mitra'))
                    <x-ui.button href="{{ route('mitras.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    <x-ui.button href="{{ route('mitras.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Tambahkan Mitra Pertama
                    </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if (isset($mitras) && $mitras->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $mitras->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
