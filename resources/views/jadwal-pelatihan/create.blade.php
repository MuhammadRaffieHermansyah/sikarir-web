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

  <form action="{{ route('jadwal-pelatihan.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
          <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
            <i data-lucide="calendar" class="w-4 h-4"></i>
          </div>
          <h2 class="font-bold text-slate-800 text-sm">Informasi Program &amp; Waktu Pelaksanaan</h2>
        </div>

        <div class="space-y-4">

          <!-- Program Kejuruan -->
          <div>
            <label for="id_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Program Kejuruan Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="id_pelatihan" id="id_pelatihan"
              class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_pelatihan') border-rose-400 bg-rose-50/50 @enderror">
              <option value="">-- Pilih Program Kejuruan --</option>
              @foreach($pelatihans as $p)
                <option
                  value="{{ $p->id_pelatihan }}"
                  data-hari="{{ $p->durasi?->hari ?? '' }}"
                  data-jam="{{ $p->durasi?->jam ?? '' }}"
                  {{ old('id_pelatihan') == $p->id_pelatihan ? 'selected' : '' }}
                >
                  {{ $p->nama_pelatihan }} (Kuota: {{ $p->kuota }} Siswa | {{ $p->durasi_label ?? '-' }})
                </option>
              @endforeach
            </select>
            @error('id_pelatihan')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
            <!-- Info badge durasi yang terpilih -->
            <div id="info-durasi" class="hidden mt-2 flex items-center gap-2 text-[11px] text-emerald-800 bg-emerald-50 border border-emerald-100 px-3 py-2 rounded-lg">
              <i data-lucide="clock" class="w-3.5 h-3.5 flex-shrink-0"></i>
              <span id="info-durasi-text"></span>
            </div>
          </div>

          <!-- Tanggal Mulai & Selesai -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="tanggal_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Tanggal Mulai Pelatihan <span class="text-rose-500">*</span>
              </label>
              <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                value="{{ old('tanggal_mulai') }}"
                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tanggal_mulai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('tanggal_mulai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="tanggal_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Tanggal Selesai Pelatihan <span class="text-rose-500">*</span>
              </label>
              <div class="relative">
                <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                  value="{{ old('tanggal_selesai') }}"
                  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('tanggal_selesai') border-rose-400 bg-rose-50/50 @enderror" />
                <!-- Spinner loading saat menghitung -->
                <div id="loading-tgl-selesai" class="hidden absolute right-2 top-1/2 -translate-y-1/2">
                  <svg class="animate-spin w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                  </svg>
                </div>
              </div>
              @error('tanggal_selesai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
              <p id="hint-tgl-selesai" class="text-[10px] text-slate-400 mt-1 hidden">
                Dihitung otomatis — melewati Sabtu, Minggu &amp; libur nasional
              </p>
            </div>
          </div>

          <!-- Jam Mulai & Selesai -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="jam_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Jam Mulai Belajar
              </label>
              <input type="time" name="jam_mulai" id="jam_mulai"
                value="{{ old('jam_mulai', '07:00') }}"
                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('jam_mulai') border-rose-400 bg-rose-50/50 @enderror" />
              @error('jam_mulai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="jam_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                Jam Selesai Belajar
                <span class="text-[10px] font-normal text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">
                  <i data-lucide="lock" class="w-2.5 h-2.5 inline -mt-0.5"></i> Otomatis
                </span>
              </label>
              <input type="time" name="jam_selesai" id="jam_selesai" readonly
                value="{{ old('jam_selesai', '15:00') }}"
                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed select-none @error('jam_selesai') border-rose-400 @enderror" />
              @error('jam_selesai')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
              <p class="text-[10px] text-slate-400 mt-1">Mengikuti jam mulai + durasi program otomatis</p>
            </div>
          </div>

          <!-- Instruktur & Tempat -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="id_instruktur" class="block text-xs font-semibold text-slate-700 mb-1.5">
                Instruktur / Pengajar <span class="text-rose-500">*</span>
              </label>
              <select name="id_instruktur" id="id_instruktur" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_instruktur') border-rose-400 bg-rose-50/50 @enderror">
                <option value="">-- Pilih Instruktur --</option>
                @foreach($instrukturs ?? [] as $instruktur)
                  <option value="{{ $instruktur->id }}" {{ old('id_instruktur') == $instruktur->id ? 'selected' : '' }}>{{ $instruktur->nama }} ({{ $instruktur->bidang_keahlian }})</option>
                @endforeach
              </select>
              <p class="text-[11px] text-slate-400 mt-1">
                Belum ada data? <a href="{{ route('instruktur.create') }}" class="text-emerald-700 hover:underline font-semibold">Tambah instruktur baru</a>
              </p>
              @error('id_instruktur')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="id_ruangan_workshop"
                  class="block text-sm font-medium text-slate-700 mb-2">
                  Ruangan Workshop
              </label>
              <select name="id_ruangan_workshop" id="id_ruangan_workshop" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('id_ruangan_workshop') border-rose-400 bg-rose-50/50 @enderror">
                <option value="">-- Pilih Ruangan Workshop --</option>
                @foreach($ruanganWorkshops as $ruangan)
                  <option value="{{ $ruangan->id }}" {{ old('id_ruangan_workshop') == $ruangan->id ? 'selected' : '' }}>{{ $ruangan->nama_ruangan }}</option>
                @endforeach
              </select>
              <p class="text-[11px] text-slate-400 mt-1">
                Belum ada data? <a href="{{ route('ruangan-workshop.create', ['from' => 'jadwal']) }}" class="text-emerald-700 hover:underline font-semibold">Tambah ruangan baru</a>
              </p>
              @error('id_ruangan_workshop')
                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Status -->
          <div>
            <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Status Batch Pelatihan <span class="text-rose-500">*</span>
            </label>
            <select name="status" id="status"
              class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('status') border-rose-400 bg-rose-50/50 @enderror">
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

      <!-- ================================================ -->
      <!-- PREVIEW HARI EFEKTIF (muncul setelah kalkulasi)  -->
      <!-- ================================================ -->
      <div id="preview-jadwal" class="hidden bg-white rounded-xl border border-emerald-200 shadow-sm p-5 space-y-4">
        <div class="flex items-center gap-2 border-b border-emerald-100 pb-3">
          <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center">
            <i data-lucide="calendar-check" class="w-4 h-4"></i>
          </div>
          <h3 class="font-bold text-slate-800 text-sm">Preview Hari Efektif Pelatihan</h3>
          <span id="badge-hari-efektif" class="ml-auto text-[10px] font-bold bg-emerald-800 text-white px-2 py-0.5 rounded-full"></span>
        </div>

        <!-- Statistik angka -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="text-center bg-emerald-50 rounded-lg p-3">
            <div id="prev-total-hari" class="text-2xl font-black text-emerald-800">0</div>
            <div class="text-[10px] text-emerald-700 font-medium">Hari Efektif</div>
          </div>
          <div class="text-center bg-blue-50 rounded-lg p-3">
            <div id="prev-total-jam" class="text-2xl font-black text-blue-700">0</div>
            <div class="text-[10px] text-blue-700 font-medium">Total Jam</div>
          </div>
          <div class="text-center bg-amber-50 rounded-lg p-3">
            <div id="prev-total-libur" class="text-2xl font-black text-amber-700">0</div>
            <div class="text-[10px] text-amber-700 font-medium">Hari Libur</div>
          </div>
          <div class="text-center bg-slate-50 rounded-lg p-3">
            <div id="prev-total-kalender" class="text-2xl font-black text-slate-700">0</div>
            <div class="text-[10px] text-slate-600 font-medium">Total Kalender</div>
          </div>
        </div>

        <!-- Chip hari libur yang dilewati -->
        <div id="list-libur-container" class="hidden">
          <p class="text-[11px] font-semibold text-slate-600 mb-2">Hari Libur yang Dilewati Sistem:</p>
          <div id="list-libur" class="flex flex-wrap gap-1.5"></div>
        </div>

        <!-- Warning jika tanggal mulai adalah hari libur -->
        <div id="warn-tgl-mulai" class="hidden items-start gap-2 text-[11px] text-amber-800 bg-amber-50 border border-amber-200 px-3 py-2 rounded-lg">
          <i data-lucide="alert-triangle" class="w-3.5 h-3.5 flex-shrink-0 mt-0.5 text-amber-600"></i>
          <span id="warn-tgl-mulai-text"></span>
        </div>
      </div>
    </div>

    <!-- Right Column: Info & Simpan -->
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
            <span class="font-bold block">Info Presensi:</span>
            Sistem absensi harian peserta akan otomatis ditautkan ke jadwal pelatihan ini.
          </div>
          <div class="p-3 bg-amber-50/60 rounded-lg border border-amber-100 space-y-1.5 text-[11px] text-amber-900">
            <span class="font-bold block">Hari Tidak Aktif (Dilewati Otomatis):</span>
            <div class="space-y-1">
              <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-slate-300 flex-shrink-0"></span>
                <span>Sabtu &amp; Minggu (weekend)</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-amber-400 flex-shrink-0"></span>
                <span>Hari libur nasional Indonesia</span>
              </div>
            </div>
            <p class="text-amber-700">Tanggal selesai dihitung otomatis melewati semua hari tidak aktif.</p>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  var selectPelatihan    = document.getElementById('id_pelatihan');
  var tglMulai           = document.getElementById('tanggal_mulai');
  var tglSelesai         = document.getElementById('tanggal_selesai');
  var jamMulai           = document.getElementById('jam_mulai');
  var jamSelesai         = document.getElementById('jam_selesai');
  var infoDurasi         = document.getElementById('info-durasi');
  var infoDurasiText     = document.getElementById('info-durasi-text');
  var loadingTglSelesai  = document.getElementById('loading-tgl-selesai');
  var hintTglSelesai     = document.getElementById('hint-tgl-selesai');
  var previewJadwal      = document.getElementById('preview-jadwal');
  var prevTotalHari      = document.getElementById('prev-total-hari');
  var prevTotalJam       = document.getElementById('prev-total-jam');
  var prevTotalLibur     = document.getElementById('prev-total-libur');
  var prevTotalKalender  = document.getElementById('prev-total-kalender');
  var badgeHariEfektif   = document.getElementById('badge-hari-efektif');
  var listLiburContainer = document.getElementById('list-libur-container');
  var listLibur          = document.getElementById('list-libur');
  var warnTglMulai       = document.getElementById('warn-tgl-mulai');
  var warnTglMulaiText   = document.getElementById('warn-tgl-mulai-text');

  var cacheHariLibur  = {};
  var hariLiburSet    = new Set();
  var jumlahHariAktif = null;
  var jumlahJamTotal  = null;
  var durasiJamMenit  = null; // durasi per hari dalam menit, disimpan saat auto-hitung

  // ============================================================
  // FIX TIMEZONE: Gunakan waktu LOKAL, bukan UTC (toISOString).
  // toISOString() di WIB (UTC+7): jam 00:00 lokal = jam 17:00 UTC
  // sehari sebelumnya → tanggal muncul mundur 1 hari (bug utama).
  // ============================================================
  function toDateStr(d) {
    var y   = d.getFullYear();
    var m   = String(d.getMonth() + 1).padStart(2, '0');
    var day = String(d.getDate()).padStart(2, '0');
    return y + '-' + m + '-' + day;
  }

  // Buat Date dari 'YYYY-MM-DD' tanpa UTC shift
  function fromStr(s) {
    var p = s.split('-');
    return new Date(+p[0], +p[1] - 1, +p[2]);
  }

  // ---- 1. Min tanggal mulai = hari ini (waktu lokal) ----
  tglMulai.min = toDateStr(new Date());

  // ---- 2. Hitung jam selesai otomatis: jam_mulai + (total_jam / hari_kerja) ----
  function hitungJamSelesai(totalHari, totalJam) {
    if (!totalHari || !totalJam) return;
    var jamPerHari  = totalJam / totalHari;
    durasiJamMenit  = Math.round(jamPerHari * 60); // simpan durasi harian
    applyDurasiJam();
  }

  // Terapkan durasiJamMenit ke jam_mulai saat ini → update jam_selesai
  function applyDurasiJam() {
    if (!durasiJamMenit) return;
    var parts  = (jamMulai.value || '07:00').split(':');
    var mulaiMenit = (+parts[0]) * 60 + (+parts[1]);
    var endMenit   = mulaiMenit + durasiJamMenit;
    var endH = Math.min(22, Math.floor(endMenit / 60));
    var endM = (endH < 22) ? (endMenit % 60) : 0;
    jamSelesai.value = String(endH).padStart(2, '0') + ':' + String(endM).padStart(2, '0');
  }

  // ---- 3. Pilih program → baca durasi ----
  selectPelatihan.addEventListener('change', function () {
    var opt  = this.options[this.selectedIndex];
    var hari = +(opt.getAttribute('data-hari') || 0);
    var jam  = +(opt.getAttribute('data-jam')  || 0);
    if (hari > 0 && jam > 0) {
      jumlahHariAktif = hari;
      jumlahJamTotal  = jam;
      var jph = (jam / hari % 1 === 0) ? (jam / hari) : (jam / hari).toFixed(1);
      infoDurasiText.textContent = 'Durasi: ' + hari + ' Hari Kerja / ' + jam + ' Total Jam (' + jph + ' jam/hari) — Jam & tanggal selesai dihitung otomatis.';
      infoDurasi.classList.remove('hidden');
      if (window.lucide) lucide.createIcons({ nodes: [infoDurasi] });
      hitungJamSelesai(hari, jam);
      if (tglMulai.value) hitungTanggalSelesai();
    } else {
      jumlahHariAktif = null;
      jumlahJamTotal  = null;
      infoDurasi.classList.add('hidden');
    }
  });

  // Jika jam mulai diubah manual → terapkan ulang durasi harian yang tersimpan
  // Pakai 'input' agar langsung reaktif saat user mengetik/memilih waktu
  jamMulai.addEventListener('input', function () {
    applyDurasiJam(); // langsung update jam_selesai tanpa validasi
  });
  jamMulai.addEventListener('change', function () {
    applyDurasiJam();
    validateJam();
  });

  // ---- 4. Fetch hari libur nasional (cached per tahun) ----
  function fetchHariLibur(tahun) {
    if (cacheHariLibur[tahun]) return Promise.resolve(cacheHariLibur[tahun]);
    var meta = document.querySelector('meta[name="csrf-token"]');
    return fetch('http://localhost:8000/internal/hari-libur?tahun=' + tahun, {
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': meta ? meta.content : '' }
    })
    .then(function(r) { if (!r.ok) throw 0; return r.json(); })
    .then(function(d) { return (cacheHariLibur[tahun] = d.hari_libur || []); })
    .catch(function() { return []; });
  }

  // ---- 5. Helpers ----
  function isLibur(ds) {
    var dow = new Date(ds + 'T00:00:00').getDay();
    return dow === 0 || dow === 6 || hariLiburSet.has(ds);
  }
  function formatTgl(ds) {
    return new Date(ds + 'T00:00:00').toLocaleDateString('id-ID', { weekday:'short', day:'numeric', month:'short', year:'numeric' });
  }
  var HARI = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

  // ---- 6. Hitung tanggal selesai (skip hari libur) ----
  function hitungTanggalSelesai() {
    if (!tglMulai.value || !jumlahHariAktif) return;
    loadingTglSelesai.classList.remove('hidden');
    hintTglSelesai.classList.remove('hidden');
    var tahun = +tglMulai.value.split('-')[0];
    Promise.all([fetchHariLibur(tahun), fetchHariLibur(tahun + 1)]).then(function(res) {
      hariLiburSet = new Set(res[0].concat(res[1]));
      var cur   = fromStr(tglMulai.value);
      var aktif = 0, dilewati = [], i = 0;
      // Peringatan jika tanggal mulai hari libur
      var s0 = toDateStr(cur);
      if (isLibur(s0)) {
        var dow = cur.getDay();
        warnTglMulaiText.textContent = (dow===0||dow===6)
          ? 'Tanggal mulai jatuh pada hari ' + HARI[dow] + '. Pelatihan akan dimulai hari kerja berikutnya.'
          : 'Tanggal mulai (' + formatTgl(s0) + ') adalah hari libur nasional. Pelatihan akan dimulai hari kerja berikutnya.';
        warnTglMulai.classList.remove('hidden'); warnTglMulai.classList.add('flex');
      } else {
        warnTglMulai.classList.add('hidden'); warnTglMulai.classList.remove('flex');
      }
      // Iterasi — semua toDateStr() (lokal, bukan UTC)
      while (aktif < jumlahHariAktif && i < 730) {
        var ds = toDateStr(cur);
        if (!isLibur(ds)) { aktif++; if (aktif === jumlahHariAktif) break; }
        else { if (dilewati.length < 30) dilewati.push(ds); }
        if (aktif < jumlahHariAktif) cur.setDate(cur.getDate() + 1);
        i++;
      }
      var selesai  = toDateStr(cur);
      tglSelesai.min   = tglMulai.value;
      tglSelesai.value = selesai;
      var diff = Math.round((fromStr(selesai) - fromStr(tglMulai.value)) / 86400000) + 1;
      prevTotalHari.textContent     = jumlahHariAktif;
      if (prevTotalJam) prevTotalJam.textContent = jumlahJamTotal || '-';
      prevTotalLibur.textContent    = dilewati.length;
      prevTotalKalender.textContent = diff;
      badgeHariEfektif.textContent  = jumlahHariAktif + ' Hari Aktif';
      renderChip(dilewati);
      previewJadwal.classList.remove('hidden');
      if (window.lucide) lucide.createIcons({ nodes: [previewJadwal] });
      loadingTglSelesai.classList.add('hidden');
    });
  }

  function renderChip(arr) {
    listLibur.innerHTML = '';
    arr.forEach(function(d) {
      var dow = new Date(d+'T00:00:00').getDay();
      var c = document.createElement('span');
      c.className = 'text-[10px] font-semibold px-2 py-0.5 rounded-full ' + (dow===0||dow===6 ? 'bg-slate-100 text-slate-600' : 'bg-amber-100 text-amber-800');
      c.textContent = formatTgl(d);
      listLibur.appendChild(c);
    });
    arr.length > 0 ? listLiburContainer.classList.remove('hidden') : listLiburContainer.classList.add('hidden');
  }

  // ---- 7. Events tanggal ----
  tglMulai.addEventListener('change', function () {
    if (!this.value) return;
    var nd = fromStr(this.value); nd.setDate(nd.getDate() + 1);
    tglSelesai.min = toDateStr(nd);
    if (tglSelesai.value && tglSelesai.value <= this.value) tglSelesai.value = '';
    if (jumlahHariAktif) hitungTanggalSelesai();
  });

  tglSelesai.addEventListener('change', function () {
    if (tglMulai.value && this.value && hariLiburSet.size > 0) updatePreviewManual();
  });

  function updatePreviewManual() {
    if (!tglMulai.value || !tglSelesai.value) return;
    var cur = fromStr(tglMulai.value), end = fromStr(tglSelesai.value);
    var aktif = 0, arr = [];
    while (cur <= end) {
      var ds = toDateStr(cur);
      if (!isLibur(ds)) { aktif++; } else { if (arr.length<30) arr.push(ds); }
      cur.setDate(cur.getDate() + 1);
    }
    var diff = Math.round((fromStr(tglSelesai.value) - fromStr(tglMulai.value)) / 86400000) + 1;
    // Total jam dihitung dinamis: hari_aktif × jam_per_hari
    var jamAktual = (jumlahHariAktif && jumlahJamTotal && aktif)
      ? Math.round(aktif * (jumlahJamTotal / jumlahHariAktif))
      : (jumlahJamTotal || '-');
    prevTotalHari.textContent     = aktif;
    if (prevTotalJam) prevTotalJam.textContent = jamAktual;
    prevTotalLibur.textContent    = arr.length;
    prevTotalKalender.textContent = diff;
    badgeHariEfektif.textContent  = aktif + ' Hari Aktif';
    renderChip(arr);
    previewJadwal.classList.remove('hidden');
    if (window.lucide) lucide.createIcons({ nodes: [previewJadwal] });
  }
  
  // ---- 8. Validasi jam ----
  function validateJam() {
    if (jamMulai.value && jamSelesai.value && jamSelesai.value <= jamMulai.value) {
      alert('Jam selesai harus lebih dari jam mulai!');
      jamSelesai.value = '';
    }
  }
  jamSelesai.addEventListener('change', validateJam);
  
  // ---- 9. Trigger jika old() terisi ----
  if (selectPelatihan.value) selectPelatihan.dispatchEvent(new Event('change'));
  });
</script>