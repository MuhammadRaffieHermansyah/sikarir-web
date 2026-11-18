@extends('layouts.app')

@section('title', 'Detail Profil Peserta Vokasi - ' . ($peserta->user->name ?? 'Peserta'))

@section('content')
  <x-ui.page-header
    title="Profil Lengkap Siswa Vokasi"
    description="Rincian biodata kependudukan, kejuruan yang diikuti, riwayat presensi, dan sertifikat kompetensi."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('pesertas.index') }}">Peserta Pelatihan</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Peserta</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('pesertas.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>

      <x-ui.button href="{{ route('pesertas.edit', $peserta->id_peserta) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Biodata
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
      <div class="flex items-center gap-5">
        <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary text-2xl font-black uppercase text-primary-foreground">
          {{ strtoupper(substr($peserta->user->name ?? 'P', 0, 2)) }}
        </span>

        <div>
          <div class="flex flex-wrap items-center gap-2.5">
            <h2 class="text-lg font-extrabold text-foreground">{{ $peserta->user->name ?? 'Peserta Tanpa Nama' }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">NIS: {{ $peserta->nomor_peserta ?? '-' }}</x-ui.badge>
            <x-ui.badge variant="secondary">{{ $peserta->jurusan ?? 'Kejuruan Vokasi' }}</x-ui.badge>
          </div>

          <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-muted-foreground">
            <span class="flex items-center gap-1.5">
              <x-lucide-mail class="size-3.5" />
              {{ $peserta->user->email ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-phone class="size-3.5" />
              {{ $peserta->nomor_wa ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-user class="size-3.5" />
              {{ $peserta->jenis_kelamin ?? '-' }}
            </span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-border sm:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">Status Pelajar</div>
        <div class="mt-1 flex items-center justify-end gap-1.5 text-xs font-bold text-primary">
          <span class="size-2 animate-pulse rounded-full bg-emerald-500"></span>
          Siswa Aktif Pelatihan
        </div>
      </div>
    </div>
  </x-ui.card>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat label="Kelas Diikuti" :value="count($peserta->kelas ?? []) . ' Kelas'" icon="book-open" />
    <x-ui.stat label="Total Presensi" :value="count($peserta->absensi ?? []) . ' Kehadiran'" icon="circle-check-big" />
    <x-ui.stat label="Sertifikat Kelulusan" :value="count($peserta->sertifikat ?? []) . ' Diterbitkan'" icon="award" />
  </div>

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-id-card class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Biodata &amp; Administrasi</x-ui.card-title>
                <x-ui.card-description>Informasi identitas kependudukan dan latar belakang pendidikan.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('pesertas.edit', $peserta->id_peserta) }}" variant="link" size="sm" class="px-0">
              <x-lucide-pencil />
              Edit
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-x-6 gap-y-4 text-xs sm:grid-cols-2">
            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Nomor Induk Siswa (NIS)</span>
              <span class="font-mono text-sm font-bold text-foreground">{{ $peserta->nomor_peserta }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Nomor Kartu Keluarga (KK)</span>
              <span class="font-mono font-semibold text-foreground">{{ $peserta->nomor_kk ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Tempat, Tanggal Lahir</span>
              <span class="font-semibold text-foreground">
                {{ $peserta->tempat_lahir ?? '-' }}, {{ $peserta->tanggal_lahir ? $peserta->tanggal_lahir->translatedFormat('d F Y') : '-' }}
              </span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Pendidikan Terakhir</span>
              <span class="font-semibold text-foreground">{{ $peserta->pendidikan_terakhir ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Pilihan Program Kejuruan</span>
              <span class="font-semibold text-primary">{{ $peserta->jurusan ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Petugas Pendaftar (Admin)</span>
              <span class="font-semibold text-foreground">{{ $peserta->admin->user->name ?? 'System Default' }}</span>
            </div>

            <div class="sm:col-span-2">
              <span class="mb-1 block font-medium text-muted-foreground">Alamat Lengkap Domisili</span>
              <span class="font-medium leading-relaxed text-foreground">{{ $peserta->alamat_lengkap ?? '-' }}</span>
            </div>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
        <x-ui.card-header class="border-b pb-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-graduation-cap class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Program Pelatihan Yang Diikuti</x-ui.card-title>
                <x-ui.card-description>Daftar kelas vokasi dan modul kompetensi aktif.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('kelas-pelatihan.create') }}" variant="link" size="sm" class="px-0">
              <x-lucide-plus />
              Masukkan ke Kelas
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="px-0">
          <x-ui.table>
            <x-ui.table-header>
              <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Nama Program</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Instruktur</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Ruangan / Jadwal</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status</x-ui.table-head>
                <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
              </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
              @forelse ($peserta->kelas ?? [] as $kelas)
                <x-ui.table-row>
                  <x-ui.table-cell class="px-4 py-3 font-bold text-foreground">
                    {{ $kelas->jadwal->pelatihan->nama_pelatihan ?? '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                    {{ $kelas->jadwal?->instruktur?->nama ?? '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                    {{ $kelas->jadwal?->ruanganWorkshop?->nama_ruangan ?? '-' }}
                    ({{ $kelas->jadwal?->tanggal_mulai?->translatedFormat('d M Y') ?? '-' }})
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <x-ui.badge tone="success" class="capitalize">{{ $kelas->status_kelulusan ?? 'Mengikuti' }}</x-ui.badge>
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <div class="flex justify-end">
                      <x-ui.button href="{{ route('kelas-pelatihan.show', $kelas->id_kelas) }}" variant="link" size="sm">
                        Detail
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
                          <x-lucide-graduation-cap />
                        </x-ui.empty-media>
                        <x-ui.empty-title class="text-base">Belum Ada Kelas Pelatihan</x-ui.empty-title>
                        <x-ui.empty-description>
                          Belum ada kelas pelatihan yang didaftarkan untuk siswa ini.
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
            <x-lucide-phone class="size-4 text-primary" />
            Kontak Peserta
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-phone class="size-4 text-primary" />
            <span>{{ $peserta->nomor_wa ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-mail class="size-4 text-primary" />
            <span>{{ $peserta->user->email ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-foreground">
            <x-lucide-calendar class="size-4 text-primary" />
            <span>Terdaftar: {{ $peserta->created_at ? $peserta->created_at->translatedFormat('d M Y') : '-' }}</span>
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
          <x-ui.button href="{{ route('pesertas.edit', $peserta->id_peserta) }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-pencil />
            Edit Biodata Peserta
          </x-ui.button>

          <form
            action="{{ route('pesertas.destroy', $peserta->id_peserta) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peserta ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Peserta
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </div>
@endsection
