@extends('layouts.app')

@section('title', 'Rekapitulasi & Laporan Absensi - BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('absen.index') }}" class="hover:text-emerald-700 transition">Daftar Absensi</a> &gt; 
        <span class="text-slate-600 font-medium">Rekapitulasi & Laporan Kehadiran</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Rekapitulasi & Laporan Presensi</h1>
      <p class="text-xs text-slate-500 mt-0.5">Analisis tingkat kehadiran, statistik presensi kelas, dan rekapitulasi kelulusan peserta pelatihan vokasi.</p>
    </div>

    <!-- Tombol Aksi Export & Cetak -->
    <div class="flex flex-wrap items-center gap-2 self-start md:self-auto">
      <a href="{{ route('absen.export', request()->query()) }}" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="download" class="w-4 h-4"></i> Export Excel (CSV)
      </a>
      <a href="{{ route('absen.cetak', request()->query()) }}" target="_blank" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="printer" class="w-4 h-4"></i> Cetak Laporan Resmi
      </a>
      <a href="{{ route('absen.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </div>
  </div>

  <!-- Form Filter Rekapitulasi -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 mb-6">
    <div class="flex items-center gap-2 mb-3">
      <i data-lucide="filter" class="w-4 h-4 text-emerald-700"></i>
      <h2 class="font-bold text-slate-800 text-sm">Filter & Parameter Laporan</h2>
    </div>

    <form method="GET" action="{{ route('absen.rekap') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 text-xs">
      <!-- Filter Jadwal Pelatihan -->
      <div class="lg:col-span-2">
        <label class="block font-semibold text-slate-600 mb-1">Batch / Jadwal Pelatihan</label>
        <select name="id_jadwal" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:ring-1 focus:ring-emerald-600 focus:outline-none">
          <option value="">-- Semua Program Pelatihan --</option>
          @foreach($jadwals as $j)
            <option value="{{ $j->id_jadwal }}" {{ request('id_jadwal') == $j->id_jadwal ? 'selected' : '' }}>
              {{ $j->pelatihan->nama_pelatihan ?? 'Pelatihan #'.$j->id_jadwal }} 
              ({{ $j->tanggal_mulai ? \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M') : '' }} - {{ $j->tanggal_selesai ? \Carbon\Carbon::parse($j->tanggal_selesai)->format('d M Y') : '' }})
            </option>
          @endforeach
        </select>
      </div>

      <!-- Tanggal Mulai -->
      <div>
        <label class="block font-semibold text-slate-600 mb-1">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:ring-1 focus:ring-emerald-600 focus:outline-none">
      </div>

      <!-- Tanggal Selesai -->
      <div>
        <label class="block font-semibold text-slate-600 mb-1">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:ring-1 focus:ring-emerald-600 focus:outline-none">
      </div>

      <!-- Status Kehadiran -->
      <div>
        <label class="block font-semibold text-slate-600 mb-1">Status Kehadiran</label>
        <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:ring-1 focus:ring-emerald-600 focus:outline-none">
          <option value="">-- Semua Status --</option>
          <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
          <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
          <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
          <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha / Alpa</option>
        </select>
      </div>

      <!-- Action Buttons -->
      <div class="lg:col-span-5 flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
        <a href="{{ route('absen.rekap') }}" class="text-slate-500 hover:text-slate-800 text-xs px-3 py-1.5 rounded-lg border border-slate-200 transition">
          Reset Filter
        </a>
        <button type="submit" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-4 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm transition">
          <i data-lucide="search" class="w-3.5 h-3.5"></i> Terapkan Filter
        </button>
      </div>
    </form>
  </div>

  <!-- Detail Batch Aktif (Jika Jadwal Dipilih) -->
  @if($selectedJadwal)
    <div class="bg-gradient-to-r from-emerald-900 to-teal-900 rounded-xl p-5 mb-6 text-white shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <span class="inline-block bg-emerald-500/20 text-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider mb-1 border border-emerald-400/30">
          Program Pelatihan Terpilih
        </span>
        <h2 class="text-base font-bold">{{ $selectedJadwal->pelatihan->nama_pelatihan ?? '-' }}</h2>
        <p class="text-xs text-emerald-100/80 mt-0.5">
          Periode: {{ $selectedJadwal->tanggal_mulai ? \Carbon\Carbon::parse($selectedJadwal->tanggal_mulai)->format('d F Y') : '-' }} s/d {{ $selectedJadwal->tanggal_selesai ? \Carbon\Carbon::parse($selectedJadwal->tanggal_selesai)->format('d F Y') : '-' }}
        </p>
      </div>
      <div class="flex items-center gap-6 text-xs text-emerald-100/90 border-t md:border-t-0 md:border-l border-emerald-800/60 pt-3 md:pt-0 md:pl-6">
        <div>
          <span class="text-[10px] uppercase text-emerald-300 block font-semibold">Instruktur</span>
          <span class="font-bold text-white">{{ $selectedJadwal->instruktur->user->name ?? $selectedJadwal->instruktur ?? '-' }}</span>
        </div>
        <div>
          <span class="text-[10px] uppercase text-emerald-300 block font-semibold">Ruangan</span>
          <span class="font-bold text-white">{{ $selectedJadwal->ruanganWorkshop->nama_ruangan ?? $selectedJadwal->tempat ?? '-' }}</span>
        </div>
      </div>
    </div>
  @endif

  <!-- Executive Summary Stat Cards -->
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-6">
    <!-- Card Hadir -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
        <i data-lucide="check-circle-2" class="w-5 h-5"></i>
      </div>
      <div>
        <span class="text-[11px] text-slate-500 font-medium block">Total Hadir</span>
        <span class="text-lg font-black text-emerald-700">{{ $totalHadir }}</span>
      </div>
    </div>

    <!-- Card Izin -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
        <i data-lucide="mail" class="w-5 h-5"></i>
      </div>
      <div>
        <span class="text-[11px] text-slate-500 font-medium block">Total Izin</span>
        <span class="text-lg font-black text-amber-700">{{ $totalIzin }}</span>
      </div>
    </div>

    <!-- Card Sakit -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
        <i data-lucide="activity" class="w-5 h-5"></i>
      </div>
      <div>
        <span class="text-[11px] text-slate-500 font-medium block">Total Sakit</span>
        <span class="text-lg font-black text-blue-700">{{ $totalSakit }}</span>
      </div>
    </div>

    <!-- Card Alpha -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
        <i data-lucide="x-circle" class="w-5 h-5"></i>
      </div>
      <div>
        <span class="text-[11px] text-slate-500 font-medium block">Total Alpha</span>
        <span class="text-lg font-black text-rose-700">{{ $totalAlpha }}</span>
      </div>
    </div>

    <!-- Card Tingkat Kehadiran -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-3 col-span-2 sm:col-span-1">
      <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 font-bold text-xs">
        %
      </div>
      <div>
        <span class="text-[11px] text-slate-500 font-medium block">Tingkat Kehadiran</span>
        <span class="text-lg font-black text-slate-800">{{ $persenHadir }}%</span>
      </div>
    </div>
  </div>

  <!-- TABEL 1: Rekapitulasi Per Siswa / Peserta -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
      <div class="flex items-center gap-2">
        <i data-lucide="users" class="w-4 h-4 text-emerald-700"></i>
        <h2 class="font-bold text-slate-800 text-sm">Rekapitulasi Kehadiran Per Peserta</h2>
        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-semibold px-2 py-0.5 rounded-full">
          {{ $rekapPeserta->count() }} Peserta
        </span>
      </div>
      <span class="text-[11px] text-slate-400">
        Syarat Kelulusan Minimal: <strong>80% Kehadiran</strong>
      </span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
            <th class="px-4 py-3 font-semibold w-10 text-center">#</th>
            <th class="px-4 py-3 font-semibold">Peserta Pelatihan</th>
            <th class="px-3 py-3 font-semibold text-center w-20">Hadir</th>
            <th class="px-3 py-3 font-semibold text-center w-20">Izin</th>
            <th class="px-3 py-3 font-semibold text-center w-20">Sakit</th>
            <th class="px-3 py-3 font-semibold text-center w-20">Alpha</th>
            <th class="px-3 py-3 font-semibold text-center w-24">Total Sesi</th>
            <th class="px-4 py-3 font-semibold text-center w-36">Persentase</th>
            <th class="px-4 py-3 font-semibold text-center w-36">Status Kelayakan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($rekapPeserta as $index => $rp)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-4 py-3 text-center text-slate-400">{{ $loop->iteration }}</td>
              <td class="px-4 py-3">
                <span class="font-bold text-slate-800 block text-xs">{{ $rp->peserta->user->name ?? '-' }}</span>
                <span class="text-[11px] text-slate-400">
                  No. Peserta: {{ $rp->peserta->nomor_peserta ?? '-' }} &bull; {{ $rp->peserta->user->email ?? '-' }}
                </span>
              </td>
              <td class="px-3 py-3 text-center font-bold text-emerald-700">{{ $rp->hadir }}</td>
              <td class="px-3 py-3 text-center font-medium text-amber-600">{{ $rp->izin }}</td>
              <td class="px-3 py-3 text-center font-medium text-blue-600">{{ $rp->sakit }}</td>
              <td class="px-3 py-3 text-center font-medium text-rose-600">{{ $rp->alpha }}</td>
              <td class="px-3 py-3 text-center font-semibold text-slate-800">{{ $rp->total }}</td>
              <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-2">
                  <div class="w-16 bg-slate-200 rounded-full h-2 overflow-hidden shrink-0">
                    <div class="h-2 rounded-full {{ $rp->persentase >= 80 ? 'bg-emerald-500' : ($rp->persentase >= 60 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ $rp->persentase }}%"></div>
                  </div>
                  <span class="font-bold text-xs {{ $rp->persentase >= 80 ? 'text-emerald-700' : 'text-slate-800' }}">{{ $rp->persentase }}%</span>
                </div>
              </td>
              <td class="px-4 py-3 text-center">
                @if($rp->persentase >= 80)
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <i data-lucide="check-circle" class="w-3 h-3"></i> Memenuhi Syarat
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <i data-lucide="alert-triangle" class="w-3 h-3"></i> Perlu Perhatian
                  </span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="p-8 text-center text-slate-400">
                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                <p>Tidak ada data absensi yang sesuai dengan filter.</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- TABEL 2: Log Detail Catatan Presensi -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
      <div class="flex items-center gap-2">
        <i data-lucide="list" class="w-4 h-4 text-emerald-700"></i>
        <h2 class="font-bold text-slate-800 text-sm">Log Rincian Presensi Harian</h2>
        <span class="bg-slate-100 text-slate-700 text-[10px] font-semibold px-2 py-0.5 rounded-full">
          {{ $absens->total() }} Record
        </span>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
            <th class="px-4 py-3 font-semibold w-10 text-center">#</th>
            <th class="px-4 py-3 font-semibold">Peserta</th>
            <th class="px-4 py-3 font-semibold">Program Pelatihan</th>
            <th class="px-4 py-3 font-semibold">Tanggal & Jam</th>
            <th class="px-3 py-3 font-semibold text-center">Status</th>
            <th class="px-4 py-3 font-semibold">Validasi Lokasi GPS</th>
            <th class="px-4 py-3 font-semibold">Keterangan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($absens as $absen)
            @php
              $status = strtolower($absen->status_kehadiran ?? '');
              $badge = match($status) {
                  'hadir' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                  'izin'  => 'bg-amber-50 text-amber-700 border-amber-200',
                  'sakit' => 'bg-blue-50 text-blue-700 border-blue-200',
                  default => 'bg-rose-50 text-rose-700 border-rose-200',
              };
            @endphp
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-4 py-3 text-center text-slate-400">{{ $loop->iteration + ($absens->currentPage() - 1) * $absens->perPage() }}</td>
              <td class="px-4 py-3">
                <span class="font-bold text-slate-800 block">{{ $absen->peserta->user->name ?? '-' }}</span>
                <span class="text-[11px] text-slate-400">{{ $absen->peserta->nomor_peserta ?? '-' }}</span>
              </td>
              <td class="px-4 py-3">
                <span class="font-medium text-slate-700">{{ $absen->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
              </td>
              <td class="px-4 py-3">
                <span class="font-medium text-slate-800 block">{{ $absen->tanggal ? $absen->tanggal->format('d/m/Y') : '-' }}</span>
                <span class="text-[11px] text-slate-400">{{ $absen->jam_hadir ? substr($absen->jam_hadir, 0, 5) . ' WIB' : '-' }}</span>
              </td>
              <td class="px-3 py-3 text-center">
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border capitalize {{ $badge }}">
                  {{ $absen->status_kehadiran }}
                </span>
              </td>
              <td class="px-4 py-3">
                @if($absen->latitude && $absen->longitude)
                  <div class="flex items-center gap-1.5 text-[11px]">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                    <span>
                      @if($absen->jarak_meter !== null)
                        <strong>{{ round($absen->jarak_meter) }}m</strong> dari titik pelatihan
                      @else
                        GPS tercatat
                      @endif
                    </span>
                    <a href="https://www.google.com/maps?q={{ $absen->latitude }},{{ $absen->longitude }}" target="_blank" class="text-emerald-700 hover:underline shrink-0">
                      <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                  </div>
                @else
                  <span class="text-slate-400 text-[11px]">-</span>
                @endif
              </td>
              <td class="px-4 py-3 text-[11px] text-slate-500">
                {{ $absen->keterangan ?? '-' }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="p-8 text-center text-slate-400">
                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                <p>Belum ada rekaman absensi pada periode ini.</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($absens->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        {{ $absens->links() }}
      </div>
    @endif
  </div>
@endsection

