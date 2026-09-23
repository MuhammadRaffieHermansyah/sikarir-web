@extends('layouts.app')

@section('title', 'Tambah Mitra Industri DU/DI - BLK CONNECT')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('mitras.index') }}" class="hover:text-emerald-700 transition">Mitra DU/DI</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Tambah Mitra Baru</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Registrasi Kemitraan Industri (DU/DI)</h1>
      <p class="text-xs text-slate-500 mt-0.5">Daftarkan perusahaan rekanan untuk penempatan magang vokasi dan rekrutmen lulusan balai.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('mitras.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
      </a>
    </div>
  </div>

  <!-- Form Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Form) -->
    <div class="lg:col-span-2 space-y-6">
      <form method="POST" action="{{ route('mitras.store') }}" class="space-y-6">
        @csrf

        @if($errors->any())
          <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
            <div class="font-bold">Mohon perbaiki kesalahan berikut:</div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
              @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
          </div>
        @endif

        <!-- Card 1: Data Identitas Perusahaan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="building-2" class="w-4 h-4"></i>
            </div>
            <div>
              <h2 class="font-bold text-slate-800 text-sm">Identitas Perusahaan / Industri</h2>
              <p class="text-xs text-slate-500">Informasi resmi badan usaha atau instansi rekanan.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Perusahaan / PT / CV <span class="text-rose-500">*</span></label>
              <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}"  placeholder="Contoh: PT Astra Honda Motor" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nama_perusahaan')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Bidang Usaha / Sektor</label>
              <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha') }}" placeholder="Contoh: Otomotif & Manufaktur" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('bidang_usaha')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kemitraan</label>
              <select name="jenis_mitra" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="BUMN / BUMD">BUMN / BUMD</option>
                <option value="Perusahaan Swasta Nasional" selected>Perusahaan Swasta Nasional</option>
                <option value="PMA / Multinasional">PMA / Multinasional</option>
                <option value="Instansi Pemerintah / Lembaga">Instansi Pemerintah / Lembaga</option>
                <option value="UMKM / Startup">UMKM / Startup</option>
              </select>
              @error('jenis_mitra')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Izin Usaha / NIB</label>
              <input type="text" name="no_izin" value="{{ old('no_izin') }}" placeholder="Nomor NIB / Legalitas" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('no_izin')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tautkan Akun User (Opsional)</label>
              <select name="id_user" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="">-- Tanpa Akun Pengguna Khusus --</option>
                @foreach($users ?? [] as $user)
                  <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
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
              <h2 class="font-bold text-slate-800 text-sm">Lokasi & Penanggung Jawab (PIC)</h2>
              <p class="text-xs text-slate-500">Alamat operasional kantor dan kontak representatif HRD / Pembimbing Industri.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kota / Kabupaten</label>
              <input type="text" name="kota" value="{{ old('kota') }}" placeholder="Contoh: Jakarta Pusat" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('kota')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Provinsi</label>
              <input type="text" name="provinsi" value="{{ old('provinsi') }}" placeholder="Contoh: DKI Jakarta" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('provinsi')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp Kantor</label>
              <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="Contoh: 021-5551234 atau 08123456789" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('no_telp')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jabatan PIC / HRD</label>
              <input type="text" name="jabatan_pic" value="{{ old('jabatan_pic') }}" placeholder="Contoh: HR & People Development Head" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('jabatan_pic')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap Perusahaan</label>
              <textarea name="alamat" rows="3" placeholder="Jl. Jendral Sudirman Kav. XX, Gedung..." class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ old('alamat') }}</textarea>
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
            <i data-lucide="save" class="w-4 h-4"></i>
            <span>Simpan Data Mitra</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Side Guidance (Right Column) -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-xs pb-3 border-b border-slate-100">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          <span>Ketentuan Kemitraan DU/DI</span>
        </div>
        <ul class="text-xs text-slate-600 space-y-3">
          <li class="flex items-start gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <span>Mitra yang terdaftar berhak mempublikasikan lowongan magang industri di portal.</span>
          </li>
          <li class="flex items-start gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <span>Peserta pelatihan vokasi dapat ditempatkan sesuai kesesuaian kurikulum kejuruan.</span>
          </li>
          <li class="flex items-start gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <span>Evaluasi dan monitoring jurnal harian terintegrasi dengan pembimbing industri.</span>
          </li>
        </ul>
      </div>

      <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-xl p-5 shadow-sm space-y-3">
        <div class="flex items-center gap-2 text-emerald-400 font-bold text-xs">
          <i data-lucide="handshake" class="w-4 h-4"></i>
          <span>Link and Match Vokasi</span>
        </div>
        <p class="text-[11px] text-slate-300 leading-relaxed">
          Kerjasama industri menjamin kompetensi lulusan BLK sesuai kebutuhan riil pasar kerja nasional dan global.
        </p>
      </div>
    </div>
  </div>
@endsection

