@extends('layouts.app')

@section('title', 'Rekapitulasi & Laporan Absensi - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Rekapitulasi & Laporan Presensi"
    description="Analisis tingkat kehadiran, statistik presensi kelas, dan rekapitulasi kelulusan peserta pelatihan vokasi."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('absen.index') }}">Daftar Absensi</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Rekapitulasi & Laporan Kehadiran</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('absen.export', request()->query()) }}" variant="outline">
        <x-lucide-download />
        Export Excel (CSV)
      </x-ui.button>

      <x-ui.button href="{{ route('absen.cetak', request()->query()) }}" target="_blank" variant="secondary">
        <x-lucide-printer />
        Cetak Laporan Resmi
      </x-ui.button>

      <x-ui.button href="{{ route('absen.index') }}" variant="ghost">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <x-ui.card-header class="border-b">
      <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
        <x-lucide-filter class="size-4 text-primary" />
        Filter & Parameter Laporan
      </x-ui.card-title>
    </x-ui.card-header>

    <x-ui.card-content>
      <form method="GET" action="{{ route('absen.rekap') }}" class="grid grid-cols-1 gap-4 text-xs sm:grid-cols-2 lg:grid-cols-5">
        <x-ui.field class="lg:col-span-2">
          <x-ui.field-label for="id_jadwal">Batch / Jadwal & Kelas</x-ui.field-label>
          <x-ui.select name="id_jadwal" id="id_jadwal" native class="w-full">
            <option value="">-- Semua Program Pelatihan --</option>
            @foreach ($jadwals as $j)
              <option value="{{ $j->id_jadwal }}" @selected(request('id_jadwal') == $j->id_jadwal)>
                {{ $j->pelatihan->nama_pelatihan ?? 'Pelatihan #' . $j->id_jadwal }}
                ({{ $j->tanggal_mulai ? \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M') : '' }} - {{ $j->tanggal_selesai ? \Carbon\Carbon::parse($j->tanggal_selesai)->format('d M Y') : '' }})
              </option>
            @endforeach
          </x-ui.select>
        </x-ui.field>

        <x-ui.field>
          <x-ui.field-label for="tanggal_mulai">Tanggal Mulai</x-ui.field-label>
          <x-ui.input id="tanggal_mulai" name="tanggal_mulai" type="date" :value="request('tanggal_mulai')" />
        </x-ui.field>

        <x-ui.field>
          <x-ui.field-label for="tanggal_selesai">Tanggal Selesai</x-ui.field-label>
          <x-ui.input id="tanggal_selesai" name="tanggal_selesai" type="date" :value="request('tanggal_selesai')" />
        </x-ui.field>

        <x-ui.field>
          <x-ui.field-label for="status">Status Kehadiran</x-ui.field-label>
          <x-ui.select name="status" id="status" native class="w-full">
            <option value="">-- Semua Status --</option>
            <option value="hadir" @selected(request('status') == 'hadir')>Hadir</option>
            <option value="izin" @selected(request('status') == 'izin')>Izin</option>
            <option value="sakit" @selected(request('status') == 'sakit')>Sakit</option>
            <option value="alpha" @selected(request('status') == 'alpha')>Alpha / Alpa</option>
          </x-ui.select>
        </x-ui.field>

        <div class="flex items-center justify-end gap-2 border-t border-border pt-3 lg:col-span-5">
          <x-ui.button href="{{ route('absen.rekap') }}" variant="ghost" size="sm">
            Reset Filter
          </x-ui.button>

          <x-ui.button type="submit" size="sm">
            <x-lucide-search />
            Terapkan Filter
          </x-ui.button>
        </div>
      </form>
    </x-ui.card-content>
  </x-ui.card>

  @if ($selectedJadwal)
    <x-ui.card class="border-primary/30 bg-gradient-to-r from-primary to-[#0d4335] text-primary-foreground">
      <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
          <x-ui.badge class="mb-1 border-primary-foreground/25 bg-primary-foreground/10 text-[10px] uppercase tracking-wider text-primary-foreground">
            Program Pelatihan Terpilih
          </x-ui.badge>
          <h2 class="text-base font-bold text-white">{{ $selectedJadwal->pelatihan->nama_pelatihan ?? '-' }}</h2>
          <p class="mt-0.5 text-xs text-primary-foreground/80">
            Periode: {{ $selectedJadwal->tanggal_mulai ? \Carbon\Carbon::parse($selectedJadwal->tanggal_mulai)->format('d F Y') : '-' }} s/d {{ $selectedJadwal->tanggal_selesai ? \Carbon\Carbon::parse($selectedJadwal->tanggal_selesai)->format('d F Y') : '-' }}
          </p>
        </div>

        <div class="flex items-center gap-6 border-t border-primary-foreground/20 pt-3 text-xs md:border-l md:border-t-0 md:pl-6 md:pt-0">
          <div>
            <span class="block text-[10px] font-semibold uppercase text-sikarir-lime">Instruktur</span>
            <span class="font-bold text-white">{{ $selectedJadwal->instruktur->nama ?? '-' }}</span>
          </div>
          <div>
            <span class="block text-[10px] font-semibold uppercase text-sikarir-lime">Ruangan</span>
            <span class="font-bold text-white">{{ $selectedJadwal->ruanganWorkshop->nama_ruangan ?? $selectedJadwal->tempat ?? '-' }}</span>
          </div>
        </div>
      </div>
    </x-ui.card>
  @endif

  <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
    <x-ui.stat label="Total Hadir" :value="$totalHadir" icon="circle-check-big" />
    <x-ui.stat label="Total Izin" :value="$totalIzin" icon="mail" />
    <x-ui.stat label="Total Sakit" :value="$totalSakit" icon="activity" />
    <x-ui.stat label="Total Alpha" :value="$totalAlpha" icon="circle-x" />
    <x-ui.stat label="Tingkat Kehadiran" :value="$persenHadir . '%'" icon="percent" class="col-span-2 sm:col-span-1" />
  </div>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-4">
      <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2.5">
          <x-lucide-users class="size-4 text-primary" />
          <x-ui.card-title class="text-base font-bold">Rekapitulasi Kehadiran Per Peserta</x-ui.card-title>
          <x-ui.badge variant="secondary">{{ $rekapPeserta->count() }} Peserta</x-ui.badge>
        </div>

        <span class="text-xs text-muted-foreground">
          Syarat Kelulusan Minimal: <strong class="text-foreground">80% Kehadiran</strong>
        </span>
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="w-10 px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">#</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Peserta Pelatihan</x-ui.table-head>
            <x-ui.table-head class="w-20 px-3 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Hadir</x-ui.table-head>
            <x-ui.table-head class="w-20 px-3 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Izin</x-ui.table-head>
            <x-ui.table-head class="w-20 px-3 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Sakit</x-ui.table-head>
            <x-ui.table-head class="w-20 px-3 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Alpha</x-ui.table-head>
            <x-ui.table-head class="w-24 px-3 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Total Sesi</x-ui.table-head>
            <x-ui.table-head class="w-36 px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Persentase</x-ui.table-head>
            <x-ui.table-head class="w-36 px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status Kelayakan</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($rekapPeserta as $index => $rp)
            <x-ui.table-row>
              <x-ui.table-cell class="px-4 py-3 text-center text-muted-foreground">{{ $loop->iteration }}</x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <span class="block text-xs font-bold text-foreground">{{ $rp->peserta->nama ?? '-' }}</span>
                <span class="text-xs text-muted-foreground">
                  No. Peserta: {{ $rp->peserta->nomor_peserta ?? '-' }} &bull; {{ $rp->peserta->user->email ?? '-' }}
                </span>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-3 py-3 text-center font-bold text-primary">{{ $rp->hadir }}</x-ui.table-cell>
              <x-ui.table-cell class="px-3 py-3 text-center font-medium text-amber-600">{{ $rp->izin }}</x-ui.table-cell>
              <x-ui.table-cell class="px-3 py-3 text-center font-medium text-sky-600">{{ $rp->sakit }}</x-ui.table-cell>
              <x-ui.table-cell class="px-3 py-3 text-center font-medium text-destructive">{{ $rp->alpha }}</x-ui.table-cell>
              <x-ui.table-cell class="px-3 py-3 text-center font-semibold text-foreground">{{ $rp->total }}</x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-2">
                  <div class="h-2 w-16 shrink-0 overflow-hidden rounded-full bg-muted">
                    <div
                      class="h-2 rounded-full {{ $rp->persentase >= 80 ? 'bg-emerald-500' : ($rp->persentase >= 60 ? 'bg-amber-500' : 'bg-rose-500') }}"
                      style="width: {{ $rp->persentase }}%"
                    ></div>
                  </div>
                  <span class="text-xs font-bold {{ $rp->persentase >= 80 ? 'text-primary' : 'text-foreground' }}">
                    {{ $rp->persentase }}%
                  </span>
                </div>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-center">
                @if ($rp->persentase >= 80)
                  <x-ui.badge tone="success" class="gap-1">
                    <x-lucide-circle-check class="size-3" />
                    Memenuhi Syarat
                  </x-ui.badge>
                @else
                  <x-ui.badge tone="warning" class="gap-1">
                    <x-lucide-triangle-alert class="size-3" />
                    Perlu Perhatian
                  </x-ui.badge>
                @endif
              </x-ui.table-cell>
            </x-ui.table-row>
          @empty
            <x-ui.table-row class="hover:bg-transparent">
              <x-ui.table-cell colspan="9" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-inbox />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Tidak Ada Data Absensi</x-ui.empty-title>
                    <x-ui.empty-description>Tidak ada data absensi yang sesuai dengan filter.</x-ui.empty-description>
                  </x-ui.empty-header>
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>
  </x-ui.card>

  <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
    <x-ui.card-header class="border-b pb-4">
      <div class="flex flex-wrap items-center gap-2.5">
        <x-lucide-list class="size-4 text-primary" />
        <x-ui.card-title class="text-base font-bold">Log Rincian Presensi Harian</x-ui.card-title>
        <x-ui.badge variant="secondary">{{ $absens->total() }} Record</x-ui.badge>
      </div>
    </x-ui.card-header>

    <x-ui.card-content class="px-0">
      <x-ui.table>
        <x-ui.table-header>
          <x-ui.table-row class="bg-muted/50 hover:bg-muted/50">
            <x-ui.table-head class="w-10 px-4 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">#</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Peserta</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Program Pelatihan</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Tanggal & Jam</x-ui.table-head>
            <x-ui.table-head class="px-3 text-center text-xs font-semibold uppercase tracking-wide text-muted-foreground">Status</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Validasi Lokasi GPS</x-ui.table-head>
            <x-ui.table-head class="px-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Keterangan</x-ui.table-head>
          </x-ui.table-row>
        </x-ui.table-header>

        <x-ui.table-body>
          @forelse ($absens as $absen)
            @php
              $status = strtolower($absen->status_kehadiran ?? '');
              $tone = match ($status) {
                  'hadir' => 'success',
                  'izin' => 'warning',
                  'sakit' => 'info',
                  default => 'danger',
              };
            @endphp

            <x-ui.table-row>
              <x-ui.table-cell class="px-4 py-3 text-center text-muted-foreground">
                {{ $loop->iteration + ($absens->currentPage() - 1) * $absens->perPage() }}
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <span class="block font-bold text-foreground">{{ $absen->peserta->nama ?? '-' }}</span>
                <span class="text-xs text-muted-foreground">{{ $absen->peserta->nomor_peserta ?? '-' }}</span>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <span class="font-medium text-foreground">{{ $absen->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                <span class="block font-medium text-foreground">{{ $absen->tanggal ? $absen->tanggal->format('d/m/Y') : '-' }}</span>
                <span class="text-xs text-muted-foreground">{{ $absen->jam_hadir ? substr($absen->jam_hadir, 0, 5) . ' WIB' : '-' }}</span>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-3 py-3 text-center">
                <x-ui.badge :tone="$tone" class="capitalize">{{ $absen->status_kehadiran }}</x-ui.badge>
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3">
                @if ($absen->latitude && $absen->longitude)
                  <div class="flex items-center gap-1.5 text-xs">
                    <x-lucide-map-pin class="size-3.5 shrink-0 text-primary" />
                    <span>
                      @if ($absen->jarak_meter !== null)
                        <strong>{{ round($absen->jarak_meter) }}m</strong> dari titik pelatihan
                      @else
                        GPS tercatat
                      @endif
                    </span>
                    <a
                      href="https://www.google.com/maps?q={{ $absen->latitude }},{{ $absen->longitude }}"
                      target="_blank"
                      class="shrink-0 text-primary hover:underline"
                      aria-label="Buka lokasi di Google Maps"
                    >
                      <x-lucide-external-link class="size-3" />
                    </a>
                  </div>
                @else
                  <span class="text-xs text-muted-foreground">-</span>
                @endif
              </x-ui.table-cell>

              <x-ui.table-cell class="px-4 py-3 text-xs text-muted-foreground">
                {{ $absen->keterangan ?? '-' }}
              </x-ui.table-cell>
            </x-ui.table-row>
          @empty
            <x-ui.table-row class="hover:bg-transparent">
              <x-ui.table-cell colspan="7" class="p-0">
                <x-ui.empty class="border-0">
                  <x-ui.empty-header>
                    <x-ui.empty-media variant="icon">
                      <x-lucide-inbox />
                    </x-ui.empty-media>
                    <x-ui.empty-title class="text-base">Belum Ada Rekaman Absensi</x-ui.empty-title>
                    <x-ui.empty-description>Belum ada rekaman absensi pada periode ini.</x-ui.empty-description>
                  </x-ui.empty-header>
                </x-ui.empty>
              </x-ui.table-cell>
            </x-ui.table-row>
          @endforelse
        </x-ui.table-body>
      </x-ui.table>
    </x-ui.card-content>

    @if ($absens->hasPages())
      <div class="border-t border-border px-6 pt-5">
        {{ $absens->links('components.pagination') }}
      </div>
    @endif
  </x-ui.card>
@endsection
