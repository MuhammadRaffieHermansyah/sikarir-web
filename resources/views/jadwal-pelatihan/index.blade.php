@extends('layouts.app')

@section('title', 'Jadwal & Agenda Pelatihan Vokasi - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Jadwal Pelatihan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Jadwal & Batch Kelas Vokasi</h1>
      <p class="text-xs text-slate-500 mt-0.5">Pantau periode pelaksanaan kursus, ketersediaan ruangan bengkel kerja, dan instruktur pengampu.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('jadwal-pelatihan.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-4 h-4"></i> Buat Batch Jadwal
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
        <i data-lucide="calendar" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Batch Jadwal</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">{{ $jadwals->total() }} Batch</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
        <i data-lucide="play-circle" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Sedang Berlangsung</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">
          {{ $countBerlangsung ?? 0 }} Batch
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
        <i data-lucide="door-open" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Pendaftaran Tersedia</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">
          {{ $countTersedia ?? 0 }} Batch
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center shrink-0">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Batch Selesai</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">
          {{ $countSelesai ?? 0 }} Batch
        </div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    
    <!-- Table Header & Search Filter Bar -->
    <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-slate-50/50">
      <div>
        <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <span>Agenda Jadwal Pelatihan Kerja</span>
          <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
            {{ $jadwals->total() }} Batch
          </span>
        </h3>
        <p class="text-xs text-slate-500 mt-0.5">Daftar periode waktu kelas dan instruktur pembimbing.</p>
      </div>

      <!-- FORM PENCARIAN & FILTER -->
      <form method="GET" action="{{ route('jadwal-pelatihan.index') }}" class="flex flex-col sm:flex-row items-center gap-2 w-full lg:w-auto">
        <!-- Input Search -->
        <div class="relative w-full sm:w-64">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            <i data-lucide="search" class="w-4 h-4"></i>
          </div>
          <input type="text" 
                 name="search" 
                 value="{{ request('search') }}" 
                 placeholder="Cari kejuruan, instruktur, tempat..." 
                 class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-xs font-medium text-slate-700 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm">
        </div>

        <!-- Filter Status Kelas -->
        <select name="status" class="w-full sm:w-auto bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-medium text-slate-700 focus:bg-white focus:outline-none focus:border-emerald-600 transition shadow-sm">
          <option value="">Semua Status</option>
          <option value="tersedia" @selected(request('status') === 'tersedia')>Tersedia</option>
          <option value="berlangsung" @selected(request('status') === 'berlangsung')>Berlangsung</option>
          <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
        </select>

        <!-- Submit & Reset Buttons -->
        <div class="flex items-center gap-1.5 w-full sm:w-auto">
          <button type="submit" class="flex-1 sm:flex-none px-3.5 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center justify-center gap-1">
            <i data-lucide="search" class="w-3.5 h-3.5"></i>
            <span>Cari</span>
          </button>

          @if(request('search') || request('status'))
            <a href="{{ route('jadwal-pelatihan.index') }}" class="p-2 border border-slate-200 hover:bg-white bg-slate-50 text-slate-500 rounded-lg transition" title="Reset Filter">
              <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 uppercase tracking-wider text-[11px]">
            <th class="px-5 py-3.5 font-semibold">ID Batch</th>
            <th class="px-5 py-3.5 font-semibold">Program Kejuruan</th>
            <th class="px-5 py-3.5 font-semibold">Periode Pelaksanaan</th>
            <th class="px-5 py-3.5 font-semibold">Instruktur & Ruang</th>
            <th class="px-5 py-3.5 font-semibold">Status Kelas</th>
            <th class="px-5 py-3.5 font-semibold">Siswa Terdaftar</th>
            <th class="px-5 py-3.5 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($jadwals as $jadwal)
            <tr class="hover:bg-slate-50/80 transition group">
              <td class="px-5 py-4 font-mono font-bold text-slate-500">
                #JDW-{{ str_pad((string)$jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
              </td>

              <td class="px-5 py-4">
                <div class="font-bold text-slate-900 group-hover:text-emerald-700 transition">
                  {{ $jadwal->pelatihan->nama_pelatihan ?? 'Kejuruan Tidak Ditemukan' }}
                </div>
                <div class="text-[11px] text-slate-400 mt-0.5">
                  Kuota Maks: {{ $jadwal->pelatihan->kuota ?? '16' }} Siswa
                </div>
              </td>

              <td class="px-5 py-4">
                <div class="text-slate-800 font-bold flex items-center gap-1.5">
                  <i data-lucide="calendar" class="w-3.5 h-3.5 text-emerald-600"></i>
                  {{ $jadwal->tanggal_mulai ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_mulai)->translatedFormat('d M Y') : '-' }}
                </div>
                <div class="flex items-center gap-1.5 text-slate-600 font-bold mt-0.5">
                  s/d {{ $jadwal->tanggal_selesai ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_selesai)->translatedFormat('d M Y') : '-' }}
                </div>
              </td>

              <td class="px-5 py-4">
                <div class="text-slate-800 font-medium flex items-center gap-1.5">
                  <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                  {{ $jadwal->instruktur ?? 'Instruktur Belum Ditunjuk' }}
                </div>
                <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                  <i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i>
                  {{ $jadwal->tempat ?? 'Workshop BLK' }}
                </div>
              </td>

              <td class="px-5 py-4">
                @if($jadwal->status === 'tersedia')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Tersedia
                  </span>
                @elseif($jadwal->status === 'berlangsung')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                    Berlangsung
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                    Selesai
                  </span>
                @endif
              </td>

              <td class="px-5 py-4">
                <span class="font-bold text-slate-800">
                  {{ count($jadwal->kelas ?? []) }}
                </span>
                <span class="text-[11px] text-slate-400"> / {{ $jadwal->pelatihan->kuota ?? '16' }} Siswa</span>
              </td>

              <td class="px-5 py-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <a href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-slate-100 rounded-lg transition" title="Lihat Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('jadwal-pelatihan.edit', $jadwal->id_jadwal) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition" title="Edit Jadwal">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('jadwal-pelatihan.destroy', $jadwal->id_jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Data">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                  <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <div class="font-bold text-slate-700 text-sm">Belum Ada Jadwal Pelatihan Ditemukan</div>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Coba ubah kata kunci pencarian atau reset filter status kelas.</p>
                @if(request('search') || request('status'))
                  <a href="{{ route('jadwal-pelatihan.index') }}" class="inline-flex items-center gap-1.5 mt-3 text-emerald-700 hover:underline text-xs font-semibold">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter Pencarian
                  </a>
                @else
                  <a href="{{ route('jadwal-pelatihan.create') }}" class="inline-flex items-center gap-1.5 mt-3 bg-emerald-900 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Buat Batch Jadwal
                  </a>
                @endif
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($jadwals->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        {{ $jadwals->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </div>
@endsection