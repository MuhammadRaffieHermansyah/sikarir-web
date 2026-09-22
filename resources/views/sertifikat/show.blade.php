@extends('layouts.app')

@section('title', 'Detail Sertifikat Peserta - BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('sertifikat.index') }}" class="hover:text-emerald-700 transition">Daftar Sertifikat</a> &gt; 
        <span class="text-slate-600 font-medium">Detail Sertifikat</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Detail Sertifikat Kelulusan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Informasi rinci dokumen sertifikasi kompetensi peserta pelatihan.</p>
    </div>

    <div class="flex items-center gap-2 self-start md:self-auto">
      <a href="{{ route('sertifikat.edit', $sertifikat->id_sertifikat ?? $sertifikat->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit
      </a>
      <a href="{{ route('sertifikat.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 transition">
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
            {{ strtoupper(substr($sertifikat->peserta->user->name ?? 'P', 0, 2)) }}
          </div>
          <div>
            <h2 class="font-bold text-slate-800 text-sm">{{ $sertifikat->peserta->user->name ?? 'Tanpa Nama' }}</h2>
            <p class="text-[11px] text-slate-400">
              ID Sertifikat: #CERT-{{ str_pad($sertifikat->id_sertifikat ?? $sertifikat->id, 4, '0', STR_PAD_LEFT) }}
              {{ isset($sertifikat->peserta->nomor_peserta) ? '• No. Peserta: '.$sertifikat->peserta->nomor_peserta : '' }}
            </p>
          </div>
        </div>

        <span class="inline-flex items-center gap-1 font-mono text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200/80 px-3 py-1 rounded-full">
          <i data-lucide="award" class="w-3.5 h-3.5 text-emerald-600"></i>
          {{ $sertifikat->no_sertifikat ?? $sertifikat->nomor_sertifikat ?? 'Belum ada No. Sertifikat' }}
        </span>
      </div>

      <!-- Detail Grid Content -->
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-slate-700">
        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="book-open" class="w-3.5 h-3.5 text-slate-400"></i> Program Pelatihan
          </span>
          <p class="font-bold text-slate-800 text-sm">
            {{ $sertifikat->jadwal->pelatihan->nama_pelatihan ?? '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i> Tanggal Terbit
          </span>
          <p class="font-bold text-slate-800 text-sm">
            {{ $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->translatedFormat('d F Y') : '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="user-check" class="w-3.5 h-3.5 text-slate-400"></i> Admin Penanggung Jawab
          </span>
          <p class="font-medium text-slate-800">
            {{ $sertifikat->admin->user->name ?? '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i> Email Peserta
          </span>
          <p class="font-medium text-slate-800">
            {{ $sertifikat->peserta->user->email ?? '-' }}
          </p>
        </div>

        <!-- Document Preview & Download Section -->
        <div class="md:col-span-2 pt-4 border-t border-slate-100 space-y-2">
          <span class="text-slate-400 font-medium uppercase text-[10px] tracking-wider flex items-center gap-1">
            <i data-lucide="file-text" class="w-3.5 h-3.5 text-slate-400"></i> Berkas Sertifikat Digital
          </span>

          @if($sertifikat->file_sertifikat)
            <div class="flex items-center justify-between p-4 bg-emerald-50/50 border border-emerald-200/80 rounded-xl">
              <div class="flex items-center gap-3">
                <div class="p-2.5 bg-emerald-100 text-emerald-800 rounded-lg shrink-0">
                  <i data-lucide="file-check-2" class="w-6 h-6"></i>
                </div>
                <div>
                  <p class="font-bold text-slate-800 text-xs">Dokumen Resmi Tersedia</p>
                  <p class="text-[11px] text-slate-500">Berkas digital kelulusan terverifikasi oleh BLK.</p>
                </div>
              </div>

              <a href="{{ Storage::url($sertifikat->file_sertifikat) }}" target="_blank" class="px-4 py-2 bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs rounded-lg transition flex items-center gap-1.5 shadow-sm shrink-0">
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Lihat / Unduh
              </a>
            </div>
          @else
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center text-slate-400 space-y-1">
              <i data-lucide="file-x" class="w-6 h-6 mx-auto text-slate-300"></i>
              <p class="text-xs font-medium text-slate-500">Belum ada berkas sertifikat yang diunggah</p>
            </div>
          @endif
        </div>
      </div>

      <!-- Card Footer Action -->
      <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <span class="text-[10px] text-slate-400">
          Diterbitkan pada: {{ $sertifikat->created_at ? $sertifikat->created_at->translatedFormat('d M Y, H:i') : '-' }}
        </span>
        <form action="{{ route('sertifikat.destroy', $sertifikat->id_sertifikat ?? $sertifikat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 flex items-center gap-1 transition">
            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Sertifikat
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection