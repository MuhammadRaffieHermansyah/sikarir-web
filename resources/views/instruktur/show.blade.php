@extends('layouts.app')

@section('title', 'Detail Instruktur - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Detail Instruktur"
    description="Informasi lengkap instruktur beserta jadwal & kelas yang diampu."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('instruktur.index') }}">Instruktur</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Instruktur</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-reset-sandi.tombol :user="$instruktur->user" />

      <x-ui.button href="{{ route('instruktur.edit', $instruktur->id) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Instruktur
      </x-ui.button>

      <x-ui.button href="{{ route('instruktur.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-reset-sandi.hasil :user="$instruktur->user" />

  <x-ui.card class="border-primary/30 bg-gradient-to-br from-primary via-[#0d4335] to-[#0a2f26] text-primary-foreground">
    <div class="flex flex-col justify-between gap-4 md:flex-row">
      <div>
        <div class="text-[10px] font-bold uppercase tracking-wider text-sikarir-lime">Master Instruktur</div>
        <div class="mt-1 flex flex-wrap items-center gap-2.5">
          <h2 class="text-lg font-extrabold text-white">{{ $instruktur->nama }}</h2>
          <x-ui.badge class="border-primary-foreground/25 bg-primary-foreground/10 font-mono text-primary-foreground">
            ID: #INS-{{ str_pad((string) $instruktur->id, 3, '0', STR_PAD_LEFT) }}
          </x-ui.badge>
        </div>
        <div class="mt-2 flex items-center gap-4 text-xs text-primary-foreground/70">
          <span class="flex items-center gap-1.5">
            <x-lucide-graduation-cap class="size-3.5" />
            {{ $instruktur->bidang_keahlian }}
          </span>
        </div>
      </div>

      <div class="flex items-center justify-between gap-3 text-right md:block md:border-l md:border-primary-foreground/20 md:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-sikarir-lime">Jadwal Diampu</div>
        <div class="mt-0.5 text-2xl font-black text-white">{{ count($instruktur->jadwal ?? []) }} Jadwal</div>
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
            <span class="text-muted-foreground">Nama:</span>
            <span class="font-bold text-foreground">{{ $instruktur->nama }}</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Bidang Keahlian:</span>
            <span class="font-bold text-foreground">{{ $instruktur->bidang_keahlian }}</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Dibuat pada:</span>
            <span class="font-bold text-foreground">
              {{ $instruktur->created_at ? $instruktur->created_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Diperbarui:</span>
            <span class="font-bold text-foreground">
              {{ $instruktur->updated_at ? $instruktur->updated_at->translatedFormat('d M Y') : '-' }}
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
            Menghapus instruktur ini akan membuat jadwal & kelas terkait kehilangan penugasan instruktur (tidak dihapus).
          </p>

          <form
            action="{{ route('instruktur.destroy', $instruktur->id) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus instruktur ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Instruktur
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>

    <div class="lg:col-span-2">
      <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
        <x-ui.card-header class="border-b pb-5">
          <x-ui.card-title class="flex items-center gap-2 text-base font-bold">
            <x-lucide-calendar-clock class="size-4 text-primary" />
            Jadwal & Kelas Diampu
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="px-0">
          <x-ui.table>
            <x-ui.table-header>
              <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Program</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Periode</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status</x-ui.table-head>
                <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
              </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
              @forelse ($instruktur->jadwal ?? [] as $jadwal)
                <x-ui.table-row>
                  <x-ui.table-cell class="px-4 py-3 font-bold text-foreground">
                    {{ $jadwal->pelatihan?->nama_pelatihan ?? 'Program dihapus' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 text-xs font-semibold text-muted-foreground">
                    {{ $jadwal->tanggal_mulai?->format('d M Y') }} &mdash; {{ $jadwal->tanggal_selesai?->format('d M Y') }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <x-ui.badge variant="secondary">{{ ucfirst($jadwal->status) }}</x-ui.badge>
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <div class="flex justify-end">
                      <x-ui.button href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}" variant="link" size="sm">
                        Detail
                        <x-lucide-chevron-right />
                      </x-ui.button>
                    </div>
                  </x-ui.table-cell>
                </x-ui.table-row>
              @empty
                <x-ui.table-row class="hover:bg-transparent">
                  <x-ui.table-cell colspan="4" class="p-0">
                    <x-ui.empty class="border-0">
                      <x-ui.empty-header>
                        <x-ui.empty-media variant="icon">
                          <x-lucide-calendar-clock />
                        </x-ui.empty-media>
                        <x-ui.empty-title class="text-base">Belum Ada Penugasan</x-ui.empty-title>
                        <x-ui.empty-description>
                          Instruktur ini belum ditugaskan pada jadwal & kelas.
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
