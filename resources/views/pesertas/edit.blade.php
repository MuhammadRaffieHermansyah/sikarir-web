@extends('layouts.app')

@section('title', 'Edit Peserta Vokasi - ' . ($peserta->user->name ?? 'Peserta'))

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pesertas.index') }}" class="hover:text-emerald-700 transition">Peserta</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Data #{{ $peserta->nomor_peserta }}</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Edit Data Peserta Vokasi</h1>
      <p class="text-xs text-slate-500 mt-0.5">Perbarui biodata siswa, kontak komunikasi, nomor kependudukan, dan riwayat pendidikan.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('pesertas.show', $peserta->id_peserta) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4 text-emerald-700"></i> Lihat Profil
      </a>
      <a href="{{ route('pesertas.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </div>
  </div>

  <!-- Profile Banner Summary -->
  <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-900 text-white font-black text-lg flex items-center justify-center shadow-sm shrink-0">
          {{ strtoupper(substr($peserta->user->name ?? 'P', 0, 2)) }}
        </div>
        <div>
          <div class="flex items-center gap-2 flex-wrap">
            <h2 class="text-base font-bold text-slate-900">{{ $peserta->user->name ?? 'Tanpa Nama' }}</h2>
            <span class="font-mono bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
              NIS: {{ $peserta->nomor_peserta }}
            </span>
            <span class="bg-indigo-50 text-indigo-700 text-[10px] font-semibold px-2 py-0.5 rounded-full">
              {{ $peserta->jurusan ?? 'Kejuruan Vokasi' }}
            </span>
          </div>
          <div class="flex items-center gap-3 text-xs text-slate-500 mt-1 flex-wrap">
            <span class="flex items-center gap-1"><i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i> {{ $peserta->user->email ?? '-' }}</span>
            <span class="flex items-center gap-1"><i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i> {{ $peserta->nomor_wa ?? '-' }}</span>
          </div>
        </div>
      </div>

      <div class="text-xs text-slate-400 flex sm:flex-col items-end justify-between gap-1 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
        <div>Terdaftar: <span class="text-slate-700 font-medium">{{ $peserta->created_at ? $peserta->created_at->translatedFormat('d M Y') : '-' }}</span></div>
        <div>Pembaruan Terakhir: <span class="text-slate-700 font-medium">{{ $peserta->updated_at ? $peserta->updated_at->diffForHumans() : '-' }}</span></div>
      </div>
    </div>
  </div>

  <!-- Edit Form Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Form) -->
    <div class="lg:col-span-2 space-y-6">
      <form method="POST" action="{{ route('pesertas.update', $peserta->id_peserta) }}" class="space-y-6">
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

        <!-- Card 1: Identitas Akun & NIS -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="user-check" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Akun Sistem & Nomor Induk</h3>
              <p class="text-xs text-slate-500">Tautan akun login dan nomor identitas peserta.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun Pengguna Terkait <span class="text-rose-500">*</span></label>
              <select name="id_user"  class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                @foreach($users ?? [] as $user)
                  <option value="{{ $user->id }}" {{ old('id_user', $peserta->id_user) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </select>
              @error('id_user')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Peserta (NIS) <span class="text-rose-500">*</span></label>
              <input type="text" name="nomor_peserta" value="{{ old('nomor_peserta', $peserta->nomor_peserta) }}"  class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nomor_peserta')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
              <select name="jenis_kelamin"  class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="Laki-laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('jenis_kelamin')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kejuruan / Jurusan</label>
              <input type="text" name="jurusan" value="{{ old('jurusan', $peserta->jurusan) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('jurusan')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp</label>
              <input type="text" name="nomor_wa" value="{{ old('nomor_wa', $peserta->nomor_wa) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nomor_wa')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        <!-- Card 2: Biodata & Domisili -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
          <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
              <i data-lucide="id-card" class="w-4 h-4"></i>
            </div>
            <div>
              <h3 class="font-bold text-slate-800 text-sm">Data Kependudukan & Domisili</h3>
              <p class="text-xs text-slate-500">Perbarui identitas kependudukan dan riwayat edukasi.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Kartu Keluarga (KK)</label>
              <input type="text" name="nomor_kk" value="{{ old('nomor_kk', $peserta->nomor_kk) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('nomor_kk')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pendidikan Terakhir</label>
              <select name="pendidikan_terakhir" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="SMK / SMA" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'SMK / SMA' ? 'selected' : '' }}>SMK / SMA Sederajat</option>
                <option value="Diploma (D3/D4)" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'Diploma (D3/D4)' ? 'selected' : '' }}>Diploma (D3/D4)</option>
                <option value="Sarjana (S1)" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'Sarjana (S1)' ? 'selected' : '' }}>Sarjana (S1)</option>
                <option value="SMP Sederajat" {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'SMP Sederajat' ? 'selected' : '' }}>SMP Sederajat</option>
              </select>
              @error('pendidikan_terakhir')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('tempat_lahir')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $peserta->tanggal_lahir ? $peserta->tanggal_lahir->format('Y-m-d') : '') }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
              @error('tanggal_lahir')<p class="text-rose-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
              <textarea name="alamat_lengkap" rows="3" class="w-full bg-slate-50/50 border border-slate-200 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ old('alamat_lengkap', $peserta->alamat_lengkap) }}</textarea>
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
          <i data-lucide="layers" class="w-4 h-4 text-emerald-700"></i>
          <span>Kelas & Sertifikat</span>
        </div>
        <div class="text-xs text-slate-600 space-y-2">
          <div class="flex items-center justify-between p-2 bg-slate-50 rounded">
            <span>Kelas Diikuti:</span>
            <strong class="text-slate-800">{{ count($peserta->kelas ?? []) }} Kelas</strong>
          </div>
          <div class="flex items-center justify-between p-2 bg-slate-50 rounded">
            <span>Sertifikat Diraih:</span>
            <strong class="text-slate-800">{{ count($peserta->sertifikat ?? []) }} Sertifikat</strong>
          </div>
        </div>
      </div>

      <div class="bg-rose-50/50 border border-rose-200 rounded-xl p-5 space-y-3">
        <div class="flex items-center gap-2 text-rose-800 font-bold text-xs">
          <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
          <span>Hapus Data Peserta</span>
        </div>
        <p class="text-[11px] text-rose-700 leading-relaxed">
          Tindakan ini akan menghapus data induk peserta, riwayat kelas, dan absensi yang terkait dari database.
        </p>
        <form action="{{ route('pesertas.destroy', $peserta->id_peserta) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peserta ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full mt-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Peserta
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection

