@extends('layouts.app')

@section('title', 'Manajemen Kelas Pelatihan Vokasi - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Roster & Peserta Kelas Vokasi"
    description="Penetapan penempatan siswa ke dalam batch kejuruan pelatihan kerja aktif."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Kelas Pelatihan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('jadwal-pelatihan.index') }}" variant="outline">
        <x-lucide-calendar />
        Jadwal Batch
      </x-ui.button>

      <x-ui.button href="{{ route('kelas-pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-user-plus />
        Masukkan Siswa ke Kelas
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
    <x-ui.stat label="Total Terdaftar" :value="$kelas->total() . ' Peserta'" icon="graduation-cap" />
    <x-ui.stat label="Status Terdaftar" :value="$kelas->where('status', 'terdaftar')->count() . ' Siswa'" icon="user-check" />
    <x-ui.stat label="Kelas Aktif" :value="$kelas->where('status', 'aktif')->count() . ' Siswa'" icon="activity" />
    <x-ui.stat label="Kelulusan Vokasi" :value="$kelas->where('status', 'lulus')->count() . ' Lulus'" icon="award" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
          <x-ui.card-title class="text-lg font-bold">Daftar Roster Penempatan Siswa</x-ui.card-title>
          <x-ui.card-description>Siswa yang dialokasikan ke masing-masing batch kejuruan.</x-ui.card-description>
        </div>

        <div class="w-full sm:w-64">
          <x-ui.input type="text" placeholder="Cari siswa / kejuruan..." aria-label="Cari siswa atau kejuruan">
            <x-slot:leading>
              <x-lucide-search />
            </x-slot:leading>
          </x-ui.input>
        </div>
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">ID Kelas</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Siswa Peserta</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Program Kejuruan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Batch & Jadwal</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status Siswa</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($kelas as $item)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3 font-mono text-xs font-bold text-muted-foreground">
                #KLS-{{ str_pad((string) $item->id_kelas, 3, '0', STR_PAD_LEFT) }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-xs font-black text-accent-foreground">
                    {{ strtoupper(substr($item->peserta->user->name ?? 'P', 0, 2)) }}
                  </span>
                  <div class="min-w-0">
                    <a
                      href="{{ route('pesertas.show', $item->id_peserta) }}"
                      class="font-bold text-foreground transition group-hover:text-primary"
                    >
                      {{ $item->peserta->user->name ?? 'Peserta Tidak Ditemukan' }}
                    </a>
                    <div class="text-xs text-muted-foreground">
                      NIS: {{ $item->peserta->nomor_peserta ?? '-' }}
                    </div>
                  </div>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="font-semibold text-foreground">{{ $item->jadwal->pelatihan->nama_pelatihan ?? '-' }}</div>
                <div class="text-xs text-muted-foreground">Instruktur: {{ $item->jadwal->instruktur ?? '-' }}</div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 text-xs font-medium text-foreground">
                  <x-lucide-calendar class="size-3.5 text-muted-foreground" />
                  {{ $item->jadwal->tanggal_mulai ? $item->jadwal->tanggal_mulai->translatedFormat('d M') : '-' }} - {{ $item->jadwal->tanggal_selesai ? $item->jadwal->tanggal_selesai->translatedFormat('d M Y') : '-' }}
                </div>
                <div class="mt-0.5 text-xs text-muted-foreground">
                  Lokasi: {{ $item->jadwal->tempat ?? 'Workshop BLK' }}
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                @if ($item->status === 'lulus')
                  <x-ui.badge tone="success" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    Lulus
                  </x-ui.badge>
                @elseif ($item->status === 'aktif')
                  <x-ui.badge tone="info" class="gap-1.5">
                    <span class="size-1.5 animate-pulse rounded-full bg-current"></span>
                    Aktif
                  </x-ui.badge>
                @elseif ($item->status === 'tidak lulus')
                  <x-ui.badge tone="danger" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-current"></span>
                    Tidak Lulus
                  </x-ui.badge>
                @else
                  <x-ui.badge variant="secondary" class="gap-1.5">
                    <span class="size-1.5 rounded-full bg-muted-foreground"></span>
                    Terdaftar
                  </x-ui.badge>
                @endif
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('kelas-pelatihan.show', $item->id_kelas) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Lihat Detail"
                    aria-label="Lihat detail kelas {{ $item->peserta->user->name ?? '' }}"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  <x-ui.button
                    href="{{ route('kelas-pelatihan.edit', $item->id_kelas) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit Status"
                    aria-label="Edit status kelas {{ $item->peserta->user->name ?? '' }}"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('kelas-pelatihan.destroy', $item->id_kelas) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini dari kelas?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus Dari Kelas"
                      aria-label="Hapus peserta dari kelas"
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
                      <x-lucide-graduation-cap />
                    </x-ui.empty-media>
                    <x-ui.empty-title>Belum Ada Siswa Didaftarkan ke Kelas</x-ui.empty-title>
                    <x-ui.empty-description>
                      Alokasikan siswa terdaftar ke batch jadwal yang sesuai untuk memulai kegiatan pelatihan.
                    </x-ui.empty-description>
                  </x-ui.empty-header>

                  <x-ui.button href="{{ route('kelas-pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                    <x-lucide-user-plus />
                    Masukkan Siswa
                  </x-ui.button>
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if ($kelas->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $kelas->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
