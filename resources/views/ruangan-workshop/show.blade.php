@extends('layouts.app')

@section('title', 'Detail Ruangan Workshop - BLK CONNECT')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('ruangan-workshop.index') }}" class="hover:text-emerald-700 transition">Ruangan Workshop</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Ruangan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Detail Ruangan Workshop</h1>
      <p class="text-xs text-slate-500 mt-0.5">Informasi lengkap ruangan workshop.</p>
    </div>

    <div>
      <a href="{{ route('ruangan-workshop.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke Daftar
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <i data-lucide="building-2" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Informasi Ruangan</h2>
        </div>

        <div class="flex items-center gap-4">
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-800 to-emerald-900 text-white font-black flex items-center justify-center text-2xl shadow-sm shrink-0 uppercase">
            {{ substr($ruanganWorkshop->nama_ruangan, 0, 1) }}
          </div>
          <div>
            <h3 class="text-lg font-black text-slate-900">{{ $ruanganWorkshop->nama_ruangan }}</h3>
            <p class="text-xs text-slate-500">ID: #RW-{{ str_pad((string)$ruanganWorkshop->id, 3, '0', STR_PAD_LEFT) }}</p>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-2">
          <div class="bg-slate-50 rounded-lg p-3">
            <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Dibuat Pada</div>
            <div class="text-xs font-bold text-slate-700 mt-1">{{ $ruanganWorkshop->created_at->format('d M Y, H:i') }}</div>
          </div>
          <div class="bg-slate-50 rounded-lg p-3">
            <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Terakhir Diupdate</div>
            <div class="text-xs font-bold text-slate-700 mt-1">{{ $ruanganWorkshop->updated_at->format('d M Y, H:i') }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          Statistik
        </h3>

        <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
          <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-lg">
            <span class="font-medium">Jadwal Terpakai</span>
            <span class="font-black text-emerald-700 text-sm">{{ $ruanganWorkshop->jadwal_count ?? 0 }}</span>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <a href="{{ route('ruangan-workshop.edit', $ruanganWorkshop->id) }}" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i>
            Edit Ruangan
          </a>
          <form action="{{ route('ruangan-workshop.destroy', $ruanganWorkshop->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4"></i>
              Hapus Ruangan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
