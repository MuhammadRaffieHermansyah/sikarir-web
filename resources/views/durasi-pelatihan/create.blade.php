@extends('layouts.app')

@section('title', 'Tambah Durasi Pelatihan - BLK CONNECT')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('durasi-pelatihan.index') }}" class="hover:text-emerald-700 transition">Durasi Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Tambah Durasi</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Tambah Durasi Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Definisikan kombinasi jumlah hari dan jam pelaksanaan program pelatihan.</p>
    </div>

    <div>
      <a href="{{ route('durasi-pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
      </a>
    </div>
  </div>

  @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
      <div class="font-bold flex items-center gap-1.5">
        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
        Mohon perbaiki beberapa kesalahan berikut:
      </div>
      <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form Layout: 2 Columns -->
  <form action="{{ route('durasi-pelatihan.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <i data-lucide="timer" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Informasi Durasi</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="hari" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Jumlah Hari <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
              <input type="number" name="hari" id="hari" value="{{ old('hari') }}" min="1" max="366" class="w-full pl-3 pr-12 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('hari') border-rose-400 bg-rose-50/50 @enderror" />
              <span class="absolute right-3 top-2 text-xs text-slate-400 font-medium">Hari</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Lama hari efektif pelaksanaan pelatihan.</p>
            @error('hari')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="jam" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Jumlah Jam <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
              <input type="number" name="jam" id="jam" value="{{ old('jam') }}" min="1" max="8760" class="w-full pl-3 pr-12 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('jam') border-rose-400 bg-rose-50/50 @enderror" />
              <span class="absolute right-3 top-2 text-xs text-slate-400 font-medium">Jam</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Total jam pelajaran (JP) kurikulum.</p>
            @error('jam')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Petunjuk & Tombol Simpan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          Panduan Pengisian
        </h3>
        <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
          <p>
            Kombinasi <strong>Hari</strong> dan <strong>Jam</strong> akan ditampilkan sebagai pilihan durasi saat membuat program pelatihan.
          </p>
          <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 text-[11px] text-slate-500">
            Contoh: <span class="font-bold text-slate-700">5 Hari / 40 Jam</span>, <span class="font-bold text-slate-700">10 Hari / 80 Jam</span>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="save" class="w-4 h-4"></i> Simpan Durasi
          </button>
          <a href="{{ route('durasi-pelatihan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>
    </div>
  </form>
@endsection