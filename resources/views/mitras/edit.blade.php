@extends('layouts.app')

@section('title', 'Edit Mitra DU/DI - ' . $mitra->nama_perusahaan)

@section('content')
  <x-ui.page-header
    title="Edit Kemitraan DU/DI"
    description="Perbarui profil perusahaan, kontak penanggung jawab industri, dan status legalitas."
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
            <x-ui.breadcrumb-page>Edit Data #MTR-{{ str_pad((string) $mitra->id_mitra, 3, '0', STR_PAD_LEFT) }}</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('mitras.show', $mitra->id_mitra) }}" variant="outline">
        <x-lucide-eye />
        Lihat Profil
      </x-ui.button>

      <x-ui.button href="{{ route('mitras.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
      <div class="flex items-center gap-4">
        <div class="size-14 shrink-0 overflow-hidden rounded-xl border border-border bg-card shadow-sm">
          @if ($mitra->logo_perusahaan)
            <img
              src="{{ Storage::url($mitra->logo_perusahaan) }}"
              alt="Logo {{ $mitra->nama_perusahaan }}"
              class="size-full object-cover"
            >
          @else
            <span class="grid size-full place-items-center bg-primary text-sm font-black text-primary-foreground">
              {{ strtoupper(substr($mitra->nama_perusahaan, 0, 2)) }}
            </span>
          @endif
        </div>

        <div>
          <div class="flex flex-wrap items-center gap-2">
            <h2 class="text-base font-bold text-foreground">{{ $mitra->nama_perusahaan }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">
              ID: #MTR-{{ str_pad((string) $mitra->id_mitra, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
            <x-ui.badge variant="secondary">{{ $mitra->jenis_mitra ?? 'Perusahaan Mitra' }}</x-ui.badge>
          </div>

          <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-muted-foreground">
            <span class="flex items-center gap-1">
              <x-lucide-briefcase class="size-3.5" />
              Sektor: {{ $mitra->bidang_usaha ?? 'Umum' }}
            </span>
            <span class="flex items-center gap-1">
              <x-lucide-map-pin class="size-3.5" />
              {{ $mitra->kota ?? 'Kota Tidak Tercatat' }}
            </span>
          </div>
        </div>
      </div>

      <div class="flex items-end justify-between gap-1 border-t border-border pt-3 text-xs text-muted-foreground sm:flex-col sm:border-t-0 sm:pt-0">
        <div>
          Terdaftar:
          <span class="font-medium text-foreground">
            {{ $mitra->created_at ? $mitra->created_at->translatedFormat('d M Y') : '-' }}
          </span>
        </div>
        <div>
          Pembaruan Terakhir:
          <span class="font-medium text-foreground">
            {{ $mitra->updated_at ? $mitra->updated_at->diffForHumans() : '-' }}
          </span>
        </div>
      </div>
    </div>
  </x-ui.card>

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

  <form action="{{ route('mitras.update', $mitra->id_mitra) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-building-2 class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Informasi Perusahaan</x-ui.card-title>
              <x-ui.card-description>Perbarui rincian resmi badan usaha.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <div class="flex flex-col items-start gap-5 sm:flex-row">
            <div id="logo-preview-wrap" class="relative size-24 shrink-0 overflow-hidden rounded-xl border-2 border-dashed border-border bg-muted">
              @if ($mitra->logo_perusahaan)
                <img
                  id="logo-preview-img"
                  src="{{ Storage::url($mitra->logo_perusahaan) }}"
                  alt="Logo {{ $mitra->nama_perusahaan }}"
                  class="absolute inset-0 size-full object-cover"
                >
                <span id="logo-placeholder" class="absolute inset-0 hidden items-center justify-center text-muted-foreground">
                  <x-lucide-image class="size-7" />
                </span>
              @else
                <span id="logo-placeholder" class="absolute inset-0 flex items-center justify-center text-muted-foreground">
                  <x-lucide-image class="size-7" />
                </span>
                <img id="logo-preview-img" src="" alt="Preview Logo" class="absolute inset-0 hidden size-full object-cover">
              @endif
            </div>

            <div class="w-full flex-1">
              <x-ui.field-label for="logo_perusahaan">
                Logo Perusahaan <span class="font-normal text-muted-foreground">(Kosongkan jika tidak diubah)</span>
              </x-ui.field-label>
              <label
                for="logo_perusahaan"
                class="mt-1.5 flex w-full cursor-pointer items-center gap-3 rounded-lg border border-border bg-muted/40 px-3.5 py-2.5 transition hover:border-primary/40 hover:bg-accent/40"
              >
                <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                  <x-lucide-upload-cloud class="size-4" />
                </span>
                <div>
                  <div id="logo-filename" class="text-xs font-semibold text-foreground">
                    {{ $mitra->logo_perusahaan ? 'Ganti logo...' : 'Klik untuk pilih file logo' }}
                  </div>
                  <div class="text-xs text-muted-foreground">PNG, JPG, WEBP, SVG · Maks. 2MB</div>
                </div>
              </label>
              <input type="file" id="logo_perusahaan" name="logo_perusahaan" accept="image/*" class="sr-only" onchange="previewLogo(this)">
              <x-ui.field-error :messages="$errors->get('logo_perusahaan')" />
            </div>
          </div>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('nama_perusahaan') ? 'true' : 'false' }}">
              <x-ui.field-label for="nama_perusahaan">Nama Perusahaan <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input
                id="nama_perusahaan"
                name="nama_perusahaan"
                type="text"
                :value="old('nama_perusahaan', $mitra->nama_perusahaan)"
              />
              <x-ui.field-error :messages="$errors->get('nama_perusahaan')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('bidang_usaha') ? 'true' : 'false' }}">
              <x-ui.field-label for="bidang_usaha">Bidang Usaha</x-ui.field-label>
              <x-ui.input id="bidang_usaha" name="bidang_usaha" type="text" :value="old('bidang_usaha', $mitra->bidang_usaha)" />
              <x-ui.field-error :messages="$errors->get('bidang_usaha')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jenis_mitra') ? 'true' : 'false' }}">
              <x-ui.field-label for="jenis_mitra">Jenis Kemitraan</x-ui.field-label>
              <x-ui.select name="jenis_mitra" id="jenis_mitra" native class="w-full">
                <option value="BUMN / BUMD" @selected(old('jenis_mitra', $mitra->jenis_mitra) == 'BUMN / BUMD')>BUMN / BUMD</option>
                <option value="Perusahaan Swasta Nasional" @selected(old('jenis_mitra', $mitra->jenis_mitra) == 'Perusahaan Swasta Nasional')>Perusahaan Swasta Nasional</option>
                <option value="PMA / Multinasional" @selected(old('jenis_mitra', $mitra->jenis_mitra) == 'PMA / Multinasional')>PMA / Multinasional</option>
                <option value="Instansi Pemerintah / Lembaga" @selected(old('jenis_mitra', $mitra->jenis_mitra) == 'Instansi Pemerintah / Lembaga')>Instansi Pemerintah / Lembaga</option>
                <option value="UMKM / Startup" @selected(old('jenis_mitra', $mitra->jenis_mitra) == 'UMKM / Startup')>UMKM / Startup</option>
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('jenis_mitra')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('no_izin') ? 'true' : 'false' }}">
              <x-ui.field-label for="no_izin">Nomor Izin Usaha / NIB</x-ui.field-label>
              <x-ui.input id="no_izin" name="no_izin" type="text" :value="old('no_izin', $mitra->no_izin)" />
              <x-ui.field-error :messages="$errors->get('no_izin')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('nama') ? 'true' : 'false' }}">
              <x-ui.field-label for="nama">Nama Penanggung Jawab (PIC) <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input id="nama" name="nama" type="text" :value="old('nama', $mitra->nama)" required />
              <x-ui.field-error :messages="$errors->get('nama')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('id_user') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_user">Akun User Terkait</x-ui.field-label>
              <x-ui.select name="id_user" id="id_user" native class="w-full">
                <option value="">-- Tanpa Akun Pengguna --</option>
                @foreach ($users ?? [] as $user)
                  <option value="{{ $user->id }}" @selected(old('id_user', $mitra->id_user) == $user->id)>
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
              <x-ui.card-title class="text-base font-bold">Lokasi & Kontak Penanggung Jawab</x-ui.card-title>
              <x-ui.card-description>Perbarui alamat kantor dan nomor kontak resmi.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('kota') ? 'true' : 'false' }}">
              <x-ui.field-label for="kota">Kota / Kabupaten</x-ui.field-label>
              <x-ui.input id="kota" name="kota" type="text" :value="old('kota', $mitra->kota)" />
              <x-ui.field-error :messages="$errors->get('kota')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('provinsi') ? 'true' : 'false' }}">
              <x-ui.field-label for="provinsi">Provinsi</x-ui.field-label>
              <x-ui.input id="provinsi" name="provinsi" type="text" :value="old('provinsi', $mitra->provinsi)" />
              <x-ui.field-error :messages="$errors->get('provinsi')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('no_telp') ? 'true' : 'false' }}">
              <x-ui.field-label for="no_telp">Nomor Telepon / WhatsApp</x-ui.field-label>
              <x-ui.input id="no_telp" name="no_telp" type="text" :value="old('no_telp', $mitra->no_telp ?? $mitra->telepon)" />
              <x-ui.field-error :messages="$errors->get('no_telp')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jabatan_pic') ? 'true' : 'false' }}">
              <x-ui.field-label for="jabatan_pic">Jabatan PIC / HRD</x-ui.field-label>
              <x-ui.input id="jabatan_pic" name="jabatan_pic" type="text" :value="old('jabatan_pic', $mitra->jabatan_pic)" />
              <x-ui.field-error :messages="$errors->get('jabatan_pic')" />
            </x-ui.field>

            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('alamat') ? 'true' : 'false' }}">
              <x-ui.field-label for="alamat">Alamat Lengkap</x-ui.field-label>
              <x-ui.textarea id="alamat" name="alamat" rows="3">{{ old('alamat', $mitra->alamat) }}</x-ui.textarea>
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
          <x-lucide-check />
          Simpan Perubahan
        </x-ui.button>
      </div>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-briefcase class="size-4 text-primary" />
            Lowongan Terbuka
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content>
          <p class="text-xs text-muted-foreground">
            Perusahaan ini memiliki
            <strong class="text-foreground">{{ count($mitra->lowongan ?? []) }} lowongan magang</strong>
            yang terdaftar di portal.
          </p>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="border-destructive/30 bg-destructive/5">
        <x-ui.card-header class="border-b border-destructive/20">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-destructive">
            <x-lucide-triangle-alert class="size-4" />
            Hapus Kemitraan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Menghapus mitra ini akan mencabut seluruh data kemitraan dan lowongan yang terafiliasi dengan perusahaan ini.
          </p>

          <x-ui.button type="submit" form="form-hapus-mitra" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Mitra DU/DI
            </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>

  {{-- Form hapus di luar form simpan: form bersarang membuat Simpan ikut mengirim _method=DELETE. --}}
  <form id="form-hapus-mitra" action="{{ route('mitras.destroy', $mitra->id_mitra) }}" method="POST" class="hidden" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mitra ini?')">
    @csrf
    @method('DELETE')
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
          if (placeholder) {
            placeholder.classList.add('hidden');
          }
        };

        reader.readAsDataURL(input.files[0]);
        filename.textContent = input.files[0].name;
      }
    }
  </script>
@endpush
