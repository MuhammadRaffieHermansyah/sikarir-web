@extends('layouts.app')

@section('title', 'Detail Profil Peserta Vokasi - ' . ($peserta->user->name ?? 'Peserta'))

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pesertas.index') }}" class="hover:text-emerald-700 transition">Peserta Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Peserta</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Profil Lengkap Siswa Vokasi</h1>
      <p class="text-xs text-slate-500 mt-0.5">Rincian biodata kependudukan, kejuruan yang diikuti, riwayat presensi, dan sertifikat kompetensi.</p>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
      <a href="{{ route('pesertas.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
      <a href="{{ route('pesertas.edit', $peserta->id_peserta) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Biodata
      </a>
    </div>
  </div>

  <!-- Hero Profile Banner Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-emerald-50/50 to-transparent pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-black text-2xl flex items-center justify-center shadow-md shrink-0">
          {{ strtoupper(substr($peserta->user->name ?? 'P', 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-extrabold text-slate-900">{{ $peserta->user->name ?? 'Peserta Tanpa Nama' }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
              NIS: {{ $peserta->nomor_peserta ?? '-' }}
            </span>
            <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">
              {{ $peserta->jurusan ?? 'Kejuruan Vokasi' }}
            </span>
          </div>
          <div class="flex items-center gap-4 text-xs text-slate-500 mt-1.5 flex-wrap">
            <span class="flex items-center gap-1.5"><i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i> {{ $peserta->user->email ?? '-' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i> {{ $peserta->nomor_wa ?? '-' }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i> {{ $peserta->jenis_kelamin ?? '-' }}</span>
          </div>
        </div>
      </div>

      <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Pelajar</div>
        <div class="text-xs font-bold text-emerald-700 flex items-center gap-1.5 mt-0.5 justify-end">
          <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
          Siswa Aktif Pelatihan
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="book-open" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Kelas Diikuti</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($peserta->kelas ?? []) }} Kelas</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
        <i data-lucide="check-circle-2" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Presensi</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($peserta->absensi ?? []) }} Kehadiran</div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Sertifikat Kelulusan</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($peserta->sertifikat ?? []) }} Diterbitkan</div>
      </div>
    </div>
  </div>

  <!-- Detail Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left 2 Cols: Biodata Kependudukan & Kelas -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Card: Biodata Kependudukan -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="id-card" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Biodata & Administrasi</h3>
              <p class="text-xs text-slate-500">Informasi identitas kependudukan dan latar belakang pendidikan.</p>
            </div>
          </div>
          <a href="{{ route('pesertas.edit', $peserta->id_peserta) }}" class="text-xs font-semibold text-emerald-700 hover:underline flex items-center gap-1">
            <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit
          </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-xs">
          <div>
            <span class="text-slate-400 font-medium block mb-1">Nomor Induk Siswa (NIS)</span>
            <span class="text-slate-800 font-bold text-sm font-mono">{{ $peserta->nomor_peserta }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Nomor Kartu Keluarga (KK)</span>
            <span class="text-slate-800 font-semibold font-mono">{{ $peserta->nomor_kk ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Tempat, Tanggal Lahir</span>
            <span class="text-slate-800 font-semibold">
              {{ $peserta->tempat_lahir ?? '-' }}, {{ $peserta->tanggal_lahir ? $peserta->tanggal_lahir->translatedFormat('d F Y') : '-' }}
            </span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Pendidikan Terakhir</span>
            <span class="text-slate-800 font-semibold">{{ $peserta->pendidikan_terakhir ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Pilihan Program Kejuruan</span>
            <span class="text-slate-800 font-semibold text-emerald-800">{{ $peserta->jurusan ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Petugas Pendaftar (Admin)</span>
            <span class="text-slate-800 font-semibold">{{ $peserta->admin->user->name ?? 'System Default' }}</span>
          </div>

          <div class="sm:col-span-2">
            <span class="text-slate-400 font-medium block mb-1">Alamat Lengkap Domisili</span>
            <span class="text-slate-800 leading-relaxed font-medium">{{ $peserta->alamat_lengkap ?? '-' }}</span>
          </div>
        </div>
      </div>

      <!-- Card: Riwayat Kelas Pelatihan -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="graduation-cap" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Program Pelatihan Yang Diikuti</h3>
              <p class="text-xs text-slate-500">Daftar kelas vokasi dan modul kompetensi aktif.</p>
            </div>
          </div>
          <a href="{{ route('kelas-pelatihan.create') }}" class="text-xs text-emerald-700 font-semibold hover:underline flex items-center gap-1">
            <i data-lucide="plus" class="w-3.5 h-3.5"></i> Masukkan ke Kelas
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 text-[11px] uppercase">
                <th class="px-5 py-3 font-semibold">Nama Program</th>
                <th class="px-5 py-3 font-semibold">Instruktur</th>
                <th class="px-5 py-3 font-semibold">Ruangan / Jadwal</th>
                <th class="px-5 py-3 font-semibold">Status</th>
                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($peserta->kelas ?? [] as $kelas)
                <tr class="hover:bg-slate-50/80">
                  <td class="px-5 py-3 font-bold text-slate-800">{{ $kelas->jadwal->pelatihan->nama_pelatihan ?? '-' }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $kelas->jadwal->instruktur ?? '-' }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $kelas->jadwal->ruangan ?? '-' }} ({{ $kelas->jadwal->hari ?? '-' }})</td>
                  <td class="px-5 py-3">
                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full capitalize">
                      {{ $kelas->status_kelulusan ?? 'Mengikuti' }}
                    </span>
                  </td>
                  <td class="px-5 py-3 text-right">
                    <a href="{{ route('kelas-pelatihan.show', $kelas->id_kelas) }}" class="text-emerald-700 hover:underline font-semibold">Detail</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada kelas pelatihan yang didaftarkan untuk siswa ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right 1 Col: Kontak Cepat & Tindakan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Kontak Peserta</h4>
        <div class="space-y-3 text-xs">
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="phone-call" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $peserta->nomor_wa ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="mail" class="w-4 h-4 text-emerald-600"></i>
            <span>{{ $peserta->user->email ?? '-' }}</span>
          </div>
          <div class="flex items-center gap-2 text-slate-700">
            <i data-lucide="calendar" class="w-4 h-4 text-emerald-600"></i>
            <span>Terdaftar: {{ $peserta->created_at ? $peserta->created_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Aksi Administratif</h4>
        <div class="space-y-2">
          <a href="{{ route('pesertas.edit', $peserta->id_peserta) }}" class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Biodata Peserta
          </a>
          <form action="{{ route('pesertas.destroy', $peserta->id_peserta) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peserta ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i> Hapus Peserta
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
