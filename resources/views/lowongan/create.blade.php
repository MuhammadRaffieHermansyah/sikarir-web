@extends('layouts.app')

@section('title', 'Buka Lowongan Magang - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('lowongan.index') }}" class="hover:text-emerald-700 transition">Lowongan Magang</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Tambah Lowongan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Publikasikan Lowongan Magang Industri</h1>
      <p class="text-xs text-slate-500 mt-0.5">Buat posting lowongan baru dari mitra DU/DI untuk penyaluran siswa lulusan vokasi BLK.</p>
    </div>
    <a href="{{ route('lowongan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
  </div>

  @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
      <div class="font-bold flex items-center gap-1.5"><i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i> Mohon perbaiki kesalahan berikut:</div>
      <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('lowongan.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <i data-lucide="briefcase" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Informasi Posisi & Perusahaan</h2>
        </div>

        <div class="space-y-4">
          <div>
            <label for="judul_lowongan" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Judul Posisi Lowongan <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="judul_lowongan" id="judul_lowongan" value="{{ old('judul_lowongan') }}" required placeholder="Contoh: Teknisi Mesin CNC / Staff Administrasi Gudang" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 @error('judul_lowongan') border-rose-400 bg-rose-50/50 @enderror" />
            @error('judul_lowongan')<p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>@enderror
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="id_mitra" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Mitra Industri DU/DI <span class="text-rose-500">*</span>
              </label>
              <select name="id_mitra" id="id_mitra" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 @error('id_mitra') border-rose-400 bg-rose-50/50 @enderror">
                <option value="">-- Pilih Mitra Perusahaan --</option>
                @foreach($mitras as $mitra)
                  <option value="{{ $mitra->id_mitra }}" {{ old('id_mitra') == $mitra->id_mitra ? 'selected' : '' }}>
                    {{ $mitra->nama_perusahaan }}
                  </option>
                @endforeach
              </select>
              @error('id_mitra')<p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label for="id_admin" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Admin BLK Penanggung Jawab <span class="text-rose-500">*</span>
              </label>
              <select name="id_admin" id="id_admin" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 @error('id_admin') border-rose-400 bg-rose-50/50 @enderror">
                <option value="">-- Pilih Admin BLK --</option>
                @foreach($admins as $admin)
                  <option value="{{ $admin->id_admin }}" {{ old('id_admin') == $admin->id_admin ? 'selected' : '' }}>
                    {{ $admin->user->name ?? 'Admin' }} (NIP: {{ $admin->nip ?? '-' }})
                  </option>
                @endforeach
              </select>
              @error('id_admin')<p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>@enderror
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="lokasi" class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi Penempatan</label>
              <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Bandung, Jawa Barat" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700" />
            </div>

            <div>
              <label for="tanggal_posting" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Posting</label>
              <input type="date" name="tanggal_posting" id="tanggal_posting" value="{{ old('tanggal_posting', date('Y-m-d')) }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700" />
            </div>
          </div>

          <div>
            <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Publikasi <span class="text-rose-500">*</span></label>
            <select name="status" id="status" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700">
              <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif (Langsung Dipublikasikan)</option>
              <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Belum Dipublikasikan)</option>
              <option value="ditutup" {{ old('status') == 'ditutup' ? 'selected' : '' }}>Ditutup (Tidak Menerima Pendaftar)</option>
            </select>
          </div>

          <div>
            <label for="deskripsi" class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Pekerjaan & Tanggung Jawab</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Jelaskan peran, tanggung jawab, dan manfaat magang di perusahaan ini..." class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700">{{ old('deskripsi') }}</textarea>
          </div>

          <div>
            <label for="kualifikasi" class="block text-xs font-semibold text-slate-700 mb-1.5">Kualifikasi & Persyaratan Peserta</label>
            <textarea name="kualifikasi" id="kualifikasi" rows="4" placeholder="Contoh: Minimal lulus program las, mampu membaca gambar teknik, sehat jasmani/rohani..." class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700">{{ old('kualifikasi') }}</textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i> Panduan Lowongan
        </h3>
        <p class="text-xs text-slate-600 leading-relaxed">
          Pastikan mitra DU/DI sudah terdaftar di sistem sebelum membuka lowongan. Lowongan akan langsung tampil di portal jika statusnya <strong>Aktif</strong>.
        </p>
        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="save" class="w-4 h-4"></i> Publikasikan Lowongan
          </button>
          <a href="{{ route('lowongan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">Batal</a>
        </div>
      </div>
    </div>
  </form>
@endsection
