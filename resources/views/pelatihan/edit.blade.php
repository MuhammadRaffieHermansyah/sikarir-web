@extends('layouts.app')

@section('title', 'Edit Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pelatihan.index') }}" class="hover:text-emerald-700 transition">Program Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Program</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Perbarui Kurikulum Program Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Edit kapasitas kuota, rincian jam pelajaran, penanggung jawab, atau deskripsi silabus.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4"></i> Lihat Detail
      </a>
      <a href="{{ route('pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
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
  <form action="{{ route('pelatihan.update', $pelatihan->id_pelatihan) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @method('PUT')

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
              <i data-lucide="book-open" class="w-4 h-4"></i>
            </div>
            <h2 class="font-bold text-slate-800 text-sm">Informasi Kejuruan & Kurikulum</h2>
          </div>
          <span class="text-xs font-mono font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md">
            ID: #PLT-{{ str_pad((string)$pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
          </span>
        </div>

        <div class="space-y-4">
          <div>
            <label for="nama_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Nama Program Kejuruan <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="nama_pelatihan" id="nama_pelatihan" value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan) }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('nama_pelatihan') border-rose-400 bg-rose-50/50 @enderror" />
            @error('nama_pelatihan')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="kuota" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Kapasitas Kuota Peserta <span class="text-rose-500">*</span>
              </label>
              <div class="relative">
                <input type="number" name="kuota" id="kuota" value="{{ old('kuota', $pelatihan->kuota) }}" min="1" required class="w-full pl-3 pr-12 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('kuota') border-rose-400 bg-rose-50/50 @enderror" />
                <span class="absolute right-3 top-2 text-xs text-slate-400 font-medium">Siswa</span>
              </div>
              @error('kuota')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="durasi_lp" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Durasi Pelatihan (Jam Pelajaran / Hari)
              </label>
              <input type="text" name="durasi_lp" id="durasi_lp" value="{{ old('durasi_lp', $pelatihan->durasi_lp) }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('durasi_lp') border-rose-400 bg-rose-50/50 @enderror" />
              @error('durasi_lp')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div>
            <label for="id_admin" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Penanggung Jawab / Instruktur Pembina
            </label>
            <select name="id_admin" id="id_admin" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_admin') border-rose-400 bg-rose-50/50 @enderror">
              <option value="">-- Pilih Instruktur / Admin BLK --</option>
              @foreach($admins as $admin)
                <option value="{{ $admin->id_admin }}" {{ old('id_admin', $pelatihan->id_admin) == $admin->id_admin ? 'selected' : '' }}>
                  {{ $admin->user->name ?? 'Admin BLK' }} (NIP: {{ $admin->nip ?? '-' }})
                </option>
              @endforeach
            </select>
            @error('id_admin')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="deskripsi_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Deskripsi Silabus & Output Kompetensi
            </label>
            <textarea name="deskripsi_pelatihan" id="deskripsi_pelatihan" rows="5" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('deskripsi_pelatihan') border-rose-400 bg-rose-50/50 @enderror">{{ old('deskripsi_pelatihan', $pelatihan->deskripsi_pelatihan) }}</textarea>
            @error('deskripsi_pelatihan')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Status, Simpan, & Danger Zone -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4 text-emerald-700"></i>
          Aksi Pembaruan
        </h3>
        
        <div class="text-xs text-slate-500 space-y-2">
          <div class="flex items-center justify-between">
            <span>Dibuat pada:</span>
            <span class="font-semibold text-slate-700">{{ $pelatihan->created_at ? $pelatihan->created_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Terakhir diubah:</span>
            <span class="font-semibold text-slate-700">{{ $pelatihan->updated_at ? $pelatihan->updated_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="check" class="w-4 h-4"></i> Simpan Perubahan
          </button>
          <a href="{{ route('pelatihan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>

      <!-- Danger Zone -->
      <div class="bg-rose-50/50 rounded-xl border border-rose-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-rose-800 text-xs flex items-center gap-1.5">
          <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i> Zona Berbahaya
        </h4>
        <p class="text-[11px] text-rose-600 leading-relaxed">
          Menghapus program ini dapat mempengaruhi jadwal dan kelas yang terhubung dengan program ini.
        </p>
      </div>
    </div>
  </form>
@endsection
