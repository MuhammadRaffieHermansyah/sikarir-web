@extends('layouts.app')

@section('title', 'Lowongan Magang Industri - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Lowongan Magang Industri DU/DI"
    description="Kelola posisi magang yang dipublikasikan mitra industri untuk penyaluran siswa vokasi."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Lowongan Magang</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      @if (auth()->user()->role === 'mitra')
        <x-ui.button href="{{ route('lowongan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
          <x-lucide-plus />
          Buka Lowongan Baru
        </x-ui.button>
      @endif
    </x-slot:actions>
  </x-ui.page-header>

  @if (session('success'))
    <x-ui.alert tone="success">
      <x-lucide-circle-check-big />
      <x-ui.alert-description>{{ session('success') }}</x-ui.alert-description>
    </x-ui.alert>
  @endif

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat label="Total Lowongan" :value="$lowongans->total() . ' Posisi'" icon="briefcase" />
    <x-ui.stat label="Lowongan Aktif" :value="($countAktif ?? 0) . ' Tersedia'" icon="door-open" />
    <x-ui.stat label="Draft / Ditutup" :value="(($countDraft ?? 0) + ($countDitutup ?? 0)) . ' Posisi'" icon="file-text" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Lowongan Magang Industri</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ $lowongans->total() }} Posisi</x-ui.badge>
          </div>
          <x-ui.card-description>
            Posisi magang yang diterima dari mitra DU/DI untuk penyaluran lulusan vokasi.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('lowongan.index')"
          search-placeholder="Cari posisi, mitra, lokasi..."
          :status-options="['aktif' => 'Aktif', 'draft' => 'Draft', 'ditutup' => 'Ditutup']"
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">ID</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Posisi & Perusahaan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Lokasi</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Tgl Posting</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($lowongans as $lowongan)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3 font-mono text-xs font-bold text-muted-foreground">
                #LWG-{{ str_pad((string) $lowongan->id_lowongan, 3, '0', STR_PAD_LEFT) }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  @if ($lowongan->gambar_url)
                    <img src="{{ $lowongan->gambar_thumb_url }}" alt="{{ $lowongan->judul_lowongan }}"
                      class="size-9 shrink-0 rounded-lg object-cover" loading="lazy">
                  @else
                    <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-muted text-xs font-black text-foreground">
                      {{ strtoupper(substr($lowongan->mitra->nama_perusahaan ?? 'M', 0, 2)) }}
                    </span>
                  @endif
                  <div class="min-w-0">
                    <a
                      href="{{ route('lowongan.show', $lowongan->id_lowongan) }}"
                      class="font-bold text-foreground transition group-hover:text-primary"
                    >
                      {{ $lowongan->judul_lowongan }}
                    </a>
                    <div class="text-xs text-muted-foreground">
                      {{ $lowongan->mitra->nama_perusahaan ?? 'Mitra Tidak Tercatat' }}
                    </div>
                  </div>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-medium text-foreground">
                  <x-lucide-map-pin class="size-3.5 text-muted-foreground" />
                  {{ $lowongan->lokasi ?? 'Lokasi Fleksibel' }}
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                {{ $lowongan->tanggal_posting ? \Illuminate\Support\Carbon::parse($lowongan->tanggal_posting)->translatedFormat('d M Y') : '-' }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                @if ($lowongan->status === 'aktif')
                  <x-ui.badge tone="success" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    Aktif
                  </x-ui.badge>
                @elseif ($lowongan->status === 'draft')
                  <x-ui.badge tone="warning" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    Draft
                  </x-ui.badge>
                @else
                  <x-ui.badge tone="danger" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    Ditutup
                  </x-ui.badge>
                @endif
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('lowongan.show', $lowongan->id_lowongan) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Lihat Detail"
                    aria-label="Lihat detail lowongan {{ $lowongan->judul_lowongan }}"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  @if (auth()->user()->role == 'mitra')
                    <x-ui.button
                      href="{{ route('lowongan.edit', $lowongan->id_lowongan) }}"
                      variant="ghost"
                      size="icon-sm"
                      title="Edit Lowongan"
                      aria-label="Edit lowongan {{ $lowongan->judul_lowongan }}"
                    >
                      <x-lucide-pencil />
                    </x-ui.button>

                    <form
                      action="{{ route('lowongan.destroy', $lowongan->id_lowongan) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')"
                    >
                      @csrf
                      @method('DELETE')

                      <x-ui.button
                        type="submit"
                        variant="ghost"
                        size="icon-sm"
                        class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                        title="Hapus Lowongan"
                        aria-label="Hapus lowongan {{ $lowongan->judul_lowongan }}"
                      >
                        <x-lucide-trash-2 />
                      </x-ui.button>
                    </form>
                  @endif
                </div>
              </x-ui.table-cell>
            </x-ui.table-row>
          @empty
            <x-ui.table-row class="hover:bg-transparent">
              <x-ui.table-cell colspan="6" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-briefcase />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Lowongan Magang Ditemukan</x-ui.empty-title>
                    <x-ui.empty-description>
                      Coba ubah kata kunci pencarian atau reset filter status lowongan.
                    </x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search') || request('status'))
                    <x-ui.button href="{{ route('lowongan.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    <x-ui.button href="{{ route('lowongan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Buka Lowongan
                    </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if ($lowongans->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $lowongans->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
