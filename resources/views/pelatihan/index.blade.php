@extends('layouts.app')

@section('title', 'Katalog Program Pelatihan Vokasi - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Program Pelatihan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Katalog Kejuruan & Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Kelola kurikulum, kapasitas kuota siswa, durasi jam pelatihan, dan alokasi instruktur vokasi.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('jadwal-pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="calendar" class="w-4 h-4"></i> Lihat Jadwal Kelas
      </a>
      <a href="{{ route('pelatihan.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Program Baru
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
        <i data-lucide="book-open" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Program</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">{{ $pelatihans->total() }} Kejuruan</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
        <i data-lucide="users" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Alokasi Kuota</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">{{ $pelatihans->sum('kuota') }} Kursi</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
        <i data-lucide="clock" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Standar Durasi</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">240 - 320 JP</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Sertifikasi BNSP</div>
        <div class="text-xl font-black text-slate-900 mt-0.5">Berstandar SKKNI</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
      <div>
        <h3 class="font-bold text-slate-800 text-sm">Daftar Kejuruan & Kurikulum Pelatihan</h3>
        <p class="text-xs text-slate-500">Menampilkan kejuruan berbasis kompetensi kerja Disnaker.</p>
      </div>

      <div class="flex items-center gap-2">
        <div class="relative">
          <input type="text" placeholder="Cari program kejuruan..." class="bg-white border border-slate-200 text-slate-700 text-xs rounded-lg pl-8 pr-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-emerald-700 w-48 sm:w-60 shadow-sm" />
          <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 uppercase tracking-wider text-[11px]">
            <th class="px-5 py-3.5 font-semibold">ID / Kode</th>
            <th class="px-5 py-3.5 font-semibold">Program Kejuruan</th>
            <th class="px-5 py-3.5 font-semibold">Alokasi Kuota</th>
            <th class="px-5 py-3.5 font-semibold">Durasi Belajar</th>
            <th class="px-5 py-3.5 font-semibold">Penanggung Jawab</th>
            <th class="px-5 py-3.5 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($pelatihans as $pelatihan)
            <tr class="hover:bg-slate-50/80 transition group">
              <td class="px-5 py-4 font-mono font-bold text-slate-500">
                #PLT-{{ str_pad((string)$pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
              </td>

              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs shrink-0">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                  </div>
                  <div>
                    <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}" class="font-bold text-slate-900 group-hover:text-emerald-700 transition">
                      {{ $pelatihan->nama_pelatihan }}
                    </a>
                    <div class="text-[11px] text-slate-400 line-clamp-1 max-w-xs">
                      {{ $pelatihan->deskripsi_pelatihan ?? 'Tidak ada deskripsi kurikulum.' }}
                    </div>
                  </div>
                </div>
              </td>

              <td class="px-5 py-4">
                <div class="flex items-center gap-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                    {{ $pelatihan->kuota }} Kursi
                  </span>
                </div>
              </td>

              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-1.5 text-slate-700 font-medium">
                  <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                  {{ $pelatihan->durasi_lp ?? '240 JP' }}
                </span>
              </td>

              <td class="px-5 py-4 text-slate-600 font-medium">
                {{ $pelatihan->admin->user->name ?? 'Admin BLK Pusat' }}
              </td>

              <td class="px-5 py-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-slate-100 rounded-lg transition" title="Lihat Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition" title="Edit Program">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program pelatihan ini?')">
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
              <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                  <i data-lucide="book-open" class="w-6 h-6"></i>
                </div>
                <div class="font-bold text-slate-700 text-sm">Belum Ada Program Pelatihan</div>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Tambahkan kurikulum kejuruan vokasi untuk memulai membuka pendaftaran kelas pelatihan kerja.</p>
                <a href="{{ route('pelatihan.create') }}" class="inline-flex items-center gap-1.5 mt-3 bg-emerald-900 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm">
                  <i data-lucide="plus" class="w-3.5 h-3.5"></i> Buat Program
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($pelatihans->hasPages())
      <div class="p-4 border-t border-slate-100">
        {{ $pelatihans->links() }}
      </div>
    @endif
  </div>
@endsection
