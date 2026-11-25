@extends('layouts.app')

@section('title', 'Katalog Program Pelatihan Vokasi - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Katalog Program Pelatihan"
    description="Kelola kurikulum kejuruan, kuota siswa, durasi jam pelatihan, dan alokasi instruktur vokasi terstandarisasi."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('dashboard') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Program Pelatihan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.badge variant="secondary" class="gap-1.5 uppercase tracking-wide">
        <span class="size-1.5 animate-pulse rounded-full bg-sikarir-lime"></span>
        Kejuruan & Kurikulum Vokasi
      </x-ui.badge>

      @if (auth()->user()?->role === 'admin_blk')
      <x-ui.button href="{{ route('jadwal-pelatihan.index') }}" variant="outline">
        <x-lucide-calendar />
        Jadwal Kelas
      </x-ui.button>
      @endif

      @if (auth()->user()?->role === 'admin_blk')
      <x-ui.button href="{{ route('pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-plus-circle />
        Tambah Program Baru
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

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat
      label="Kejuruan Aktif"
      :value="$pelatihans->total()"
      caption="Program kejuruan terdaftar"
      icon="book-open"
    />

    <x-ui.stat
      label="Kapasitas Siswa"
      :value="$pelatihans->sum('kuota')"
      caption="Total alokasi kursi batch"
      icon="users"
    />

    <x-ui.stat label="Standar Jam" value="240 - 320" caption="Jam Pelajaran (JP) reguler" icon="clock" />

    <x-ui.stat label="Sertifikasi" value="BNSP & SKKNI" caption="Uji kompetensi terakreditasi" icon="award" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-5">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <x-ui.card-title class="text-lg font-bold">Daftar Kejuruan & Kurikulum Pelatihan</x-ui.card-title>
            <x-ui.badge tone="success" class="gap-1.5">
              <span class="size-1.5 rounded-full bg-current"></span>
              {{ $pelatihans->total() }} Program
            </x-ui.badge>
          </div>
          <x-ui.card-description>
            Menampilkan seluruh program kejuruan aktif berbasis kompetensi kerja Disnakertrans.
          </x-ui.card-description>
        </div>

        <x-search-filter :action="route('pelatihan.index')" search-placeholder="Cari program kejuruan..." />
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Kode</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Program Kejuruan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Alokasi Kuota</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Durasi Belajar</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Penanggung Jawab</x-ui.table-head>
            <x-ui.table-head class="px-4 text-end text-xs font-semibold uppercase tracking-wide text-muted-foreground">Aksi</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($pelatihans as $pelatihan)
            <x-ui.table-row class="group">
              <x-ui.table-cell class="px-4 py-3 font-mono text-xs font-semibold text-muted-foreground group-hover:text-primary">
                #PLT-{{ str_pad((string) $pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex min-w-[240px] items-center gap-3">
                  @if ($pelatihan->gambar_url)
                    <img
                      src="{{ $pelatihan->gambar_url }}"
                      alt="{{ $pelatihan->nama_pelatihan }}"
                      class="size-10 shrink-0 rounded-lg border border-border object-cover"
                    >
                  @else
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg border border-border bg-accent text-accent-foreground">
                      <x-lucide-book-open class="size-4" />
                    </span>
                  @endif

                  <div class="min-w-0">
                    <a
                      href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}"
                      class="line-clamp-1 text-sm font-bold tracking-tight text-foreground transition group-hover:text-primary"
                    >
                      {{ $pelatihan->nama_pelatihan }}
                    </a>
                    <p class="mt-0.5 line-clamp-1 max-w-sm text-xs text-muted-foreground">
                      {{ $pelatihan->deskripsi_pelatihan ?? 'Belum ada deskripsi kurikulum terlampir.' }}
                    </p>
                  </div>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <x-ui.badge tone="success" class="gap-1.5">
                  <x-lucide-users class="size-3.5" />
                  {{ $pelatihan->kuota }} Kursi
                </x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-foreground">
                  <x-lucide-clock class="size-3.5 text-primary" />
                  {{ $pelatihan->durasi_label ?? '-' }}
                </span>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                @php($penanggungJawab = $pelatihan->instruktur?->nama ?? $pelatihan->admin?->nama ?? 'Belum Ditunjuk')

                <div class="flex items-center gap-2">
                  <x-ui.avatar class="size-6">
                    <x-ui.avatar-fallback class="bg-muted text-[10px] font-bold text-muted-foreground">
                      {{ strtoupper(substr($penanggungJawab, 0, 1)) }}
                    </x-ui.avatar-fallback>
                  </x-ui.avatar>
                  <span class="max-w-[150px] truncate text-xs font-medium text-foreground">
                    {{ $penanggungJawab }}
                  </span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <div class="flex items-center justify-end gap-1">
                  <x-ui.button
                    href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Lihat Detail"
                    aria-label="Lihat detail {{ $pelatihan->nama_pelatihan }}"
                  >
                    <x-lucide-eye />
                  </x-ui.button>

                  @if (auth()->user()?->role === 'admin_blk')
                  <x-ui.button
                    href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}"
                    variant="ghost"
                    size="icon-sm"
                    title="Edit Kurikulum"
                    aria-label="Edit {{ $pelatihan->nama_pelatihan }}"
                  >
                    <x-lucide-pencil />
                  </x-ui.button>

                  <form
                    action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kejuruan ini?')"
                  >
                    @csrf
                    @method('DELETE')

                    <x-ui.button
                      type="submit"
                      variant="ghost"
                      size="icon-sm"
                      class="text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                      title="Hapus Program"
                      aria-label="Hapus {{ $pelatihan->nama_pelatihan }}"
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
              <x-ui.table-cell colspan="6" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-book-open />
                    </x-ui.empty-media>
                    <x-ui.empty-title>Tidak Ada Program Kejuruan Ditemukan</x-ui.empty-title>
                    <x-ui.empty-description>
                      Coba ubah kata kunci pencarian atau bersihkan filter yang aktif.
                    </x-ui.empty-description>
                  </x-ui.empty-header>

                  @if (request('search'))
                    <x-ui.button href="{{ route('pelatihan.index') }}" variant="outline" size="sm">
                      <x-lucide-rotate-ccw />
                      Reset Filter Pencarian
                    </x-ui.button>
                  @else
                    @if (auth()->user()?->role === 'admin_blk')
                    <x-ui.button href="{{ route('pelatihan.create') }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
                      <x-lucide-plus />
                      Buat Program Baru
                    </x-ui.button>
                    @endif
                  @endif
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if ($pelatihans->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $pelatihans->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
