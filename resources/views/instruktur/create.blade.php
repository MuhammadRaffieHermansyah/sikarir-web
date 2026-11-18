@extends('layouts.app')

@section('title', 'Tambah Instruktur - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Tambah Instruktur"
    description="Daftarkan nama instruktur beserta bidang keahliannya."
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
            <x-ui.breadcrumb-page>Tambah Instruktur</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('instruktur.index') }}" variant="outline">
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

  <form action="{{ route('instruktur.store') }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-user-check class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Informasi Instruktur</x-ui.card-title>
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
                :value="old('nama')"
                maxlength="150"
                placeholder="Contoh: Bambang Hermanto"
                required
              />
              <x-ui.field-description>Hanya huruf dan spasi, maksimal 150 karakter.</x-ui.field-description>
              <x-ui.field-error :messages="$errors->get('nama')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('bidang_keahlian') ? 'true' : 'false' }}">
              <x-ui.field-label for="bidang_keahlian">Bidang Keahlian <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input
                id="bidang_keahlian"
                name="bidang_keahlian"
                type="text"
                :value="old('bidang_keahlian')"
                maxlength="150"
                placeholder="Contoh: Teknik Kendaraan Ringan"
                required
              />
              <x-ui.field-description>Hanya huruf dan spasi, maksimal 150 karakter.</x-ui.field-description>
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
            <x-lucide-info class="size-4 text-primary" />
            Panduan Pengisian
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Data instruktur ini akan muncul sebagai pilihan pada form
            <strong class="text-foreground">Jadwal & Kelas</strong> beserta bidang keahliannya.
          </p>

          <div class="rounded-lg border border-border bg-muted/40 p-3 text-xs text-muted-foreground">
            Contoh:
            <span class="font-bold text-foreground">Teknik Kendaraan Ringan</span>,
            <span class="font-bold text-foreground">Teknik Komputer Jaringan</span>
          </div>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-save />
            Simpan Instruktur
          </x-ui.button>

          <x-ui.button href="{{ route('instruktur.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
