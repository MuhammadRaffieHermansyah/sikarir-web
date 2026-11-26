@extends('layouts.app')

@section('title', 'Edit Instruktur - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Perbarui Instruktur"
    description="Ubah nama instruktur dan bidang keahlian yang dimiliki."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('instruktur.index') }}">Instruktur</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Instruktur</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('instruktur.show', $instruktur->id) }}" variant="outline">
        <x-lucide-eye />
        Lihat Detail
      </x-ui.button>

      <x-ui.button href="{{ route('instruktur.index') }}" variant="outline">
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

  <form action="{{ route('instruktur.update', $instruktur->id) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-user-check class="size-4" />
              </span>
              <x-ui.card-title class="text-base font-bold">Informasi Instruktur</x-ui.card-title>
            </div>

            <x-ui.badge variant="secondary" class="font-mono">
              ID: #INS-{{ str_pad((string) $instruktur->id, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('nama') ? 'true' : 'false' }}">
              <x-ui.field-label for="nama">Nama Instruktur <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input
                id="nama"
                name="nama"
                type="text"
                :value="old('nama', $instruktur->nama)"
                maxlength="150"
                required
              />
              <x-ui.field-description>Hanya huruf dan spasi, maksimal 150 karakter.</x-ui.field-description>
              <x-ui.field-error :messages="$errors->get('nama')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('bidang_keahlian') ? 'true' : 'false' }}">
              <x-ui.field-label for="bidang_keahlian">Bidang Keahlian <span class="text-destructive">*</span></x-ui.field-label>
              @php($bidangTerpilih = old('bidang_keahlian', $instruktur->bidang_keahlian))
              <x-ui.select name="bidang_keahlian" id="bidang_keahlian" native class="w-full" required>
                <option value="">-- Pilih Bidang Keahlian --</option>
                @foreach ($bidangKeahlians as $bidang)
                  <option value="{{ $bidang->nama }}" @selected($bidangTerpilih === $bidang->nama)>{{ $bidang->nama }}</option>
                @endforeach
              </x-ui.select>
              <x-ui.field-description>
                Belum ada di daftar?
                <a href="{{ route('bidang-keahlian.create') }}" class="font-semibold text-primary hover:underline">Kelola master bidang keahlian</a>
              </x-ui.field-description>
              <x-ui.field-error :messages="$errors->get('bidang_keahlian')" />
            </x-ui.field>
          </div>
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
              <span>Jadwal diampu:</span>
              <span class="font-bold text-foreground">{{ $instruktur->jadwal()->count() }} Jadwal</span>
            </div>
            <div class="flex items-center justify-between gap-3">
              <span>Dibuat pada:</span>
              <span class="font-bold text-foreground">
                {{ $instruktur->created_at ? $instruktur->created_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
            <div class="flex items-center justify-between gap-3">
              <span>Terakhir diubah:</span>
              <span class="font-bold text-foreground">
                {{ $instruktur->updated_at ? $instruktur->updated_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
          </div>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-check />
            Simpan Perubahan
          </x-ui.button>

          <x-ui.button href="{{ route('instruktur.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
