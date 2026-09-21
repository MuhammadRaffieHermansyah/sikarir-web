@extends('layouts.app')

@section('title', 'Detail Profil Administrator BLK - ' . ($admin->user->name ?? 'Admin'))

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Admin BLK</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Detail Profil</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Detail Profil Administrator BLK</h1>
      <p class="text-xs text-slate-500 mt-0.5">Informasi lengkap data personel, hak akses kewenangan sistem, dan riwayat kegiatan operasional.</p>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
      <a href="{{ route('admin-blk.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
      <a href="{{ route('admin-blk.edit', $admin->id_admin) }}" class="bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Profil
      </a>
    </div>
  </div>

  <!-- Hero Profile Banner Card -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-emerald-50/50 to-transparent pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-700 to-teal-950 text-white font-black text-2xl flex items-center justify-center shadow-md shrink-0">
          {{ strtoupper(substr($admin->user->name ?? 'A', 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-extrabold text-slate-900">{{ $admin->user->name ?? 'Tanpa Nama' }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
              ID: #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}
            </span>
            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-semibold px-2.5 py-0.5 rounded-full flex items-center gap-1">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Super Administrator Balai
            </span>
          </div>
          <div class="flex items-center gap-4 text-xs text-slate-500 mt-1.5 flex-wrap">
            <span class="flex items-center gap-1.5">
              <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
              {{ $admin->user->email ?? '-' }}
            </span>
            <span class="flex items-center gap-1.5">
              <i data-lucide="building-2" class="w-3.5 h-3.5 text-slate-400"></i>
              BLK Pusat Vokasi & Pelatihan Kerja
            </span>
            <span class="flex items-center gap-1.5">
              <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
              Bergabung sejak {{ $admin->created_at ? $admin->created_at->translatedFormat('d F Y') : '-' }}
            </span>
          </div>
        </div>
      </div>

      <div class="flex items-center gap-2 self-start sm:self-center">
        <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
          <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Akun</div>
          <div class="text-xs font-bold text-emerald-700 flex items-center gap-1.5 mt-0.5 justify-end">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Aktif & Terverifikasi
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat 1 -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
        <i data-lucide="book-open" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Program Pelatihan</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($admin->pelatihan ?? []) }} Program</div>
      </div>
    </div>

    <!-- Stat 2 -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
        <i data-lucide="briefcase" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Lowongan Magang</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($admin->lowongan ?? []) }} Lowongan</div>
      </div>
    </div>

    <!-- Stat 3 -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
        <i data-lucide="users" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Peserta Dibina</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($admin->peserta ?? []) }} Peserta</div>
      </div>
    </div>

    <!-- Stat 4 -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
        <i data-lucide="award" class="w-5 h-5"></i>
      </div>
      <div>
        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Sertifikat Validasi</div>
        <div class="text-lg font-black text-slate-900 mt-0.5">{{ count($admin->sertifikat ?? []) }} Diterbitkan</div>
      </div>
    </div>
  </div>

  <!-- Detail Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left 2 Cols: Account Info & Program List -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Card: Informasi Rinci Kepegawaian -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="id-card" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Informasi Data Administrator</h3>
              <p class="text-xs text-slate-500">Rincian identitas akun dan penugasan balai kerja.</p>
            </div>
          </div>
          <a href="{{ route('admin-blk.edit', $admin->id_admin) }}" class="text-xs font-semibold text-emerald-700 hover:underline flex items-center gap-1">
            <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit
          </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-xs">
          <div>
            <span class="text-slate-400 font-medium block mb-1">Nama Lengkap</span>
            <span class="text-slate-800 font-bold text-sm">{{ $admin->user->name ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Alamat Email</span>
            <span class="text-slate-800 font-semibold">{{ $admin->user->email ?? '-' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">ID Administrator BLK</span>
            <span class="font-mono text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded w-fit inline-block">
              #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}
            </span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Role Akun Sistem</span>
            <span class="text-slate-700 font-semibold capitalize">{{ $admin->user->role ?? 'admin_blk' }}</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Unit Balai Kerja</span>
            <span class="text-slate-800 font-semibold">BLK Pusat Vokasi</span>
          </div>

          <div>
            <span class="text-slate-400 font-medium block mb-1">Waktu Pendaftaran</span>
            <span class="text-slate-700 font-semibold">{{ $admin->created_at ? $admin->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
          </div>
        </div>
      </div>

      <!-- Card: Program Pelatihan Terkait -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="layers" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Program Pelatihan Dikelola</h3>
              <p class="text-xs text-slate-500">Program kejuruan yang berada di bawah wewenang administrator ini.</p>
            </div>
          </div>
          <a href="{{ route('pelatihan.index') }}" class="text-xs text-emerald-700 font-semibold hover:underline">
            Semua Program &rarr;
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="bg-slate-50 text-slate-400 border-b border-slate-100 text-[11px] uppercase">
                <th class="px-5 py-3 font-semibold">Nama Program</th>
                <th class="px-5 py-3 font-semibold">Durasi</th>
                <th class="px-5 py-3 font-semibold">Kuota Peserta</th>
                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($admin->pelatihan ?? [] as $pelatihan)
                <tr class="hover:bg-slate-50/80">
                  <td class="px-5 py-3 font-bold text-slate-800">{{ $pelatihan->nama_pelatihan }}</td>
                  <td class="px-5 py-3 text-slate-600">{{ $pelatihan->durasi_lp ?? '-' }}</td>
                  <td class="px-5 py-3 font-semibold text-emerald-700">{{ $pelatihan->kuota }} Kuota</td>
                  <td class="px-5 py-3 text-right">
                    <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}" class="text-emerald-700 hover:underline font-semibold">Detail</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-5 py-6 text-center text-slate-400">Belum ada program pelatihan yang ditautkan ke administrator ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right 1 Col: Otoritas & Tindakan -->
    <div class="space-y-6">
      <!-- Hak Otoritas Sistem -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-xs pb-3 border-b border-slate-100">
          <i data-lucide="shield-alert" class="w-4 h-4 text-emerald-700"></i>
          <span>Otoritas Operasional Balai</span>
        </div>

        <div class="space-y-3 text-xs">
          <div class="flex items-start gap-2.5">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <div>
              <div class="font-bold text-slate-800">Verifikasi Jurnal Harian</div>
              <p class="text-[11px] text-slate-500">Mengesahkan catatan kegiatan & presensi magang.</p>
            </div>
          </div>

          <div class="flex items-start gap-2.5">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <div>
              <div class="font-bold text-slate-800">Penerbitan Sertifikat Resmi</div>
              <p class="text-[11px] text-slate-500">Menandatangani & menerbitkan e-sertifikat kompetensi.</p>
            </div>
          </div>

          <div class="flex items-start gap-2.5">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <div>
              <div class="font-bold text-slate-800">Manajemen Mitra Industri</div>
              <p class="text-[11px] text-slate-500">Menyetujui pendaftaran dan kuota lowongan DU/DI.</p>
            </div>
          </div>

          <div class="flex items-start gap-2.5">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <div>
              <div class="font-bold text-slate-800">Manajemen Kurikulum & Kelas</div>
              <p class="text-[11px] text-slate-500">Menyusun jadwal dan instruktur pelatihan vokasi.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tindakan Akun -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100">Tindakan Cepat</h4>
        <div class="space-y-2">
          <a href="{{ route('admin-blk.edit', $admin->id_admin) }}" class="w-full px-3.5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Data Administrator
          </a>
          <form action="{{ route('admin-blk.destroy', $admin->id_admin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data administrator ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition">
              <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i> Hapus Administrator
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

