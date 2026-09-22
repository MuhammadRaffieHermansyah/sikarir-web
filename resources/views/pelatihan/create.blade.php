@extends('layouts.app')

@section('title', 'Tambah Program Pelatihan Vokasi - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pelatihan.index') }}" class="hover:text-emerald-700 transition">Program Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Tambah Program</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Tambah Kejuruan / Program Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Daftarkan kurikulum pelatihan vokasi baru dengan kapasitas kuota dan estimasi jam pelajaran.</p>
    </div>

    <div>
      <a href="{{ route('pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
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
  <form action="{{ route('pelatihan.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <i data-lucide="book-open" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Informasi Kejuruan & Kurikulum</h2>
        </div>

        <div class="space-y-4">
          <div>
            <label for="nama_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Nama Program Kejuruan <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="nama_pelatihan" id="nama_pelatihan" value="{{ old('nama_pelatihan') }}" placeholder="Contoh: Teknik Las Fabrikasi / Desain Grafis & Multimedia" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('nama_pelatihan') border-rose-400 bg-rose-50/50 @enderror" />
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
                <input type="number" name="kuota" id="kuota" value="{{ old('kuota', 16) }}" min="1" class="w-full pl-3 pr-12 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('kuota') border-rose-400 bg-rose-50/50 @enderror" />
                <span class="absolute right-3 top-2 text-xs text-slate-400 font-medium">Siswa</span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Standar kelas BLK: 16 - 20 peserta/batch.</p>
              @error('kuota')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="durasi_lp" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Durasi Pelatihan (Jam Pelajaran / Hari)
              </label>
              <input type="text" name="durasi_lp" id="durasi_lp" value="{{ old('durasi_lp', '240 JP (30 Hari)') }}" placeholder="Contoh: 240 JP atau 1.5 Bulan" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('durasi_lp') border-rose-400 bg-rose-50/50 @enderror" />
              @error('durasi_lp')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div>
            <label for="id_admin" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Penanggung Jawab / Instruktur Pembina <span class="text-rose-500">*</span>
            </label>
            <select name="id_admin" id="id_admin" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_admin') border-rose-400 bg-rose-50/50 @enderror">
              <option value="">-- Pilih Instruktur / Admin BLK --</option>
              @foreach($admins as $admin)
                <option value="{{ $admin->id_admin }}" {{ old('id_admin') == $admin->id_admin ? 'selected' : '' }}>
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
            <textarea name="deskripsi_pelatihan" id="deskripsi_pelatihan" rows="5" placeholder="Jelaskan kompetensi kerja yang akan dikuasai peserta, modul kurikulum, syarat kelulusan, dan standar uji kompetensi..." class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('deskripsi_pelatihan') border-rose-400 bg-rose-50/50 @enderror">{{ old('deskripsi_pelatihan') }}</textarea>
            @error('deskripsi_pelatihan')
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
          Panduan Kurikulum Vokasi
        </h3>
        <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
          <p>
            Pastikan nama kejuruan mengacu pada Standar Kompetensi Kerja Nasional Indonesia (<strong>SKKNI</strong>) Disnaker.
          </p>
          <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 space-y-1.5 text-[11px]">
            <div class="font-bold text-slate-700 flex items-center gap-1.5">
              <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i> Alur Pembuatan Kelas:
            </div>
            <ol class="list-decimal list-inside space-y-1 text-slate-500 pl-1">
              <li>Buat Program Pelatihan (di sini)</li>
              <li>Atur Jadwal Pelatihan & Ruangan</li>
              <li>Daftarkan Siswa ke Kelas Pelatihan</li>
            </ol>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="save" class="w-4 h-4"></i> Simpan Program Pelatihan
          </button>
          <a href="{{ route('pelatihan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>
    </div>
  </form>
@endsection
