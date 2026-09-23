@extends('layouts.app')

@section('title', 'Edit Presensi Peserta - BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('absen.index') }}" class="hover:text-emerald-700 transition">Daftar Absensi</a> &gt; 
        <span class="text-slate-600 font-medium">Edit Presensi</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Edit Presensi Peserta</h1>
      <p class="text-xs text-slate-500 mt-0.5">Perbarui data pencatatan kehadiran atau keterangan presensi harian.</p>
    </div>

    <a href="{{ route('absen.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 transition self-start md:self-auto">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
  </div>

  <!-- Form Card -->
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-5 border-b border-slate-100 flex items-center gap-2.5 bg-slate-50/50">
        <div class="p-2 bg-amber-50 text-amber-700 rounded-lg">
          <i data-lucide="edit-3" class="w-5 h-5"></i>
        </div>
        <div>
          <h2 class="font-bold text-slate-800 text-sm">Formulir Perubahan Presensi</h2>
          <p class="text-[11px] text-slate-500">ID Absen: #ABS-{{ str_pad($absen->id_absen, 4, '0', STR_PAD_LEFT) }}</p>
        </div>
      </div>

      <form method="POST" action="{{ route('absen.update', $absen->id_absen) }}" class="p-6 space-y-5">
        @csrf
        @method('PUT')

        <!-- Global Error Alert -->
        @if($errors->any())
          <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 space-y-1">
            <div class="font-bold flex items-center gap-1.5">
              <i data-lucide="alert-circle" class="w-4 h-4"></i> Gagal memperbarui data:
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
          <div class="md:col-span-1 space-y-1">
            <label class="block text-xs font-semibold text-slate-700">
              Peserta <span class="text-rose-500">*</span>
            </label>
            <select name="id_peserta"  class="w-full bg-white border @error('id_peserta') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
              <option value="">-- Pilih Peserta --</option>
              @foreach($pesertas as $p)
                <option value="{{ $p->id_peserta }}" {{ old('id_peserta', $absen->id_peserta) == $p->id_peserta ? 'selected' : '' }}>
                  {{ $p->user->name ?? 'Peserta #'.$p->id_peserta }} {{ isset($p->nomor_peserta) ? '('.$p->nomor_peserta.')' : '' }}
                </option>
              @endforeach
            </select>
            @error('id_peserta')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Jadwal Select -->
          <div class="md:col-span-1 space-y-1">
            <label class="block text-xs font-semibold text-slate-700">
              Jadwal Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="id_jadwal"  class="w-full bg-white border @error('id_jadwal') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
              <option value="">-- Pilih Jadwal --</option>
              @foreach($jadwals as $j)
                <option value="{{ $j->id_jadwal }}" {{ old('id_jadwal', $absen->id_jadwal) == $j->id_jadwal ? 'selected' : '' }}>
                  {{ $j->pelatihan->nama_pelatihan ?? '-' }}
                </option>
              @endforeach
            </select>
            @error('id_jadwal')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <!-- Tanggal -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">
              Tanggal Presensi <span class="text-rose-500">*</span>
            </label>
            <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($absen->tanggal)->format('Y-m-d')) }}"  class="w-full bg-white border @error('tanggal') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
            @error('tanggal')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Jam Hadir -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">Jam Masuk / Hadir</label>
            <input type="time" name="jam_hadir" value="{{ old('jam_hadir', $absen->jam_hadir ? \Carbon\Carbon::parse($absen->jam_hadir)->format('H:i') : '') }}" class="w-full bg-white border @error('jam_hadir') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
            @error('jam_hadir')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status Kehadiran -->
          <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-700">
              Status <span class="text-rose-500">*</span>
            </label>
            <select name="status_kehadiran"  class="w-full bg-white border @error('status_kehadiran') border-rose-500 @else border-slate-200 @enderror rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">
              @foreach(['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'] as $key => $label)
                <option value="{{ $key }}" {{ old('status_kehadiran', $absen->status_kehadiran ?? $absen->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
            @error('status_kehadiran')
              <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Keterangan -->
        <div class="space-y-1">
          <label class="block text-xs font-semibold text-slate-700">Keterangan / Catatan</label>
          <textarea name="keterangan" rows="3" placeholder="Catatan tambahan..." class="w-full bg-white border border-slate-200 rounded-lg p-3 text-xs font-medium text-slate-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-sm">{{ old('keterangan', $absen->keterangan) }}</textarea>
          @error('keterangan')
            <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
          <a href="{{ route('absen.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
            Batal
          </a>
          <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center gap-1.5">
            <i data-lucide="check" class="w-4 h-4"></i> Perbarui Presensi
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection