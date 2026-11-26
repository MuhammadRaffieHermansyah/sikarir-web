@extends('layouts.app')

@section('title', 'Edit Bidang Keahlian - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Edit Bidang Keahlian"
    description="Perbarui nama bidang keahlian."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('bidang-keahlian.index') }}">Bidang Keahlian</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Bidang Keahlian</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('bidang-keahlian.index') }}" variant="outline">
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

  <form action="{{ route('bidang-keahlian.update', $bidangKeahlian->id) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-tags class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Informasi Bidang Keahlian</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <x-ui.field data-invalid="{{ $errors->has('nama') ? 'true' : 'false' }}">
            <x-ui.field-label for="nama">Nama Bidang Keahlian <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.input
              id="nama"
              name="nama"
              type="text"
              :value="old('nama', $bidangKeahlian->nama)"
              maxlength="150"
              placeholder="Contoh: Teknik Kendaraan Ringan"
            />
            <x-ui.field-description>Huruf, angka, spasi, dan tanda baca umum. Maksimal 150 karakter.</x-ui.field-description>
            <x-ui.field-error :messages="$errors->get('nama')" />
          </x-ui.field>
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

        <x-ui.card-content class="space-y-4">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Mengganti nama akan ikut memperbarui bidang keahlian pada {{ $bidangKeahlian->instruktur_count }} instruktur yang memakainya.
          </p>

          <div class="space-y-2 pt-2">
            <x-ui.button type="submit" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              <x-lucide-save />
              Simpan Perubahan
            </x-ui.button>

            <x-ui.button href="{{ route('bidang-keahlian.index') }}" variant="secondary" class="w-full">
              Batal
            </x-ui.button>
          </div>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
