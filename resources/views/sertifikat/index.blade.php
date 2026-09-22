@extends('layouts.app')

@section('title', 'Manajemen Sertifikat - BLK')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <span>Beranda</span> &gt; <span class="text-slate-600 font-medium">Sertifikasi</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Manajemen Sertifikat Peserta</h1>
      <p class="text-xs text-slate-500 mt-0.5">Kelola data terbitan sertifikat kelulusan pelatihan vokasi dan dokumen digital peserta.</p>
    </div>

    <div class="flex flex-wrap items-center gap-2 self-start md:self-auto">
      <a href="{{ route('sertifikat.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="award" class="w-4 h-4"></i> Tambah Sertifikat
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

  <!-- Management Section: Table Sertifikat -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <div class="flex items-center gap-2">
          <div class="p-1.5 bg-emerald-50 text-emerald-700 rounded-lg">
            <i data-lucide="award" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Daftar Sertifikat Diterbitkan</h2>
          <span class="bg-emerald-100 text-emerald-800 text-[11px] font-semibold px-2 py-0.5 rounded-full">
            {{ isset($sertifikats) ? $sertifikats->total() : 0 }} Berkas
          </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Daftar sertifikat kompetensi resmi yang diterbitkan oleh Balai Latihan Kerja.</p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('sertifikat.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition">
          <i data-lucide="plus" class="w-3.5 h-3.5"></i>
          <span>Tambah Sertifikat</span>
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
            <th class="px-5 py-3 font-semibold">Program Pelatihan</th>
            <th class="px-5 py-3 font-semibold">No. Sertifikat</th>
            <th class="px-5 py-3 font-semibold">Tanggal Terbit</th>
            <th class="px-5 py-3 font-semibold text-center">Berkas PDF</th>
            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($sertifikats as $sertifikat)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-5 py-3.5 text-center font-medium text-slate-400">
                {{ $loop->iteration + ($sertifikats->currentPage() - 1) * $sertifikats->perPage() }}
              </td>
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr($sertifikat->peserta->user->name ?? 'P', 0, 2)) }}
                  </div>
                  <div>
                    <div class="font-bold text-slate-800">
                      {{ $sertifikat->peserta->user->name ?? 'Tanpa Nama' }}
                    </div>
                    <div class="text-[10px] text-slate-400">
                      {{ $sertifikat->peserta->user->email ?? '-' }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1.5">
                  <i data-lucide="book-open" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $sertifikat->jadwal->pelatihan->nama_pelatihan ?? '-' }}</span>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <span class="inline-flex items-center gap-1 font-mono text-[11px] font-semibold text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80">
                  <i data-lucide="file-badge" class="w-3 h-3 text-emerald-700"></i>
                  {{ $sertifikat->no_sertifikat ?? $sertifikat->nomor_sertifikat ?? '-' }}
                </span>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1.5">
                  <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->translatedFormat('d M Y') : '-' }}</span>
                </div>
              </td>
              <td class="px-5 py-3.5 text-center">
                @if($sertifikat->file_sertifikat)
                  <a href="{{ Storage::url($sertifikat->file_sertifikat) }}" target="_blank" class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 px-2.5 py-1 rounded-full text-[11px] font-semibold transition">
                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Lihat PDF
                  </a>
                @else
                  <span class="inline-flex items-center gap-1 text-slate-400 text-[11px]">
                    <i data-lucide="file-x" class="w-3.5 h-3.5"></i> Belum Ada
                  </span>
                @endif
              </td>
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('sertifikat.show', $sertifikat->id_sertifikat) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Lihat Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('sertifikat.edit', $sertifikat->id_sertifikat) }}" class="p-1.5 text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Edit Data">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('sertifikat.destroy', $sertifikat->id_sertifikat) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini beserta filenya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus Sertifikat">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-5 py-10 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center gap-2">
                  <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                    <i data-lucide="award" class="w-6 h-6"></i>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Belum ada data sertifikat yang diterbitkan</p>
                  <a href="{{ route('sertifikat.create') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Terbitkan Sertifikat Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($sertifikats) && $sertifikats->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        {{ $sertifikats->links() }}
      </div>
    @endif
  </div>
@endsection