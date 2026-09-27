@extends('layouts.app')

@section('title', 'Mitra Industri DU/DI - BLK CONNECT')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Mitra Industri DU/DI</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Kemitraan Dunia Usaha & Industri (DU/DI)</h1>
      <p class="text-xs text-slate-500 mt-0.5">Kelola kerjasama perusahaan mitra vokasi, ketersediaan kuota magang, dan penempatan kerja peserta.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('mitras.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Mitra DU/DI
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
        <i data-lucide="building-2" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Mitra DU/DI</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ isset($mitras) ? $mitras->total() : 0 }} Perusahaan</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
        <i data-lucide="briefcase" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Status Kerjasama</div>
        <div class="text-lg font-black text-emerald-700 mt-0.5">100% Aktif</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
        <i data-lucide="check-check" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Verifikasi Industri</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">Terstandarisasi BLK</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    
    <!-- Table Header & Search Filter Bar -->
    <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
      <div>
        <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <span>Daftar Perusahaan & Industri Rekanan</span>
          <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
            {{ isset($mitras) ? $mitras->total() : 0 }} Rekanan
          </span>
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Daftar mitra industri tempat pelaksanaan program magang bersertifikat.</p>
      </div>

      <!-- FORM PENCARIAN & FILTER -->
      <form method="GET" action="{{ route('mitras.index') }}" class="flex flex-col sm:flex-row items-center gap-2 w-full lg:w-auto">
        <!-- Input Search -->
        <div class="relative w-full sm:w-64">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            <i data-lucide="search" class="w-4 h-4"></i>
          </div>
          <input type="text" 
                 name="search" 
                 value="{{ request('search') }}" 
                 placeholder="Cari perusahaan, kota, PIC..." 
                 class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-xs font-medium text-slate-700 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition">
        </div>

        <!-- Filter Jenis Mitra -->
        <select name="jenis_mitra" class="w-full sm:w-auto bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:bg-white focus:outline-none focus:border-emerald-600 transition">
          <option value="">Semua Jenis Mitra</option>
          @foreach($jenisMitraList ?? [] as $jm)
            <option value="{{ $jm }}" @selected(request('jenis_mitra') === $jm)>{{ $jm }}</option>
          @endforeach
        </select>

        <!-- Submit & Reset Buttons -->
        <div class="flex items-center gap-1.5 w-full sm:w-auto">
          <button type="submit" class="flex-1 sm:flex-none px-3 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center justify-center gap-1">
            <i data-lucide="search" class="w-3.5 h-3.5"></i>
            <span>Cari</span>
          </button>

          @if(request('search') || request('jenis_mitra'))
            <a href="{{ route('mitras.index') }}" class="p-2 border border-slate-200 hover:bg-slate-50 text-slate-500 rounded-lg transition" title="Reset Filter">
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
            <th class="px-5 py-3 font-semibold">Perusahaan & Industri</th>
            <th class="px-5 py-3 font-semibold">Bidang Usaha</th>
            <th class="px-5 py-3 font-semibold">Wilayah / Lokasi</th>
            <th class="px-5 py-3 font-semibold">Kontak & PIC</th>
            <th class="px-5 py-3 font-semibold text-center">Lowongan</th>
            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($mitras ?? [] as $mitra)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 text-white font-bold flex items-center justify-center text-xs shadow-sm shrink-0">
                    {{ strtoupper(substr($mitra->nama_perusahaan, 0, 2)) }}
                  </div>
                  <div>
                    <a href="{{ route('mitras.show', $mitra->id_mitra) }}" class="font-bold text-slate-900 hover:text-emerald-700 transition">
                      {{ $mitra->nama_perusahaan }}
                    </a>
                    <div class="text-[10px] text-slate-400">
                      ID: #MTR-{{ str_pad((string)$mitra->id_mitra, 3, '0', STR_PAD_LEFT) }} • {{ $mitra->jenis_mitra ?? 'Perusahaan Swasta' }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <span class="bg-slate-100 text-slate-700 font-medium px-2 py-0.5 rounded text-[11px]">
                  {{ $mitra->bidang_usaha ?? 'Umum' }}
                </span>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1">
                  <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $mitra->kota ?? 'Kota Tidak Tercatat' }}</span>
                </div>
                <div class="text-[10px] text-slate-400">{{ $mitra->provinsi ?? '-' }}</div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1">
                  <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $mitra->no_telp ?? $mitra->telepon ?? '-' }}</span>
                </div>
                <div class="text-[10px] text-slate-400">{{ $mitra->jabatan_pic ?? 'PIC Industri' }}</div>
              </td>
              <td class="px-5 py-3.5 text-center">
                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded text-[11px]">
                  <i data-lucide="briefcase" class="w-3 h-3"></i> {{ count($mitra->lowongan ?? []) }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('mitras.show', $mitra->id_mitra) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('mitras.edit', $mitra->id_mitra) }}" class="p-1.5 text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Edit">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('mitras.destroy', $mitra->id_mitra) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')">
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
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Belum ada data Mitra DU/DI yang ditemukan</p>
                  @if(request('search') || request('jenis_mitra'))
                    <a href="{{ route('mitras.index') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                      <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter Pencarian
                    </a>
                  @else
                    <a href="{{ route('mitras.create') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                      <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambahkan Mitra Pertama
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($mitras) && $mitras->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        {{ $mitras->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </div>
@endsection