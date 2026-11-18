@extends('layouts.app')

@section('title', 'Detail Profil Administrator BLK - ' . ($admin->user->name ?? 'Admin'))

@section('content')
  <x-ui.page-header
    title="Detail Profil Administrator BLK"
    description="Informasi lengkap data personel, hak akses kewenangan sistem, dan riwayat kegiatan operasional."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Admin BLK</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Profil</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('admin-blk.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>

      <x-ui.button href="{{ route('admin-blk.edit', $admin->id_admin) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit Profil
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
      <div class="flex items-center gap-5">
        <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary text-2xl font-black text-primary-foreground">
          {{ strtoupper(substr($admin->user->name ?? 'A', 0, 2)) }}
        </span>

        <div>
          <div class="flex flex-wrap items-center gap-2.5">
            <h2 class="text-lg font-extrabold text-foreground">{{ $admin->user->name ?? 'Tanpa Nama' }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">
              ID: #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
            <x-ui.badge tone="success" class="gap-1">
              <span class="size-1.5 rounded-full bg-current"></span>
              Super Administrator Balai
            </x-ui.badge>
          </div>

          <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-muted-foreground">
            <span class="flex items-center gap-1.5">
              <x-lucide-mail class="size-3.5" />
              {{ $admin->user->email ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-building-2 class="size-3.5" />
              BLK Pusat Vokasi & Pelatihan Kerja
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-calendar class="size-3.5" />
              Bergabung sejak {{ $admin->created_at ? $admin->created_at->translatedFormat('d F Y') : '-' }}
            </span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-border sm:pl-6">
        <div class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">Status Akun</div>
        <div class="mt-1 flex items-center justify-end gap-1.5 text-xs font-bold text-primary">
          <span class="size-2 animate-pulse rounded-full bg-emerald-500"></span>
          Aktif & Terverifikasi
        </div>
      </div>
    </div>
  </x-ui.card>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat label="Program Pelatihan" :value="count($admin->pelatihan ?? []) . ' Program'" icon="book-open" />
    <x-ui.stat label="Lowongan Magang" :value="count($admin->lowongan ?? []) . ' Lowongan'" icon="briefcase" />
    <x-ui.stat label="Peserta Dibina" :value="count($admin->peserta ?? []) . ' Peserta'" icon="users" />
    <x-ui.stat label="Sertifikat Validasi" :value="count($admin->sertifikat ?? []) . ' Diterbitkan'" icon="award" />
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
                <x-ui.card-title class="text-base font-bold">Informasi Data Administrator</x-ui.card-title>
                <x-ui.card-description>Rincian identitas akun dan penugasan balai kerja.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('admin-blk.edit', $admin->id_admin) }}" variant="link" size="sm" class="px-0">
              <x-lucide-pencil />
              Edit
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-x-6 gap-y-4 text-xs sm:grid-cols-2">
            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Nama Lengkap</span>
              <span class="text-sm font-bold text-foreground">{{ $admin->user->name ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Alamat Email</span>
              <span class="font-semibold text-foreground">{{ $admin->user->email ?? '-' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">ID Administrator BLK</span>
              <x-ui.badge variant="secondary" class="w-fit font-mono">
                #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}
              </x-ui.badge>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Role Akun Sistem</span>
              <span class="font-semibold capitalize text-foreground">{{ $admin->user->role ?? 'admin_blk' }}</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Unit Balai Kerja</span>
              <span class="font-semibold text-foreground">BLK Pusat Vokasi</span>
            </div>

            <div>
              <span class="mb-1 block font-medium text-muted-foreground">Waktu Pendaftaran</span>
              <span class="font-semibold text-foreground">
                {{ $admin->created_at ? $admin->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB
              </span>
            </div>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
        <x-ui.card-header class="border-b pb-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-layers class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Program Pelatihan Dikelola</x-ui.card-title>
                <x-ui.card-description>Program kejuruan yang berada di bawah wewenang administrator ini.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button href="{{ route('pelatihan.index') }}" variant="link" size="sm" class="px-0">
              Semua Program
              <x-lucide-arrow-right />
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="px-0">
          <x-ui.table>
            <x-ui.table-header>
              <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Nama Program</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Durasi</x-ui.table-head>
                <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Kuota Peserta</x-ui.table-head>
                <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
              </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
              @forelse ($admin->pelatihan ?? [] as $pelatihan)
                <x-ui.table-row>
                  <x-ui.table-cell class="px-4 py-3 font-bold text-foreground">
                    {{ $pelatihan->nama_pelatihan }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3 text-muted-foreground">
                    {{ $pelatihan->durasi_label ?? '-' }}
                  </x-ui.table-cell>

                  <x-ui.table-cell class="px-4 py-3">
                    <x-ui.badge tone="success">{{ $pelatihan->kuota }} Kuota</x-ui.badge>
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
                  <x-ui.table-cell colspan="4" class="p-0">
                    <x-ui.empty class="border-0">
                      <x-ui.empty-header>
                        <x-ui.empty-media variant="icon">
                          <x-lucide-layers />
                        </x-ui.empty-media>
                        <x-ui.empty-title class="text-base">Belum Ada Program Pelatihan</x-ui.empty-title>
                        <x-ui.empty-description>
                          Belum ada program pelatihan yang ditautkan ke administrator ini.
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
            <x-lucide-shield-alert class="size-4 text-primary" />
            Otoritas Operasional Balai
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3 text-xs">
          <div class="flex items-start gap-2.5">
            <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
            <div>
              <div class="font-bold text-foreground">Verifikasi Jurnal Harian</div>
              <p class="text-muted-foreground">Mengesahkan catatan kegiatan & presensi magang.</p>
            </div>
          </div>

          <div class="flex items-start gap-2.5">
            <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
            <div>
              <div class="font-bold text-foreground">Penerbitan Sertifikat Resmi</div>
              <p class="text-muted-foreground">Menandatangani & menerbitkan e-sertifikat kompetensi.</p>
            </div>
          </div>

          <div class="flex items-start gap-2.5">
            <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
            <div>
              <div class="font-bold text-foreground">Manajemen Mitra Industri</div>
              <p class="text-muted-foreground">Menyetujui pendaftaran dan kuota lowongan DU/DI.</p>
            </div>
          </div>

          <div class="flex items-start gap-2.5">
            <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
            <div>
              <div class="font-bold text-foreground">Manajemen Kurikulum & Kelas</div>
              <p class="text-muted-foreground">Menyusun jadwal dan instruktur pelatihan vokasi.</p>
            </div>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-sliders-horizontal class="size-4 text-primary" />
            Tindakan Cepat
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-2.5">
          <x-ui.button href="{{ route('admin-blk.edit', $admin->id_admin) }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-pencil />
            Edit Data Administrator
          </x-ui.button>

          <form
            action="{{ route('admin-blk.destroy', $admin->id_admin) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data administrator ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Administrator
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </div>
@endsection
