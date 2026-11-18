@extends('layouts.app')

@section('title', 'Detail Durasi Pelatihan - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Detail Durasi Pelatihan"
    description="Informasi lengkap referensi durasi pelaksanaan program pelatihan."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('durasi-pelatihan.index') }}">Durasi Pelatihan</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Durasi</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('durasi-pelatihan.edit', $durasi->id_durasi) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Durasi
      </x-ui.button>

      <x-ui.button href="{{ route('durasi-pelatihan.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card class="border-primary/30 bg-gradient-to-br from-primary via-[#0d4335] to-[#0a2f26] text-primary-foreground">
    <div class="flex flex-col justify-between gap-4 md:flex-row">
      <div>
        <div class="text-[10px] font-bold uppercase tracking-wider text-sikarir-lime">Master Durasi Pelatihan</div>
        <div class="mt-1 flex flex-wrap items-center gap-2.5">
          <h2 class="text-lg font-extrabold text-white">{{ $durasi->durasi_label }}</h2>
          <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 font-mono text-primary-foreground">
            ID: #DUR-{{ str_pad((string) $durasi->id_durasi, 3, '0', STR_PAD_LEFT) }}
          </x-ui.badge>
        </div>
        <div class="mt-2 flex items-center gap-4 text-xs text-primary-foreground/70">
          <span class="flex items-center gap-1.5">
            <x-lucide-calendar-days class="size-3.5" />
            {{ $durasi->hari }} Hari
          </span>
          <span class="flex items-center gap-1.5">
            <x-lucide-clock class="size-3.5" />
            {{ $durasi->jam }} Jam Pelajaran
          </span>
        </div>
      </div>

      <div class="flex items-center justify-between gap-3 text-right md:block md:border-l md:border-primary-foreground/20 md:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-sikarir-lime">Program Terkait</div>
        <div class="mt-0.5 text-2xl font-black text-white">{{ count($durasi->pelatihan ?? []) }} Program</div>
      </div>
    </div>
  </x-ui.card>

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-info class="size-4 text-primary" />
            Metadata
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Hari:</span>
            <span class="font-bold text-foreground">{{ $durasi->hari }} Hari</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Jam:</span>
            <span class="font-bold text-foreground">{{ $durasi->jam }} Jam</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Dibuat pada:</span>
            <span class="font-bold text-foreground">
              {{ $durasi->created_at ? $durasi->created_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Diperbarui:</span>
            <span class="font-bold text-foreground">
              {{ $durasi->updated_at ? $durasi->updated_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="border-destructive/30 bg-destructive/5">
        <x-ui.card-header class="border-b border-destructive/20">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-destructive">
            <x-lucide-triangle-alert class="size-4" />
            Zona Berbahaya
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Menghapus durasi ini akan membuat program pelatihan terkait kehilangan referensi durasinya.
          </p>

          <form
            action="{{ route('durasi-pelatihan.destroy', $durasi->id_durasi) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus durasi ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Durasi
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>

    <div class="lg:col-span-2">
      <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
        <x-ui.card-header class="border-b pb-5">
          <x-ui.card-title class="flex items-center gap-2 text-base font-bold">
            <x-lucide-book class="size-4 text-primary" />
            Program Pelatihan Terkait
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="px-0">
          <x-ui.table>
            <x-ui.table-header>
              <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Nama Program</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Kuota</x-ui.table-head>
                <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
              </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
              @forelse ($durasi->pelatihan ?? [] as $pelatihan)
                <x-ui.table-row>
                  <x-ui.table-cell class="px-4 py-3 font-bold text-foreground">
                    {{ $pelatihan->nama_pelatihan }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <x-ui.badge variant="secondary">{{ $pelatihan->kuota }} Kursi</x-ui.badge>
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <div class="flex justify-end">
                      <x-ui.button href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}" variant="link" size="sm">
                        Detail
                        <x-lucide-chevron-right />
                      </x-ui.button>
                    </div>
                  </x-ui.table-cell>
                </x-ui.table-row>
              @empty
                <x-ui.table-row class="hover:bg-transparent">
                  <x-ui.table-cell colspan="3" class="p-0">
                    <x-ui.empty class="border-0">
                      <x-ui.empty-header>
                        <x-ui.empty-media variant="icon">
                          <x-lucide-book />
                        </x-ui.empty-media>
                        <x-ui.empty-title class="text-base">Belum Ada Program Terkait</x-ui.empty-title>
                        <x-ui.empty-description>
                          Belum ada program pelatihan yang menggunakan durasi ini.
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
  </div>
@endsection
