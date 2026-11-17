@extends('layouts.app')

@section('title', 'Program Pelatihan - BLK CONNECT')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Program Pelatihan</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Katalog Program Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Kelola kurikulum kejuruan, kuota siswa, durasi jam pelatihan, dan alokasi instruktur vokasi terstandarisasi.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('jadwal-pelatihan.index') }}" class="bg-white hover:bg-slate-50 text-slate-700 hover:text-emerald-800 border border-slate-200 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="calendar" class="w-4 h-4 text-emerald-600"></i> Jadwal Kelas
      </a>
      <a href="{{ route('pelatihan.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Program Baru
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

  <!-- Top Metrics -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="book-open" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Kejuruan Aktif</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ $pelatihans->total() }} Program</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
        <i data-lucide="users" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Kapasitas Siswa</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ $pelatihans->sum('kuota') }} Kursi</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
        <i data-lucide="clock" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Standar Jam</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">240 - 320 JP</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Sertifikasi</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">BNSP &amp; SKKNI</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
      <div>
        <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <span>Daftar Kejuruan &amp; Kurikulum Pelatihan</span>
          <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
            {{ $pelatihans->total() }} Data
          </span>
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Menampilkan seluruh program kejuruan aktif berbasis kompetensi kerja Disnakertrans.</p>
      </div>

      <!-- FORM PENCARIAN (Component) -->
      <x-search-filter
        :action="route('pelatihan.index')"
        search-placeholder="Cari program kejuruan..."
      />
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
            <th class="px-5 py-3 font-semibold">Kode</th>
            <th class="px-5 py-3 font-semibold">Program Kejuruan</th>
            <th class="px-5 py-3 font-semibold">Alokasi Kuota</th>
            <th class="px-5 py-3 font-semibold">Durasi Belajar</th>
            <th class="px-5 py-3 font-semibold">Penanggung Jawab</th>
            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($pelatihans as $pelatihan)
            <tr class="hover:bg-slate-50/80 transition">
              <!-- Kode -->
              <td class="px-5 py-3.5 font-mono text-[11px] text-slate-400">
                #PLT-{{ str_pad((string) $pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
              </td>

              <!-- Program Kejuruan -->
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-3 min-w-[240px]">
                  @if ($pelatihan->gambar_url)
                    <img src="{{ $pelatihan->gambar_url }}" alt="{{ $pelatihan->nama_pelatihan }}"
                      class="w-9 h-9 rounded-xl object-cover shadow-sm shrink-0">
                  @else
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-800 to-emerald-900 text-white flex items-center justify-center shadow-sm shrink-0">
                      <i data-lucide="book-open" class="w-4 h-4"></i>
                    </div>
                  @endif
                  <div class="min-w-0">
                    <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}"
                      class="font-bold text-slate-900 hover:text-emerald-700 transition line-clamp-1">
                      {{ $pelatihan->nama_pelatihan }}
                    </a>
                    <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5 max-w-sm">
                      {{ $pelatihan->deskripsi_pelatihan ?? 'Belum ada deskripsi kurikulum terlampir.' }}
                    </p>
                  </div>
                </div>
              </td>

              <!-- Alokasi Kuota -->
              <td class="px-5 py-3.5">
                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded text-[11px]">
                  <i data-lucide="users" class="w-3 h-3"></i> {{ $pelatihan->kuota }} Kursi
                </span>
              </td>

              <!-- Durasi Belajar -->
              <td class="px-5 py-3.5">
                <span class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 font-semibold px-2 py-0.5 rounded text-[11px]">
                  <i data-lucide="clock" class="w-3 h-3"></i> {{ $pelatihan->durasi_label ?? '-' }}
                </span>
              </td>

              <!-- Penanggung Jawab -->
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-2">
                  <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] flex items-center justify-center shrink-0">
                    {{ strtoupper(substr($pelatihan->admin->user->name ?? 'A', 0, 1)) }}
                  </div>
                  <span class="text-slate-700 font-medium truncate max-w-[150px]">
                    {{ $pelatihan->admin->user->name ?? 'Admin BLK' }}
                  </span>
                </div>
              </td>

              <!-- Aksi -->
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}"
                    class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}"
                    class="p-1.5 text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Edit">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}" method="POST" class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kejuruan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus">
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
                    <i data-lucide="book-open" class="w-6 h-6"></i>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Belum ada program kejuruan yang ditemukan</p>
                  @if(request('search'))
                    <a href="{{ route('pelatihan.index') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                      <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter Pencarian
                    </a>
                  @else
                    <a href="{{ route('pelatihan.create') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                      <i data-lucide="plus" class="w-3.5 h-3.5"></i> Buat Program Pertama
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($pelatihans->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        {{ $pelatihans->withQueryString()->links('components.pagination') }}
      </div>
    @endif
  </div>
@endsection
