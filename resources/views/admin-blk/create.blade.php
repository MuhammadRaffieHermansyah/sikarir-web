@extends('layouts.app')

@section('title', 'Tambah Administrator BLK - SIMAGANG')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Admin BLK</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Tambah Baru</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Registrasi Administrator BLK</h1>
      <p class="text-xs text-slate-500 mt-0.5">Daftarkan personel pengelola balai latihan kerja untuk mengelola pelatihan, mitra industri, dan verifikasi sertifikat.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('admin-blk.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
      </a>
    </div>
  </div>

  <!-- Form Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form (Left 2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <form method="POST" action="{{ route('admin-blk.store') }}" class="space-y-6">
        @csrf

        <!-- Card 1: Informasi Akun Pengguna -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="user-check" class="w-4 h-4"></i>
            </div>
            <div>
              <h2 class="font-bold text-slate-800 text-sm">Akun Pengguna</h2>
              <p class="text-xs text-slate-500">Pilih akun pengguna yang akan diberikan hak akses sebagai Administrator BLK.</p>
            </div>
          </div>

          <div>
            <label for="id_user" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Pilih Pengguna <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
              <select name="id_user" id="id_user" required class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="">-- Pilih Akun Pengguna Terdaftar --</option>
                @foreach($users ?? [] as $user)
                  <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }}) - Role: {{ $user->role ?? 'User' }}
                  </option>
                @endforeach
              </select>
            </div>
            @error('id_user')
              <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1">
                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
              </p>
            @enderror
            <p class="text-[11px] text-slate-400 mt-1.5">Hanya akun pengguna aktif yang dapat ditugaskan sebagai Administrator Balai.</p>
          </div>
        </div>

        <!-- Card 2: Penugasan & Wewenang Balai -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="building" class="w-4 h-4"></i>
            </div>
            <div>
              <h2 class="font-bold text-slate-800 text-sm">Penugasan & Balai Operasional</h2>
              <p class="text-xs text-slate-500">Tentukan unit balai dan cakupan kewenangan staf administrator.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Unit Balai Kerja</label>
              <input type="text" value="BLK Pusat Vokasi & Pelatihan Kerja" readonly class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-600 font-medium cursor-not-allowed">
              <span class="text-[10px] text-slate-400 mt-1 block">Unit default sistem saat ini</span>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Level Hak Akses</label>
              <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-lg px-3.5 py-2 text-xs font-semibold text-emerald-800">
                <i data-lucide="shield" class="w-4 h-4 text-emerald-600"></i>
                <span>Super Administrator BLK</span>
              </div>
            </div>
          </div>

          <!-- Permissions Checklist Preview -->
          <div class="pt-2">
            <label class="block text-xs font-semibold text-slate-700 mb-2">Cakupan Otoritas Sistem yang Diberikan:</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
              <div class="flex items-start gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                <div>
                  <div class="text-xs font-bold text-slate-800">Manajemen Pelatihan</div>
                  <div class="text-[11px] text-slate-500">Membuat dan mengelola silabus kelas & jadwal.</div>
                </div>
              </div>

              <div class="flex items-start gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                <div>
                  <div class="text-xs font-bold text-slate-800">Approval Jurnal & Presensi</div>
                  <div class="text-[11px] text-slate-500">Validasi kegiatan harian peserta magang.</div>
                </div>
              </div>

              <div class="flex items-start gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                <div>
                  <div class="text-xs font-bold text-slate-800">Kerjasama Mitra Industri</div>
                  <div class="text-[11px] text-slate-500">Posting lowongan dan sinkronisasi kuota magang.</div>
                </div>
              </div>

              <div class="flex items-start gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                <div>
                  <div class="text-xs font-bold text-slate-800">Penerbitan Sertifikat</div>
                  <div class="text-[11px] text-slate-500">Validasi kelulusan dan nomor sertifikat resmi.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="{{ route('admin-blk.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition shadow-sm">
            Batalkan
          </a>
          <button type="submit" class="px-6 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center gap-2 transition">
            <i data-lucide="save" class="w-4 h-4"></i>
            <span>Simpan Administrator</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Side Guidance Cards (Right 1 Col) -->
    <div class="space-y-6">
      <!-- Panduan Administrator -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-xs pb-3 border-b border-slate-100">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          <span>Panduan Pengisian</span>
        </div>
        <ul class="text-xs text-slate-600 space-y-3">
          <li class="flex items-start gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
            <span>Pastikan akun pengguna sudah dibuat dan memiliki status aktif di sistem.</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
            <span>Satu akun pengguna hanya dapat ditugaskan untuk satu profil administrator BLK.</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
            <span>Setelah disimpan, administrator dapat langsung login dan mengelola modul BLK.</span>
          </li>
        </ul>
      </div>

      <!-- Keamanan & Standar Operasional -->
      <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-xl p-5 shadow-sm space-y-3">
        <div class="flex items-center gap-2 text-emerald-400 font-bold text-xs">
          <i data-lucide="lock" class="w-4 h-4"></i>
          <span>Keamanan & Otoritas</span>
        </div>
        <p class="text-[11px] text-slate-300 leading-relaxed">
          Hak akses Administrator BLK memiliki wewenang penuh dalam mengesahkan jurnal harian peserta magang dan validasi kelulusan program kejuruan.
        </p>
        <div class="pt-2 border-t border-slate-700/60 flex items-center justify-between text-[11px] text-slate-400">
          <span>SIMAGANG Vokasi</span>
          <span class="text-emerald-400 font-semibold">Terkoneksi BLK</span>
        </div>
      </div>
    </div>
  </div>
@endsection

