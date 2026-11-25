@extends('layouts.app')

@section('title', 'Manajemen Absensi Peserta - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Manajemen Absensi Peserta"
    description="Kelola pencatatan kehadiran, izin, dan rekapitulasi absensi peserta pelatihan vokasi."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Beranda</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Daftar Absensi</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      @if (auth()->user()?->role === 'admin_blk')
      <x-ui.button href="{{ route('absen.rekap') }}" variant="outline">
        <x-lucide-chart-column />
        Rekapitulasi & Laporan
      </x-ui.button>
      @endif

      @if (auth()->user()?->role === 'admin_blk')
      <x-ui.button href="{{ route('absen.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus />
        Catat Absen
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

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex items-center gap-2.5">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-clipboard-check class="size-4" />
            </span>
            <x-ui.card-title class="text-lg font-bold">Daftar Kehadiran Peserta</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ isset($absens) ? $absens->total() : 0 }} Data</x-ui.badge>
          </div>
          <x-ui.card-description>
            Daftar rekaman absensi harian peserta pelatihan yang terdaftar.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('absen.index')"
          search-placeholder="Cari peserta / pelatihan..."
          :status-options="['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alfa' => 'Alfa']"
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="w-12 px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">#</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Peserta</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Jadwal & Kelas</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Tanggal</x-ui.table-head>
            <x-ui.table-head class="px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($absens as $absen)
            @php
              $status = strtolower($absen->status_kehadiran ?? $absen->status ?? '');
              $tone = match ($status) {
                  'hadir' => 'success',
                  'izin', 'sakit' => 'warning',
                  default => 'danger',
              };
            @endphp

            <x-ui.table-row>
              <x-ui.table-cell class="px-4 py-3 text-center font-medium text-muted-foreground">
                {{ $loop->iteration + ($absens->currentPage() - 1) * $absens->perPage() }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <x-ui.avatar class="size-8">
                    <x-ui.avatar-fallback class="bg-muted text-xs font-bold text-muted-foreground">
                      {{ strtoupper(substr($absen->peserta->nama ?? 'P', 0, 2)) }}
                    </x-ui.avatar-fallback>
                  </x-ui.avatar>
                  <div class="min-w-0">
                    <div class="font-bold text-foreground">{{ $absen->peserta->nama ?? 'Tanpa Nama' }}</div>
                    <div class="text-xs text-muted-foreground">{{ $absen->peserta->user->email ?? '-' }}</div>
                  </div>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-medium text-foreground">
                  <x-lucide-book-open class="size-3.5 text-muted-foreground" />
                  <span>{{ $absen->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-medium text-foreground">
                  <x-lucide-calendar class="size-3.5 text-muted-foreground" />
                  <span>{{ $absen->tanggal ? \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') : '-' }}</span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                <x-ui.badge :tone="$tone" class="gap-1.5 capitalize">
                  <span class="size-1.5 rounded-full bg-current"></span>
                  {{ $absen->status_kehadiran ?? $absen->status ?? '-' }}
                </x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('absen.show', $absen->id_absen) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Lihat Detail"
                    aria-label="Lihat detail absensi"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  @if (auth()->user()?->role === 'admin_blk')
                  <x-ui.button
                    href="{{ route('absen.edit', $absen->id_absen) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit Data"
                    aria-label="Edit data absensi"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('absen.destroy', $absen->id_absen) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus Data"
                      aria-label="Hapus data absensi"
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
                      <x-lucide-clipboard-x />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Data Absensi</x-ui.empty-title>
                    <x-ui.empty-description>
                      Belum ada data absensi yang ditemukan.
                    </x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search') || request('status'))
                    <x-ui.button href="{{ route('absen.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    @if (auth()->user()?->role === 'admin_blk')
                    <x-ui.button href="{{ route('absen.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Catat Absensi Pertama
                    </x-ui.button>
                    @endif
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if (isset($absens) && $absens->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $absens->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
