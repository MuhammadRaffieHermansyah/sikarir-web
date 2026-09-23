@extends('layouts.app')

@section('title', 'Edit Status Kelas Pelatihan - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('kelas-pelatihan.index') }}" class="hover:text-emerald-700 transition">Kelas Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Penempatan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Perbarui Status Siswa di Kelas</h1>
      <p class="text-xs text-slate-500 mt-0.5">Ubah status keaktifan, kelulusan, atau pemindahan batch kelas.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('kelas-pelatihan.show', $kelas->id_kelas) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4"></i> Lihat Detail
      </a>
      <a href="{{ route('kelas-pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
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
  <form action="{{ route('kelas-pelatihan.update', $kelas->id_kelas) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @method('PUT')

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
              <i data-lucide="graduation-cap" class="w-4 h-4"></i>
            </div>
            <h2 class="font-bold text-slate-800 text-sm">Informasi Penempatan Siswa</h2>
          </div>
          <span class="text-xs font-mono font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md">
            ID: #KLS-{{ str_pad((string)$kelas->id_kelas, 3, '0', STR_PAD_LEFT) }}
          </span>
        </div>

        <div class="space-y-4">
          <div>
            <label for="id_peserta" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Siswa Peserta <span class="text-rose-500">*</span>
            </label>
            <select name="id_peserta" id="id_peserta"  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_peserta') border-rose-400 bg-rose-50/50 @enderror">
              @foreach($pesertas as $peserta)
                <option value="{{ $peserta->id_peserta }}" {{ old('id_peserta', $kelas->id_peserta) == $peserta->id_peserta ? 'selected' : '' }}>
                  {{ $peserta->user->name ?? 'Peserta' }} (NIS: {{ $peserta->nomor_peserta }})
                </option>
              @endforeach
            </select>
            @error('id_peserta')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="id_jadwal" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Batch Jadwal Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="id_jadwal" id="id_jadwal"  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_jadwal') border-rose-400 bg-rose-50/50 @enderror">
              @foreach($jadwals as $jadwal)
                <option value="{{ $jadwal->id_jadwal }}" {{ old('id_jadwal', $kelas->id_jadwal) == $jadwal->id_jadwal ? 'selected' : '' }}>
                  {{ $jadwal->pelatihan->nama_pelatihan ?? 'Pelatihan' }} - [Batch: #JDW-{{ str_pad((string)$jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}]
                </option>
              @endforeach
            </select>
            @error('id_jadwal')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Status Kelulusan / Keaktifan Siswa <span class="text-rose-500">*</span>
            </label>
            <select name="status" id="status"  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('status') border-rose-400 bg-rose-50/50 @enderror">
              <option value="terdaftar" {{ old('status', $kelas->status) == 'terdaftar' ? 'selected' : '' }}>Terdaftar (Menunggu Mulai)</option>
              <option value="aktif" {{ old('status', $kelas->status) == 'aktif' ? 'selected' : '' }}>Aktif (Sedang Mengikuti)</option>
              <option value="lulus" {{ old('status', $kelas->status) == 'lulus' ? 'selected' : '' }}>Lulus (Telah Menyelesaikan)</option>
              <option value="tidak lulus" {{ old('status', $kelas->status) == 'tidak lulus' ? 'selected' : '' }}>Tidak Lulus (Drop Out / Tidak Memenuhi Syarat)</option>
            </select>
            @error('status')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Status & Simpan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4 text-emerald-700"></i>
          Aksi Pembaruan
        </h3>
        
        <div class="text-xs text-slate-500 space-y-2">
          <div class="flex items-center justify-between">
            <span>Didaftarkan:</span>
            <span class="font-semibold text-slate-700">{{ $kelas->created_at ? $kelas->created_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Status Saat Ini:</span>
            <span class="font-semibold text-emerald-800 uppercase text-[10px]">{{ $kelas->status }}</span>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="check" class="w-4 h-4"></i> Simpan Perubahan
          </button>
          <a href="{{ route('kelas-pelatihan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>

      <div class="bg-rose-50/50 rounded-xl border border-rose-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-rose-800 text-xs flex items-center gap-1.5">
          <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i> Hapus dari Kelas
        </h4>
        <p class="text-[11px] text-rose-600 leading-relaxed">
          Mengeluarkan siswa dari kelas akan membatalkan status keikutsertaan dalam batch ini.
        </p>
      </div>
    </div>
  </form>
@endsection
