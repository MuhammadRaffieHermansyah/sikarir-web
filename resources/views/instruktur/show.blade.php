@extends('layouts.app')

@section('title', 'Detail Instruktur - BLK CONNECT')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('instruktur.index') }}" class="hover:text-emerald-700 transition">Instruktur</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Instruktur</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Detail Instruktur</h1>
      <p class="text-xs text-slate-500 mt-0.5">Informasi lengkap instruktur beserta jadwal pelatihan yang diampu.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('instruktur.edit', $instruktur->id) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Instruktur
      </a>
      <a href="{{ route('instruktur.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </div>
  </div>

  <!-- Header Card -->
  <div class="bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 rounded-2xl text-white p-6 shadow-sm flex flex-col md:flex-row justify-between gap-4">
    <div>
      <div class="text-[10px] text-emerald-300 uppercase font-bold tracking-wider mb-1">Master Instruktur</div>
      <div class="flex items-center gap-2.5 flex-wrap">
        <h2 class="text-lg font-extrabold">{{ $instruktur->nama }}</h2>
        <span class="bg-emerald-500/20 text-emerald-200 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-400/30">
          ID: #INS-{{ str_pad((string)$instruktur->id, 3, '0', STR_PAD_LEFT) }}
        </span>
      </div>
      <div class="flex items-center gap-4 text-xs text-emerald-100/70 mt-1.5">
        <span class="flex items-center gap-1.5"><i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i> {{ $instruktur->bidang_keahlian }}</span>
      </div>
    </div>
    <div class="text-right md:border-l md:border-emerald-800/50 md:pl-6 flex md:block items-center justify-between gap-3">
      <div class="text-[10px] text-emerald-300 uppercase font-bold tracking-wider">Jadwal Diampu</div>
      <div class="text-2xl font-black mt-0.5">{{ count($instruktur->jadwal ?? []) }} Jadwal</div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Metadata -->
    <div class="space-y-6 lg:col-span-1">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Metadata</h4>
        <div class="space-y-3 text-xs">
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Nama:</span>
            <span class="font-semibold">{{ $instruktur->nama }}</span>
          </div>
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Bidang Keahlian:</span>
            <span class="font-semibold">{{ $instruktur->bidang_keahlian }}</span>
          </div>
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Dibuat pada:</span>
            <span class="font-semibold">{{ $instruktur->created_at ? $instruktur->created_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between text-slate-700">
            <span class="text-slate-400">Diperbarui:</span>
            <span class="font-semibold">{{ $instruktur->updated_at ? $instruktur->updated_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
        </div>
      </div>

      <!-- Danger Zone -->
      <div class="bg-rose-50/50 rounded-xl border border-rose-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-rose-800 text-xs flex items-center gap-1.5">
          <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i> Zona Berbahaya
        </h4>
        <p class="text-[11px] text-rose-600 leading-relaxed">
          Menghapus instruktur ini akan membuat jadwal pelatihan terkait kehilangan penugasan instruktur (tidak dihapus).
        </p>
        <form action="{{ route('instruktur.destroy', $instruktur->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus instruktur ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs py-2 px-4 rounded-lg transition">
            Hapus Instruktur
          </button>
        </form>
      </div>
    </div>

    <!-- Jadwal Pelatihan Terkait -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
          <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
            <i data-lucide="calendar-clock" class="w-4 h-4 text-emerald-700"></i>
            Jadwal Pelatihan Diampu
          </h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
                <th class="px-5 py-3 font-semibold">Program</th>
                <th class="px-5 py-3 font-semibold">Periode</th>
                <th class="px-5 py-3 font-semibold">Status</th>
                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($instruktur->jadwal ?? [] as $jadwal)
                <tr class="hover:bg-slate-50/80 transition">
                  <td class="px-5 py-3.5 font-bold text-slate-800">{{ $jadwal->pelatihan?->nama_pelatihan ?? 'Program dihapus' }}</td>
                  <td class="px-5 py-3.5">
                    <span class="text-[11px] font-semibold text-slate-600">
                      {{ $jadwal->tanggal_mulai?->format('d M Y') }} &mdash; {{ $jadwal->tanggal_selesai?->format('d M Y') }}
                    </span>
                  </td>
                  <td class="px-5 py-3.5">
                    <span class="bg-blue-50 text-blue-700 font-semibold px-2 py-0.5 rounded text-[11px]">{{ ucfirst($jadwal->status) }}</span>
                  </td>
                  <td class="px-5 py-3.5 text-right">
                    <a href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}" class="text-emerald-700 hover:underline font-semibold">Detail</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-5 py-10 text-center text-slate-400">
                    <div class="flex flex-col items-center justify-center gap-2">
                      <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <i data-lucide="calendar-clock" class="w-6 h-6"></i>
                      </div>
                      <p class="text-xs font-medium text-slate-600">Instruktur ini belum ditugaskan pada jadwal pelatihan</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
