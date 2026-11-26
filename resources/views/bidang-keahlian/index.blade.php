@extends('layouts.app')

@section('title', 'Bidang Keahlian - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Master Bidang Keahlian"
    description="Kelola daftar bidang keahlian yang menjadi pilihan saat menambah instruktur."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Bidang Keahlian</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('bidang-keahlian.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus-circle />
        Tambah Bidang
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
    <x-ui.stat label="Total Bidang" :value="(isset($bidangKeahlians) ? $bidangKeahlians->total() : 0) . ' Bidang'" icon="tags" />
    <x-ui.stat label="Instruktur Terdaftar" :value="(isset($bidangKeahlians) && $bidangKeahlians->isNotEmpty() ? $bidangKeahlians->sum('instruktur_count') : 0) . ' Instruktur'" icon="user-check" />
    <x-ui.stat label="Belum Dipakai" :value="(isset($bidangKeahlians) && $bidangKeahlians->isNotEmpty() ? $bidangKeahlians->where('instruktur_count', 0)->count() : 0) . ' Bidang'" icon="circle-dashed" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Bidang Keahlian</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ isset($bidangKeahlians) ? $bidangKeahlians->total() : 0 }} Data</x-ui.badge>
          </div>
          <x-ui.card-description>
            Bidang keahlian menjadi pilihan dropdown saat menambah atau mengubah instruktur.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('bidang-keahlian.index')"
          search-placeholder="Cari bidang keahlian..."
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">ID</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Bidang Keahlian</x-ui.table-head>
            <x-ui.table-head class="px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Jumlah Instruktur</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($bidangKeahlians ?? [] as $bidang)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3 font-mono text-xs font-bold text-muted-foreground">
                #BK-{{ str_pad((string) $bidang->id, 3, '0', STR_PAD_LEFT) }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-primary text-xs font-bold uppercase text-primary-foreground">
                    {{ substr($bidang->nama, 0, 1) }}
                  </span>
                  <span class="font-bold text-foreground">{{ $bidang->nama }}</span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                <x-ui.badge tone="success" class="gap-1">
                  <x-lucide-user-check class="size-3" />
                  {{ $bidang->instruktur_count ?? 0 }}
                </x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('bidang-keahlian.edit', $bidang->id) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit"
                    aria-label="Edit bidang {{ $bidang->nama }}"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('bidang-keahlian.destroy', $bidang->id) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang keahlian ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus"
                      aria-label="Hapus bidang {{ $bidang->nama }}"
                    >
                      <x-lucide-trash-2 />
                    </x-ui.button>
                  </form>
                </div>
              </x-ui.table-cell>
            </x-ui.table-row>
          @empty
            <x-ui.table-row class="hover:bg-transparent">
              <x-ui.table-cell colspan="4" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-tags />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Bidang Keahlian</x-ui.empty-title>
                    <x-ui.empty-description>Belum ada data bidang keahlian yang ditemukan.</x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search'))
                    <x-ui.button href="{{ route('bidang-keahlian.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    <x-ui.button href="{{ route('bidang-keahlian.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Tambahkan Bidang Pertama
                    </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if (isset($bidangKeahlians) && $bidangKeahlians->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $bidangKeahlians->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
