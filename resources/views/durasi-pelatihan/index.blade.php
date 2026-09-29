@extends('layouts.app')

@section('title', 'Durasi Pelatihan - BLK CONNECT')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Durasi Pelatihan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Master Durasi Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Kelola referensi durasi program pelatihan berbasis jumlah hari dan jam.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('durasi-pelatihan.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Durasi
      </a>
    </div>
  </div>

  <!-- Session Alerts -->
  @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
      <div class="flex items-center gap-2.5">
        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
          <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-700"></i>
        </div>
        <span class="font-medium">{{ session('success') }}</span>
      </div>
      <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
        <i data-lucide="x" class="w-4 h-4"></i>
      </button>
    </div>
  @endif

  <!-- Top Metrics -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="timer" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Durasi</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ isset($durations) ? $durations->total() : 0 }} Kategori</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
        <i data-lucide="calendar-days" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Rentang Hari</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ isset($durations) && $durations->isNotEmpty() ? ($durations->min('hari') . ' - ' . $durations->max('hari')) : '—' }} Hari</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
        <i data-lucide="clock" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Jam Pelajaran</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ isset($durations) && $durations->isNotEmpty() ? $durations->sum('jam') : 0 }} Jam</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
      <div>
        <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <span>Daftar Referensi Durasi</span>
          <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
            {{ isset($durations) ? $durations->total() : 0 }} Data
          </span>
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Durasi digunakan sebagai referensi lama pelaksanaan program pelatihan.</p>
      </div>

      <form method="GET" action="{{ route('durasi-pelatihan.index') }}" class="flex flex-col sm:flex-row items-center gap-2 w-full lg:w-auto">
        <div class="relative w-full sm:w-64">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            <i data-lucide="search" class="w-4 h-4"></i>
          </div>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jumlah hari / jam..." class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-xs font-medium text-slate-700 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
        </div>
        <div class="flex items-center gap-1.5 w-full sm:w-auto">
          <button type="submit" class="flex-1 sm:flex-none px-3 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center justify-center gap-1">
            <i data-lucide="search" class="w-3.5 h-3.5"></i>
            <span>Cari</span>
          </button>
          @if(request('search'))
            <a href="{{ route('durasi-pelatihan.index') }}" class="p-2 border border-slate-200 hover:bg-slate-50 text-slate-500 rounded-lg transition" title="Reset Filter">
              <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
            </a>
          @endif
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
            <th class="px-5 py-3 font-semibold">ID</th>
            <th class="px-5 py-3 font-semibold">Durasi</th>
            <th class="px-5 py-3 font-semibold">Hari</th>
            <th class="px-5 py-3 font-semibold">Jam</th>
            <th class="px-5 py-3 font-semibold text-center">Program Terkait</th>
            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($durations ?? [] as $durasi)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-5 py-3.5 font-mono text-[11px] text-slate-400">
                #DUR-{{ str_pad((string)$durasi->id_durasi, 3, '0', STR_PAD_LEFT) }}
              </td>
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-800 to-emerald-900 text-white font-bold flex items-center justify-center text-xs shadow-sm shrink-0">
                    {{ $durasi->hari }}H
                  </div>
                  <a href="{{ route('durasi-pelatihan.show', $durasi->id_durasi) }}" class="font-bold text-slate-900 hover:text-emerald-700 transition">
                    {{ $durasi->durasi_label }}
                  </a>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <span class="bg-blue-50 text-blue-700 font-semibold px-2 py-0.5 rounded text-[11px]">{{ $durasi->hari }} Hari</span>
              </td>
              <td class="px-5 py-3.5">
                <span class="bg-indigo-50 text-indigo-700 font-semibold px-2 py-0.5 rounded text-[11px]">{{ $durasi->jam }} Jam</span>
              </td>
              <td class="px-5 py-3.5 text-center">
                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded text-[11px]">
                  <i data-lucide="book" class="w-3 h-3"></i> {{ $durasi->pelatihan_count ?? 0 }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('durasi-pelatihan.show', $durasi->id_durasi) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('durasi-pelatihan.edit', $durasi->id_durasi) }}" class="p-1.5 text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Edit">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('durasi-pelatihan.destroy', $durasi->id_durasi) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus durasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-5 py-10 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center gap-2">
                  <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                    <i data-lucide="timer" class="w-6 h-6"></i>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Belum ada data durasi pelatihan yang ditemukan</p>
                  @if(request('search'))
                    <a href="{{ route('durasi-pelatihan.index') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                      <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter Pencarian
                    </a>
                  @else
                    <a href="{{ route('durasi-pelatihan.create') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                      <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambahkan Durasi Pertama
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($durations) && $durations->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        {{ $durations->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </div>
@endsection