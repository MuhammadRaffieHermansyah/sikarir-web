@extends('layouts.app')

@section('title', 'Detail Ruangan Workshop - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Detail Ruangan Workshop"
    description="Informasi lengkap ruangan workshop."
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
            <x-ui.breadcrumb-page>Detail Ruangan</x-ui.breadcrumb-page>
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

  <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-building-2 class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Informasi Ruangan</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <div class="flex items-center gap-4">
            <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary text-2xl font-black uppercase text-primary-foreground">
              {{ substr($ruanganWorkshop->nama_ruangan, 0, 1) }}
            </span>
            <div>
              <h3 class="text-lg font-extrabold text-foreground">{{ $ruanganWorkshop->nama_ruangan }}</h3>
              <p class="text-xs text-muted-foreground">
                ID: #RW-{{ str_pad((string) $ruanganWorkshop->id, 3, '0', STR_PAD_LEFT) }}
              </p>
            </div>
          </div>

          <div class="grid grid-cols-1 gap-4 pt-2 sm:grid-cols-2">
            <div class="rounded-lg bg-muted/40 p-3">
              <div class="text-[10px] font-semibold uppercase tracking-wide text-muted-foreground">Dibuat Pada</div>
              <div class="mt-1 text-xs font-bold text-foreground">{{ $ruanganWorkshop->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div class="rounded-lg bg-muted/40 p-3">
              <div class="text-[10px] font-semibold uppercase tracking-wide text-muted-foreground">Terakhir Diupdate</div>
              <div class="mt-1 text-xs font-bold text-foreground">{{ $ruanganWorkshop->updated_at->format('d M Y, H:i') }}</div>
            </div>
          </div>
        </x-ui.card-content>
      </x-ui.card>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-info class="size-4 text-primary" />
            Statistik
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-4">
          <div class="flex items-center justify-between rounded-lg bg-accent p-3 text-xs">
            <span class="font-medium text-accent-foreground">Jadwal Terpakai</span>
            <span class="text-sm font-black text-primary">{{ $ruanganWorkshop->jadwal_count ?? 0 }}</span>
          </div>

          <div class="space-y-2">
            <x-ui.button href="{{ route('ruangan-workshop.edit', $ruanganWorkshop->id) }}" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              <x-lucide-pencil />
              Edit Ruangan
            </x-ui.button>

            <form
              action="{{ route('ruangan-workshop.destroy', $ruanganWorkshop->id) }}"
              method="POST"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')"
            >
              @csrf
              @method('DELETE')

              <x-ui.button type="submit" variant="destructive" class="w-full">
                <x-lucide-trash-2 />
                Hapus Ruangan
              </x-ui.button>
            </form>
          </div>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </div>
@endsection
