@extends('layouts.app')

@section('title', 'Dashboard Mitra - SiKarir')

@section('content')
  @if (! $isVerified)
    <x-ui.card class="relative overflow-hidden border-amber-500/30 bg-gradient-to-br from-amber-500/10 via-background to-background">
      <div class="relative z-10 max-w-2xl space-y-4">
        <x-ui.badge tone="warning" class="gap-1.5"><x-lucide-clock-3 class="size-3.5" /> Menunggu Verifikasi</x-ui.badge>
        <div>
          <h1 class="text-2xl font-black tracking-tight text-foreground md:text-3xl">Pendaftaran mitra sedang ditinjau</h1>
          <p class="mt-2 text-sm leading-relaxed text-muted-foreground">Dokumen {{ $mitra?->nama_perusahaan ?? 'perusahaan Anda' }} sudah diterima. Admin BLK akan meninjau pengajuan sebelum akses pengelolaan lowongan dibuka.</p>
        </div>
        <x-ui.button href="{{ route('profile.edit') }}" variant="outline"><x-lucide-settings /> Lihat Profil Akun</x-ui.button>
      </div>
      <x-lucide-shield-check class="absolute -bottom-12 -right-10 size-56 text-amber-500/10" />
    </x-ui.card>

    <x-ui.card variant="sectioned">
      <x-ui.card-header class="border-b"><x-ui.card-title class="text-base font-bold">Yang terjadi selanjutnya</x-ui.card-title></x-ui.card-header>
      <x-ui.card-content class="grid gap-4 pt-5 sm:grid-cols-3">
        @foreach ([['file-check-2', 'Dokumen diterima', 'Surat legalitas dan permohonan kerja sama telah dikirim.'], ['search-check', 'Admin meninjau', 'Admin BLK akan memeriksa data dan dokumen perusahaan.'], ['badge-check', 'Akses dibuka', 'Setelah disetujui, Anda dapat membuat dan mengelola lowongan.']] as [$icon, $title, $description])
          <div class="rounded-xl border border-border bg-muted/20 p-4">
            <x-dynamic-component :component="'lucide-'.$icon" class="mb-3 size-5 text-primary" />
            <div class="text-sm font-bold text-foreground">{{ $title }}</div>
            <p class="mt-1 text-xs leading-relaxed text-muted-foreground">{{ $description }}</p>
          </div>
        @endforeach
      </x-ui.card-content>
    </x-ui.card>
  @else
    <x-ui.card class="relative overflow-hidden border-primary/30 bg-gradient-to-r from-primary via-[#0d4335] to-[#0a2f26] text-primary-foreground">
      <div class="relative z-10 flex flex-col items-start gap-5 md:flex-row md:items-center md:justify-between">
        <div class="max-w-2xl">
          <x-ui.badge class="gap-1.5 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground"><x-lucide-badge-check class="size-3.5 text-sky-300" /> Mitra Terverifikasi</x-ui.badge>
          <h1 class="mt-3 text-2xl font-black tracking-tight text-white md:text-3xl">{{ $mitra->nama_perusahaan }}</h1>
          <p class="mt-2 text-sm leading-relaxed text-primary-foreground/75">Kelola lowongan kerja, pantau posisi aktif, dan lihat jumlah pelamar dari satu tempat.</p>
        </div>
        <x-ui.button href="{{ route('lowongan.create') }}" variant="secondary" class="shrink-0 bg-white font-bold text-primary hover:bg-white/90"><x-lucide-plus /> Buka Lowongan Baru</x-ui.button>
      </div>
      <x-lucide-briefcase-business class="absolute -bottom-12 -right-8 size-56 text-white/5" />
    </x-ui.card>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
      <x-ui.stat label="Lowongan Aktif" :value="$statistics['aktif'].' Posisi'" icon="briefcase-business" />
      <x-ui.stat label="Draft" :value="$statistics['draft'].' Posisi'" icon="file-pen-line" />
      <x-ui.stat label="Ditutup" :value="$statistics['ditutup'].' Posisi'" icon="circle-x" />
      <x-ui.stat label="Total Pelamar" :value="$statistics['pelamar'].' Orang'" icon="users-round" />
    </div>

    <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
      <x-ui.card-header class="border-b pb-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
          <div><x-ui.card-title class="text-lg font-bold">Lowongan Terbaru Saya</x-ui.card-title><x-ui.card-description>Ringkasan lima lowongan terakhir dari perusahaan Anda.</x-ui.card-description></div>
          <x-ui.button href="{{ route('lowongan.index') }}" variant="outline" size="sm">Kelola Semua <x-lucide-arrow-right /></x-ui.button>
        </div>
      </x-ui.card-header>
      <x-ui.card-content class="px-0">
        @if ($lowongans->isEmpty())
          <x-ui.empty class="border-0 py-12">
            <x-ui.empty-header><x-ui.empty-media variant="icon"><x-lucide-briefcase-business /></x-ui.empty-media><x-ui.empty-title>Belum ada lowongan</x-ui.empty-title><x-ui.empty-description>Mulai publikasikan posisi pertama dari perusahaan Anda.</x-ui.empty-description></x-ui.empty-header>
            <x-ui.button href="{{ route('lowongan.create') }}"><x-lucide-plus /> Buat Lowongan</x-ui.button>
          </x-ui.empty>
        @else
          <x-ui.table>
            <x-ui.table-header><x-ui.table-row class="bg-muted/50 hover:bg-muted/50"><x-ui.table-head class="px-5">Posisi</x-ui.table-head><x-ui.table-head>Lokasi</x-ui.table-head><x-ui.table-head>Status</x-ui.table-head><x-ui.table-head class="text-center">Pelamar</x-ui.table-head><x-ui.table-head class="text-end">Aksi</x-ui.table-head></x-ui.table-row></x-ui.table-header>
            <x-ui.table-body>
              @foreach ($lowongans as $lowongan)
                @php($tone = match ($lowongan->status) { 'aktif' => 'success', 'draft' => 'warning', default => 'secondary' })
                <x-ui.table-row>
                  <x-ui.table-cell class="px-5 py-4"><div class="font-bold text-foreground">{{ $lowongan->judul_lowongan }}</div><div class="mt-1 text-xs text-muted-foreground">Diposting {{ $lowongan->tanggal_posting?->translatedFormat('d M Y') ?? '-' }}</div></x-ui.table-cell>
                  <x-ui.table-cell class="font-medium text-muted-foreground">{{ $lowongan->lokasi }}</x-ui.table-cell>
                  <x-ui.table-cell><x-ui.badge :tone="$tone">{{ ucfirst($lowongan->status) }}</x-ui.badge></x-ui.table-cell>
                  <x-ui.table-cell class="text-center"><x-ui.badge variant="secondary" class="gap-1"><x-lucide-users-round class="size-3" /> {{ $lowongan->lamaran_count }}</x-ui.badge></x-ui.table-cell>
                  <x-ui.table-cell class="text-end"><x-ui.button href="{{ route('lowongan.show', $lowongan) }}" variant="ghost" size="icon-sm" title="Lihat lowongan"><x-lucide-arrow-up-right /></x-ui.button></x-ui.table-cell>
                </x-ui.table-row>
              @endforeach
            </x-ui.table-body>
          </x-ui.table>
        @endif
      </x-ui.card-content>
    </x-ui.card>
  @endif
@endsection
