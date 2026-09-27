@extends('layouts.app')

@section('title', 'Edit Jadwal Pelatihan - ' . ($jadwal->pelatihan->nama_pelatihan ?? 'Jadwal'))

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('jadwal-pelatihan.index') }}" class="hover:text-emerald-700 transition">Jadwal Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Jadwal</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Perbarui Batch Jadwal Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Ubah tanggal pelaksanaan, jam kegiatan belajar mengajar, instruktur, atau ruangan kelas.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4"></i> Lihat Detail
      </a>
      <a href="{{ route('jadwal-pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
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
  <form action="{{ route('jadwal-pelatihan.update', $jadwal->id_jadwal) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @method('PUT')

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
              <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <h2 class="font-bold text-slate-800 text-sm">Informasi Program & Waktu Pelaksanaan</h2>
          </div>
          <span class="text-xs font-mono font-bold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md">
            ID: #JDW-{{ str_pad((string)$jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
          </span>
        </div>

        <div class="space-y-4">
          <div>
            <label for="id_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Program Kejuruan Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="id_pelatihan" id="id_pelatihan" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_pelatihan') border-rose-400 bg-rose-50/50 @enderror">
              <option value="">-- Pilih Program Kejuruan --</option>
              @foreach($pelatihans as $p)
                <option value="{{ $p->id_pelatihan }}" {{ old('id_pelatihan', $jadwal->id_pelatihan) == $p->id_pelatihan ? 'selected' : '' }}>
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
              <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', $jadwal->tanggal_mulai ? $jadwal->tanggal_mulai->format('Y-m-d') : '') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tanggal_mulai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('tanggal_mulai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="tanggal_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Tanggal Selesai Pelatihan <span class="text-rose-500">*</span>
              </label>
              <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai', $jadwal->tanggal_selesai ? $jadwal->tanggal_selesai->format('Y-m-d') : '') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tanggal_selesai') border-rose-400 bg-rose-50/50 @enderror" />
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
              <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '08:00') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('jam_mulai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('jam_mulai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="jam_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Jam Selesai Belajar
              </label>
              <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '15:30') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('jam_selesai') border-rose-400 bg-rose-50/50 @enderror" />
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
              <input type="text" name="instruktur" id="instruktur" value="{{ old('instruktur', $jadwal->instruktur) }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('instruktur') border-rose-400 bg-rose-50/50 @enderror" />
              @error('instruktur')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="tempat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Lokasi Bengkel / Ruangan Kelas
              </label>
              <input type="text" name="tempat" id="tempat" value="{{ old('tempat', $jadwal->tempat) }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tempat') border-rose-400 bg-rose-50/50 @enderror" />
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
              <option value="tersedia" {{ old('status', $jadwal->status) == 'tersedia' ? 'selected' : '' }}>Tersedia (Pendaftaran Terbuka)</option>
              <option value="berlangsung" {{ old('status', $jadwal->status) == 'berlangsung' ? 'selected' : '' }}>Berlangsung (Kelas Aktif)</option>
              <option value="selesai" {{ old('status', $jadwal->status) == 'selesai' ? 'selected' : '' }}>Selesai (Angkatan Lulus)</option>
            </select>
            @error('status')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Status & Simpan -->
    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4 text-emerald-700"></i>
          Aksi Pembaruan
        </h3>
        
        <div class="text-xs text-slate-500 space-y-2">
          <div class="flex items-center justify-between">
            <span>Dibuat:</span>
            <span class="font-semibold text-slate-700">{{ $jadwal->created_at ? $jadwal->created_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Terakhir diubah:</span>
            <span class="font-semibold text-slate-700">{{ $jadwal->updated_at ? $jadwal->updated_at->translatedFormat('d M Y') : '-' }}</span>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition">
            <i data-lucide="check" class="w-4 h-4"></i> Simpan Perubahan
          </button>
          <a href="{{ route('jadwal-pelatihan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>

      <div class="bg-rose-50/50 rounded-xl border border-rose-200 shadow-sm p-5 space-y-3">
        <h4 class="font-bold text-rose-800 text-xs flex items-center gap-1.5">
          <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i> Zona Berbahaya
        </h4>
        <p class="text-[11px] text-rose-600 leading-relaxed">
          Menghapus batch jadwal ini akan menghapus seluruh data presensi dan penugasan kelas yang terhubung.
        </p>
      </div>
    </div>
  </form>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ----------------------------------------------------
    // 1. LOGIKA TANGGAL (EDIT)
    // ----------------------------------------------------
    const tglMulai = document.getElementById('tanggal_mulai');
    const tglSelesai = document.getElementById('tanggal_selesai');

    function updateMinTglSelesai() {
      if (tglMulai.value) {
        // Hitung H+1 dari tanggal mulai buat nilai min tanggal selesai
        let nextDay = new Date(tglMulai.value);
        nextDay.setDate(nextDay.getDate() + 1);
        
        let minSelesai = nextDay.toISOString().split('T')[0];
        tglSelesai.min = minSelesai;

        // Kalo tgl selesai lebih kecil atau sama dengan tgl mulai
        if (tglSelesai.value && tglSelesai.value <= tglMulai.value) {
          alert('Tanggal selesai harus setelah tanggal mulai!');
          tglSelesai.value = '';
        }
      }
    }

    // PENTING UNTUK EDIT: Jalankan langsung pas halaman baru ke-load
    updateMinTglSelesai();

    // Jalankan tiap ada perubahan pada input tanggal
    tglMulai.addEventListener('change', updateMinTglSelesai);
    tglSelesai.addEventListener('change', updateMinTglSelesai);


    // ----------------------------------------------------
    // 2. LOGIKA JAM (EDIT)
    // ----------------------------------------------------
    const jamMulai = document.getElementById('jam_mulai');
    const jamSelesai = document.getElementById('jam_selesai');

    function validateJamSelesai() {
      if (jamMulai.value) {
        jamSelesai.min = jamMulai.value;

        if (jamSelesai.value && jamSelesai.value <= jamMulai.value) {
          alert('Jam selesai harus lebih dari jam mulai!');
          jamSelesai.value = '';
        }
      }
    }

    // PENTING UNTUK EDIT: Jalankan langsung pas halaman baru ke-load
    validateJamSelesai();

    // Jalankan tiap ada perubahan pada input jam
    jamMulai.addEventListener('change', function() {
      validateJamSelesai();
    });
    jamSelesai.addEventListener('change', validateJamSelesai);
  });
</script>