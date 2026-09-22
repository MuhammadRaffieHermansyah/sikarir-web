@extends('layouts.app')

@section('title', 'Manajemen Absensi Peserta - BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <span>Beranda</span> &gt; <span class="text-slate-600 font-medium">Daftar Absensi</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Manajemen Absensi Peserta</h1>
      <p class="text-xs text-slate-500 mt-0.5">Kelola pencatatan kehadiran, izin, dan rekapitulasi absensi peserta pelatihan vokasi.</p>
    </div>

    <div class="flex flex-wrap items-center gap-2 self-start md:self-auto">
      <a href="{{ route('absen.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-4 h-4"></i> Catat Absen
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

  <!-- Management Section: Table Absensi -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <div class="flex items-center gap-2">
          <div class="p-1.5 bg-emerald-50 text-emerald-700 rounded-lg">
            <i data-lucide="clipboard-check" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Daftar Kehadiran Peserta</h2>
          <span class="bg-emerald-100 text-emerald-800 text-[11px] font-semibold px-2 py-0.5 rounded-full">
            {{ isset($absens) ? $absens->total() : 0 }} Data
          </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Daftar rekaman absensi harian peserta pelatihan yang terdaftar.</p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('absen.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition">
          <i data-lucide="plus" class="w-3.5 h-3.5"></i>
          <span>Catat Absen</span>
        </a>
      </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
            <th class="px-5 py-3 font-semibold w-12 text-center">#</th>
            <th class="px-5 py-3 font-semibold">Peserta</th>
            <th class="px-5 py-3 font-semibold">Jadwal Pelatihan</th>
            <th class="px-5 py-3 font-semibold">Tanggal</th>
            <th class="px-5 py-3 font-semibold text-center">Status</th>
            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($absens as $absen)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-5 py-3.5 text-center font-medium text-slate-400">
                {{ $loop->iteration + ($absens->currentPage() - 1) * $absens->perPage() }}
              </td>
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr($absen->peserta->user->name ?? 'P', 0, 2)) }}
                  </div>
                  <div>
                    <div class="font-bold text-slate-800">
                      {{ $absen->peserta->user->name ?? 'Tanpa Nama' }}
                    </div>
                    <div class="text-[10px] text-slate-400">
                      {{ $absen->peserta->user->email ?? '-' }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1.5">
                  <i data-lucide="book-open" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $absen->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1.5">
                  <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $absen->tanggal ? \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') : '-' }}</span>
                </div>
              </td>
              <td class="px-5 py-3.5 text-center">
                @php
                  $status = strtolower($absen->status_kehadiran ?? $absen->status ?? '');
                  $badgeStyle = match($status) {
                      'hadir' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
                      'izin', 'sakit' => 'bg-amber-50 text-amber-700 border-amber-200/80',
                      default => 'bg-rose-50 text-rose-700 border-rose-200/80',
                  };
                  $dotStyle = match($status) {
                      'hadir' => 'bg-emerald-500',
                      'izin', 'sakit' => 'bg-amber-500',
                      default => 'bg-rose-500',
                  };
                @endphp
                <span class="inline-flex items-center gap-1.5 border px-2.5 py-1 rounded-full text-[11px] font-semibold capitalize {{ $badgeStyle }}">
                  <span class="w-1.5 h-1.5 rounded-full {{ $dotStyle }}"></span>
                  {{ $absen->status_kehadiran ?? $absen->status ?? '-' }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('absen.show', $absen->id_absen) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Lihat Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('absen.edit', $absen->id_absen) }}" class="p-1.5 text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Edit Data">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('absen.destroy', $absen->id_absen) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus Data">
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
                    <i data-lucide="clipboard-x" class="w-6 h-6"></i>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Belum ada data absensi</p>
                  <a href="{{ route('absen.create') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Catat Absensi Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($absens) && $absens->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        {{ $absens->links() }}
      </div>
    @endif
  </div>
@endsection