@extends('layouts.app')

@section('title', 'Detail Profil Mitra DU/DI - ' . $mitra->nama_perusahaan)

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('mitras.index') }}" class="hover:text-emerald-700 transition">Mitra DU/DI</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Perusahaan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Profil Mitra Industri DU/DI</h1>
      <p class="text-xs text-slate-500 mt-0.5">Rincian profil badan usaha, legalitas kerjasama, penanggung jawab industri, dan lowongan aktif.</p>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
      <a href="{{ route('mitras.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
      <a href="{{ route('mitras.edit', $mitra->id_mitra) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Data
      </a>
    </div>
  </div>

  <!-- Hero Profile Banner Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-emerald-50/50 to-transparent pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-950 text-white font-black text-2xl flex items-center justify-center shadow-md shrink-0">
          {{ strtoupper(substr($mitra->nama_perusahaan, 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-extrabold text-slate-900">{{ $mitra->nama_perusahaan }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
              ID: #MTR-{{ str_pad((string)$mitra->id_mitra, 3, '0', STR_PAD_LEFT) }}
            </span>
            <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">
              {{ $mitra->jenis_mitra ?? 'Perusahaan Mitra' }}
            </span>
          </div>
          <div class="flex items-center gap-4 text-xs text-slate-500 mt-1.5 flex-wrap">
            <span class="flex items-center gap-1.5"><i data-lucide="briefcase" class="w-3.5 h-3.5 text-slate-400"></i> Sektor: {{ $mitra->bidang_usaha ?? 'Umum' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $mitra->kota ?? 'Kota Tidak Tercatat' }}, {{ $mitra->provinsi ?? '-' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i> {{ $mitra->no_telp ?? $mitra->telepon ?? '-' }}</span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Kerjasama</div>
        <div class="text-xs font-bold text-emerald-700 flex items-center gap-1.5 mt-0.5 justify-end">
          <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
          Mitra Aktif Balai
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="briefcase" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Lowongan Magang</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($mitra->lowongan ?? []) }} Posisi</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
        <i data-lucide="shield-check" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Status Legalitas</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ $mitra->no_izin ? 'Terverifikasi NIB' : 'Terdaftar' }}</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
        <i data-lucide="user-check" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">PIC Penanggung Jawab</div>
        <div class="text-sm font-bold text-slate-900 mt-0.5">{{ $mitra->jabatan_pic ?? 'HRD / PIC Industri' }}</div>
      </div>
    </div>
  </div>

  <!-- Detail Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left 2 Cols: Informasi Rinci & Lowongan -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Card: Informasi Perusahaan -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="info" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Informasi Badan Usaha</h3>
              <p class="text-xs text-slate-500">Rincian legalitas dan kontak resmi perusahaan.</p>
            </div>
          </div>
          <a href="{{ route('mitras.edit', $mitra->id_mitra) }}" class="text-xs font-semibold text-emerald-700 hover:underline flex items-center gap-1">
            <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit
          </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-xs">
          <div>
            <span class="text-slate-400 font-medium block mb-1">Nama Perusahaan</span>
            <span class="text-slate-800 font-bold text-sm">{{ $mitra->nama_perusahaan }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Bidang Usaha</span>
            <span class="text-slate-800 font-semibold">{{ $mitra->bidang_usaha ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Nomor Izin / NIB</span>
            <span class="text-slate-800 font-semibold">{{ $mitra->no_izin ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Akun Pengguna Terkait</span>
            <span class="text-slate-800 font-semibold">{{ $mitra->user->name ?? 'Tidak ditautkan' }} {{ $mitra->user ? '(' . $mitra->user->email . ')' : '' }}</span>
          </div>

          <div class="sm:col-span-2">
            <span class="text-slate-400 font-medium block mb-1">Alamat Kantor / Pabrik</span>
            <span class="text-slate-800 leading-relaxed font-medium">{{ $mitra->alamat ?? '-' }}</span>
          </div>
        </div>
      </div>

      <!-- Card: Lowongan Yang Dibuka -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="briefcase" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Lowongan Magang Industri</h3>
              <p class="text-xs text-slate-500">Daftar posisi magang yang dipublikasikan oleh mitra ini.</p>
            </div>
          </div>
          <a href="{{ route('lowongan.create') }}" class="text-xs text-emerald-700 font-semibold hover:underline flex items-center gap-1">
            <i data-lucide="plus" class="w-3.5 h-3.5"></i> Buka Lowongan Baru
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 text-[11px] uppercase">
                <th class="px-5 py-3 font-semibold">Judul Lowongan</th>
                <th class="px-5 py-3 font-semibold">Lokasi Penempatan</th>
                <th class="px-5 py-3 font-semibold">Tanggal Posting</th>
                <th class="px-5 py-3 font-semibold">Status</th>
                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($mitra->lowongan ?? [] as $lowongan)
                <tr class="hover:bg-slate-50/80">
                  <td class="px-5 py-3 font-bold text-slate-800">{{ $lowongan->judul_lowongan }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $lowongan->lokasi ?? '-' }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $lowongan->tanggal_posting ? $lowongan->tanggal_posting->translatedFormat('d M Y') : '-' }}</td>
                  <td class="px-5 py-3">
                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full capitalize">
                      {{ $lowongan->status ?? 'aktif' }}
                    </span>
                  </td>
                  <td class="px-5 py-3 text-right">
                    <a href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" class="text-emerald-700 hover:underline font-semibold">Detail</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada lowongan magang yang dibuka oleh mitra ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right 1 Col: Kontak & Tindakan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Kontak Cepat PIC</h4>
        <div class="space-y-3 text-xs">
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="phone" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $mitra->no_telp ?? $mitra->telepon ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="user" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $mitra->jabatan_pic ?? 'Representatif Industri' }}</span>
          </div>
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="map-pin" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $mitra->kota ?? '-' }}, {{ $mitra->provinsi ?? '-' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Aksi Cepat</h4>
        <div class="space-y-2">
          <a href="{{ route('mitras.edit', $mitra->id_mitra) }}" class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Data Mitra
          </a>
          <form action="{{ route('mitras.destroy', $mitra->id_mitra) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i> Hapus Mitra
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

