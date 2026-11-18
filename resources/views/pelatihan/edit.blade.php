@extends('layouts.app')

@section('title', 'Edit Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
  <x-ui.page-header
    title="Edit Program Pelatihan"
    description="Perbarui kapasitas kuota, rincian jam pelajaran, penanggung jawab instruktur, atau deskripsi silabus kejuruan."
  >
    <x-slot:actions>
      <x-ui.badge variant="secondary" class="gap-1.5 uppercase tracking-wide">
        <span class="size-1.5 rounded-full bg-sikarir-lime"></span>
        Pembaruan Kurikulum
      </x-ui.badge>

      <x-ui.button href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}" variant="outline">
        <x-lucide-eye />
        Lihat Detail
      </x-ui.button>

      <x-ui.button href="{{ route('pelatihan.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  @if ($errors->any())
    <x-ui.alert tone="danger">
      <x-lucide-circle-alert />
      <x-ui.alert-title>Periksa kembali beberapa input berikut:</x-ui.alert-title>
      <x-ui.alert-description>
        <ul class="list-inside list-disc space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </x-ui.alert-description>
    </x-ui.alert>
  @endif

  <form action="{{ route('pelatihan.update', $pelatihan->id_pelatihan) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-book-open class="size-4" />
              </span>
              <div>
                <x-ui.card-title class="text-base font-bold">Informasi Kejuruan & Kurikulum</x-ui.card-title>
                <x-ui.card-description>Sesuaikan kurikulum pelatihan vokasi BLK.</x-ui.card-description>
              </div>
            </div>

            <x-ui.badge tone="success" class="font-mono">
              #PLT-{{ str_pad((string) $pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <x-ui.field data-invalid="{{ $errors->has('nama_pelatihan') ? 'true' : 'false' }}">
            <x-ui.field-label for="nama_pelatihan">Nama Program Kejuruan</x-ui.field-label>
            <x-ui.input
              id="nama_pelatihan"
              name="nama_pelatihan"
              type="text"
              :value="old('nama_pelatihan', $pelatihan->nama_pelatihan)"
              required
            />
            <x-ui.field-error :messages="$errors->get('nama_pelatihan')" />
          </x-ui.field>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('kuota') ? 'true' : 'false' }}">
              <x-ui.field-label for="kuota">Kapasitas Kuota Peserta</x-ui.field-label>
              <div class="relative">
                <x-ui.input
                  id="kuota"
                  name="kuota"
                  type="number"
                  :value="old('kuota', $pelatihan->kuota)"
                  min="1"
                  class="pr-16"
                  required
                />
                <span class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-xs font-semibold text-muted-foreground">
                  Siswa
                </span>
              </div>
              <x-ui.field-error :messages="$errors->get('kuota')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('id_durasi') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_durasi">Standar Durasi Belajar</x-ui.field-label>
              <x-ui.select name="id_durasi" id="id_durasi" native class="w-full">
                <option value="">-- Pilih Durasi Pelatihan --</option>
                @foreach ($durations as $durasi)
                  <option value="{{ $durasi->id_durasi }}" @selected(old('id_durasi', $pelatihan->id_durasi) == $durasi->id_durasi)>
                    {{ $durasi->durasi_label }}
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_durasi')" />
            </x-ui.field>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('id_admin') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_admin">Penanggung Jawab / Pembina Kejuruan</x-ui.field-label>
            <x-ui.select name="id_admin" id="id_admin" native class="w-full" required>
              <option value="">-- Pilih Instruktur / Admin BLK --</option>
              @foreach ($admins as $admin)
                <option value="{{ $admin->id_admin }}" @selected(old('id_admin', $pelatihan->id_admin) == $admin->id_admin)>
                  {{ $admin->user->name ?? 'Admin BLK' }} (NIP: {{ $admin->nip ?? '-' }})
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('id_admin')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('deskripsi_pelatihan') ? 'true' : 'false' }}">
            <x-ui.field-label for="deskripsi_pelatihan">Deskripsi Silabus & Output Kompetensi</x-ui.field-label>
            <x-ui.textarea
              id="deskripsi_pelatihan"
              name="deskripsi_pelatihan"
              rows="5"
              placeholder="Jelaskan ringkasan materi, standar kompetensi kerja, kurikulum kejuruan, dan sertifikasi BNSP..."
            >{{ old('deskripsi_pelatihan', $pelatihan->deskripsi_pelatihan) }}</x-ui.textarea>
            <x-ui.field-error :messages="$errors->get('deskripsi_pelatihan')" />
          </x-ui.field>
        </x-ui.card-content>
      </x-ui.card>
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
            <div class="flex items-center justify-between gap-3">
              <span>Dibuat:</span>
              <span class="font-bold text-foreground">
                {{ $pelatihan->created_at ? $pelatihan->created_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
            <div class="flex items-center justify-between gap-3">
              <span>Terakhir diubah:</span>
              <span class="font-bold text-foreground">
                {{ $pelatihan->updated_at ? $pelatihan->updated_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
          </div>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-check />
            Simpan Perubahan
          </x-ui.button>

          <x-ui.button href="{{ route('pelatihan.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>

      @php $adaGambar = (bool) $pelatihan->gambar_url; @endphp

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-image class="size-4 text-primary" />
            Poster Program
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <label
            for="gambar"
            id="dropzone"
            class="relative flex h-48 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-border bg-muted/40 transition hover:border-primary hover:bg-accent/50 @error('gambar') border-destructive @enderror"
          >
            <div id="upload-placeholder" class="{{ $adaGambar ? 'hidden' : 'flex' }} flex-col items-center gap-2 px-4 text-center">
              <x-lucide-upload-cloud class="size-8 text-muted-foreground" />
              <p class="text-xs font-bold text-foreground">Klik untuk upload gambar</p>
              <p class="text-[11px] text-muted-foreground">JPG, PNG, WEBP. Maks 2 MB.</p>
            </div>

            <img
              id="upload-preview"
              src="{{ $pelatihan->gambar_url }}"
              alt="Preview poster"
              class="{{ $adaGambar ? '' : 'hidden' }} absolute inset-0 size-full object-cover"
            >
            <input type="file" name="gambar" id="gambar" accept="image/png,image/jpeg,image/webp" class="hidden">
          </label>

          <input type="hidden" name="hapus_gambar" id="hapus_gambar" value="0">

          <x-ui.button
            type="button"
            id="remove-image"
            variant="ghost"
            size="sm"
            class="{{ $adaGambar ? '' : 'hidden' }} w-full text-destructive hover:bg-destructive/10 hover:text-destructive"
          >
            Hapus gambar
          </x-ui.button>

          <x-ui.field-error :messages="$errors->get('gambar')" />
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection

@push('scripts')
  <script>
    const input = document.getElementById('gambar');
    const preview = document.getElementById('upload-preview');
    const placeholder = document.getElementById('upload-placeholder');
    const removeBtn = document.getElementById('remove-image');
    const hapusInput = document.getElementById('hapus_gambar');
    const adaGambarLama = {{ $adaGambar ? 'true' : 'false' }};

    input.addEventListener('change', () => {
      const file = input.files[0];
      if (!file) return;
      if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 2 MB.');
        input.value = '';
        return;
      }
      preview.src = URL.createObjectURL(file);
      preview.classList.remove('hidden');
      placeholder.classList.add('hidden');
      placeholder.classList.remove('flex');
      removeBtn.classList.remove('hidden');
      hapusInput.value = '0';
    });

    removeBtn.addEventListener('click', () => {
      input.value = '';
      preview.removeAttribute('src');
      preview.classList.add('hidden');
      placeholder.classList.remove('hidden');
      placeholder.classList.add('flex');
      removeBtn.classList.add('hidden');
      hapusInput.value = adaGambarLama ? '1' : '0';
    });
  </script>
@endpush
