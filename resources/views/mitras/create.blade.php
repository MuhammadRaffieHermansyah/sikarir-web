@extends('layouts.app')

@section('title', 'Tambah Mitra Industri DU/DI - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Registrasi Kemitraan Industri (DU/DI)"
    description="Daftarkan perusahaan rekanan untuk penempatan magang vokasi dan rekrutmen lulusan balai."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('mitras.index') }}">Mitra DU/DI</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Tambah Mitra Baru</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('mitras.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali ke Daftar
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

  <form action="{{ route('mitras.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-building-2 class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Identitas Perusahaan / Industri</x-ui.card-title>
              <x-ui.card-description>Informasi resmi badan usaha atau instansi rekanan.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <div class="flex flex-col items-start gap-5 sm:flex-row">
            <div id="logo-preview-wrap" class="relative size-24 shrink-0 overflow-hidden rounded-xl border-2 border-dashed border-border bg-muted">
              <span id="logo-placeholder" class="absolute inset-0 flex items-center justify-center text-muted-foreground">
                <x-lucide-image class="size-7" />
              </span>
              <img id="logo-preview-img" src="" alt="Preview Logo" class="absolute inset-0 hidden size-full object-cover">
            </div>

            <div class="w-full flex-1">
              <x-ui.field-label for="logo_perusahaan">Logo Perusahaan <span class="text-destructive">*</span></x-ui.field-label>
              <label
                for="logo_perusahaan"
                class="mt-1.5 flex w-full cursor-pointer items-center gap-3 rounded-lg border border-border bg-muted/40 px-3.5 py-2.5 transition hover:border-primary/40 hover:bg-accent/40"
              >
                <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                  <x-lucide-upload-cloud class="size-4" />
                </span>
                <div>
                  <div id="logo-filename" class="text-xs font-semibold text-foreground">Klik untuk pilih file logo</div>
                  <div class="text-xs text-muted-foreground">PNG, JPG, WEBP, SVG · Maks. 2MB</div>
                </div>
              </label>
              <input type="file" id="logo_perusahaan" name="logo_perusahaan" accept="image/*" class="sr-only" onchange="previewLogo(this)">
              <x-ui.field-error :messages="$errors->get('logo_perusahaan')" />
            </div>
          </div>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('nama_perusahaan') ? 'true' : 'false' }}">
              <x-ui.field-label for="nama_perusahaan">Nama Perusahaan / PT / CV <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input
                id="nama_perusahaan"
                name="nama_perusahaan"
                type="text"
                :value="old('nama_perusahaan')"
                placeholder="Contoh: PT Astra Honda Motor"
              />
              <x-ui.field-error :messages="$errors->get('nama_perusahaan')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('bidang_usaha') ? 'true' : 'false' }}">
              <x-ui.field-label for="bidang_usaha">Bidang Usaha / Sektor</x-ui.field-label>
              <x-ui.input
                id="bidang_usaha"
                name="bidang_usaha"
                type="text"
                :value="old('bidang_usaha')"
                placeholder="Contoh: Otomotif & Manufaktur"
              />
              <x-ui.field-error :messages="$errors->get('bidang_usaha')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jenis_mitra') ? 'true' : 'false' }}">
              <x-ui.field-label for="jenis_mitra">Jenis Kemitraan</x-ui.field-label>
              <x-ui.select name="jenis_mitra" id="jenis_mitra" native class="w-full">
                <option value="BUMN / BUMD">BUMN / BUMD</option>
                <option value="Perusahaan Swasta Nasional" selected>Perusahaan Swasta Nasional</option>
                <option value="PMA / Multinasional">PMA / Multinasional</option>
                <option value="Instansi Pemerintah / Lembaga">Instansi Pemerintah / Lembaga</option>
                <option value="UMKM / Startup">UMKM / Startup</option>
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('jenis_mitra')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('no_izin') ? 'true' : 'false' }}">
              <x-ui.field-label for="no_izin">Nomor Izin Usaha / NIB</x-ui.field-label>
              <x-ui.input
                id="no_izin"
                name="no_izin"
                type="text"
                :value="old('no_izin')"
                placeholder="Nomor NIB / Legalitas"
              />
              <x-ui.field-error :messages="$errors->get('no_izin')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('id_user') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_user">Tautkan Akun User (Opsional)</x-ui.field-label>
              <x-ui.select name="id_user" id="id_user" native class="w-full">
                <option value="">-- Tanpa Akun Pengguna Khusus --</option>
                @foreach ($users ?? [] as $user)
                  <option value="{{ $user->id }}" @selected(old('id_user') == $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_user')" />
            </x-ui.field>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-map-pin class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Lokasi & Penanggung Jawab (PIC)</x-ui.card-title>
              <x-ui.card-description>Alamat operasional kantor dan kontak representatif HRD / Pembimbing Industri.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('kota') ? 'true' : 'false' }}">
              <x-ui.field-label for="kota">Kota / Kabupaten</x-ui.field-label>
              <x-ui.input id="kota" name="kota" type="text" :value="old('kota')" placeholder="Contoh: Jakarta Pusat" />
              <x-ui.field-error :messages="$errors->get('kota')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('provinsi') ? 'true' : 'false' }}">
              <x-ui.field-label for="provinsi">Provinsi</x-ui.field-label>
              <x-ui.input id="provinsi" name="provinsi" type="text" :value="old('provinsi')" placeholder="Contoh: DKI Jakarta" />
              <x-ui.field-error :messages="$errors->get('provinsi')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('no_telp') ? 'true' : 'false' }}">
              <x-ui.field-label for="no_telp">Nomor Telepon / WhatsApp Kantor</x-ui.field-label>
              <x-ui.input
                id="no_telp"
                name="no_telp"
                type="text"
                :value="old('no_telp')"
                placeholder="Contoh: 021-5551234 atau 08123456789"
              />
              <x-ui.field-error :messages="$errors->get('no_telp')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jabatan_pic') ? 'true' : 'false' }}">
              <x-ui.field-label for="jabatan_pic">Jabatan PIC / HRD</x-ui.field-label>
              <x-ui.input
                id="jabatan_pic"
                name="jabatan_pic"
                type="text"
                :value="old('jabatan_pic')"
                placeholder="Contoh: HR & People Development Head"
              />
              <x-ui.field-error :messages="$errors->get('jabatan_pic')" />
            </x-ui.field>

            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('alamat') ? 'true' : 'false' }}">
              <x-ui.field-label for="alamat">Alamat Lengkap Perusahaan</x-ui.field-label>
              <x-ui.textarea id="alamat" name="alamat" rows="3" placeholder="Jl. Jendral Sudirman Kav. XX, Gedung...">{{ old('alamat') }}</x-ui.textarea>
              <x-ui.field-error :messages="$errors->get('alamat')" />
            </x-ui.field>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <div class="flex items-center justify-end gap-2">
        <x-ui.button href="{{ route('mitras.index') }}" variant="outline">
          Batalkan
        </x-ui.button>

        <x-ui.button type="submit" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
          <x-lucide-save />
          Simpan Data Mitra
        </x-ui.button>
      </div>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-info class="size-4 text-primary" />
            Ketentuan Kemitraan DU/DI
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content>
          <ul class="space-y-3 text-xs text-muted-foreground">
            <li class="flex items-start gap-2">
              <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
              <span>Mitra yang terdaftar berhak mempublikasikan lowongan magang industri di portal.</span>
            </li>
            <li class="flex items-start gap-2">
              <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
              <span>Peserta pelatihan vokasi dapat ditempatkan sesuai kesesuaian kurikulum kejuruan.</span>
            </li>
            <li class="flex items-start gap-2">
              <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
              <span>Evaluasi dan monitoring jurnal harian terintegrasi dengan pembimbing industri.</span>
            </li>
          </ul>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card class="border-primary/30 bg-gradient-to-br from-primary to-[#0a2f26] text-primary-foreground">
        <div class="flex items-center gap-2 text-xs font-bold text-sikarir-lime">
          <x-lucide-handshake class="size-4" />
          <span>Link and Match Vokasi</span>
        </div>
        <p class="mt-3 text-xs leading-relaxed text-primary-foreground/80">
          Kerjasama industri menjamin kompetensi lulusan BLK sesuai kebutuhan riil pasar kerja nasional dan global.
        </p>
      </x-ui.card>
    </div>
  </form>
@endsection

@push('scripts')
  <script>
    function previewLogo(input) {
      const img = document.getElementById('logo-preview-img');
      const placeholder = document.getElementById('logo-placeholder');
      const filename = document.getElementById('logo-filename');

      if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = (event) => {
          img.src = event.target.result;
          img.classList.remove('hidden');
          placeholder.classList.add('hidden');
        };

        reader.readAsDataURL(input.files[0]);
        filename.textContent = input.files[0].name;
      }
    }
  </script>
@endpush
