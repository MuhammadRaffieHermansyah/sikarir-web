@extends('layouts.app')

@section('title', 'Detail Batch Jadwal - ' . ($jadwal->pelatihan->nama_pelatihan ?? 'Jadwal'))

@section('content')
  <x-ui.page-header
    title="Rincian Pelaksanaan & Roster Kelas"
    description="Informasi periode waktu, alokasi ruangan laboratorium/bengkel, dan daftar siswa yang terdaftar."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('jadwal-pelatihan.index') }}">Jadwal &amp; Kelas</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Batch</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('jadwal-pelatihan.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>

      <x-ui.button href="{{ route('jadwal-pelatihan.edit', $jadwal->id_jadwal) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Jadwal
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
      <div class="flex items-center gap-5">
        <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary text-primary-foreground">
          <x-lucide-calendar class="size-8" />
        </span>

        <div>
          <div class="flex flex-wrap items-center gap-2.5">
            <h2 class="text-lg font-extrabold text-foreground">{{ $jadwal->pelatihan->nama_pelatihan ?? 'Kejuruan Vokasi' }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">
              Batch: #JDW-{{ str_pad((string) $jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
          </div>

          <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-muted-foreground">
            <span class="flex items-center gap-1.5">
              <x-lucide-user class="size-3.5" />
              Instruktur: {{ $jadwal->instruktur?->nama ?? 'Belum Ditunjuk' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-map-pin class="size-3.5" />
              {{ $jadwal->ruanganWorkshop?->nama_ruangan ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-clock class="size-3.5" />
              {{ $jadwal->jam_mulai ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '08:00' }} -
              {{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '15:30' }}
            </span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-border sm:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">Status Pelaksanaan</div>
        <div class="mt-1 flex items-center justify-end gap-1.5 text-xs font-bold">
          @if ($jadwal->status === 'tersedia')
            <span class="size-2 rounded-full bg-emerald-500"></span>
            <span class="text-primary">Pendaftaran Tersedia</span>
          @elseif ($jadwal->status === 'berlangsung')
            <span class="size-2 animate-pulse rounded-full bg-blue-500"></span>
            <span class="text-blue-600">Kelas Berlangsung</span>
          @else
            <span class="size-2 rounded-full bg-muted-foreground"></span>
            <span class="text-muted-foreground">Selesai</span>
          @endif
        </div>
      </div>
    </div>
  </x-ui.card>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat label="Siswa Terdaftar" :value="count($jadwal->kelas ?? []) . ' / ' . ($jadwal->pelatihan->kuota ?? '16') . ' Peserta'" icon="users" />
    <x-ui.stat label="Catatan Presensi" :value="count($jadwal->absensi ?? []) . ' Kehadiran'" icon="check-square" />
    <x-ui.stat label="Sertifikat Diterbitkan" :value="count($jadwal->sertifikat ?? []) . ' Lembar'" icon="award" />
  </div>

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
        <x-ui.card-header class="border-b pb-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-users class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Daftar Roster Siswa Kelas Ini</x-ui.card-title>
                <x-ui.card-description>Siswa vokasi yang terdaftar pada batch jadwal ini.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('kelas-pelatihan.create') }}" variant="link" size="sm" class="px-0">
              <x-lucide-user-plus />
              Masukkan Siswa
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="px-0">
          <x-ui.table>
            <x-ui.table-header>
              <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">NIS</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Nama Siswa</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Kontak / Email</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status Kelas</x-ui.table-head>
                <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
              </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
              @forelse ($jadwal->kelas ?? [] as $kelas)
                <x-ui.table-row>
                  <x-ui.table-cell class="px-4 py-3 font-mono text-xs font-bold text-muted-foreground">
                    {{ $kelas->peserta->nomor_peserta ?? '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 font-bold text-foreground">
                    {{ $kelas->peserta->user->name ?? '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                    {{ $kelas->peserta->nomor_wa ?? $kelas->peserta->user->email ?? '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <x-ui.badge tone="success" class="capitalize">{{ $kelas->status_kelulusan ?? 'Terdaftar' }}</x-ui.badge>
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <div class="flex justify-end">
                      <x-ui.button href="{{ route('pesertas.show', $kelas->id_peserta) }}" variant="link" size="sm">
                        Lihat Siswa
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
                          <x-lucide-users />
                        </x-ui.empty-media>
                        <x-ui.empty-title class="text-base">Belum Ada Peserta</x-ui.empty-title>
                        <x-ui.empty-description>
                          Belum ada peserta yang dimasukkan ke dalam batch ini.
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
            <x-lucide-calendar-days class="size-4 text-primary" />
            Rincian Periode
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div class="flex items-center justify-between text-foreground">
            <span class="text-muted-foreground">Mulai:</span>
            <span class="font-semibold">{{ $jadwal->tanggal_mulai ? $jadwal->tanggal_mulai->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between text-foreground">
            <span class="text-muted-foreground">Selesai:</span>
            <span class="font-semibold">{{ $jadwal->tanggal_selesai ? $jadwal->tanggal_selesai->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between text-foreground">
            <span class="text-muted-foreground">Durasi Silabus:</span>
            <span class="font-semibold">{{ $jadwal->pelatihan->durasi_label ?? '-' }}</span>
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
          <x-ui.button href="{{ route('absen.index') }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-check-square />
            Rekap Presensi Siswa
          </x-ui.button>

          <x-ui.button href="{{ route('jadwal-pelatihan.edit', $jadwal->id_jadwal) }}" variant="secondary" class="w-full">
            <x-lucide-pencil />
            Edit Jadwal
          </x-ui.button>

          <form
            action="{{ route('jadwal-pelatihan.destroy', $jadwal->id_jadwal) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus batch jadwal ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Jadwal
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </div>
@endsection
