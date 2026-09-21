@extends('layouts.app')

@section('title', 'Detail Penempatan Kelas Siswa - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('kelas-pelatihan.index') }}" class="hover:text-emerald-700 transition">Kelas Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Siswa di Kelas</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Status Penempatan & Progres Siswa</h1>
      <p class="text-xs text-slate-500 mt-0.5">Pantau keterlibatan siswa pada program kejuruan vokasi, rekaman presensi, dan status kelulusan.</p>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
      <a href="{{ route('kelas-pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
      <a href="{{ route('kelas-pelatihan.edit', $kelas->id_kelas) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Status
      </a>
    </div>
  </div>

  <!-- Hero Banner Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-emerald-50/50 to-transparent pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-black text-2xl flex items-center justify-center shadow-md shrink-0">
          {{ strtoupper(substr($kelas->peserta->user->name ?? 'P', 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-extrabold text-slate-900">{{ $kelas->peserta->user->name ?? 'Peserta' }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
              NIS: {{ $kelas->peserta->nomor_peserta ?? '-' }}
            </span>
            <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">
              {{ $kelas->jadwal->pelatihan->nama_pelatihan ?? '-' }}
            </span>
          </div>
          <div class="flex items-center gap-4 text-xs text-slate-500 mt-1.5 flex-wrap">
            <span class="flex items-center gap-1.5"><i data-lucide="user-check" class="w-3.5 h-3.5 text-slate-400"></i> Instruktur: {{ $kelas->jadwal->instruktur ?? '-' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> Ruangan: {{ $kelas->jadwal->tempat ?? '-' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i> Batch #JDW-{{ str_pad((string)$kelas->jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}</span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Siswa</div>
        <div class="text-xs font-bold text-emerald-700 flex items-center gap-1.5 mt-0.5 justify-end">
          @if($kelas->status === 'lulus')
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            Telah Lulus Pelatihan
          @elseif($kelas->status === 'aktif')
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            Sedang Mengikuti Kelas
          @elseif($kelas->status === 'tidak lulus')
            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
            Tidak Lulus
          @else
            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
            Terdaftar di Roster
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left 2 Cols: Info Program & Biodata -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="info" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Rincian Program & Jadwal Siswa</h3>
              <p class="text-xs text-slate-500">Informasi lengkap penempatan kelas pelatihan vokasi.</p>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-xs">
          <div>
            <span class="text-slate-400 font-medium block mb-1">Nama Program Kejuruan</span>
            <span class="text-slate-800 font-bold text-sm">{{ $kelas->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Durasi Jam Pelatihan</span>
            <span class="text-slate-800 font-semibold">{{ $kelas->jadwal->pelatihan->durasi_lp ?? '240 JP' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Periode Tanggal</span>
            <span class="text-slate-800 font-semibold">
              {{ $kelas->jadwal->tanggal_mulai ? $kelas->jadwal->tanggal_mulai->translatedFormat('d M Y') : '-' }} s/d {{ $kelas->jadwal->tanggal_selesai ? $kelas->jadwal->tanggal_selesai->translatedFormat('d M Y') : '-' }}
            </span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Jam Belajar Harian</span>
            <span class="text-slate-800 font-semibold">
              {{ $kelas->jadwal->jam_mulai ? \Carbon\Carbon::parse($kelas->jadwal->jam_mulai)->format('H:i') : '08:00' }} - {{ $kelas->jadwal->jam_selesai ? \Carbon\Carbon::parse($kelas->jadwal->jam_selesai)->format('H:i') : '15:30' }} WIB
            </span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Instruktur Pembimbing</span>
            <span class="text-slate-800 font-semibold">{{ $kelas->jadwal->instruktur ?? 'Belum Ditunjuk' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Ruangan / Tempat</span>
            <span class="text-slate-800 font-semibold">{{ $kelas->jadwal->tempat ?? 'Workshop BLK' }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Right 1 Col: Info Siswa & Tindakan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Profil Singkat Siswa</h4>
        <div class="space-y-3 text-xs">
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="user" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $kelas->peserta->user->name ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="phone" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $kelas->peserta->nomor_wa ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="mail" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $kelas->peserta->user->email ?? '-' }}</span>
          </div>
          <div class="pt-2 border-t border-slate-100">
            <a href="{{ route('pesertas.show', $kelas->id_peserta) }}" class="text-xs text-emerald-700 font-semibold hover:underline flex items-center gap-1">
              <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Lihat Profil Lengkap Siswa
            </a>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Aksi</h4>
        <div class="space-y-2">
          <a href="{{ route('kelas-pelatihan.edit', $kelas->id_kelas) }}" class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Penempatan Kelas
          </a>
          <form action="{{ route('kelas-pelatihan.destroy', $kelas->id_kelas) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini dari kelas?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i> Hapus dari Roster
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
