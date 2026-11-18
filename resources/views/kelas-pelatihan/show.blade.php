@extends('layouts.app')

@section('title', 'Detail Penempatan Kelas Siswa - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Status Penempatan & Progres Siswa"
    description="Pantau keterlibatan siswa pada program kejuruan vokasi, rekaman presensi, dan status kelulusan."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('kelas-pelatihan.index') }}">Kelas Pelatihan</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Siswa di Kelas</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('kelas-pelatihan.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>

      <x-ui.button href="{{ route('kelas-pelatihan.edit', $kelas->id_kelas) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Status
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-y-0 right-0 w-64 bg-gradient-to-l from-accent/60 to-transparent"></div>

    <div class="relative flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
      <div class="flex items-center gap-5">
        <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary text-2xl font-black text-primary-foreground">
          {{ strtoupper(substr($kelas->peserta->user->name ?? 'P', 0, 2)) }}
        </span>

        <div>
          <div class="flex flex-wrap items-center gap-2.5">
            <h2 class="text-lg font-extrabold text-foreground">{{ $kelas->peserta->user->name ?? 'Peserta' }}</h2>
            <x-ui.badge variant="secondary">NIS: {{ $kelas->peserta->nomor_peserta ?? '-' }}</x-ui.badge>
            <x-ui.badge variant="secondary">{{ $kelas->jadwal->pelatihan->nama_pelatihan ?? '-' }}</x-ui.badge>
          </div>

          <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-muted-foreground">
            <span class="flex items-center gap-1.5">
              <x-lucide-user-check class="size-3.5" />
              Instruktur: {{ $kelas->jadwal->instruktur ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-map-pin class="size-3.5" />
              Ruangan: {{ $kelas->jadwal->tempat ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-calendar class="size-3.5" />
              Batch #JDW-{{ str_pad((string) $kelas->jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
            </span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-border sm:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">Status Siswa</div>
        <div class="mt-0.5 flex items-center justify-end gap-1.5 text-xs font-bold">
          @if ($kelas->status === 'lulus')
            <span class="size-2 rounded-full bg-emerald-500"></span>
            <span class="text-primary">Telah Lulus Pelatihan</span>
          @elseif ($kelas->status === 'aktif')
            <span class="size-2 animate-pulse rounded-full bg-sky-500"></span>
            <span class="text-primary">Sedang Mengikuti Kelas</span>
          @elseif ($kelas->status === 'tidak lulus')
            <span class="size-2 rounded-full bg-destructive"></span>
            <span class="text-destructive">Tidak Lulus</span>
          @else
            <span class="size-2 rounded-full bg-muted-foreground"></span>
            <span class="text-muted-foreground">Terdaftar di Roster</span>
          @endif
        </div>
      </div>
    </div>
  </x-ui.card>

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-info class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Rincian Program & Jadwal Siswa</x-ui.card-title>
              <x-ui.card-description>Informasi lengkap penempatan kelas pelatihan vokasi.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-x-6 gap-y-4 text-xs sm:grid-cols-2">
            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Nama Program Kejuruan</span>
              <span class="text-sm font-bold text-foreground">{{ $kelas->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Durasi Jam Pelatihan</span>
              <span class="font-semibold text-foreground">{{ $kelas->jadwal->pelatihan->durasi_label ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Periode Tanggal</span>
              <span class="font-semibold text-foreground">
                {{ $kelas->jadwal->tanggal_mulai ? $kelas->jadwal->tanggal_mulai->translatedFormat('d M Y') : '-' }} s/d {{ $kelas->jadwal->tanggal_selesai ? $kelas->jadwal->tanggal_selesai->translatedFormat('d M Y') : '-' }}
              </span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Jam Belajar Harian</span>
              <span class="font-semibold text-foreground">
                {{ $kelas->jadwal->jam_mulai ? \Carbon\Carbon::parse($kelas->jadwal->jam_mulai)->format('H:i') : '08:00' }} - {{ $kelas->jadwal->jam_selesai ? \Carbon\Carbon::parse($kelas->jadwal->jam_selesai)->format('H:i') : '15:30' }} WIB
              </span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Instruktur Pembimbing</span>
              <span class="font-semibold text-foreground">{{ $kelas->jadwal->instruktur ?? 'Belum Ditunjuk' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Ruangan / Tempat</span>
              <span class="font-semibold text-foreground">{{ $kelas->jadwal->tempat ?? 'Workshop BLK' }}</span>
            </div>
          </div>
        </x-ui.card-content>
      </x-ui.card>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-user class="size-4 text-primary" />
            Profil Singkat Siswa
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-user class="size-4 text-primary" />
            <span>{{ $kelas->peserta->user->name ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-phone class="size-4 text-primary" />
            <span>{{ $kelas->peserta->nomor_wa ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-mail class="size-4 text-primary" />
            <span>{{ $kelas->peserta->user->email ?? '-' }}</span>
          </div>

          <div class="border-t border-border pt-3">
            <x-ui.button href="{{ route('pesertas.show', $kelas->id_peserta) }}" variant="link" size="sm" class="px-0">
              <x-lucide-external-link />
              Lihat Profil Lengkap Siswa
            </x-ui.button>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-sliders-horizontal class="size-4 text-primary" />
            Aksi
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-2.5">
          <x-ui.button href="{{ route('kelas-pelatihan.edit', $kelas->id_kelas) }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-pencil />
            Edit Penempatan Kelas
          </x-ui.button>

          <form
            action="{{ route('kelas-pelatihan.destroy', $kelas->id_kelas) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini dari kelas?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus dari Roster
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </div>
@endsection
