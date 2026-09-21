@extends('layouts.app')

@section('title', 'Detail Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pelatihan.index') }}" class="hover:text-emerald-700 transition">Program Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Program</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Rincian Kurikulum & Kejuruan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Spesifikasi kompetensi vokasi, silabus pembelajaran, kuota kelas, dan jadwal pelaksanaan.</p>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
      <a href="{{ route('pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
      <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Kurikulum
      </a>
    </div>
  </div>

  <!-- Hero Profile Banner Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-emerald-50/50 to-transparent pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-black text-2xl flex items-center justify-center shadow-md shrink-0">
          <i data-lucide="book-open" class="w-8 h-8"></i>
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-extrabold text-slate-900">{{ $pelatihan->nama_pelatihan }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
              ID: #PLT-{{ str_pad((string)$pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
            </span>
          </div>
          <div class="flex items-center gap-4 text-xs text-slate-500 mt-1.5 flex-wrap">
            <span class="flex items-center gap-1.5"><i data-lucide="user-check" class="w-3.5 h-3.5 text-slate-400"></i> Pembina: {{ $pelatihan->admin->user->name ?? 'Admin BLK Pusat' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i> Durasi: {{ $pelatihan->durasi_lp ?? '240 JP' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i> Kuota: {{ $pelatihan->kuota }} Kursi / Batch</span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Kurikulum</div>
        <div class="text-xs font-bold text-emerald-700 flex items-center gap-1.5 mt-0.5 justify-end">
          <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
          Aktif Digunakan
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="calendar" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Batch Jadwal</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($pelatihan->jadwal ?? []) }} Batch</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
        <i data-lucide="users-2" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Target Kuota / Angkatan</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ $pelatihan->kuota }} Peserta</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Standar Kompetensi</div>
        <div class="text-sm font-bold text-slate-900 mt-0.5">Sertifikasi BNSP / BLK</div>
      </div>
    </div>
  </div>

  <!-- Detail Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left 2 Cols: Silabus & Jadwal Pelatihan -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Card: Silabus & Deskripsi -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
          <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
            <i data-lucide="file-text" class="w-4 h-4"></i>
          </div>
          <div>
            <h3 class="font-bold text-slate-800 text-sm">Deskripsi Silabus & Output Kejuruan</h3>
            <p class="text-xs text-slate-500">Materi dan keahlian kerja yang dipelajari selama pelatihan.</p>
          </div>
        </div>

        <div class="text-xs text-slate-700 leading-relaxed font-normal whitespace-pre-line bg-slate-50/70 p-4 rounded-xl border border-slate-100">
          {{ $pelatihan->deskripsi_pelatihan ?: 'Belum ada silabus / deskripsi pelatihan yang ditambahkan.' }}
        </div>
      </div>

      <!-- Card: Jadwal Pelatihan Aktif -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="calendar-check" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Batch & Jadwal Kelas Aktif</h3>
              <p class="text-xs text-slate-500">Jadwal yang dibuka untuk program kejuruan ini.</p>
            </div>
          </div>
          <a href="{{ route('jadwal-pelatihan.create') }}" class="text-xs text-emerald-700 font-semibold hover:underline flex items-center gap-1">
            <i data-lucide="plus" class="w-3.5 h-3.5"></i> Buka Batch Baru
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 text-[11px] uppercase">
                <th class="px-5 py-3 font-semibold">Instruktur</th>
                <th class="px-5 py-3 font-semibold">Ruangan / Tempat</th>
                <th class="px-5 py-3 font-semibold">Hari & Jam</th>
                <th class="px-5 py-3 font-semibold">Siswa Terdaftar</th>
                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($pelatihan->jadwal ?? [] as $jadwal)
                <tr class="hover:bg-slate-50/80">
                  <td class="px-5 py-3 font-bold text-slate-800">{{ $jadwal->instruktur ?? '-' }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $jadwal->ruangan ?? '-' }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $jadwal->hari ?? '-' }} ({{ $jadwal->jam ?? '-' }})</td>
                  <td class="px-5 py-3">
                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                      {{ count($jadwal->kelas ?? []) }} Siswa
                    </span>
                  </td>
                  <td class="px-5 py-3 text-right">
                    <a href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}" class="text-emerald-700 hover:underline font-semibold">Detail</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada batch jadwal yang dibuat untuk program ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right 1 Col: Info Ringkas & Tindakan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Metadata Pelatihan</h4>
        <div class="space-y-3 text-xs">
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Durasi:</span>
            <span class="font-semibold">{{ $pelatihan->durasi_lp ?? '240 JP' }}</span>
          </div>
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Kuota:</span>
            <span class="font-semibold">{{ $pelatihan->kuota }} Siswa</span>
          </div>
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Terdaftar Pada:</span>
            <span class="font-semibold">{{ $pelatihan->created_at ? $pelatihan->created_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Aksi Administratif</h4>
        <div class="space-y-2">
          <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}" class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Kurikulum
          </a>
          <a href="{{ route('jadwal-pelatihan.create') }}" class="w-full px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
            <i data-lucide="calendar-plus" class="w-4 h-4"></i> Buat Jadwal Baru
          </a>
          <form action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i> Hapus Program
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
