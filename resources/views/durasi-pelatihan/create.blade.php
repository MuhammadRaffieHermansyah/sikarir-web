@extends('layouts.app')

@section('title', 'Tambah Durasi Pelatihan - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Tambah Durasi Pelatihan"
    description="Definisikan kombinasi jumlah hari dan jam pelaksanaan program pelatihan."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('durasi-pelatihan.index') }}">Durasi Pelatihan</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Tambah Durasi</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('durasi-pelatihan.index') }}" variant="outline">
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

  <form action="{{ route('durasi-pelatihan.store') }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-timer class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Informasi Durasi</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('hari') ? 'true' : 'false' }}">
              <x-ui.field-label for="hari">Jumlah Hari <span class="text-destructive">*</span></x-ui.field-label>
              <div class="relative">
                <x-ui.input
                  id="hari"
                  name="hari"
                  type="number"
                  :value="old('hari')"
                  min="1"
                  max="366"
                  class="pr-16"
                  required
                />
                <span class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-xs font-semibold text-muted-foreground">
                  Hari
                </span>
              </div>
              <x-ui.field-description>Lama hari efektif pelaksanaan pelatihan.</x-ui.field-description>
              <x-ui.field-error :messages="$errors->get('hari')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jam') ? 'true' : 'false' }}">
              <x-ui.field-label for="jam">Jumlah Jam <span class="text-destructive">*</span></x-ui.field-label>
              <div class="relative">
                <x-ui.input
                  id="jam"
                  name="jam"
                  type="number"
                  :value="old('jam')"
                  min="1"
                  max="8760"
                  class="pr-16"
                  required
                />
                <span class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-xs font-semibold text-muted-foreground">
                  Jam
                </span>
              </div>
              <x-ui.field-description>Total jam pelajaran (JP) kurikulum.</x-ui.field-description>
              <x-ui.field-error :messages="$errors->get('jam')" />
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
            Kombinasi <strong class="text-foreground">Hari</strong> dan
            <strong class="text-foreground">Jam</strong> akan ditampilkan sebagai pilihan durasi saat membuat program pelatihan.
          </p>

          <div class="rounded-lg border border-border bg-muted/40 p-3 text-xs text-muted-foreground">
            Contoh:
            <span class="font-bold text-foreground">5 Hari / 40 Jam</span>,
            <span class="font-bold text-foreground">10 Hari / 80 Jam</span>
          </div>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-save />
            Simpan Durasi
          </x-ui.button>

          <x-ui.button href="{{ route('durasi-pelatihan.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
