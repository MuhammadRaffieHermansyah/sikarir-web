@extends('layouts.app')

@section('title', 'Edit Jadwal & Kelas - ' . ($jadwal->pelatihan->nama_pelatihan ?? 'Jadwal'))

@section('content')
  <x-ui.page-header
    title="Perbarui Batch Jadwal & Kelas"
    description="Ubah tanggal pelaksanaan, jam kegiatan belajar mengajar, instruktur, atau ruangan kelas."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('jadwal-pelatihan.index') }}">Jadwal &amp; Kelas</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Jadwal</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}" variant="outline">
        <x-lucide-eye />
        Lihat Detail
      </x-ui.button>

      <x-ui.button href="{{ route('jadwal-pelatihan.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  @if ($errors->any())
    <x-ui.alert tone="danger">
      <x-lucide-circle-alert />
      <x-ui.alert-title>Mohon perbaiki beberapa kesalahan berikut:</x-ui.alert-title>
      <x-ui.alert-description>
        <ul class="list-inside list-disc space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </x-ui.alert-description>
    </x-ui.alert>
  @endif

  <form action="{{ route('jadwal-pelatihan.update', $jadwal->id_jadwal) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-calendar class="size-4" />
              </span>
              <x-ui.card-title class="text-base font-bold">Informasi Program &amp; Waktu Pelaksanaan</x-ui.card-title>
            </div>

            <x-ui.badge variant="secondary" class="font-mono">
              ID: #JDW-{{ str_pad((string) $jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <x-ui.field data-invalid="{{ $errors->has('id_pelatihan') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_pelatihan">Program Kejuruan Pelatihan <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="id_pelatihan" id="id_pelatihan" native class="w-full" required>
              <option value="">-- Pilih Program Kejuruan --</option>
              @foreach ($pelatihans as $p)
                <option
                  value="{{ $p->id_pelatihan }}"
                  data-hari="{{ $p->durasi?->hari ?? '' }}"
                  data-jam="{{ $p->durasi?->jam ?? '' }}"
                  @selected(old('id_pelatihan', $jadwal->id_pelatihan) == $p->id_pelatihan)
                >
                  {{ $p->nama_pelatihan }} (Kuota: {{ $p->kuota }} Siswa | {{ $p->durasi_label ?? '-' }})
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('id_pelatihan')" />

            <div id="info-durasi" class="mt-2 hidden items-center gap-2 rounded-lg border border-border bg-accent px-3 py-2 text-xs text-accent-foreground">
              <x-lucide-clock class="size-3.5 shrink-0" />
              <span id="info-durasi-text"></span>
            </div>
          </x-ui.field>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('tanggal_mulai') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal_mulai">Tanggal Mulai Pelatihan <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input
                type="date"
                name="tanggal_mulai"
                id="tanggal_mulai"
                :value="old('tanggal_mulai', $jadwal->tanggal_mulai ? $jadwal->tanggal_mulai->format('Y-m-d') : '')"
                required
              />
              <x-ui.field-error :messages="$errors->get('tanggal_mulai')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tanggal_selesai') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal_selesai">Tanggal Selesai Pelatihan <span class="text-destructive">*</span></x-ui.field-label>
              <div class="relative">
                <x-ui.input
                  type="date"
                  name="tanggal_selesai"
                  id="tanggal_selesai"
                  :value="old('tanggal_selesai', $jadwal->tanggal_selesai ? $jadwal->tanggal_selesai->format('Y-m-d') : '')"
                  class="w-full"
                  required
                />
                <div id="loading-tgl-selesai" class="absolute end-2 top-1/2 hidden -translate-y-1/2">
                  <svg class="size-3.5 animate-spin text-primary" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                  </svg>
                </div>
              </div>
              <p id="hint-tgl-selesai" class="mt-1 hidden text-xs text-muted-foreground">
                Dihitung otomatis â€” melewati Sabtu, Minggu &amp; libur nasional
              </p>
              <x-ui.field-error :messages="$errors->get('tanggal_selesai')" />
            </x-ui.field>
          </div>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('jam_mulai') ? 'true' : 'false' }}">
              <x-ui.field-label for="jam_mulai">Jam Mulai Belajar</x-ui.field-label>
              <x-ui.input
                type="time"
                name="jam_mulai"
                id="jam_mulai"
                :value="old('jam_mulai', $jadwal->jam_mulai ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '08:00')"
              />
              <x-ui.field-error :messages="$errors->get('jam_mulai')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jam_selesai') ? 'true' : 'false' }}">
              <x-ui.field-label for="jam_selesai" class="flex items-center gap-1.5">
                Jam Selesai Belajar
                <span class="rounded bg-muted px-1.5 py-0.5 text-[10px] font-normal text-muted-foreground">
                  <x-lucide-lock class="inline size-2.5" /> Otomatis
                </span>
              </x-ui.field-label>
              <x-ui.input
                type="time"
                name="jam_selesai"
                id="jam_selesai"
                :value="old('jam_selesai', $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '15:00')"
                readonly
                class="cursor-not-allowed bg-muted text-muted-foreground"
              />
              <x-ui.field-description>Mengikuti jam mulai + durasi program otomatis</x-ui.field-description>
              <x-ui.field-error :messages="$errors->get('jam_selesai')" />
            </x-ui.field>
          </div>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('id_instruktur') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_instruktur">Instruktur / Pengajar <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="id_instruktur" id="id_instruktur" native class="w-full">
                <option value="">-- Pilih Instruktur --</option>
                @foreach ($instrukturs ?? [] as $instruktur)
                  <option value="{{ $instruktur->id }}" @selected(old('id_instruktur', $jadwal->id_instruktur) == $instruktur->id)>
                    {{ $instruktur->nama }} ({{ $instruktur->bidang_keahlian }})
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-description>
                Belum ada data?
                <a href="{{ route('instruktur.create') }}" class="font-semibold text-primary hover:underline">Tambah instruktur baru</a>
              </x-ui.field-description>
              <x-ui.field-error :messages="$errors->get('id_instruktur')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('id_ruangan_workshop') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_ruangan_workshop">Ruangan Workshop</x-ui.field-label>
              <x-ui.select name="id_ruangan_workshop" id="id_ruangan_workshop" native class="w-full">
                <option value="">-- Pilih Ruangan Workshop --</option>
                @foreach ($ruanganWorkshops as $ruangan)
                  <option value="{{ $ruangan->id }}" @selected(old('id_ruangan_workshop', $jadwal->id_ruangan_workshop) == $ruangan->id)>
                    {{ $ruangan->nama_ruangan }}
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_ruangan_workshop')" />
            </x-ui.field>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('status') ? 'true' : 'false' }}">
            <x-ui.field-label for="status">Status Batch Pelatihan <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="status" id="status" native class="w-full" required>
              <option value="tersedia" @selected(old('status', $jadwal->status) == 'tersedia')>Tersedia (Pendaftaran Terbuka)</option>
              <option value="berlangsung" @selected(old('status', $jadwal->status) == 'berlangsung')>Berlangsung (Kelas Aktif)</option>
              <option value="selesai" @selected(old('status', $jadwal->status) == 'selesai')>Selesai (Angkatan Lulus)</option>
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('status')" />
          </x-ui.field>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-map-pin class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Titik Lokasi &amp; Geofencing Presensi Peserta</x-ui.card-title>
                <x-ui.card-description>Koordinat GPS yang diwajibkan bagi peserta saat melakukan presensi masuk di aplikasi mobile.</x-ui.card-description>
              </div>
            </div>

            <x-ui.button type="button" variant="outline" size="sm" id="btn-use-current-location">
              <x-lucide-crosshair />
              Ambil GPS Saat Ini
            </x-ui.button>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-4">
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <x-ui.field data-invalid="{{ $errors->has('lokasi_latitude') ? 'true' : 'false' }}">
              <x-ui.field-label for="lokasi_latitude">Latitude</x-ui.field-label>
              <x-ui.input type="number" step="any" name="lokasi_latitude" id="lokasi_latitude" :value="old('lokasi_latitude', $jadwal->lokasi_latitude ?? '-8.1763000')" placeholder="-8.1763000" />
              <x-ui.field-error :messages="$errors->get('lokasi_latitude')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('lokasi_longitude') ? 'true' : 'false' }}">
              <x-ui.field-label for="lokasi_longitude">Longitude</x-ui.field-label>
              <x-ui.input type="number" step="any" name="lokasi_longitude" id="lokasi_longitude" :value="old('lokasi_longitude', $jadwal->lokasi_longitude ?? '113.7007000')" placeholder="113.7007000" />
              <x-ui.field-error :messages="$errors->get('lokasi_longitude')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('radius_meter') ? 'true' : 'false' }}">
              <x-ui.field-label for="radius_meter">Radius Presensi (Meter)</x-ui.field-label>
              <x-ui.input type="number" name="radius_meter" id="radius_meter" :value="old('radius_meter', $jadwal->radius_meter ?? 100)" placeholder="100" />
              <x-ui.field-error :messages="$errors->get('radius_meter')" />
            </x-ui.field>
          </div>

          <div class="flex items-center gap-2 pt-1">
            <button
              type="button"
              onclick="document.getElementById('lokasi_latitude').value='-8.1763000';document.getElementById('lokasi_longitude').value='113.7007000';document.getElementById('radius_meter').value='100';"
              class="text-xs font-medium text-muted-foreground underline transition hover:text-primary"
            >
              Reset ke Default (Kampus Utama BLK Jember - 100m)
            </button>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      {{-- PREVIEW HARI EFEKTIF --}}
      <div id="preview-jadwal" class="hidden space-y-4 rounded-xl border border-primary/30 bg-card p-5 shadow-sm">
        <div class="flex items-center gap-2 border-b border-border pb-3">
          <span class="grid size-7 place-items-center rounded-lg bg-accent text-accent-foreground">
            <x-lucide-calendar-check class="size-4" />
          </span>
          <h3 class="text-sm font-bold text-foreground">Preview Hari Efektif Pelatihan</h3>
          <span id="badge-hari-efektif" class="ms-auto rounded-full bg-primary px-2 py-0.5 text-[10px] font-bold text-primary-foreground"></span>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
          <div class="rounded-lg bg-accent p-3 text-center">
            <div id="prev-total-hari" class="text-2xl font-black text-accent-foreground">0</div>
            <div class="text-[10px] font-medium text-accent-foreground">Hari Efektif</div>
          </div>
          <div class="rounded-lg bg-blue-50 p-3 text-center">
            <div id="prev-total-jam" class="text-2xl font-black text-blue-700">0</div>
            <div class="text-[10px] font-medium text-blue-700">Total Jam</div>
          </div>
          <div class="rounded-lg bg-amber-50 p-3 text-center">
            <div id="prev-total-libur" class="text-2xl font-black text-amber-700">0</div>
            <div class="text-[10px] font-medium text-amber-700">Hari Libur</div>
          </div>
          <div class="rounded-lg bg-muted p-3 text-center">
            <div id="prev-total-kalender" class="text-2xl font-black text-foreground">0</div>
            <div class="text-[10px] font-medium text-muted-foreground">Total Kalender</div>
          </div>
        </div>

        <div id="list-libur-container" class="hidden">
          <p class="mb-2 text-xs font-semibold text-muted-foreground">Hari Libur yang Dilewati Sistem:</p>
          <div id="list-libur" class="flex flex-wrap gap-1.5"></div>
        </div>

        <div id="warn-tgl-mulai" class="hidden items-start gap-2 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-800">
          <x-lucide-triangle-alert class="mt-0.5 size-3.5 shrink-0 text-amber-600" />
          <span id="warn-tgl-mulai-text"></span>
        </div>

        <div id="warn-data-libur" class="hidden rounded-lg border border-destructive/30 bg-destructive/10 px-3 py-2 text-xs text-destructive"></div>
      </div>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-save class="size-4 text-primary" />
            Aksi Pembaruan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-4">
          <div class="space-y-2 rounded-xl border border-border bg-muted/40 p-3.5 text-xs text-muted-foreground">
            <div class="flex items-center justify-between">
              <span>Dibuat:</span>
              <span class="font-bold text-foreground">{{ $jadwal->created_at ? $jadwal->created_at->translatedFormat('d M Y') : '-' }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span>Terakhir diubah:</span>
              <span class="font-bold text-foreground">{{ $jadwal->updated_at ? $jadwal->updated_at->translatedFormat('d M Y') : '-' }}</span>
            </div>
          </div>

          <div class="space-y-1.5 rounded-lg border border-amber-200 bg-amber-50/60 p-3 text-xs text-amber-900">
            <span class="block font-bold">Hari Tidak Aktif (Dilewati Otomatis):</span>
            <div class="space-y-1">
              <div class="flex items-center gap-1.5">
                <span class="size-3 shrink-0 rounded-sm bg-slate-300"></span>
                <span>Sabtu &amp; Minggu (weekend)</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="size-3 shrink-0 rounded-sm bg-amber-400"></span>
                <span>Hari libur nasional Indonesia</span>
              </div>
            </div>
          </div>

          <div class="space-y-2 pt-2">
            <x-ui.button type="submit" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              <x-lucide-check />
              Simpan Perubahan
            </x-ui.button>

            <x-ui.button href="{{ route('jadwal-pelatihan.index') }}" variant="secondary" class="w-full">
              Batal
            </x-ui.button>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="border-destructive/30 bg-destructive/5">
        <x-ui.card-header class="border-b border-destructive/20">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-destructive">
            <x-lucide-triangle-alert class="size-4" />
            Zona Berbahaya
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content>
          <p class="text-xs leading-relaxed text-muted-foreground">
            Menghapus batch jadwal ini akan menghapus seluruh data presensi dan penugasan kelas yang terhubung.
          </p>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection

@push('scripts')
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
      var warnDataLibur      = document.getElementById('warn-data-libur');
      var tahunTanpaData     = new Set();
      var warnTglMulai       = document.getElementById('warn-tgl-mulai');
      var warnTglMulaiText   = document.getElementById('warn-tgl-mulai-text');

      var cacheHariLibur  = {};
      var hariLiburSet    = new Set();
      var jumlahHariAktif = null;
      var jumlahJamTotal  = null;
      var durasiJamMenit  = null;

      // FIX TIMEZONE: Gunakan waktu LOKAL bukan UTC (toISOString).
      function toDateStr(d) {
        return d.getFullYear() + '-' +
          String(d.getMonth() + 1).padStart(2, '0') + '-' +
          String(d.getDate()).padStart(2, '0');
      }

      function fromStr(s) {
        var p = s.split('-');
        return new Date(+p[0], +p[1] - 1, +p[2]);
      }

      function hitungJamSelesai(totalHari, totalJam) {
        if (!totalHari || !totalJam) return;
        var jamPerHari = totalJam / totalHari;
        durasiJamMenit = Math.round(jamPerHari * 60);
        applyDurasiJam();
      }

      function applyDurasiJam() {
        if (!durasiJamMenit) return;
        var parts   = (jamMulai.value || '07:00').split(':');
        var mulaiMnt = (+parts[0]) * 60 + (+parts[1]);
        var endMnt   = mulaiMnt + durasiJamMenit;
        var endH     = Math.min(22, Math.floor(endMnt / 60));
        var endM     = (endH < 22) ? (endMnt % 60) : 0;
        jamSelesai.value = String(endH).padStart(2, '0') + ':' + String(endM).padStart(2, '0');
      }

      // ---- 1. Inisialisasi: baca durasi dari option terpilih ----
      function initDurasi() {
        var opt = selectPelatihan.options[selectPelatihan.selectedIndex];
        if (!opt) return;
        var hari = +(opt.getAttribute('data-hari') || 0);
        var jam  = +(opt.getAttribute('data-jam') || 0);

        if (hari > 0 && jam > 0) {
          jumlahHariAktif = hari;
          jumlahJamTotal  = jam;
          durasiJamMenit  = Math.round((jam / hari) * 60);
          var jph = (jam / hari % 1 === 0) ? (jam / hari) : (jam / hari).toFixed(1);
          infoDurasiText.textContent = 'Durasi: ' + hari + ' Hari Kerja / ' + jam + ' Total Jam (' + jph + ' jam/hari)';
          infoDurasi.classList.remove('hidden');
          infoDurasi.classList.add('flex');
        }
      }
      initDurasi();

      // ---- 2. Load preview dari data existing ----
      if (tglMulai.value && tglSelesai.value) {
        hintTglSelesai.classList.remove('hidden');
        muatHariLiburRentang(updatePreviewManual);
      }

      // ---- 3. Pilih program â†’ update durasi & hitung ulang ----
      selectPelatihan.addEventListener('change', function () {
        var opt  = this.options[this.selectedIndex];
        var hari = +(opt.getAttribute('data-hari') || 0);
        var jam  = +(opt.getAttribute('data-jam') || 0);

        if (hari > 0 && jam > 0) {
          jumlahHariAktif = hari;
          jumlahJamTotal  = jam;
          var jph = (jam / hari % 1 === 0) ? (jam / hari) : (jam / hari).toFixed(1);
          infoDurasiText.textContent = 'Durasi: ' + hari + ' Hari Kerja / ' + jam +
            ' Total Jam (' + jph + ' jam/hari) â€” Tanggal & jam selesai akan dihitung ulang.';
          infoDurasi.classList.remove('hidden');
          infoDurasi.classList.add('flex');
          hitungJamSelesai(hari, jam);
          if (tglMulai.value) hitungTanggalSelesai();
        } else {
          jumlahHariAktif = null;
          jumlahJamTotal  = null;
          infoDurasi.classList.add('hidden');
          infoDurasi.classList.remove('flex');
        }
      });

      jamMulai.addEventListener('input', function () {
        applyDurasiJam();
      });
      jamMulai.addEventListener('change', function () {
        applyDurasiJam();
        validateJam();
      });

      // ---- 4. Fetch hari libur (cached) ----
      function fetchHariLibur(tahun) {
        if (cacheHariLibur[tahun]) return Promise.resolve(cacheHariLibur[tahun]);
        return fetch('{{ route("hari-libur.index") }}?tahun=' + tahun, {
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
        .then(function (d) {
          if (!d.tersedia) tahunTanpaData.add(tahun); else tahunTanpaData.delete(tahun);
          return (cacheHariLibur[tahun] = d.hari_libur || []);
        })
        .catch(function () { tahunTanpaData.add(tahun); return []; });
      }

      // ---- 5. Helpers ----
      function isLibur(ds) {
        var dow = new Date(ds + 'T00:00:00').getDay();
        return dow === 0 || dow === 6 || hariLiburSet.has(ds);
      }

      function formatTgl(ds) {
        return new Date(ds + 'T00:00:00').toLocaleDateString('id-ID', {
          weekday: 'short', day: 'numeric', month: 'short', year: 'numeric'
        });
      }

      var HARI = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

      function cekDataLibur() {
        if (!tglMulai.value || !tglSelesai.value) { warnDataLibur.classList.add('hidden'); return; }
        var t1 = +tglMulai.value.split('-')[0], t2 = +tglSelesai.value.split('-')[0];
        var kosong = [];
        for (var t = t1; t <= t2; t++) { if (tahunTanpaData.has(t)) kosong.push(t); }

        if (kosong.length) {
          warnDataLibur.textContent = 'Data libur nasional tahun ' + kosong.join(', ') +
            ' belum tersedia. Tanggal selesai hanya melewati Sabtu & Minggu â€” periksa manual.';
          warnDataLibur.classList.remove('hidden');
        } else {
          warnDataLibur.classList.add('hidden');
        }
      }

      function muatHariLiburRentang(callback) {
        var t1 = +tglMulai.value.split('-')[0], t2 = +tglSelesai.value.split('-')[0];
        var jobs = [];
        for (var t = t1; t <= t2; t++) jobs.push(fetchHariLibur(t));
        Promise.all(jobs).then(function (res) {
          var semua = [];
          res.forEach(function (r) { semua = semua.concat(r); });
          hariLiburSet = new Set(semua);
          callback();
        });
      }

      // ---- 6. Hitung tanggal selesai (skip hari libur) ----
      function hitungTanggalSelesai() {
        if (!tglMulai.value || !jumlahHariAktif) return;
        loadingTglSelesai.classList.remove('hidden');
        hintTglSelesai.classList.remove('hidden');
        var tahun = +tglMulai.value.split('-')[0];

        Promise.all([fetchHariLibur(tahun), fetchHariLibur(tahun + 1)]).then(function (res) {
          hariLiburSet = new Set(res[0].concat(res[1]));
          var cur   = fromStr(tglMulai.value);
          var aktif = 0, dilewati = [], i = 0;

          var s0 = toDateStr(cur);
          if (isLibur(s0)) {
            var dow = cur.getDay();
            warnTglMulaiText.textContent = (dow === 0 || dow === 6)
              ? 'Tanggal mulai jatuh pada hari ' + HARI[dow] + '. Pelatihan akan dimulai hari kerja berikutnya.'
              : 'Tanggal mulai (' + formatTgl(s0) + ') adalah hari libur nasional. Pelatihan akan dimulai hari kerja berikutnya.';
            warnTglMulai.classList.remove('hidden');
            warnTglMulai.classList.add('flex');
          } else {
            warnTglMulai.classList.add('hidden');
            warnTglMulai.classList.remove('flex');
          }

          while (aktif < jumlahHariAktif && i < 730) {
            var ds = toDateStr(cur);
            if (!isLibur(ds)) {
              aktif++;
              if (aktif === jumlahHariAktif) break;
            } else {
              if (dilewati.length < 30) dilewati.push(ds);
            }
            if (aktif < jumlahHariAktif) cur.setDate(cur.getDate() + 1);
            i++;
          }

          var selesai = toDateStr(cur);
          tglSelesai.min   = tglMulai.value;
          tglSelesai.value = selesai;

          var diff = Math.round((fromStr(selesai) - fromStr(tglMulai.value)) / 86400000) + 1;
          prevTotalHari.textContent     = jumlahHariAktif;
          if (prevTotalJam) prevTotalJam.textContent = jumlahJamTotal || '-';
          prevTotalLibur.textContent    = dilewati.length;
          prevTotalKalender.textContent = diff;
          badgeHariEfektif.textContent  = jumlahHariAktif + ' Hari Aktif';
          renderChip(dilewati);
          cekDataLibur();
          previewJadwal.classList.remove('hidden');
          loadingTglSelesai.classList.add('hidden');
        });
      }

      function renderChip(arr) {
        listLibur.innerHTML = '';
        arr.forEach(function (d) {
          var dow = new Date(d + 'T00:00:00').getDay();
          var c = document.createElement('span');
          c.className = 'text-[10px] font-semibold px-2 py-0.5 rounded-full ' + (dow === 0 || dow === 6 ? 'bg-muted text-muted-foreground' : 'bg-amber-100 text-amber-800');
          c.textContent = formatTgl(d);
          listLibur.appendChild(c);
        });
        arr.length > 0 ? listLiburContainer.classList.remove('hidden') : listLiburContainer.classList.add('hidden');
      }

      // ---- 7. Events tanggal ----
      tglMulai.addEventListener('change', function () {
        if (!this.value) return;
        var nd = fromStr(this.value);
        nd.setDate(nd.getDate() + 1);
        tglSelesai.min = toDateStr(nd);
        if (tglSelesai.value && tglSelesai.value <= this.value) {
          alert('Tanggal selesai harus setelah tanggal mulai!');
          tglSelesai.value = '';
        }
        if (jumlahHariAktif) hitungTanggalSelesai();
      });

      tglSelesai.addEventListener('change', function () {
        if (!this.value) return;
        if (this.value <= tglMulai.value) {
          alert('Tanggal selesai harus setelah tanggal mulai!');
          this.value = '';
          return;
        }
        if (tglMulai.value && tglSelesai.value) {
          hintTglSelesai.classList.remove('hidden');
          muatHariLiburRentang(updatePreviewManual);
        }
      });

      function updatePreviewManual() {
        if (!tglMulai.value || !tglSelesai.value) return;
        var cur = fromStr(tglMulai.value), end = fromStr(tglSelesai.value);
        var aktif = 0, arr = [];
        while (cur <= end) {
          var ds = toDateStr(cur);
          if (!isLibur(ds)) {
            aktif++;
          } else {
            if (arr.length < 30) arr.push(ds);
          }
          cur.setDate(cur.getDate() + 1);
        }
        var diff = Math.round((fromStr(tglSelesai.value) - fromStr(tglMulai.value)) / 86400000) + 1;
        var jamAktual = (jumlahHariAktif && jumlahJamTotal && aktif)
          ? Math.round(aktif * (jumlahJamTotal / jumlahHariAktif))
          : (jumlahJamTotal || '-');
        prevTotalHari.textContent     = aktif;
        if (prevTotalJam) prevTotalJam.textContent = jamAktual;
        prevTotalLibur.textContent    = arr.length;
        prevTotalKalender.textContent = diff;
        badgeHariEfektif.textContent  = aktif + ' Hari Aktif';
        renderChip(arr);
        cekDataLibur();
        previewJadwal.classList.remove('hidden');
      }

      // ---- 8. Validasi jam ----
      function validateJam() {
        if (jamMulai.value && jamSelesai.value && jamSelesai.value <= jamMulai.value) {
          alert('Jam selesai harus lebih dari jam mulai!');
          jamSelesai.value = '';
        }
      }
      jamSelesai.addEventListener('change', validateJam);
      validateJam();

      var btnLoc = document.getElementById('btn-use-current-location');
      if (btnLoc && navigator.geolocation) {
        btnLoc.addEventListener('click', function () {
          btnLoc.innerHTML = '<span class="inline-block animate-spin mr-1">âŒ›</span> Mendeteksi...';
          navigator.geolocation.getCurrentPosition(function (pos) {
            document.getElementById('lokasi_latitude').value  = pos.coords.latitude.toFixed(7);
            document.getElementById('lokasi_longitude').value = pos.coords.longitude.toFixed(7);
            btnLoc.innerHTML = 'âœ” Berhasil';
            setTimeout(function () {
              btnLoc.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><circle cx="12" cy="12" r="10"/><path d="M22 12h-4M6 12H2M12 6V2M12 22v-4"/></svg> Ambil GPS Saat Ini';
            }, 2000);
          }, function (err) {
            alert('Gagal mengambil lokasi: ' + err.message);
            btnLoc.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><circle cx="12" cy="12" r="10"/><path d="M22 12h-4M6 12H2M12 6V2M12 22v-4"/></svg> Ambil GPS Saat Ini';
          }, { enableHighAccuracy: true });
        });
      }
    });
  </script>
@endpush
