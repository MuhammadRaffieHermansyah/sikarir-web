@extends('layouts.app')

@section('title', 'Buka Lowongan Magang - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Publikasikan Lowongan Magang Industri"
    description="Buat posting lowongan baru dari mitra DU/DI untuk penyaluran siswa lulusan vokasi BLK."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('lowongan.index') }}">Lowongan Magang</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Tambah Lowongan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('lowongan.index') }}" variant="outline">
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

  <form action="{{ route('lowongan.store') }}" method="POST" enctype="multipart/form-data"
    class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-briefcase class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Informasi Posisi & Perusahaan</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <div class="flex items-center gap-3 rounded-lg border border-border bg-accent/40 p-3.5">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-primary text-xs font-bold uppercase text-primary-foreground">
              {{ strtoupper(substr($mitra->nama_perusahaan ?? 'M', 0, 2)) }}
            </span>
            <div>
              <div class="text-xs font-medium text-muted-foreground">Perusahaan Penerbit Lowongan</div>
              <div class="text-xs font-bold text-foreground">
                {{ $mitra->nama_perusahaan ?? '-' }} ({{ $mitra->bidang_usaha ?? 'Mitra DU/DI' }})
              </div>
            </div>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('judul_lowongan') ? 'true' : 'false' }}">
            <x-ui.field-label for="judul_lowongan">Judul Posisi Lowongan <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.input
              id="judul_lowongan"
              name="judul_lowongan"
              type="text"
              :value="old('judul_lowongan')"
              placeholder="Contoh: Teknisi Mesin CNC / Staff Administrasi Gudang"
            />
            <x-ui.field-error :messages="$errors->get('judul_lowongan')" />
          </x-ui.field>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('lokasi') ? 'true' : 'false' }}">
              <x-ui.field-label for="lokasi">Lokasi Penempatan</x-ui.field-label>
              <x-ui.input
                id="lokasi"
                name="lokasi"
                type="text"
                :value="old('lokasi')"
                placeholder="Contoh: Bandung, Jawa Barat"
              />
              <x-ui.field-error :messages="$errors->get('lokasi')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tanggal_posting') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal_posting">Tanggal Posting</x-ui.field-label>
              <x-ui.input
                id="tanggal_posting"
                name="tanggal_posting"
                type="date"
                min="{{ date('Y-m-d') }}"
                :value="old('tanggal_posting', date('Y-m-d'))"
              />
              <x-ui.field-error :messages="$errors->get('tanggal_posting')" />
            </x-ui.field>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('status') ? 'true' : 'false' }}">
            <x-ui.field-label for="status">Status Publikasi <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="status" id="status" native class="w-full" required>
              <option value="aktif" @selected(old('status', 'aktif') == 'aktif')>Aktif (Langsung Dipublikasikan)</option>
              <option value="draft" @selected(old('status') == 'draft')>Draft (Belum Dipublikasikan)</option>
              <option value="ditutup" @selected(old('status') == 'ditutup')>Ditutup (Tidak Menerima Pendaftar)</option>
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('status')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('deskripsi') ? 'true' : 'false' }}">
            <x-ui.field-label for="deskripsi">Deskripsi Pekerjaan & Tanggung Jawab</x-ui.field-label>
            <x-ui.textarea
              id="deskripsi"
              name="deskripsi"
              rows="4"
              placeholder="Jelaskan peran, tanggung jawab, dan manfaat magang di perusahaan ini..."
            >{{ old('deskripsi') }}</x-ui.textarea>
            <x-ui.field-error :messages="$errors->get('deskripsi')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('kualifikasi') ? 'true' : 'false' }}">
            <x-ui.field-label for="kualifikasi">Kualifikasi & Persyaratan Peserta</x-ui.field-label>
            <x-ui.textarea
              id="kualifikasi"
              name="kualifikasi"
              rows="4"
              placeholder="Contoh: Minimal lulus program las, mampu membaca gambar teknik, sehat jasmani/rohani..."
            >{{ old('kualifikasi') }}</x-ui.textarea>
            <x-ui.field-error :messages="$errors->get('kualifikasi')" />
          </x-ui.field>
        </x-ui.card-content>
      </x-ui.card>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-image class="size-4 text-primary" />
            Foto Lowongan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <label for="gambar" id="dropzone"
            class="relative flex h-44 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-border bg-muted/40 transition hover:border-primary hover:bg-accent/40">
            <span id="upload-placeholder" class="flex flex-col items-center gap-2 px-4 text-center">
              <x-lucide-upload-cloud class="size-7 text-muted-foreground" />
              <span class="text-xs font-semibold text-foreground">Klik untuk upload foto</span>
              <span class="text-[11px] text-muted-foreground">JPG, PNG, WEBP. Maks 2 MB.</span>
            </span>
            <img id="upload-preview" src="" alt="Preview foto" class="absolute inset-0 hidden size-full object-cover" />
            <input type="file" name="gambar" id="gambar" accept="image/png,image/jpeg,image/webp" class="hidden" />
          </label>

          <button type="button" id="remove-image"
            class="hidden w-full rounded-lg bg-destructive/10 py-2 text-xs font-semibold text-destructive transition hover:bg-destructive/15">
            Hapus gambar
          </button>

          <x-ui.field-error :messages="$errors->get('gambar')" />
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-info class="size-4 text-primary" />
            Panduan Lowongan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Pastikan mitra DU/DI sudah terdaftar di sistem sebelum membuka lowongan. Lowongan akan langsung tampil
            di portal jika statusnya <strong class="text-foreground">Aktif</strong>.
          </p>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-save />
            Publikasikan Lowongan
          </x-ui.button>

          <x-ui.button href="{{ route('lowongan.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection

@push('scripts')
  <script>
      const gambarInput = document.getElementById('gambar');
      const gambarPreview = document.getElementById('upload-preview');
      const gambarPlaceholder = document.getElementById('upload-placeholder');
      const gambarRemove = document.getElementById('remove-image');

      gambarInput?.addEventListener('change', () => {
          const file = gambarInput.files[0];
          if (!file) return;
          if (file.size > 2 * 1024 * 1024) {
              alert('Ukuran gambar maksimal 2 MB.');
              gambarInput.value = '';
              return;
          }
          gambarPreview.src = URL.createObjectURL(file);
          gambarPreview.classList.remove('hidden');
          gambarPlaceholder.classList.add('hidden');
          gambarRemove.classList.remove('hidden');
      });

      gambarRemove?.addEventListener('click', () => {
          gambarInput.value = '';
          gambarPreview.src = '';
          gambarPreview.classList.add('hidden');
          gambarPlaceholder.classList.remove('hidden');
          gambarRemove.classList.add('hidden');
      });
  </script>
@endpush
