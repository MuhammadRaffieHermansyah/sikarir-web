@extends('layouts.app')

@section('title', 'Detail Presensi Peserta - BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('absen.index') }}" class="hover:text-emerald-700 transition">Daftar Absensi</a> &gt; 
        <span class="text-slate-600 font-medium">Detail Presensi</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Detail Catatan Presensi</h1>
      <p class="text-xs text-slate-500 mt-0.5">Informasi rinci mengenai pencatatan kehadiran peserta pelatihan vokasi.</p>
    </div>

    <div class="flex items-center gap-2 self-start md:self-auto">
      <a href="{{ route('absen.edit', $absen->id_absen) }}" class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit
      </a>
      <a href="{{ route('absen.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </div>
  </div>

  <!-- Detail Card -->
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <!-- Card Header -->
      <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm shadow-sm shrink-0">
            {{ strtoupper(substr($absen->peserta->user->name ?? 'P', 0, 2)) }}
          </div>
          <div>
            <h2 class="font-bold text-slate-800 text-sm">{{ $absen->peserta->user->name ?? 'Tanpa Nama' }}</h2>
            <p class="text-[11px] text-slate-400">
              ID Absen: #ABS-{{ str_pad($absen->id_absen, 4, '0', STR_PAD_LEFT) }} 
              {{ isset($absen->peserta->nomor_peserta) ? '• No. Peserta: '.$absen->peserta->nomor_peserta : '' }}
            </p>
          </div>
        </div>

        @php
          $status = strtolower($absen->status_kehadiran ?? $absen->status ?? '');
          $badgeStyle = match($status) {
              'hadir' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
              'izin'  => 'bg-amber-50 text-amber-700 border-amber-200',
              'sakit' => 'bg-blue-50 text-blue-700 border-blue-200',
              default => 'bg-rose-50 text-rose-700 border-rose-200',
          };
          $dotStyle = match($status) {
              'hadir' => 'bg-emerald-500',
              'izin'  => 'bg-amber-500',
              'sakit' => 'bg-blue-500',
              default => 'bg-rose-500',
          };
        @endphp
        <span class="inline-flex items-center gap-1.5 border px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badgeStyle }}">
          <span class="w-2 h-2 rounded-full {{ $dotStyle }}"></span>
          {{ $absen->status_kehadiran ?? $absen->status ?? '-' }}
        </span>
      </div>

      <!-- Detail Grid Content -->
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-slate-700">
        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="book-open" class="w-3.5 h-3.5 text-slate-400"></i> Program Pelatihan
          </span>
          <p class="font-bold text-slate-800 text-sm">
            {{ $absen->jadwal->pelatihan->nama_pelatihan ?? '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i> Tanggal Presensi
          </span>
          <p class="font-bold text-slate-800 text-sm">
            {{ $absen->tanggal ? \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') : '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i> Jam Masuk / Presensi
          </span>
          <p class="font-medium text-slate-800">
            {{ $absen->jam_hadir ? \Carbon\Carbon::parse($absen->jam_hadir)->format('H:i') . ' WIB' : '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i> Email Peserta
          </span>
          <p class="font-medium text-slate-800">
            {{ $absen->peserta->user->email ?? '-' }}
          </p>
        </div>

        <div class="md:col-span-2 pt-4 border-t border-slate-100 space-y-1.5">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="file-text" class="w-3.5 h-3.5 text-slate-400"></i> Keterangan / Catatan
          </span>
          <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-lg text-slate-700 leading-relaxed font-normal">
            {{ $absen->keterangan ?? 'Tidak ada catatan tambahan.' }}
          </div>
        </div>
      </div>

      <!-- Card Footer Action -->
      <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <span class="text-[10px] text-slate-400">
          Dicatat pada: {{ $absen->created_at ? $absen->created_at->translatedFormat('d M Y, H:i') : '-' }}
        </span>
        <form action="{{ route('absen.destroy', $absen->id_absen) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 flex items-center gap-1 transition">
            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Data
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection