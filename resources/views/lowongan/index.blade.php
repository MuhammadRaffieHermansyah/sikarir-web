@extends('layouts.app')

@section('title', 'Lowongan Magang Industri - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Lowongan Magang</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Lowongan Magang Industri DU/DI</h1>
      <p class="text-xs text-slate-500 mt-0.5">Kelola posisi magang yang dipublikasikan mitra industri untuk penyaluran siswa vokasi.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('mitras.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="building-2" class="w-4 h-4"></i> Data Mitra
      </a>
      <a href="{{ route('lowongan.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-4 h-4"></i> Buka Lowongan Baru
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs font-medium flex items-center justify-between shadow-sm">
      <div class="flex items-center gap-2">
        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
        <i data-lucide="x" class="w-4 h-4"></i>
      </button>
    </div>
  @endif

  <!-- Metrics / KPI Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="briefcase" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Lowongan</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">{{ $lowongans->total() }} Posisi</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
        <i data-lucide="door-open" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Lowongan Aktif</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">{{ $lowongans->where('status', 'aktif')->count() }} Tersedia</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
        <i data-lucide="door-closed" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Sudah Ditutup</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">{{ $lowongans->where('status', 'ditutup')->count() }} Posisi</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
        <i data-lucide="file-edit" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Draft / Belum Publik</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">{{ $lowongans->where('status', 'draft')->count() }} Draft</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
      <div>
        <h3 class="font-bold text-slate-800 text-sm">Daftar Lowongan Magang Industri</h3>
        <p class="text-xs text-slate-500">Posisi magang yang diterima dari mitra DU/DI untuk penyaluran lulusan vokasi.</p>
      </div>

      <div class="flex items-center gap-2">
        <div class="relative">
          <input type="text" placeholder="Cari posisi / mitra..." class="bg-white border border-slate-200 text-slate-700 text-xs rounded-lg pl-8 pr-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-emerald-700 w-48 sm:w-60 shadow-sm" />
          <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 uppercase tracking-wider text-[11px]">
            <th class="px-5 py-3.5 font-semibold">ID</th>
            <th class="px-5 py-3.5 font-semibold">Posisi & Perusahaan</th>
            <th class="px-5 py-3.5 font-semibold">Lokasi</th>
            <th class="px-5 py-3.5 font-semibold">Tgl Posting</th>
            <th class="px-5 py-3.5 font-semibold">Status</th>
            <th class="px-5 py-3.5 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($lowongans as $lowongan)
            <tr class="hover:bg-slate-50/80 transition group">
              <td class="px-5 py-4 font-mono font-bold text-slate-500">
                #LWG-{{ str_pad((string)$lowongan->id_lowongan, 3, '0', STR_PAD_LEFT) }}
              </td>

              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-700 font-black flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr($lowongan->mitra->nama_perusahaan ?? 'M', 0, 2)) }}
                  </div>
                  <div>
                    <a href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" class="font-bold text-slate-900 group-hover:text-emerald-700 transition">
                      {{ $lowongan->judul_lowongan }}
                    </a>
                    <div class="text-[11px] text-slate-400 mt-0.5">
                      {{ $lowongan->mitra->nama_perusahaan ?? 'Mitra Tidak Tercatat' }}
                    </div>
                  </div>
                </div>
              </td>

              <td class="px-5 py-4">
                <div class="flex items-center gap-1.5 text-slate-700 font-medium">
                  <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                  {{ $lowongan->lokasi ?? 'Lokasi Fleksibel' }}
                </div>
              </td>

              <td class="px-5 py-4 text-slate-600">
                {{ $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d M Y') : '-' }}
              </td>

              <td class="px-5 py-4">
                @if($lowongan->status === 'aktif')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Aktif
                  </span>
                @elseif($lowongan->status === 'ditutup')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                    Ditutup
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Draft
                  </span>
                @endif
              </td>

              <td class="px-5 py-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <a href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-slate-100 rounded-lg transition" title="Lihat Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('lowongan.edit', $lowongan->id_lowongan) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition" title="Edit Lowongan">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('lowongan.destroy', $lowongan->id_lowongan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Lowongan">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                  <i data-lucide="briefcase" class="w-6 h-6"></i>
                </div>
                <div class="font-bold text-slate-700 text-sm">Belum Ada Lowongan Magang</div>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Publikasikan posisi magang dari mitra DU/DI untuk penyaluran siswa lulusan vokasi.</p>
                <a href="{{ route('lowongan.create') }}" class="inline-flex items-center gap-1.5 mt-3 bg-emerald-900 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm">
                  <i data-lucide="plus" class="w-3.5 h-3.5"></i> Buka Lowongan
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($lowongans->hasPages())
      <div class="p-4 border-t border-slate-100">
        {{ $lowongans->links() }}
      </div>
    @endif
  </div>
@endsection
