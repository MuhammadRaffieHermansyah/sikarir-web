@extends('layouts.app')

@section('title', 'Data Peserta - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Data Peserta Pelatihan"
    description="Monitoring data induk peserta vokasi, status keikutsertaan kelas, presensi, dan capaian sertifikasi."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Peserta SiKarir</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('pesertas.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-user-plus />
        Registrasi Peserta Baru
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  @if (session('success'))
    <x-ui.alert tone="success">
      <x-lucide-circle-check-big />
      <x-ui.alert-description>{{ session('success') }}</x-ui.alert-description>
    </x-ui.alert>
  @endif

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat label="Total Peserta Terdaftar" :value="(isset($pesertas) ? $pesertas->total() : 0) . ' Peserta'" icon="users" />
    <x-ui.stat label="Program Vokasi" value="Multi-Kejuruan" icon="graduation-cap" />
    <x-ui.stat label="Status Kompetensi" value="Terstandarisasi BNSP" icon="award" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Peserta Pelatihan</x-ui.card-title>
            <x-ui.badge variant="secondary">{{ isset($pesertas) ? $pesertas->total() : 0 }} Peserta</x-ui.badge>
          </div>
          <x-ui.card-description>
            Daftar lengkap peserta vokasi yang terdaftar pada sistem SiKarir.
          </x-ui.card-description>
        </div>

        <x-search-filter
          :action="route('pesertas.index')"
          search-placeholder="Cari nama, NIS, jurusan..."
          status-name="jurusan"
          status-placeholder="Semua Jurusan"
          :status-options="collect($jurusanList)->pluck('jurusan', 'jurusan')->toArray()"
        />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Peserta</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Nomor Peserta (NIS)</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Kejuruan / Jurusan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Kontak WhatsApp</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Pendidikan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($pesertas ?? [] as $peserta)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <span class="grid size-9 shrink-0 place-items-center rounded-full bg-primary text-xs font-bold uppercase text-primary-foreground">
                    {{ strtoupper(substr($peserta->user->name ?? 'P', 0, 2)) }}
                  </span>
                  <div class="min-w-0">
                    <a
                      href="{{ route('pesertas.show', $peserta->id_peserta) }}"
                      class="font-bold text-foreground transition group-hover:text-primary"
                    >
                      {{ $peserta->user->name ?? 'Tanpa Nama' }}
                    </a>
                    <div class="text-xs text-muted-foreground">
                      {{ $peserta->jenis_kelamin ?? '-' }} • {{ $peserta->user->email ?? '-' }}
                    </div>
                  </div>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <span class="rounded bg-accent px-2 py-0.5 font-mono text-xs font-bold text-accent-foreground">
                  {{ $peserta->nomor_peserta }}
                </span>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="font-semibold text-foreground">{{ $peserta->jurusan ?? 'Pelatihan Umum' }}</div>
                <div class="text-xs text-muted-foreground">{{ count($peserta->kelas ?? []) }} Kelas Diikuti</div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center gap-1.5 font-medium text-foreground">
                  <x-lucide-phone class="size-3.5 text-muted-foreground" />
                  <span>{{ $peserta->nomor_wa ?? '-' }}</span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="font-medium text-foreground">{{ $peserta->pendidikan_terakhir ?? '-' }}</div>
                <div class="text-xs text-muted-foreground">
                  {{ $peserta->tempat_lahir ? $peserta->tempat_lahir . ', ' : '' }}{{ $peserta->tanggal_lahir ? \Illuminate\Support\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d/m/Y') : '' }}
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('pesertas.show', $peserta->id_peserta) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Detail"
                    aria-label="Lihat detail peserta {{ $peserta->user->name ?? '' }}"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  <x-ui.button
                    href="{{ route('pesertas.edit', $peserta->id_peserta) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit"
                    aria-label="Edit peserta {{ $peserta->user->name ?? '' }}"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('pesertas.destroy', $peserta->id_peserta) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus"
                      aria-label="Hapus peserta {{ $peserta->user->name ?? '' }}"
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
                      <x-lucide-users />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Data Peserta</x-ui.empty-title>
                    <x-ui.empty-description>Belum ada data Peserta yang ditemukan.</x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search') || request('jurusan'))
                    <x-ui.button href="{{ route('pesertas.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    <x-ui.button href="{{ route('pesertas.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Daftarkan Peserta Pertama
                    </x-ui.button>
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if (isset($pesertas) && $pesertas->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $pesertas->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
