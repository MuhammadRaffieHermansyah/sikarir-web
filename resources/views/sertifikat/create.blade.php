@extends('layouts.app')

@section('title', 'Tambah Sertifikat - BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('sertifikat.index') }}" class="hover:text-emerald-700 transition">Daftar Sertifikat</a> &gt; 
        <span class="text-slate-600 font-medium">Tambah Sertifikat</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Terbitkan Sertifikat Peserta</h1>
      <p class="text-xs text-slate-500 mt-0.5">Isi formulir di bawah untuk menerbitkan dan mengunggah dokumen sertifikat kelulusan.</p>
    </div>

    <a href="{{ route('sertifikat.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 transition self-start md:self-auto">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
  </div>

  <!-- Form Card -->
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-5 border-b border-slate-100 flex items-center gap-2.5 bg-slate-50/50">
        <div class="p-2 bg-emerald-50 text-emerald-700 rounded-lg">
          <i data-lucide="award" class="w-5 h-5"></i>
        </div>
        <div>
          <h2 class="font-bold text-slate-800 text-sm">Formulir Penerbitan Sertifikat</h2>
          <p class="text-[11px] text-slate-500">Pastikan file sertifikat berformat PDF atau Gambar (maksimal 5MB).</p>
        </div>
      </div>

      <form method="POST" action="{{ route('sertifikat.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf

        <!-- Global Error Alert -->
        @if($errors->any())
          <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 space-y-1">
            <div class="font-bold flex items-center gap-1.5">
              <i data-lucide="alert-circle" class="w-4 h-4"></i> Gagal menyimpan sertifikat:
            </div>
            <ul class="list-disc list-inside pl-1 space-y-0.5 text-slate-600">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <!-- Peserta Select -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">
              Peserta Penerima <span class="text-rose-500">*</span>
            </label>
            <select name="id_peserta" required class="w-full bg-white border @error('id_peserta') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
              <option value="">-- Pilih Peserta --</option>
              @foreach($pesertas as $p)
                <option value="{{ $p->id_peserta ?? $p->id }}" {{ old('id_peserta') == ($p->id_peserta ?? $p->id) ? 'selected' : '' }}>
                  {{ $p->user->name ?? 'Peserta #'.($p->id_peserta ?? $p->id) }} {{ isset($p->nomor_peserta) ? '('.$p->nomor_peserta.')' : '' }}
                </option>
              @endforeach
            </select>
            @error('id_peserta')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Jadwal Select -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">
              Program / Jadwal Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="id_jadwal" required class="w-full bg-white border @error('id_jadwal') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
              <option value="">-- Pilih Jadwal --</option>
              @foreach($jadwals as $j)
                <option value="{{ $j->id_jadwal ?? $j->id }}" {{ old('id_jadwal') == ($j->id_jadwal ?? $j->id) ? 'selected' : '' }}>
                  {{ $j->pelatihan->nama_pelatihan ?? '-' }} {{ $j->tanggal_mulai ? '— '.\Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') : '' }}
                </option>
              @endforeach
            </select>
            @error('id_jadwal')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <!-- Nomor Sertifikat -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">Nomor Sertifikat</label>
            <input type="text" name="no_sertifikat" value="{{ old('no_sertifikat', old('nomor_sertifikat')) }}" placeholder="Contoh: SERT/BLK/2026/001" class="w-full bg-white border @error('no_sertifikat') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
            @error('no_sertifikat')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Tanggal Terbit -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">Tanggal Terbit</label>
            <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', date('Y-m-d')) }}" class="w-full bg-white border @error('tanggal_terbit') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
            @error('tanggal_terbit')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Admin Penanggung Jawab -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">Admin Penanggung Jawab</label>
            <select name="id_admin" class="w-full bg-white border @error('id_admin') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
              <option value="">-- Pilih Admin --</option>
              @foreach($admins as $a)
                <option value="{{ $a->id_admin ?? $a->id }}" {{ old('id_admin') == ($a->id_admin ?? $a->id) ? 'selected' : '' }}>
                  {{ $a->user->name ?? 'Admin #'.($a->id_admin ?? $a->id) }}
                </option>
              @endforeach
            </select>
            @error('id_admin')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- File Upload -->
        <div class="space-y-1">
          <label class="block text-xs font-semibold text-slate-700">
            Berkas Sertifikat Digital <span class="text-slate-400 font-normal">(PDF/JPG/PNG, maks 5MB)</span>
          </label>
          <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" class="w-full bg-white border @error('file_sertifikat') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 focus:outline-none shadow-sm">
          @error('file_sertifikat')
            <p class="text-[10px] text-rose-500 font-medium mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
          <a href="{{ route('sertifikat.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
            Batal
          </a>
          <button type="submit" class="px-4 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center gap-1.5">
            <i data-lucide="save" class="w-4 h-4"></i> Simpan Sertifikat
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection