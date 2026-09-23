@extends('layouts.app')

@section('title', 'Edit Mitra DU/DI - ' . $mitra->nama_perusahaan)

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('mitras.index') }}" class="hover:text-emerald-700 transition">Mitra DU/DI</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Data #MTR-{{ str_pad((string)$mitra->id_mitra, 3, '0', STR_PAD_LEFT) }}</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Edit Kemitraan DU/DI</h1>
      <p class="text-xs text-slate-500 mt-0.5">Perbarui profil perusahaan, kontak penanggung jawab industri, dan status legalitas.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('mitras.show', $mitra->id_mitra) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4 text-emerald-700"></i> Lihat Profil
      </a>
      <a href="{{ route('mitras.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </div>
  </div>

  <!-- Profile Banner Summary -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-slate-800 to-slate-950 text-white font-black text-lg flex items-center justify-center shadow-sm shrink-0">
          {{ strtoupper(substr($mitra->nama_perusahaan, 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2 flex-wrap">
            <h2 class="text-base font-bold text-slate-900">{{ $mitra->nama_perusahaan }}</h2>
            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
              ID: #MTR-{{ str_pad((string)$mitra->id_mitra, 3, '0', STR_PAD_LEFT) }}
            </span>
            <span class="bg-indigo-50 text-indigo-700 text-[10px] font-semibold px-2 py-0.5 rounded-full">
              {{ $mitra->jenis_mitra ?? 'Perusahaan Mitra' }}
            </span>
          </div>
          <div class="flex items-center gap-3 text-xs text-slate-500 mt-1 flex-wrap">
            <span class="flex items-center gap-1"><i data-lucide="briefcase" class="w-3.5 h-3.5 text-slate-400"></i> Sektor: {{ $mitra->bidang_usaha ?? 'Umum' }}</span>
            <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $mitra->kota ?? 'Kota Tidak Tercatat' }}</span>
          </div>
        </div>
      </div>

      <div class="text-xs text-slate-400 flex sm:flex-col items-end justify-between gap-1 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
        <div>Terdaftar: <span class="text-slate-700 font-medium">{{ $mitra->created_at ? $mitra->created_at->translatedFormat('d M Y') : '-' }}</span></div>
        <div>Pembaruan Terakhir: <span class="text-slate-700 font-medium">{{ $mitra->updated_at ? $mitra->updated_at->diffForHumans() : '-' }}</span></div>
      </div>
    </div>
  </div>

  <!-- Form Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Form) -->
    <div class="lg:col-span-2 space-y-6">
      <form method="POST" action="{{ route('mitras.update', $mitra->id_mitra) }}" class="space-y-6">
        @csrf
        @method('PUT')

        @if($errors->any())
          <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
            <div class="font-bold">Mohon perbaiki kesalahan berikut:</div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
              @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
          </div>
        @endif

        <!-- Card 1: Identitas Perusahaan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="building-2" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Informasi Perusahaan</h3>
              <p class="text-xs text-slate-500">Perbarui rincian resmi badan usaha.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Perusahaan <span class="text-rose-500">*</span></label>
              <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $mitra->nama_perusahaan) }}"  class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nama_perusahaan')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Bidang Usaha</label>
              <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha', $mitra->bidang_usaha) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('bidang_usaha')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kemitraan</label>
              <select name="jenis_mitra" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="BUMN / BUMD" {{ old('jenis_mitra', $mitra->jenis_mitra) == 'BUMN / BUMD' ? 'selected' : '' }}>BUMN / BUMD</option>
                <option value="Perusahaan Swasta Nasional" {{ old('jenis_mitra', $mitra->jenis_mitra) == 'Perusahaan Swasta Nasional' ? 'selected' : '' }}>Perusahaan Swasta Nasional</option>
                <option value="PMA / Multinasional" {{ old('jenis_mitra', $mitra->jenis_mitra) == 'PMA / Multinasional' ? 'selected' : '' }}>PMA / Multinasional</option>
                <option value="Instansi Pemerintah / Lembaga" {{ old('jenis_mitra', $mitra->jenis_mitra) == 'Instansi Pemerintah / Lembaga' ? 'selected' : '' }}>Instansi Pemerintah / Lembaga</option>
                <option value="UMKM / Startup" {{ old('jenis_mitra', $mitra->jenis_mitra) == 'UMKM / Startup' ? 'selected' : '' }}>UMKM / Startup</option>
              </select>
              @error('jenis_mitra')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Izin Usaha / NIB</label>
              <input type="text" name="no_izin" value="{{ old('no_izin', $mitra->no_izin) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('no_izin')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun User Terkait</label>
              <select name="id_user" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="">-- Tanpa Akun Pengguna --</option>
                @foreach($users ?? [] as $user)
                  <option value="{{ $user->id }}" {{ old('id_user', $mitra->id_user) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
              </select>
              @error('id_user')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        <!-- Card 2: Lokasi & Kontak PIC -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="map-pin" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Lokasi & Kontak Penanggung Jawab</h3>
              <p class="text-xs text-slate-500">Perbarui alamat kantor dan nomor kontak resmi.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kota / Kabupaten</label>
              <input type="text" name="kota" value="{{ old('kota', $mitra->kota) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('kota')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Provinsi</label>
              <input type="text" name="provinsi" value="{{ old('provinsi', $mitra->provinsi) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('provinsi')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp</label>
              <input type="text" name="no_telp" value="{{ old('no_telp', $mitra->no_telp ?? $mitra->telepon) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('no_telp')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jabatan PIC / HRD</label>
              <input type="text" name="jabatan_pic" value="{{ old('jabatan_pic', $mitra->jabatan_pic) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('jabatan_pic')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
              <textarea name="alamat" rows="3" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ old('alamat', $mitra->alamat) }}</textarea>
              @error('alamat')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="{{ route('mitras.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition shadow-sm">
            Batalkan
          </a>
          <button type="submit" class="px-6 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center gap-2 transition">
            <i data-lucide="check" class="w-4 h-4"></i>
            <span>Simpan Perubahan</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Right Column (Danger Zone & Summary) -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-xs pb-3 border-b border-slate-100">
          <i data-lucide="briefcase" class="w-4 h-4 text-emerald-700"></i>
          <span>Lowongan Terbuka</span>
        </div>
        <div class="text-xs text-slate-600">
          Perusahaan ini memiliki <strong class="text-slate-800">{{ count($mitra->lowongan ?? []) }} lowongan magang</strong> yang terdaftar di portal.
        </div>
      </div>

      <div class="bg-rose-50/50 border border-rose-200 rounded-xl p-5 space-y-3">
        <div class="flex items-center gap-2 text-rose-800 font-bold text-xs">
          <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
          <span>Hapus Kemitraan</span>
        </div>
        <p class="text-[11px] text-rose-700 leading-relaxed">
          Menghapus mitra ini akan mencabut seluruh data kemitraan dan lowongan yang terafiliasi dengan perusahaan ini.
        </p>
        <form action="{{ route('mitras.destroy', $mitra->id_mitra) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mitra ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full mt-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Mitra DU/DI
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection

