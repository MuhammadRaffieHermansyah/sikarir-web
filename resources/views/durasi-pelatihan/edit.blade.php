@extends('layouts.app')

@section('title', 'Edit Durasi Pelatihan - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Perbarui Durasi Pelatihan"
    description="Ubah kombinasi jumlah hari dan jam pelaksanaan program pelatihan."
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
            <x-ui.breadcrumb-page>Edit Durasi</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('durasi-pelatihan.show', $durasi->id_durasi) }}" variant="outline">
        <x-lucide-eye />
        Lihat Detail
      </x-ui.button>

      <x-ui.button href="{{ route('durasi-pelatihan.index') }}" variant="outline">
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

  <form action="{{ route('durasi-pelatihan.update', $durasi->id_durasi) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-timer class="size-4" />
              </span>
              <x-ui.card-title class="text-base font-bold">Informasi Durasi</x-ui.card-title>
            </div>

            <x-ui.badge variant="secondary" class="font-mono">
              ID: #DUR-{{ str_pad((string) $durasi->id_durasi, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
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
                  :value="old('hari', $durasi->hari)"
                  min="1"
                  max="366"
                  class="pr-16"
                  required
                />
                <span class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-xs font-semibold text-muted-foreground">
                  Hari
                </span>
              </div>
              <x-ui.field-error :messages="$errors->get('hari')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jam') ? 'true' : 'false' }}">
              <x-ui.field-label for="jam">Jumlah Jam <span class="text-destructive">*</span></x-ui.field-label>
              <div class="relative">
                <x-ui.input
                  id="jam"
                  name="jam"
                  type="number"
                  :value="old('jam', $durasi->jam)"
                  min="1"
                  max="8760"
                  class="pr-16"
                  required
                />
                <span class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-xs font-semibold text-muted-foreground">
                  Jam
                </span>
              </div>
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
            <x-lucide-save class="size-4 text-primary" />
            Aksi Pembaruan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-4">
          <div class="space-y-2 rounded-xl border border-border bg-muted/40 p-3.5 text-xs text-muted-foreground">
            <div class="flex items-center justify-between gap-3">
              <span>Dibuat pada:</span>
              <span class="font-bold text-foreground">
                {{ $durasi->created_at ? $durasi->created_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
            <div class="flex items-center justify-between gap-3">
              <span>Terakhir diubah:</span>
              <span class="font-bold text-foreground">
                {{ $durasi->updated_at ? $durasi->updated_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
          </div>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-check />
            Simpan Perubahan
          </x-ui.button>

          <x-ui.button href="{{ route('durasi-pelatihan.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
