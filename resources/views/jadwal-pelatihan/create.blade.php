@extends('layouts.app')

@section('title', 'Buat Batch Jadwal Pelatihan - Disnaker BLK')

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('jadwal-pelatihan.index') }}" class="hover:text-emerald-700 transition">Jadwal Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Buat Batch Jadwal</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Buat Batch Jadwal Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Tentukan periode pelatihan, ruangan bengkel kerja/laboratorium, dan instruktur pembimbing.</p>
    </div>

    <div>
      <a href="{{ route('jadwal-pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
      </a>
    </div>
  </div>

  @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
      <div class="font-bold flex items-center gap-1.5">
        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
        Mohon perbaiki beberapa kesalahan berikut:
      </div>
      <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form Layout: 2 Columns -->
  <form action="{{ route('jadwal-pelatihan.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <i data-lucide="calendar" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Informasi Program & Waktu Pelaksanaan</h2>
        </div>

        <div class="space-y-4">
          <div>
            <label for="id_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Program Kejuruan Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="id_pelatihan" id="id_pelatihan" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_pelatihan') border-rose-400 bg-rose-50/50 @enderror">
              <option value="">-- Pilih Program Kejuruan --</option>
              @foreach($pelatihans as $p)
                <option value="{{ $p->id_pelatihan }}" {{ old('id_pelatihan') == $p->id_pelatihan ? 'selected' : '' }}>
                  {{ $p->nama_pelatihan }} (Kuota: {{ $p->kuota }} Siswa | {{ $p->durasi_lp ?? '240 JP' }})
                </option>
              @endforeach
            </select>
            @error('id_pelatihan')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="tanggal_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Tanggal Mulai Pelatihan <span class="text-rose-500">*</span>
              </label>
              <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tanggal_mulai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('tanggal_mulai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="tanggal_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Tanggal Selesai Pelatihan <span class="text-rose-500">*</span>
              </label>
              <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tanggal_selesai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('tanggal_selesai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="jam_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Jam Mulai Belajar
              </label>
              <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('jam_mulai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('jam_mulai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="jam_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Jam Selesai Belajar
              </label>
              <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', '15:30') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('jam_selesai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('jam_selesai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="instruktur" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Nama Instruktur / Pengajar
              </label>
              <input type="text" name="instruktur" id="instruktur" value="{{ old('instruktur') }}" placeholder="Contoh: Ir. Bambang Hermanto, M.T." class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('instruktur') border-rose-400 bg-rose-50/50 @enderror" />
              @error('instruktur')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="tempat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Lokasi Bengkel / Ruangan Kelas
              </label>
              <input type="text" name="tempat" id="tempat" value="{{ old('tempat', 'Workshop Lab Komputer BLK') }}" placeholder="Contoh: Workshop Otomotif Gedung B" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tempat') border-rose-400 bg-rose-50/50 @enderror" />
              @error('tempat')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div>
            <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Status Batch Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="status" id="status" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('status') border-rose-400 bg-rose-50/50 @enderror">
              <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia (Pendaftaran Terbuka)</option>
              <option value="berlangsung" {{ old('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung (Kelas Aktif)</option>
              <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai (Angkatan Lulus)</option>
            </select>
            @error('status')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Petunjuk & Simpan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          Ketentuan Penjadwalan
        </h3>
        <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
          <p>
            Setelah batch jadwal dibuat, Anda dapat langsung menambahkan siswa ke kelas melalui menu <strong>Kelas Pelatihan</strong>.
          </p>
          <div class="p-3 bg-emerald-50/60 rounded-lg border border-emerald-100 space-y-1 text-[11px] text-emerald-900">
            <span class="font-bold block">💡 Info Presensi:</span>
            Sistem absensi harian peserta akan otomatis ditautkan ke jadwal pelatihan ini.
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="save" class="w-4 h-4"></i> Buat Batch Jadwal
          </button>
          <a href="{{ route('jadwal-pelatihan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>
    </div>
  </form>
@endsection
