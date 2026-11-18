@extends('layouts.app')

@section('title', 'Edit Ruangan Workshop - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Edit Ruangan Workshop"
    description="Perbarui informasi ruangan workshop."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('ruangan-workshop.index') }}">Ruangan Workshop</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Ruangan Workshop</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('ruangan-workshop.index') }}" variant="outline">
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

  <form action="{{ route('ruangan-workshop.update', $ruanganWorkshop->id) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-building-2 class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Informasi Ruangan Workshop</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <x-ui.field data-invalid="{{ $errors->has('nama_ruangan') ? 'true' : 'false' }}">
            <x-ui.field-label for="nama_ruangan">Nama Ruangan <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.input
              id="nama_ruangan"
              name="nama_ruangan"
              type="text"
              :value="old('nama_ruangan', $ruanganWorkshop->nama_ruangan)"
              maxlength="150"
              placeholder="Contoh: Workshop Otomotif"
            />
            <x-ui.field-description>Masukkan nama ruangan workshop, maksimal 150 karakter.</x-ui.field-description>
            <x-ui.field-error :messages="$errors->get('nama_ruangan')" />
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
            Perubahan data akan langsung diterapkan pada data ruangan workshop.
          </p>

          <div class="space-y-2 pt-2">
            <x-ui.button type="submit" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              <x-lucide-save />
              Simpan Perubahan
            </x-ui.button>

            <x-ui.button href="{{ route('ruangan-workshop.index') }}" variant="secondary" class="w-full">
              Batal
            </x-ui.button>
          </div>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
