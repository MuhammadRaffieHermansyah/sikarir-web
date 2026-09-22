@extends('layouts.app')

@section('title', 'Dashboard Utama - SIKARIR')

@section('content')
  <!-- Hero / Banner Welcome Section -->
  <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 p-6 md:p-8 text-white shadow-lg border border-emerald-800/40">
    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
      <div class="space-y-2 max-w-2xl">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 rounded-full border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-sm">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          SIMAGANG & SIKARIR BLK
        </div>
        <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white">
          Selamat Datang di SIKARIR
        </h1>
        <p class="text-emerald-100/80 text-xs md:text-sm leading-relaxed">
          Sistem Informasi Karir & Pelatihan Vokasi Balai Latihan Kerja. Monitor operasional pelatihan, magang industri, hingga penerbitan sertifikasi kompetensi.
        </p>
      </div>

      <a href="{{ url('/api/documentation') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-emerald-900 font-bold text-xs rounded-xl shadow-md hover:bg-emerald-50 transition shrink-0 group">
        <i data-lucide="file-code" class="w-4 h-4 text-emerald-700"></i>
        <span>Swagger API Docs</span>
        <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
      </a>
    </div>

    <!-- Decorative Gradient Blob -->
    <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
  </div>

  <!-- Component Stat Cards (opsional kalau ada) -->
  @if(View::exists('components.stat-cards'))
    <x-stat-cards />
  @endif

  <!-- Navigation Grid Section -->
  <div class="space-y-4">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-base font-bold text-slate-900 tracking-tight">Navigasi Modul Utama</h2>
        <p class="text-xs text-slate-500">Pilih modul di bawah untuk mengelola data operasional BLK.</p>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      <!-- Mitra -->
      <a href="{{ route('mitras.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
              Mitra
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="building-2" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Kelola Mitra Perusahaan
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Daftar, tambah, dan kelola data perusahaan mitra kerja sama industri.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Peserta -->
      <a href="{{ route('pesertas.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-2.5 py-1 rounded-md border border-teal-100">
              Peserta
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="users" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Kelola Data Peserta
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Data pribadi, NIK, kontak, dan riwayat keikutsertaan peserta pelatihan.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Admin BLK -->
      <a href="{{ route('admin-blk.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-700 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200">
              Admin BLK
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="shield-check" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Admin & Instruktur BLK
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Kelola akun pengguna, hak akses, dan penugasan staf administrator BLK.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Lowongan -->
      <a href="{{ route('lowongan.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-purple-700 bg-purple-50 px-2.5 py-1 rounded-md border border-purple-100">
              Lowongan
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="briefcase" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Lowongan Pekerjaan
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Publikasi dan kelola informasi lowongan kerja aktif dari perusahaan mitra.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Pelatihan -->
      <a href="{{ route('pelatihan.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
              Program Pelatihan
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="book-open" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Daftar Program Pelatihan
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Program kejuruan, kurikulum, dan katalog pelatihan vokasi BLK.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Jadwal -->
      <a href="{{ route('jadwal-pelatihan.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-100">
              Jadwal Pelatihan
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Jadwal & Kuota Batch
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Atur tanggal mulai, tanggal selesai, kuota, tempat, dan status gelombang.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Kelas -->
      <a href="{{ route('kelas-pelatihan.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-cyan-700 bg-cyan-50 px-2.5 py-1 rounded-md border border-cyan-100">
              Kelas
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="graduation-cap" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Pendaftaran Peserta Kelas
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Kelola penempatan, verifikasi pendaftaran, dan daftar anggota kelas.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Absensi -->
      <a href="{{ route('absen.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-rose-700 bg-rose-50 px-2.5 py-1 rounded-md border border-rose-100">
              Absensi
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="clipboard-check" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Presensi Peserta Harian
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Pencatatan hadir, izin, sakit, dan alpa peserta pelatihan harian.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>

      <!-- Sertifikat -->
      <a href="{{ route('sertifikat.index') }}" class="group relative p-5 bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-800 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200/80">
              Sertifikat
            </span>
            <div class="p-2 bg-slate-50 text-slate-600 rounded-lg group-hover:bg-emerald-900 group-hover:text-white transition-colors">
              <i data-lucide="award" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
            Penerbitan Sertifikat
          </div>
          <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
            Penomoran, tanggal terbit, dan unggah berkas sertifikat digital kelulusan.
          </p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-semibold text-slate-400 group-hover:text-emerald-700">
          <span>Akses Modul</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </div>
      </a>
    </div>
  </div>
@endsection