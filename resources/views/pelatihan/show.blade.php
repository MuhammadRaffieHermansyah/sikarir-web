@extends('layouts.app')

@section('title', 'Detail Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-3 sm:pt-5 pb-1">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pelatihan.index') }}" class="hover:text-emerald-700 transition">Program Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Program</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">{{ $pelatihan->nama_pelatihan }}</h1>
      <p class="text-xs text-slate-500 mt-0.5">Spesifikasi kompetensi vokasi, silabus pembelajaran, kapasitas kuota, dan jadwal batch pelaksanaan kelas.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
      </a>
      <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Kurikulum
      </a>
    </div>
  </div>

  <!-- Poster Program -->
  @if ($pelatihan->gambar_url)
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <img src="{{ $pelatihan->gambar_url }}" alt="Poster {{ $pelatihan->nama_pelatihan }}"
        class="w-full max-h-72 object-cover">
    </div>
  @endif

  <!-- Top Metrics -->
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
        <i data-lucide="users" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Kapasitas / Angkatan</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ $pelatihan->kuota }} Peserta</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Standar Sertifikasi</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">BNSP &amp; SKKNI</div>
      </div>
    </div>
  </div>

  <!-- Main Detail Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <!-- Left 2 Cols -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Silabus -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <i data-lucide="file-text" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Deskripsi Silabus &amp; Output Kejuruan</h2>
        </div>

        <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-lg border border-slate-100">{{ $pelatihan->deskripsi_pelatihan ?: 'Belum ada silabus / deskripsi pelatihan yang ditambahkan untuk kejuruan ini.' }}</div>
      </div>

      <!-- Jadwal -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
              <span>Batch &amp; Jadwal Kelas</span>
              <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
                {{ count($pelatihan->jadwal ?? []) }} Batch
              </span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Jadwal yang dibuka untuk program kejuruan ini.</p>
          </div>

          <a href="{{ route('jadwal-pelatihan.create') }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-lg transition">
            <i data-lucide="plus" class="w-4 h-4 text-emerald-700"></i> Buka Batch Baru
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 text-[11px] uppercase tracking-wider">
                <th class="px-5 py-3 font-semibold">Instruktur</th>
                <th class="px-5 py-3 font-semibold">Ruangan</th>
                <th class="px-5 py-3 font-semibold">Hari &amp; Jam</th>
                <th class="px-5 py-3 font-semibold">Peserta</th>
                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($pelatihan->jadwal ?? [] as $jadwal)
                @php
                  // instruktur & ruangan bisa berupa relasi (object) atau kolom teks biasa
                  $instruktur = $jadwal->instruktur;
                  $namaInstruktur = is_object($instruktur) ? ($instruktur->nama ?? '-') : ($instruktur ?: '-');

                  $ruangan = $jadwal->ruangan;
                  $namaRuangan = is_object($ruangan)
                      ? ($ruangan->nama_ruangan ?? $ruangan->nama ?? '-')
                      : ($ruangan ?: '-');
                @endphp
                <tr class="hover:bg-slate-50/80 transition">
                  <td class="px-5 py-3.5">
                    <div class="flex items-center gap-2.5">
                      <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($namaInstruktur, 0, 1)) }}
                      </div>
                      <div class="min-w-0">
                        <div class="font-bold text-slate-900">{{ $namaInstruktur }}</div>
                        @if (is_object($instruktur) && !empty($instruktur->bidang_keahlian))
                          <div class="text-[11px] text-slate-400">{{ $instruktur->bidang_keahlian }}</div>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-3.5 text-slate-600 font-medium">{{ $namaRuangan }}</td>
                  <td class="px-5 py-3.5 text-slate-600 font-medium">
                    {{ $jadwal->hari ?? '-' }} <span class="text-slate-400">({{ $jadwal->jam ?? '-' }})</span>
                  </td>
                  <td class="px-5 py-3.5">
                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded text-[11px] whitespace-nowrap">
                      <i data-lucide="users" class="w-3 h-3"></i> {{ count($jadwal->kelas ?? []) }} Siswa
                    </span>
                  </td>
                  <td class="px-5 py-3.5 text-right">
                    <a href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}"
                      class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-900 font-semibold hover:underline">
                      Rincian <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-5 py-10 text-center text-slate-400">
                    <div class="flex flex-col items-center justify-center gap-2">
                      <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                      </div>
                      <p class="text-xs font-medium text-slate-600">Belum ada batch jadwal kelas yang dibuat untuk program ini</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right Col -->
    <div class="space-y-6">
      <!-- Metadata -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          Metadata Pelatihan
        </h3>

        <div class="space-y-3 text-xs">
          <div class="flex items-center justify-between gap-3">
            <span class="text-slate-400">Kode:</span>
            <span class="font-mono font-bold text-slate-700">#PLT-{{ str_pad((string) $pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-slate-400">Durasi Pelatihan:</span>
            <span class="font-bold text-slate-900">{{ $pelatihan->durasi_label ?? '-' }}</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-slate-400">Target Kuota:</span>
            <span class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded text-[11px]">{{ $pelatihan->kuota }} Siswa / Batch</span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-slate-400">Terdaftar Pada:</span>
            <span class="font-bold text-slate-900">
              {{ $pelatihan->created_at ? $pelatihan->created_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
          <div class="flex items-center justify-between gap-3">
            <span class="text-slate-400">Terakhir Diperbarui:</span>
            <span class="font-bold text-slate-900">
              {{ $pelatihan->updated_at ? $pelatihan->updated_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
        </div>
      </div>

      <!-- Aksi Administratif -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="sliders" class="w-4 h-4 text-emerald-700"></i>
          Aksi Administratif
        </h3>

        <div class="space-y-2">
          <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}"
            class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Kurikulum
          </a>

          <a href="{{ route('jadwal-pelatihan.create') }}"
            class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            <i data-lucide="calendar-plus" class="w-4 h-4"></i> Buat Jadwal Baru
          </a>

          <form action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kejuruan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="w-full bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition cursor-pointer">
              <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Program
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
