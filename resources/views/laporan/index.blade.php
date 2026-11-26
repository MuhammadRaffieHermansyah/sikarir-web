@extends('layouts.app')

@section('title', 'Laporan & Export Data - SiKarir BLK')

@php
  $opsiJadwal = function () use ($jadwals) {
      $html = '<option value="">-- Semua Jadwal --</option>';
      foreach ($jadwals as $j) {
          $periode = trim(($j->tanggal_mulai?->format('d M') ?? '') . ' - ' . ($j->tanggal_selesai?->format('d M Y') ?? ''), ' -');
          $html .= '<option value="' . $j->id_jadwal . '">' . e(($j->pelatihan->nama_pelatihan ?? 'Pelatihan #' . $j->id_jadwal) . ($periode ? " ({$periode})" : '')) . '</option>';
      }

      return $html;
  };
@endphp

@section('content')
  <x-ui.page-header
    title="Laporan & Export Data"
    description="Unduh laporan data BLK dalam format CSV yang bisa langsung dibuka di Microsoft Excel atau Google Sheets."
  />

  <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    {{-- Data Peserta --}}
    <x-ui.card variant="sectioned">
      <x-ui.card-header>
        <x-ui.card-title class="flex items-center gap-2">
          <x-lucide-users-round class="size-4 text-primary" />
          Data Peserta
        </x-ui.card-title>
        <x-ui.card-description>Biodata seluruh peserta beserta jumlah kelas dan sertifikat. ({{ $jumlah['peserta'] }} data)</x-ui.card-description>
      </x-ui.card-header>
      <x-ui.card-content class="flex justify-end">
        <x-ui.button href="{{ route('laporan.peserta') }}" size="sm">
          <x-lucide-download />
          Export CSV
        </x-ui.button>
      </x-ui.card-content>
    </x-ui.card>

    {{-- Pendaftaran Kelas --}}
    <x-ui.card variant="sectioned">
      <x-ui.card-header>
        <x-ui.card-title class="flex items-center gap-2">
          <x-lucide-calendar-fold class="size-4 text-primary" />
          Pendaftaran Kelas Pelatihan
        </x-ui.card-title>
        <x-ui.card-description>Daftar peserta per jadwal pelatihan beserta status kelasnya. ({{ $jumlah['pendaftaran'] }} data)</x-ui.card-description>
      </x-ui.card-header>
      <x-ui.card-content>
        <form method="GET" action="{{ route('laporan.pendaftaran') }}" class="flex flex-col gap-2 sm:flex-row sm:items-end">
          <x-ui.field class="flex-1">
            <x-ui.field-label for="pendaftaran_jadwal">Jadwal</x-ui.field-label>
            <x-ui.select name="id_jadwal" id="pendaftaran_jadwal" native class="w-full">{!! $opsiJadwal() !!}</x-ui.select>
          </x-ui.field>
          <x-ui.button type="submit" size="sm">
            <x-lucide-download />
            Export CSV
          </x-ui.button>
        </form>
      </x-ui.card-content>
    </x-ui.card>

    {{-- Sertifikat --}}
    <x-ui.card variant="sectioned">
      <x-ui.card-header>
        <x-ui.card-title class="flex items-center gap-2">
          <x-lucide-award class="size-4 text-primary" />
          Sertifikat Terbit
        </x-ui.card-title>
        <x-ui.card-description>Nomor sertifikat, tanggal terbit, dan pemiliknya. ({{ $jumlah['sertifikat'] }} data)</x-ui.card-description>
      </x-ui.card-header>
      <x-ui.card-content>
        <form method="GET" action="{{ route('laporan.sertifikat') }}" class="flex flex-col gap-2 sm:flex-row sm:items-end">
          <x-ui.field class="flex-1">
            <x-ui.field-label for="sertifikat_jadwal">Jadwal</x-ui.field-label>
            <x-ui.select name="id_jadwal" id="sertifikat_jadwal" native class="w-full">{!! $opsiJadwal() !!}</x-ui.select>
          </x-ui.field>
          <x-ui.button type="submit" size="sm">
            <x-lucide-download />
            Export CSV
          </x-ui.button>
        </form>
      </x-ui.card-content>
    </x-ui.card>

    {{-- Lamaran Kerja --}}
    <x-ui.card variant="sectioned">
      <x-ui.card-header>
        <x-ui.card-title class="flex items-center gap-2">
          <x-lucide-briefcase-business class="size-4 text-primary" />
          Lamaran Kerja
        </x-ui.card-title>
        <x-ui.card-description>Lamaran peserta ke lowongan mitra beserta statusnya. ({{ $jumlah['lamaran'] }} data)</x-ui.card-description>
      </x-ui.card-header>
      <x-ui.card-content>
        <form method="GET" action="{{ route('laporan.lamaran') }}" class="flex flex-col gap-2 sm:flex-row sm:items-end">
          <x-ui.field class="flex-1">
            <x-ui.field-label for="lamaran_status">Status</x-ui.field-label>
            <x-ui.select name="status" id="lamaran_status" native class="w-full">
              <option value="">-- Semua Status --</option>
              @foreach ($statusLamaran as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
              @endforeach
            </x-ui.select>
          </x-ui.field>
          <x-ui.button type="submit" size="sm">
            <x-lucide-download />
            Export CSV
          </x-ui.button>
        </form>
      </x-ui.card-content>
    </x-ui.card>

    {{-- Rekap Presensi (sudah ada) --}}
    <x-ui.card variant="sectioned" class="lg:col-span-2">
      <x-ui.card-header>
        <x-ui.card-title class="flex items-center gap-2">
          <x-lucide-clipboard-list class="size-4 text-primary" />
          Rekap Presensi
        </x-ui.card-title>
        <x-ui.card-description>Rekap kehadiran per peserta dengan filter jadwal, tanggal, dan status. Tersedia export CSV dan cetak/PDF.</x-ui.card-description>
      </x-ui.card-header>
      <x-ui.card-content class="flex justify-end gap-2">
        <x-ui.button href="{{ route('absen.export') }}" variant="outline" size="sm">
          <x-lucide-download />
          Export CSV
        </x-ui.button>
        <x-ui.button href="{{ route('absen.rekap') }}" size="sm">
          <x-lucide-arrow-right />
          Buka Rekap
        </x-ui.button>
      </x-ui.card-content>
    </x-ui.card>
  </div>
@endsection
