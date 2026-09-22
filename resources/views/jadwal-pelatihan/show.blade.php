@extends('layouts.app')

@section('title', 'Detail Batch Jadwal - ' . ($jadwal->pelatihan->nama_pelatihan ?? 'Jadwal'))

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('jadwal-pelatihan.index') }}" class="hover:text-emerald-700 transition">Jadwal Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Batch</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Rincian Pelaksanaan & Roster Kelas</h1>
      <p class="text-xs text-slate-500 mt-0.5">Informasi periode waktu, alokasi ruangan laboratorium/bengkel, dan daftar siswa yang terdaftar.</p>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
      <a href="{{ route('jadwal-pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
      <a href="{{ route('jadwal-pelatihan.edit', $jadwal->id_jadwal) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Jadwal
      </a>
    </div>
  </div>

  <!-- Hero Profile Banner Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-emerald-50/50 to-transparent pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-black text-2xl flex items-center justify-center shadow-md shrink-0">
          <i data-lucide="calendar" class="w-8 h-8"></i>
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-extrabold text-slate-900">{{ $jadwal->pelatihan->nama_pelatihan ?? 'Kejuruan Vokasi' }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
              Batch: #JDW-{{ str_pad((string)$jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
            </span>
          </div>
          <div class="flex items-center gap-4 text-xs text-slate-500 mt-1.5 flex-wrap">
            <span class="flex items-center gap-1.5"><i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i> Instruktur: {{ $jadwal->instruktur ?? 'Belum Ditunjuk' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> Lokasi: {{ $jadwal->tempat ?? 'Workshop BLK' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i> Jam: {{ $jadwal->jam_mulai ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '08:00' }} - {{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '15:30' }}</span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Pelaksanaan</div>
        <div class="text-xs font-bold text-emerald-700 flex items-center gap-1.5 mt-0.5 justify-end">
          @if($jadwal->status === 'tersedia')
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            Pendaftaran Tersedia
          @elseif($jadwal->status === 'berlangsung')
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            Kelas Berlangsung
          @else
            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
            Selesai
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="users" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Siswa Terdaftar</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">
          {{ count($jadwal->kelas ?? []) }} / {{ $jadwal->pelatihan->kuota ?? '16' }} Peserta
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
        <i data-lucide="check-square" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Catatan Presensi</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($jadwal->absensi ?? []) }} Kehadiran</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Sertifikat Diterbitkan</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($jadwal->sertifikat ?? []) }} Lembar</div>
      </div>
    </div>
  </div>

  <!-- Detail Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left 2 Cols: Siswa Terdaftar di Kelas -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="users" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Daftar Roster Siswa Kelas Ini</h3>
              <p class="text-xs text-slate-500">Siswa vokasi yang terdaftar pada batch jadwal ini.</p>
            </div>
          </div>
          <a href="{{ route('kelas-pelatihan.create') }}" class="text-xs text-emerald-700 font-semibold hover:underline flex items-center gap-1">
            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Masukkan Siswa
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 text-[11px] uppercase">
                <th class="px-5 py-3 font-semibold">NIS</th>
                <th class="px-5 py-3 font-semibold">Nama Siswa</th>
                <th class="px-5 py-3 font-semibold">Kontak / Email</th>
                <th class="px-5 py-3 font-semibold">Status Kelas</th>
                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($jadwal->kelas ?? [] as $kelas)
                <tr class="hover:bg-slate-50/80">
                  <td class="px-5 py-3 font-mono font-bold text-slate-500">{{ $kelas->peserta->nomor_peserta ?? '-' }}</td>
                  <td class="px-5 py-3 font-bold text-slate-800">{{ $kelas->peserta->user->name ?? '-' }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $kelas->peserta->nomor_wa ?? $kelas->peserta->user->email ?? '-' }}</td>
                  <td class="px-5 py-3">
                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full capitalize">
                      {{ $kelas->status_kelulusan ?? 'Terdaftar' }}
                    </span>
                  </td>
                  <td class="px-5 py-3 text-right">
                    <a href="{{ route('pesertas.show', $kelas->id_peserta) }}" class="text-emerald-700 hover:underline font-semibold">Lihat Siswa</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada peserta yang dimasukkan ke dalam batch ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right 1 Col: Info Periode & Tindakan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Rincian Periode</h4>
        <div class="space-y-3 text-xs">
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Mulai:</span>
            <span class="font-semibold">{{ $jadwal->tanggal_mulai ? $jadwal->tanggal_mulai->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Selesai:</span>
            <span class="font-semibold">{{ $jadwal->tanggal_selesai ? $jadwal->tanggal_selesai->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Durasi Silabus:</span>
            <span class="font-semibold">{{ $jadwal->pelatihan->durasi_lp ?? '240 JP' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Aksi Administratif</h4>
        <div class="space-y-2">
          <a href="{{ route('absen.index') }}" class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="check-square" class="w-4 h-4"></i> Rekap Presensi Siswa
          </a>
          <a href="{{ route('jadwal-pelatihan.edit', $jadwal->id_jadwal) }}" class="w-full px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Jadwal
          </a>
          <form action="{{ route('jadwal-pelatihan.destroy', $jadwal->id_jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus batch jadwal ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i> Hapus Jadwal
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
