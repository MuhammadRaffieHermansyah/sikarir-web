@extends('layouts.app')

@section('title', 'Edit Lowongan - ' . $lowongan->judul_lowongan)

@section('content')
  <x-ui.page-header
    title="Perbarui Informasi Lowongan Magang"
    description="Ubah deskripsi posisi, kualifikasi, lokasi, atau status publikasi lowongan."
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
            <x-ui.breadcrumb-page>Edit Lowongan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" variant="outline">
        <x-lucide-eye />
        Lihat Detail
      </x-ui.button>

      <x-ui.button href="{{ route('lowongan.index') }}" variant="outline">
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

  <form
    action="{{ route('lowongan.update', $lowongan->id_lowongan) }}"
    method="POST"
    enctype="multipart/form-data"
    class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3"
  >
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-briefcase class="size-4" />
              </span>
              <x-ui.card-title class="text-base font-bold">Informasi Posisi & Perusahaan</x-ui.card-title>
            </div>

            <x-ui.badge variant="secondary" class="font-mono">
              ID: #LWG-{{ str_pad((string) $lowongan->id_lowongan, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <div class="flex items-center gap-3 rounded-lg border border-border bg-accent/40 p-3.5">
            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-primary text-xs font-bold uppercase text-primary-foreground">
              {{ strtoupper(substr($lowongan->mitra->nama_perusahaan ?? 'M', 0, 2)) }}
            </span>
            <div>
              <div class="text-xs font-medium text-muted-foreground">Perusahaan Penerbit Lowongan</div>
              <div class="text-xs font-bold text-foreground">
                {{ $lowongan->mitra->nama_perusahaan ?? '-' }} ({{ $lowongan->mitra->bidang_usaha ?? 'Mitra DU/DI' }})
              </div>
            </div>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('judul_lowongan') ? 'true' : 'false' }}">
            <x-ui.field-label for="judul_lowongan">Judul Posisi Lowongan <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.input
              id="judul_lowongan"
              name="judul_lowongan"
              type="text"
              :value="old('judul_lowongan', $lowongan->judul_lowongan)"
            />
            <x-ui.field-error :messages="$errors->get('judul_lowongan')" />
          </x-ui.field>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('lokasi') ? 'true' : 'false' }}">
              <x-ui.field-label for="lokasi">Lokasi Penempatan</x-ui.field-label>
              <x-ui.input id="lokasi" name="lokasi" type="text" :value="old('lokasi', $lowongan->lokasi)" />
              <x-ui.field-error :messages="$errors->get('lokasi')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tanggal_posting') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal_posting">Tanggal Posting</x-ui.field-label>
              <x-ui.input
                id="tanggal_posting"
                name="tanggal_posting"
                type="date"
                :value="old('tanggal_posting', $lowongan->tanggal_posting ? $lowongan->tanggal_posting->format('Y-m-d') : '')"
              />
              <x-ui.field-error :messages="$errors->get('tanggal_posting')" />
            </x-ui.field>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('status') ? 'true' : 'false' }}">
            <x-ui.field-label for="status">Status Publikasi <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="status" id="status" native class="w-full">
              <option value="aktif" @selected(old('status', $lowongan->status) == 'aktif')>Aktif</option>
              <option value="draft" @selected(old('status', $lowongan->status) == 'draft')>Draft</option>
              <option value="ditutup" @selected(old('status', $lowongan->status) == 'ditutup')>Ditutup</option>
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('status')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('deskripsi') ? 'true' : 'false' }}">
            <x-ui.field-label for="deskripsi">Deskripsi Pekerjaan</x-ui.field-label>
            <x-ui.textarea id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $lowongan->deskripsi) }}</x-ui.textarea>
            <x-ui.field-error :messages="$errors->get('deskripsi')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('kualifikasi') ? 'true' : 'false' }}">
            <x-ui.field-label for="kualifikasi">Kualifikasi & Persyaratan</x-ui.field-label>
            <x-ui.textarea id="kualifikasi" name="kualifikasi" rows="4">{{ old('kualifikasi', $lowongan->kualifikasi) }}</x-ui.textarea>
            <x-ui.field-error :messages="$errors->get('kualifikasi')" />
          </x-ui.field>
        </x-ui.card-content>
      </x-ui.card>
    </div>

    <div class="space-y-6">
      @php($adaGambar = (bool) $lowongan->gambar_url)

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
            <span id="upload-placeholder" class="{{ $adaGambar ? 'hidden' : 'flex' }} flex-col items-center gap-2 px-4 text-center">
              <x-lucide-upload-cloud class="size-7 text-muted-foreground" />
              <span class="text-xs font-semibold text-foreground">Klik untuk upload foto</span>
              <span class="text-[11px] text-muted-foreground">JPG, PNG, WEBP. Maks 2 MB.</span>
            </span>
            <img id="upload-preview" src="{{ $lowongan->gambar_url }}" alt="Preview foto lowongan"
              class="{{ $adaGambar ? '' : 'hidden' }} absolute inset-0 size-full object-cover" />
            <input type="file" name="gambar" id="gambar" accept="image/png,image/jpeg,image/webp" class="hidden" />
          </label>

          <input type="hidden" name="hapus_gambar" id="hapus_gambar" value="0">

          <button type="button" id="remove-image"
            class="{{ $adaGambar ? '' : 'hidden' }} w-full rounded-lg bg-destructive/10 py-2 text-xs font-semibold text-destructive transition hover:bg-destructive/15">
            Hapus gambar
          </button>

          <x-ui.field-error :messages="$errors->get('gambar')" />
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-save class="size-4 text-primary" />
            Aksi Pembaruan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-4">
          <div class="space-y-2 rounded-xl border border-border bg-muted/40 p-3.5 text-xs text-muted-foreground">
            <div class="flex items-center justify-between gap-3">
              <span>Diposting:</span>
              <span class="font-bold text-foreground">
                {{ $lowongan->created_at ? $lowongan->created_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
          </div>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-check />
            Simpan Perubahan
          </x-ui.button>

          <x-ui.button href="{{ route('lowongan.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
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
            Tutup lowongan dengan mengubah status menjadi "Ditutup" agar tidak menerima pendaftar baru.
          </p>
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
      const gambarHapus = document.getElementById('hapus_gambar');

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
          gambarHapus.value = '0';
      });

      gambarRemove?.addEventListener('click', () => {
          gambarInput.value = '';
          gambarPreview.src = '';
          gambarPreview.classList.add('hidden');
          gambarPlaceholder.classList.remove('hidden');
          gambarRemove.classList.add('hidden');
          gambarHapus.value = '1';
      });
  </script>
@endpush
