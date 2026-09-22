@extends('layouts.app')

@section('title', 'Pendaftaran Peserta Vokasi Baru - BLK CONNECT')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pesertas.index') }}" class="hover:text-emerald-700 transition">Peserta</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Registrasi Baru</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Formulir Pendaftaran Peserta Vokasi</h1>
      <p class="text-xs text-slate-500 mt-0.5">Input data induk siswa pelatihan vokasi untuk penugasan kelas kejuruan dan magang industri.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('pesertas.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
      </a>
    </div>
  </div>

  <!-- Form Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Form) -->
    <div class="lg:col-span-2 space-y-6">
      <form method="POST" action="{{ route('pesertas.store') }}" class="space-y-6">
        @csrf

        @if($errors->any())
          <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
            <div class="font-bold">Mohon perbaiki kesalahan berikut:</div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
              @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
          </div>
        @endif

        <!-- Card 1: Akun Pengguna & Identitas Siswa -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="user-check" class="w-4 h-4"></i>
            </div>
            <div>
              <h2 class="font-bold text-slate-800 text-sm">Akun Pengguna & Nomor Induk</h2>
              <p class="text-xs text-slate-500">Tautkan akun sistem dan tentukan Nomor Induk Siswa (NIS).</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Akun Pengguna <span class="text-rose-500">*</span></label>
              <select name="id_user" required class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="">-- Pilih Akun Pengguna Terdaftar --</option>
                @foreach($users ?? [] as $user)
                  <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </select>
              @error('id_user')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Induk Siswa / NIS <span class="text-rose-500">*</span></label>
              <input type="text" name="nomor_peserta" value="{{ old('nomor_peserta', '2025-VOK-' . rand(100, 999)) }}" required placeholder="Contoh: 2025-VOK-001" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nomor_peserta')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
              <select name="jenis_kelamin" required class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('jenis_kelamin')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jurusan / Kejuruan Pelatihan</label>
              <input type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: Teknik Informatika / Mekatronika" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('jurusan')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp / HP</label>
              <input type="text" name="nomor_wa" value="{{ old('nomor_wa') }}" placeholder="08xxxxxxxxxx" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nomor_wa')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        <!-- Card 2: Biodata & Pendidikan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="id-card" class="w-4 h-4"></i>
            </div>
            <div>
              <h2 class="font-bold text-slate-800 text-sm">Data Pribadi & Riwayat Pendidikan</h2>
              <p class="text-xs text-slate-500">Kelengkapan berkas kependudukan dan latar belakang edukasi.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Kartu Keluarga (KK)</label>
              <input type="text" name="nomor_kk" value="{{ old('nomor_kk') }}" placeholder="16 digit nomor KK" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nomor_kk')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pendidikan Terakhir</label>
              <select name="pendidikan_terakhir" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="SMK / SMA" selected>SMK / SMA Sederajat</option>
                <option value="Diploma (D3/D4)">Diploma (D3/D4)</option>
                <option value="Sarjana (S1)">Sarjana (S1)</option>
                <option value="SMP Sederajat">SMP Sederajat</option>
              </select>
              @error('pendidikan_terakhir')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('tempat_lahir')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('tanggal_lahir')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap Domisili</label>
              <textarea name="alamat_lengkap" rows="3" placeholder="Alamat lengkap sesuai KTP / Domisili..." class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ old('alamat_lengkap') }}</textarea>
              @error('alamat_lengkap')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="{{ route('pesertas.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition shadow-sm">
            Batalkan
          </a>
          <button type="submit" class="px-6 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center gap-2 transition">
            <i data-lucide="save" class="w-4 h-4"></i>
            <span>Simpan Data Peserta</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Right Column (Sidebar guidance) -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-xs pb-3 border-b border-slate-100">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          <span>Panduan Registrasi Siswa</span>
        </div>
        <ul class="text-xs text-slate-600 space-y-3">
          <li class="flex items-start gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <span>Nomor Induk Siswa (NIS) menjadi acuan dalam penerbitan e-sertifikat kelulusan.</span>
          </li>
          <li class="flex items-start gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <span>Pastikan nomor WhatsApp aktif untuk notifikasi jadwal kelas dan seleksi magang.</span>
          </li>
          <li class="flex items-start gap-2">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
            <span>Setelah data tersimpan, peserta dapat di-plot ke dalam jadwal kelas pelatihan aktif.</span>
          </li>
        </ul>
      </div>

      <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-xl p-5 shadow-sm space-y-3">
        <div class="flex items-center gap-2 text-emerald-400 font-bold text-xs">
          <i data-lucide="award" class="w-4 h-4"></i>
          <span>Vokasi Siap Kerja</span>
        </div>
        <p class="text-[11px] text-slate-300 leading-relaxed">
          Sistem mencatat rekam jejak pelatihan, absensi kehadiran harian, dan logbook magang industri secara transparan.
        </p>
      </div>
    </div>
  </div>
@endsection

