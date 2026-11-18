@extends('layouts.app')

@section('title', 'Detail Presensi Peserta - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Detail Catatan Presensi"
    description="Informasi rinci mengenai pencatatan kehadiran peserta pelatihan vokasi."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('absen.index') }}">Daftar Absensi</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Presensi</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('absen.edit', $absen->id_absen) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit
      </x-ui.button>

      <x-ui.button href="{{ route('absen.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <div class="mx-auto max-w-3xl">
    @php
      $status = strtolower($absen->status_kehadiran ?? $absen->status ?? '');
      $tone = match ($status) {
          'hadir' => 'success',
          'izin' => 'warning',
          'sakit' => 'info',
          default => 'danger',
      };
    @endphp

    <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
      <x-ui.card-header class="flex flex-row items-center justify-between gap-4 border-b">
        <div class="flex items-center gap-3">
          <x-ui.avatar class="size-10">
            <x-ui.avatar-fallback class="bg-accent text-sm font-bold text-accent-foreground">
              {{ strtoupper(substr($absen->peserta->user->name ?? 'P', 0, 2)) }}
            </x-ui.avatar-fallback>
          </x-ui.avatar>

          <div class="min-w-0">
            <x-ui.card-title class="text-base font-bold">{{ $absen->peserta->user->name ?? 'Tanpa Nama' }}</x-ui.card-title>
            <x-ui.card-description>
              ID Absen: #ABS-{{ str_pad($absen->id_absen, 4, '0', STR_PAD_LEFT) }}
              {{ isset($absen->peserta->nomor_peserta) ? '• No. Peserta: ' . $absen->peserta->nomor_peserta : '' }}
            </x-ui.card-description>
          </div>
        </div>

        <x-ui.badge :tone="$tone" class="gap-1.5 capitalize">
          <span class="size-1.5 rounded-full bg-current"></span>
          {{ $absen->status_kehadiran ?? $absen->status ?? '-' }}
        </x-ui.badge>
      </x-ui.card-header>

      <x-ui.card-content class="grid grid-cols-1 gap-6 text-xs md:grid-cols-2">
        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-book-open class="size-3.5" />
            Program Pelatihan
          </span>
          <p class="text-sm font-bold text-foreground">{{ $absen->jadwal->pelatihan->nama_pelatihan ?? '-' }}</p>
        </div>

        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-calendar class="size-3.5" />
            Tanggal Presensi
          </span>
          <p class="text-sm font-bold text-foreground">
            {{ $absen->tanggal ? \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') : '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-clock class="size-3.5" />
            Jam Masuk / Presensi
          </span>
          <p class="font-medium text-foreground">
            {{ $absen->jam_hadir ? \Carbon\Carbon::parse($absen->jam_hadir)->format('H:i') . ' WIB' : '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-mail class="size-3.5" />
            Email Peserta
          </span>
          <p class="font-medium text-foreground">{{ $absen->peserta->user->email ?? '-' }}</p>
        </div>

        <div class="space-y-2 border-t border-border pt-4 md:col-span-2">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-map-pin class="size-3.5 text-primary" />
            Koordinat Lokasi GPS
          </span>

          @if ($absen->latitude && $absen->longitude)
            <div class="flex flex-col justify-between gap-3 rounded-lg border border-border bg-accent/40 p-3.5 text-foreground sm:flex-row sm:items-center">
              <div class="space-y-0.5">
                <p class="font-semibold text-foreground">
                  Lat: <span class="font-mono text-primary">{{ $absen->latitude }}</span>,
                  Lng: <span class="font-mono text-primary">{{ $absen->longitude }}</span>
                </p>
                <p class="text-xs text-muted-foreground">
                  @if ($absen->jarak_meter !== null)
                    Terdeteksi <strong class="text-foreground">{{ round($absen->jarak_meter) }} meter</strong> dari titik pelatihan
                  @else
                    Presensi tercatat dengan koordinat GPS
                  @endif
                </p>
              </div>

              <x-ui.button
                href="https://www.google.com/maps?q={{ $absen->latitude }},{{ $absen->longitude }}"
                target="_blank"
                rel="noopener noreferrer"
                size="sm"
                class="shrink-0"
              >
                <x-lucide-external-link />
                Buka Google Maps
              </x-ui.button>
            </div>
          @else
            <div class="rounded-lg border border-border bg-muted/40 p-3 text-xs text-muted-foreground">
              Tidak ada data koordinat GPS (presensi manual / perizinan).
            </div>
          @endif
        </div>

        <div class="space-y-1.5 border-t border-border pt-4 md:col-span-2">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-file-text class="size-3.5" />
            Keterangan / Catatan
          </span>
          <div class="rounded-lg border border-border bg-muted/40 p-3.5 font-normal leading-relaxed text-foreground">
            {{ $absen->keterangan ?? 'Tidak ada catatan tambahan.' }}
          </div>
        </div>
      </x-ui.card-content>

      <div class="flex flex-wrap items-center justify-between gap-3 border-t border-border bg-muted/40 px-6 py-4">
        <span class="text-[10px] text-muted-foreground">
          Dicatat pada: {{ $absen->created_at ? $absen->created_at->translatedFormat('d M Y, H:i') : '-' }}
        </span>

        <form
          action="{{ route('absen.destroy', $absen->id_absen) }}"
          method="POST"
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi ini?')"
        >
          @csrf
          @method('DELETE')

          <x-ui.button type="submit" variant="ghost" size="sm" class="text-destructive hover:bg-destructive/10 hover:text-destructive">
            <x-lucide-trash-2 />
            Hapus Data
          </x-ui.button>
        </form>
      </div>
    </x-ui.card>
  </div>
@endsection
