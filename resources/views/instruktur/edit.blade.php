@extends('layouts.app')

@section('title', 'Edit Instruktur - BLK CONNECT')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('instruktur.index') }}" class="hover:text-emerald-700 transition">Instruktur</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Instruktur</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Perbarui Instruktur</h1>
      <p class="text-xs text-slate-500 mt-0.5">Ubah nama instruktur dan bidang keahlian yang dimiliki.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('instruktur.show', $instruktur->id) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4"></i> Lihat Detail
      </a>
      <a href="{{ route('instruktur.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
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
  <form action="{{ route('instruktur.update', $instruktur->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @method('PUT')

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
              <i data-lucide="user-check" class="w-4 h-4"></i>
            </div>
            <h2 class="font-bold text-slate-800 text-sm">Informasi Instruktur</h2>
          </div>
          <span class="text-xs font-mono font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md">
            ID: #INS-{{ str_pad((string)$instruktur->id, 3, '0', STR_PAD_LEFT) }}
          </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Nama Instruktur <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $instruktur->nama) }}" maxlength="150" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('nama') border-rose-400 bg-rose-50/50 @enderror" />
            <p class="text-[11px] text-slate-400 mt-1">Hanya huruf dan spasi, maksimal 150 karakter.</p>
            @error('nama')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="bidang_keahlian" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Bidang Keahlian <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="bidang_keahlian" id="bidang_keahlian" value="{{ old('bidang_keahlian', $instruktur->bidang_keahlian) }}" maxlength="150" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('bidang_keahlian') border-rose-400 bg-rose-50/50 @enderror" />
            <p class="text-[11px] text-slate-400 mt-1">Hanya huruf dan spasi, maksimal 150 karakter.</p>
            @error('bidang_keahlian')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Aksi -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4 text-emerald-700"></i>
          Aksi Pembaruan
        </h3>

        <div class="text-xs text-slate-500 space-y-2">
          <div class="flex items-center justify-between">
            <span>Jadwal diampu:</span>
            <span class="font-semibold text-slate-700">{{ $instruktur->jadwal()->count() }} Jadwal</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Dibuat pada:</span>
            <span class="font-semibold text-slate-700">{{ $instruktur->created_at ? $instruktur->created_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Terakhir diubah:</span>
            <span class="font-semibold text-slate-700">{{ $instruktur->updated_at ? $instruktur->updated_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="check" class="w-4 h-4"></i> Simpan Perubahan
          </button>
          <a href="{{ route('instruktur.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>
    </div>
  </form>
@endsection
