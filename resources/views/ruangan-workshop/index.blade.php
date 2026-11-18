@extends('layouts.app')

@section('title', 'Ruangan Workshop - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Master Ruangan Workshop"
    description="Kelola daftar ruangan workshop yang dapat digunakan pada jadwal & kelas."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Ruangan Workshop</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('ruangan-workshop.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus-circle />
        Tambah Ruangan
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
    <x-ui.stat label="Total Ruangan" :value="(isset($ruanganWorkshops) ? $ruanganWorkshops->total() : 0) . ' Ruangan'" icon="building-2" />
    <x-ui.stat label="Jadwal Terpakai" :value="(isset($ruanganWorkshops) && $ruanganWorkshops->isNotEmpty() ? $ruanganWorkshops->sum('jadwal_count') : 0) . ' Jadwal'" icon="calendar-fold" />
    <x-ui.stat label="Ruangan Kosong" :value="(isset($ruanganWorkshops) && $ruanganWorkshops->isNotEmpty() ? $ruanganWorkshops->where('jadwal_count', 0)->count() : 0) . ' Ruangan'" icon="door-open" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Ruangan Workshop</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ isset($ruanganWorkshops) ? $ruanganWorkshops->total() : 0 }} Data</x-ui.badge>
          </div>
          <x-ui.card-description>
            Ruangan workshop menjadi pilihan saat membuat batch jadwal & kelas.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('ruangan-workshop.index')"
          search-placeholder="Cari nama ruangan..."
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">ID</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Nama Ruangan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Jadwal Terpakai</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($ruanganWorkshops ?? [] as $ruangan)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3 font-mono text-xs font-bold text-muted-foreground">
                #RW-{{ str_pad((string) $ruangan->id, 3, '0', STR_PAD_LEFT) }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-primary text-xs font-bold uppercase text-primary-foreground">
                    {{ substr($ruangan->nama_ruangan, 0, 1) }}
                  </span>
                  <span class="font-bold text-foreground">{{ $ruangan->nama_ruangan }}</span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                <x-ui.badge tone="success" class="gap-1">
                  <x-lucide-calendar-days class="size-3" />
                  {{ $ruangan->jadwal_count ?? 0 }}
                </x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('ruangan-workshop.edit', $ruangan->id) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit"
                    aria-label="Edit ruangan {{ $ruangan->nama_ruangan }}"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('ruangan-workshop.destroy', $ruangan->id) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus"
                      aria-label="Hapus ruangan {{ $ruangan->nama_ruangan }}"
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
                      <x-lucide-building-2 />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Ruangan Workshop</x-ui.empty-title>
                    <x-ui.empty-description>Belum ada data ruangan workshop yang ditemukan.</x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search'))
                    <x-ui.button href="{{ route('ruangan-workshop.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    <x-ui.button href="{{ route('ruangan-workshop.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Tambahkan Ruangan Pertama
                    </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if (isset($ruanganWorkshops) && $ruanganWorkshops->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $ruanganWorkshops->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
