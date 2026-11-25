@extends('layouts.app')

@section('title', 'Dashboard Utama - SIKARIR')

@section('content')
  <x-ui.card class="relative overflow-hidden border-primary/30 bg-gradient-to-r from-primary via-[#0d4335] to-[#0a2f26] text-primary-foreground">
    <div class="relative z-10 flex flex-col items-start gap-6 md:flex-row md:items-center md:justify-between">
      <div class="max-w-2xl space-y-3">
        <x-ui.badge class="gap-2 border-primary-foreground/20 bg-primary-foreground/10 text-primary-foreground">
          <span class="size-2 animate-pulse rounded-full bg-sikarir-lime"></span>
          SIKARIR BLK
        </x-ui.badge>
        <h1 class="text-2xl font-black tracking-tight text-white md:text-3xl">Selamat Datang di SIKARIR</h1>
        <p class="text-sm leading-relaxed text-primary-foreground/75">
          Sistem Informasi Karir & Pelatihan Vokasi Balai Latihan Kerja. Monitor operasional pelatihan hingga penerbitan sertifikasi kompetensi.
        </p>
      </div>

      <x-ui.button href="{{ url('/api/documentation') }}" target="_blank" variant="secondary" class="shrink-0 bg-white text-primary hover:bg-white/90">
        <x-lucide-file-code />
        Swagger API Docs
        <x-lucide-external-link />
      </x-ui.button>
    </div>

    <div class="pointer-events-none absolute -bottom-16 -right-16 size-64 rounded-full bg-sikarir-lime/10 blur-3xl"></div>
  </x-ui.card>

  @if (auth()->user()->role === 'mitra' && ! auth()->user()->mitra?->is_verified)
    <x-ui.alert tone="info" class="mt-6">
      <x-lucide-clock-3 />
      <x-ui.alert-title>Verifikasi mitra masih diproses</x-ui.alert-title>
      <x-ui.alert-description>Dokumen perusahaan Anda sedang ditinjau admin. Akses untuk mengelola lowongan akan aktif setelah akun diverifikasi.</x-ui.alert-description>
    </x-ui.alert>
  @endif

  @if (View::exists('components.stat-cards'))
    <x-stat-cards />
  @endif

  <x-ui.page-header
    title="Navigasi Modul Utama"
    description="Pilih modul di bawah untuk mengelola data operasional BLK."
  />

  @if (auth()->user()->role !== 'mitra' || auth()->user()->mitra?->is_verified)
  <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ([
      ['Mitra', 'building-2', 'Kelola Mitra Perusahaan', 'Daftar, tambah, dan kelola data perusahaan mitra kerja sama industri.', 'mitras.index'],
      ['Peserta', 'users', 'Kelola Data Peserta', 'Data pribadi, NIK, kontak, dan riwayat keikutsertaan peserta pelatihan.', 'pesertas.index'],
      ['Admin BLK', 'shield-check', 'Admin & Instruktur BLK', 'Kelola akun pengguna, hak akses, dan penugasan staf administrator BLK.', 'admin-blk.index'],
      ['Lowongan', 'briefcase', 'Lowongan Pekerjaan', 'Publikasi dan kelola informasi lowongan kerja aktif dari perusahaan mitra.', 'lowongan.index'],
      ['Program Pelatihan', 'book-open', 'Daftar Program Pelatihan', 'Program kejuruan, kurikulum, dan katalog pelatihan vokasi BLK.', 'pelatihan.index'],
      ['Jadwal & Kelas', 'calendar', 'Jadwal & Kuota Batch', 'Atur tanggal mulai, tanggal selesai, kuota, tempat, dan status gelombang.', 'jadwal-pelatihan.index'],
      ['Kelas', 'graduation-cap', 'Pendaftaran Peserta Kelas', 'Kelola penempatan, verifikasi pendaftaran, dan daftar anggota kelas.', 'kelas-pelatihan.index'],
      ['Absensi', 'clipboard-check', 'Presensi Peserta Harian', 'Pencatatan hadir, izin, sakit, dan alpa peserta pelatihan harian.', 'absen.index'],
      ['Sertifikat', 'award', 'Penerbitan Sertifikat', 'Penomoran, tanggal terbit, dan unggah berkas sertifikat digital kelulusan.', 'sertifikat.index'],
    ] as [$label, $icon, $title, $description, $route])
      <a href="{{ route($route) }}" class="group block outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 rounded-xl">
        <x-ui.card class="flex h-full flex-col justify-between transition-all hover:border-primary/40 hover:shadow-md">
          <div>
            <div class="mb-3 flex items-center justify-between">
              <x-ui.badge variant="secondary" size="sm" class="uppercase tracking-wide">{{ $label }}</x-ui.badge>
              <span class="grid size-9 place-items-center rounded-lg bg-muted text-muted-foreground transition-colors group-hover:bg-primary group-hover:text-primary-foreground">
                <x-dynamic-component :component="'lucide-'.$icon" class="size-4" />
              </span>
            </div>
            <div class="text-sm font-bold text-foreground transition-colors group-hover:text-primary">{{ $title }}</div>
            <p class="mt-1.5 text-xs leading-relaxed text-muted-foreground">{{ $description }}</p>
          </div>
          <div class="mt-4 flex items-center justify-between border-t border-border pt-3 text-[11px] font-semibold text-muted-foreground group-hover:text-primary">
            <span>Akses Modul</span>
            <x-lucide-arrow-right class="size-3.5 transition-transform group-hover:translate-x-1" />
          </div>
        </x-ui.card>
      </a>
    @endforeach
  </div>
  @endif
@endsection
