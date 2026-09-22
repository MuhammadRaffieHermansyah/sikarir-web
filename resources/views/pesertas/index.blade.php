@extends('layouts.app')

@section('title', 'Data Peserta Vokasi & Magang - BLK CONNECT')

@section('content')
  <!-- Title & Action Bar -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Peserta Magang & Vokasi</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Data Peserta Pelatihan & Magang Industri</h1>
      <p class="text-xs text-slate-500 mt-0.5">Monitoring data induk peserta vokasi, status keikutsertaan kelas, presensi, dan capaian sertifikasi.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('pesertas.create') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="user-plus" class="w-4 h-4"></i> Registrasi Peserta Baru
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
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="users" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Peserta Terdaftar</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ isset($pesertas) ? $pesertas->total() : 0 }} Peserta</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Program Vokasi</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">Multi-Kejuruan</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Status Kompetensi</div>
        <div class="text-lg font-black text-emerald-700 mt-0.5">Terstandarisasi BNSP</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <span>Daftar Peserta Pelatihan & Magang</span>
          <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
            {{ isset($pesertas) ? $pesertas->total() : 0 }} Peserta
          </span>
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Daftar lengkap peserta vokasi yang terdaftar pada sistem SIMAGANG BLK.</p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('pesertas.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm transition">
          <i data-lucide="plus" class="w-3.5 h-3.5"></i>
          <span>Tambah Peserta</span>
        </a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead>
          <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
            <th class="px-5 py-3 font-semibold">Peserta</th>
            <th class="px-5 py-3 font-semibold">Nomor Peserta (NIS)</th>
            <th class="px-5 py-3 font-semibold">Kejuruan / Jurusan</th>
            <th class="px-5 py-3 font-semibold">Kontak WhatsApp</th>
            <th class="px-5 py-3 font-semibold">Pendidikan</th>
            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          @forelse($pesertas ?? [] as $peserta)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="px-5 py-3.5">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-bold flex items-center justify-center text-xs shadow-sm shrink-0">
                    {{ strtoupper(substr($peserta->user->name ?? 'P', 0, 2)) }}
                  </div>
                  <div>
                    <a href="{{ route('pesertas.show', $peserta->id_peserta) }}" class="font-bold text-slate-900 hover:text-emerald-700 transition">
                      {{ $peserta->user->name ?? 'Tanpa Nama' }}
                    </a>
                    <div class="text-[10px] text-slate-400">
                      {{ $peserta->jenis_kelamin ?? '-' }} • {{ $peserta->user->email ?? '-' }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <span class="font-mono font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded text-[11px]">
                  {{ $peserta->nomor_peserta }}
                </span>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-semibold text-slate-800">{{ $peserta->jurusan ?? 'Pelatihan Umum' }}</div>
                <div class="text-[10px] text-slate-400">{{ count($peserta->kelas ?? []) }} Kelas Diikuti</div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800 flex items-center gap-1">
                  <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                  <span>{{ $peserta->nomor_wa ?? '-' }}</span>
                </div>
              </td>
              <td class="px-5 py-3.5">
                <div class="font-medium text-slate-800">{{ $peserta->pendidikan_terakhir ?? '-' }}</div>
                <div class="text-[10px] text-slate-400">{{ $peserta->tempat_lahir ? $peserta->tempat_lahir . ', ' : '' }}{{ $peserta->tanggal_lahir ? $peserta->tanggal_lahir->translatedFormat('d/m/Y') : '' }}</div>
              </td>
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('pesertas.show', $peserta->id_peserta) }}" class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('pesertas.edit', $peserta->id_peserta) }}" class="p-1.5 text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Edit">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('pesertas.destroy', $peserta->id_peserta) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')">
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
                    <i data-lucide="users" class="w-6 h-6"></i>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Belum ada data Peserta terdaftar</p>
                  <a href="{{ route('pesertas.create') }}" class="text-xs text-emerald-700 hover:underline font-semibold flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Daftarkan Peserta Pertama
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($pesertas) && $pesertas->hasPages())
      <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
        {{ $pesertas->links() }}
      </div>
    @endif
  </div>
@endsection

