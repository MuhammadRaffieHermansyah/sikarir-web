@extends('layouts.app')

@section('title', 'Detail Lowongan - ' . $lowongan->judul_lowongan)

@section('content')
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('lowongan.index') }}" class="hover:text-emerald-700 transition">Lowongan Magang</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Lowongan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Rincian Lowongan Magang Industri</h1>
      <p class="text-xs text-slate-500 mt-0.5">Spesifikasi posisi, kualifikasi, dan informasi perusahaan mitra industri penerima magang.</p>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ route('lowongan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
      <a href="{{ route('lowongan.edit', $lowongan->id_lowongan) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Lowongan
      </a>
    </div>
  </div>

  <!-- Hero Banner -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-emerald-50/50 to-transparent pointer-events-none"></div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 text-white font-black text-2xl flex items-center justify-center shadow-md shrink-0">
          {{ strtoupper(substr($lowongan->mitra->nama_perusahaan ?? 'M', 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-extrabold text-slate-900">{{ $lowongan->judul_lowongan }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
              #LWG-{{ str_pad((string)$lowongan->id_lowongan, 3, '0', STR_PAD_LEFT) }}
            </span>
          </div>
          <div class="flex items-center gap-4 text-xs text-slate-500 mt-1.5 flex-wrap">
            <span class="flex items-center gap-1.5"><i data-lucide="building-2" class="w-3.5 h-3.5 text-slate-400"></i> {{ $lowongan->mitra->nama_perusahaan ?? '-' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $lowongan->lokasi ?? 'Lokasi Fleksibel' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i> {{ $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d M Y') : '-' }}</span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Lowongan</div>
        <div class="text-xs font-bold mt-0.5 flex items-center gap-1.5 justify-end
          {{ $lowongan->status === 'aktif' ? 'text-emerald-700' : ($lowongan->status === 'draft' ? 'text-amber-700' : 'text-slate-600') }}">
          <span class="w-2 h-2 rounded-full {{ $lowongan->status === 'aktif' ? 'bg-emerald-500 animate-pulse' : ($lowongan->status === 'draft' ? 'bg-amber-400' : 'bg-slate-400') }}"></span>
          {{ ucfirst($lowongan->status) }}
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
      <!-- Deskripsi -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
          <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
            <i data-lucide="file-text" class="w-4 h-4"></i>
          </div>
          <h3 class="font-bold text-slate-800 text-sm">Deskripsi Pekerjaan & Tanggung Jawab</h3>
        </div>
        <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50/70 p-4 rounded-xl border border-slate-100">
          {{ $lowongan->deskripsi ?: 'Belum ada deskripsi pekerjaan yang ditambahkan.' }}
        </div>
      </div>

      <!-- Kualifikasi -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
          <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
            <i data-lucide="check-square" class="w-4 h-4"></i>
          </div>
          <h3 class="font-bold text-slate-800 text-sm">Kualifikasi & Persyaratan Pendaftar</h3>
        </div>
        <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50/70 p-4 rounded-xl border border-slate-100">
          {{ $lowongan->kualifikasi ?: 'Belum ada kualifikasi yang dicantumkan.' }}
        </div>
      </div>
    </div>

    <!-- Right sidebar -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Info Mitra & PIC</h4>
        <div class="space-y-3 text-xs">
          <div>
            <span class="text-slate-400 block mb-0.5">Perusahaan</span>
            <span class="font-bold text-slate-800">{{ $lowongan->mitra->nama_perusahaan ?? '-' }}</span>
          </div>
          <div>
            <span class="text-slate-400 block mb-0.5">Admin Penanggung Jawab</span>
            <span class="font-semibold text-slate-700">{{ $lowongan->admin->user->name ?? '-' }}</span>
          </div>
          <div>
            <span class="text-slate-400 block mb-0.5">Tanggal Diposting</span>
            <span class="font-semibold text-slate-700">{{ $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d F Y') : '-' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Aksi Administratif</h4>
        <div class="space-y-2">
          <a href="{{ route('lowongan.edit', $lowongan->id_lowongan) }}" class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Lowongan
          </a>
          <form action="{{ route('lowongan.destroy', $lowongan->id_lowongan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Lowongan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
