@extends('layouts.app')

@section('title', 'Manajemen Sertifikat - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Manajemen Sertifikat Peserta"
    description="Kelola data terbitan sertifikat kelulusan pelatihan vokasi dan dokumen digital peserta."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Beranda</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Sertifikasi</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      @if (auth()->user()?->role === 'admin_blk')
      <x-ui.button href="{{ route('sertifikat.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus />
        Tambah Sertifikat
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
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Sertifikat Diterbitkan</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ isset($sertifikats) ? $sertifikats->total() : 0 }} Berkas</x-ui.badge>
          </div>
          <x-ui.card-description>
            Daftar sertifikat kompetensi resmi yang diterbitkan oleh Balai Latihan Kerja.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('sertifikat.index')"
          search-placeholder="Cari no sertifikat, peserta, pelatihan..."
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="w-12 px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">#</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Peserta</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Program Pelatihan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">No. Sertifikat</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Tanggal Terbit</x-ui.table-head>
            <x-ui.table-head class="px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Berkas PDF</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($sertifikats as $sertifikat)
            <x-ui.table-row>
              <x-ui.table-cell class="px-4 py-3 text-center font-medium text-muted-foreground">
                {{ $loop->iteration + ($sertifikats->currentPage() - 1) * $sertifikats->perPage() }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <x-ui.avatar class="size-8">
                    <x-ui.avatar-fallback class="bg-muted text-xs font-bold text-muted-foreground">
                      {{ strtoupper(substr($sertifikat->peserta->nama ?? 'P', 0, 2)) }}
                    </x-ui.avatar-fallback>
                  </x-ui.avatar>
                  <div class="min-w-0">
                    <div class="font-bold text-foreground">{{ $sertifikat->peserta->nama ?? 'Tanpa Nama' }}</div>
                    <div class="text-xs text-muted-foreground">{{ $sertifikat->peserta->user->email ?? '-' }}</div>
                  </div>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-medium text-foreground">
                  <x-lucide-book-open class="size-3.5 text-muted-foreground" />
                  <span>{{ $sertifikat->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <x-ui.badge variant="secondary" class="gap-1 font-mono">
                  <x-lucide-file-badge class="size-3 text-primary" />
                  {{ $sertifikat->no_sertifikat ?? $sertifikat->nomor_sertifikat ?? '-' }}
                </x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-medium text-foreground">
                  <x-lucide-calendar class="size-3.5 text-muted-foreground" />
                  <span>{{ $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->translatedFormat('d M Y') : '-' }}</span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                @if ($sertifikat->file_sertifikat)
                  <x-ui.badge tone="success" href="{{ Storage::url($sertifikat->file_sertifikat) }}" target="_blank" class="gap-1">
                    <x-lucide-file-text class="size-3.5" />
                    Lihat PDF
                  </x-ui.badge>
                @else
                  <span class="inline-flex items-center gap-1 text-xs text-muted-foreground">
                    <x-lucide-file-x class="size-3.5" />
                    Belum Ada
                  </span>
                @endif
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('sertifikat.show', $sertifikat->id_sertifikat) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Lihat Detail"
                    aria-label="Lihat detail sertifikat"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  @if (auth()->user()?->role === 'admin_blk')
                  <x-ui.button
                    href="{{ route('sertifikat.edit', $sertifikat->id_sertifikat) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit Data"
                    aria-label="Edit sertifikat"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('sertifikat.destroy', $sertifikat->id_sertifikat) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini beserta filenya?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus Sertifikat"
                      aria-label="Hapus sertifikat"
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
              <x-ui.table-cell colspan="7" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-award />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Sertifikat Diterbitkan</x-ui.empty-title>
                    <x-ui.empty-description>
                      Belum ada data sertifikat yang diterbitkan.
                    </x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (auth()->user()?->role === 'admin_blk')
                  <x-ui.button href="{{ route('sertifikat.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                    <x-lucide-plus />
                    Terbitkan Sertifikat Pertama
                  </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if (isset($sertifikats) && $sertifikats->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $sertifikats->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
