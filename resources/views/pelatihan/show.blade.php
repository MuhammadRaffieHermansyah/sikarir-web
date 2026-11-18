@extends('layouts.app')

@section('title', 'Detail Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
  <x-ui.page-header
    title="{{ $pelatihan->nama_pelatihan }}"
    description="Spesifikasi kompetensi vokasi, silabus pembelajaran, kapasitas kuota, dan jadwal batch pelaksanaan kelas."
  >
    <x-slot:actions>
      <x-ui.badge variant="secondary" class="gap-1.5 uppercase tracking-wide">
        <span class="size-1.5 animate-pulse rounded-full bg-sikarir-lime"></span>
        Rincian Kurikulum & Kelas
      </x-ui.badge>

      <x-ui.button href="{{ route('pelatihan.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>

      <x-ui.button href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Kurikulum
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  @if ($pelatihan->gambar_url)
    <x-ui.card class="overflow-hidden p-0">
      <img
        src="{{ $pelatihan->gambar_url }}"
        alt="Poster {{ $pelatihan->nama_pelatihan }}"
        class="max-h-96 w-full object-cover"
      >
    </x-ui.card>
  @endif

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat
      label="Total Batch Jadwal"
      :value="count($pelatihan->jadwal ?? []) . ' Batch'"
      icon="calendar"
    />

    <x-ui.stat
      label="Kapasitas / Angkatan"
      :value="$pelatihan->kuota . ' Peserta'"
      icon="users"
    />

    <x-ui.stat label="Standar Sertifikasi" value="BNSP & SKKNI" icon="award" />
  </div>

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-file-text class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Deskripsi Silabus & Output Kejuruan</x-ui.card-title>
              <x-ui.card-description>Materi dan keahlian kerja yang dipelajari selama pelatihan vokasi.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="whitespace-pre-line rounded-xl border border-border bg-muted/40 p-5 text-sm leading-relaxed text-foreground">
            {{ $pelatihan->deskripsi_pelatihan ?: 'Belum ada silabus / deskripsi pelatihan yang ditambahkan untuk kejuruan ini.' }}
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
        <x-ui.card-header class="border-b pb-5">
          <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-calendar-check class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Batch & Jadwal Kelas</x-ui.card-title>
                <x-ui.card-description>Jadwal yang dibuka untuk program kejuruan ini.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('jadwal-pelatihan.create') }}" variant="outline" size="sm">
              <x-lucide-plus />
              Buka Batch Baru
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="px-0">
          <x-ui.table>
            <x-ui.table-header>
              <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Instruktur</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Ruangan</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Hari & Jam</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Peserta Terdaftar</x-ui.table-head>
                <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
              </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
              @forelse ($pelatihan->jadwal ?? [] as $jadwal)
                <x-ui.table-row>
                  <x-ui.table-cell class="px-4 py-3 font-bold text-foreground">{{ $jadwal->instruktur ?? '-' }}</x-ui.table-cell>
                  <x-ui.table-cell class="px-4 py-3 font-medium text-muted-foreground">{{ $jadwal->ruangan ?? '-' }}</x-ui.table-cell>
                  <x-ui.table-cell class="px-4 py-3 font-medium text-muted-foreground">
                    {{ $jadwal->hari ?? '-' }} <span class="text-muted-foreground/70">({{ $jadwal->jam ?? '-' }})</span>
                  </x-ui.table-cell>
                  <x-ui.table-cell class="px-4 py-3">
                    <x-ui.badge tone="success" class="gap-1.5">
                      <x-lucide-users class="size-3.5" />
                      {{ count($jadwal->kelas ?? []) }} Siswa
                    </x-ui.badge>
                  </x-ui.table-cell>
                  <x-ui.table-cell class="px-4 py-3">
                    <div class="flex justify-end">
                      <x-ui.button href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}" variant="link" size="sm">
                        Rincian
                        <x-lucide-chevron-right />
                      </x-ui.button>
                    </div>
                  </x-ui.table-cell>
                </x-ui.table-row>
              @empty
                <x-ui.table-row class="hover:bg-transparent">
                  <x-ui.table-cell colspan="5" class="p-0">
                    <x-ui.empty class="border-0">
                      <x-ui.empty-header>
                        <x-ui.empty-media variant="icon">
                          <x-lucide-calendar />
                        </x-ui.empty-media>
                        <x-ui.empty-title class="text-base">Belum Ada Batch Jadwal</x-ui.empty-title>
                        <x-ui.empty-description>
                          Belum ada batch jadwal kelas yang dibuat untuk program ini.
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

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-info class="size-4 text-primary" />
            Metadata Pelatihan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Durasi Pelatihan:</span>
            <span class="font-bold text-foreground">{{ $pelatihan->durasi_label ?? '-' }}</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Target Kuota Siswa:</span>
            <x-ui.badge tone="success">{{ $pelatihan->kuota }} Siswa / Batch</x-ui.badge>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Terdaftar Pada:</span>
            <span class="font-bold text-foreground">
              {{ $pelatihan->created_at ? $pelatihan->created_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-muted-foreground">Terakhir Diperbarui:</span>
            <span class="font-bold text-foreground">
              {{ $pelatihan->updated_at ? $pelatihan->updated_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-sliders-horizontal class="size-4 text-primary" />
            Aksi Administratif
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-2.5">
          <x-ui.button href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-pencil />
            Edit Kurikulum
          </x-ui.button>

          <x-ui.button href="{{ route('jadwal-pelatihan.create') }}" variant="outline" class="w-full">
            <x-lucide-calendar-plus />
            Buat Jadwal Baru
          </x-ui.button>

          <form
            action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kejuruan ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Program
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </div>
@endsection
