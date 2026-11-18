@extends('layouts.app')

@section('title', 'Durasi Pelatihan - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Master Durasi Pelatihan"
    description="Kelola referensi durasi program pelatihan berbasis jumlah hari dan jam."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Durasi Pelatihan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('durasi-pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus-circle />
        Tambah Durasi
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
    <x-ui.stat
      label="Total Durasi"
      :value="(isset($durations) ? $durations->total() : 0) . ' Kategori'"
      icon="timer"
    />

    <x-ui.stat
      label="Rentang Hari"
      :value="(isset($durations) && $durations->isNotEmpty() ? $durations->min('hari') . ' - ' . $durations->max('hari') : '—') . ' Hari'"
      icon="calendar-days"
    />

    <x-ui.stat
      label="Total Jam Pelajaran"
      :value="(isset($durations) && $durations->isNotEmpty() ? $durations->sum('jam') : 0) . ' Jam'"
      icon="clock"
    />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Referensi Durasi</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ isset($durations) ? $durations->total() : 0 }} Data</x-ui.badge>
          </div>
          <x-ui.card-description>
            Durasi digunakan sebagai referensi lama pelaksanaan program pelatihan.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('durasi-pelatihan.index')"
          search-placeholder="Cari jumlah hari / jam..."
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">ID</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Durasi</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Hari</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Jam</x-ui.table-head>
            <x-ui.table-head class="px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Program Terkait</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($durations ?? [] as $durasi)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3 font-mono text-xs text-muted-foreground">
                #DUR-{{ str_pad((string) $durasi->id_durasi, 3, '0', STR_PAD_LEFT) }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-primary text-xs font-bold text-primary-foreground">
                    {{ $durasi->hari }}H
                  </span>
                  <a
                    href="{{ route('durasi-pelatihan.show', $durasi->id_durasi) }}"
                    class="font-bold text-foreground transition group-hover:text-primary"
                  >
                    {{ $durasi->durasi_label }}
                  </a>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <x-ui.badge variant="secondary">{{ $durasi->hari }} Hari</x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <x-ui.badge variant="secondary">{{ $durasi->jam }} Jam</x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                <x-ui.badge tone="success" class="gap-1.5">
                  <x-lucide-book class="size-3" />
                  {{ $durasi->pelatihan_count ?? 0 }}
                </x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('durasi-pelatihan.show', $durasi->id_durasi) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Detail"
                    aria-label="Lihat detail durasi {{ $durasi->durasi_label }}"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  <x-ui.button
                    href="{{ route('durasi-pelatihan.edit', $durasi->id_durasi) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit"
                    aria-label="Edit durasi {{ $durasi->durasi_label }}"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('durasi-pelatihan.destroy', $durasi->id_durasi) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus durasi ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus"
                      aria-label="Hapus durasi {{ $durasi->durasi_label }}"
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
                      <x-lucide-timer />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Data Durasi Pelatihan</x-ui.empty-title>
                    <x-ui.empty-description>
                      Belum ada data durasi pelatihan yang ditemukan.
                    </x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search'))
                    <x-ui.button href="{{ route('durasi-pelatihan.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    <x-ui.button href="{{ route('durasi-pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Tambahkan Durasi Pertama
                    </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if (isset($durations) && $durations->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $durations->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
