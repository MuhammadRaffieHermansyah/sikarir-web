@extends('layouts.app')

@section('title', 'Jadwal & Agenda Pelatihan Vokasi - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Jadwal & Batch Kelas Vokasi"
    description="Pantau periode pelaksanaan kursus, ketersediaan ruangan bengkel kerja, dan instruktur pengampu."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Jadwal &amp; Kelas</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('jadwal-pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus />
        Buat Batch Jadwal
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  @if (session('success'))
    <x-ui.alert tone="success">
      <x-lucide-circle-check-big />
      <x-ui.alert-description>{{ session('success') }}</x-ui.alert-description>
    </x-ui.alert>
  @endif

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat label="Total Batch Jadwal" :value="$jadwals->total() . ' Batch'" icon="calendar" />
    <x-ui.stat label="Sedang Berlangsung" :value="($countBerlangsung ?? 0) . ' Batch'" icon="play-circle" />
    <x-ui.stat label="Pendaftaran Tersedia" :value="($countTersedia ?? 0) . ' Batch'" icon="door-open" />
    <x-ui.stat label="Batch Selesai" :value="($countSelesai ?? 0) . ' Batch'" icon="circle-check" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Agenda Jadwal &amp; Kelas Kerja</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ $jadwals->total() }} Batch</x-ui.badge>
          </div>
          <x-ui.card-description>
            Daftar periode waktu kelas dan instruktur pembimbing.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('jadwal-pelatihan.index')"
          search-placeholder="Cari kejuruan, instruktur..."
          :status-options="['tersedia' => 'Tersedia', 'berlangsung' => 'Berlangsung', 'selesai' => 'Selesai']"
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">ID Batch</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Program Kejuruan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Periode Pelaksanaan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Instruktur &amp; Ruang</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status Kelas</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Siswa Terdaftar</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($jadwals as $jadwal)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3 font-mono text-xs font-bold text-muted-foreground">
                #JDW-{{ str_pad((string) $jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="font-bold text-foreground transition group-hover:text-primary">
                  {{ $jadwal->pelatihan->nama_pelatihan ?? 'Kejuruan Tidak Ditemukan' }}
                </div>
                <div class="text-xs text-muted-foreground">
                  Kuota Maks: {{ $jadwal->pelatihan->kuota ?? '16' }} Siswa
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-bold text-foreground">
                  <x-lucide-calendar class="size-3.5 text-primary" />
                  {{ $jadwal->tanggal_mulai ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_mulai)->translatedFormat('d M Y') : '-' }}
                </div>
                <div class="mt-0.5 flex items-center gap-1.5 text-xs font-bold text-muted-foreground">
                  s/d {{ $jadwal->tanggal_selesai ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_selesai)->translatedFormat('d M Y') : '-' }}
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-medium text-foreground">
                  <x-lucide-user class="size-3.5 text-muted-foreground" />
                  {{ $jadwal->instruktur?->nama ?? 'Instruktur Belum Ditunjuk' }}
                </div>
                <div class="mt-0.5 flex items-center gap-1 text-xs text-muted-foreground">
                  <x-lucide-map-pin class="size-3" />
                  {{ $jadwal->ruanganWorkshop?->nama_ruangan ?? '-' }}
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                @if ($jadwal->status === 'tersedia')
                  <x-ui.badge tone="success" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    Tersedia
                  </x-ui.badge>
                @elseif ($jadwal->status === 'berlangsung')
                  <x-ui.badge tone="info" class="gap-1.5">
                    <span class="size-1.5 animate-pulse rounded-full bg-current"></span>
                    Berlangsung
                  </x-ui.badge>
                @else
                  <x-ui.badge tone="neutral" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    Selesai
                  </x-ui.badge>
                @endif
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <span class="font-bold text-foreground">{{ $jadwal->kelas_count }}</span>
                <span class="text-xs text-muted-foreground"> / {{ $jadwal->pelatihan->kuota ?? '16' }} Siswa</span>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Lihat Detail"
                    aria-label="Lihat detail jadwal"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  <x-ui.button
                    href="{{ route('jadwal-pelatihan.edit', $jadwal->id_jadwal) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit Jadwal"
                    aria-label="Edit jadwal"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('jadwal-pelatihan.destroy', $jadwal->id_jadwal) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus Data"
                      aria-label="Hapus jadwal"
                    >
                      <x-lucide-trash-2 />
                    </x-ui.button>
                  </form>
                </div>
              </x-ui.table-cell>
            </x-ui.table-row>
          @empty
            <x-ui.table-row class="hover:bg-transparent">
              <x-ui.table-cell colspan="7" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-calendar />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Jadwal &amp; Kelas Ditemukan</x-ui.empty-title>
                    <x-ui.empty-description>
                      Coba ubah kata kunci pencarian atau reset filter status kelas.
                    </x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search') || request('status'))
                    <x-ui.button href="{{ route('jadwal-pelatihan.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    <x-ui.button href="{{ route('jadwal-pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Buat Batch Jadwal
                    </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if ($jadwals->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $jadwals->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
