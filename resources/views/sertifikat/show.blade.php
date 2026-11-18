@extends('layouts.app')

@section('title', 'Detail Sertifikat Peserta - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Detail Sertifikat Kelulusan"
    description="Informasi rinci dokumen sertifikasi kompetensi peserta pelatihan."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('sertifikat.index') }}">Daftar Sertifikat</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Detail Sertifikat</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('sertifikat.edit', $sertifikat->id_sertifikat ?? $sertifikat->id) }}" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
        <x-lucide-pencil />
        Edit
      </x-ui.button>

      <x-ui.button href="{{ route('sertifikat.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <div class="mx-auto max-w-3xl">
    <x-ui.card variant="sectioned" class="gap-0 overflow-hidden">
      <x-ui.card-header class="flex flex-row items-center justify-between gap-4 border-b">
        <div class="flex items-center gap-3">
          <x-ui.avatar class="size-10">
            <x-ui.avatar-fallback class="bg-accent text-sm font-bold text-accent-foreground">
              {{ strtoupper(substr($sertifikat->peserta->user->name ?? 'P', 0, 2)) }}
            </x-ui.avatar-fallback>
          </x-ui.avatar>

          <div class="min-w-0">
            <x-ui.card-title class="text-base font-bold">{{ $sertifikat->peserta->user->name ?? 'Tanpa Nama' }}</x-ui.card-title>
            <x-ui.card-description>
              ID Sertifikat: #CERT-{{ str_pad($sertifikat->id_sertifikat ?? $sertifikat->id, 4, '0', STR_PAD_LEFT) }}
              {{ isset($sertifikat->peserta->nomor_peserta) ? '• No. Peserta: ' . $sertifikat->peserta->nomor_peserta : '' }}
            </x-ui.card-description>
          </div>
        </div>

        <x-ui.badge variant="secondary" class="gap-1 font-mono">
          <x-lucide-award class="size-3.5 text-primary" />
          {{ $sertifikat->no_sertifikat ?? $sertifikat->nomor_sertifikat ?? 'Belum ada No. Sertifikat' }}
        </x-ui.badge>
      </x-ui.card-header>

      <x-ui.card-content class="grid grid-cols-1 gap-6 text-xs md:grid-cols-2">
        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-book-open class="size-3.5" />
            Program Pelatihan
          </span>
          <p class="text-sm font-bold text-foreground">{{ $sertifikat->jadwal->pelatihan->nama_pelatihan ?? '-' }}</p>
        </div>

        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-calendar class="size-3.5" />
            Tanggal Terbit
          </span>
          <p class="text-sm font-bold text-foreground">
            {{ $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->translatedFormat('d F Y') : '-' }}
          </p>
        </div>

        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-user-check class="size-3.5" />
            Admin Penanggung Jawab
          </span>
          <p class="font-medium text-foreground">{{ $sertifikat->admin->user->name ?? '-' }}</p>
        </div>

        <div class="space-y-1">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-mail class="size-3.5" />
            Email Peserta
          </span>
          <p class="font-medium text-foreground">{{ $sertifikat->peserta->user->email ?? '-' }}</p>
        </div>

        <div class="space-y-2 border-t border-border pt-4 md:col-span-2">
          <span class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-muted-foreground">
            <x-lucide-file-text class="size-3.5" />
            Berkas Sertifikat Digital
          </span>

          @if ($sertifikat->file_sertifikat)
            <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-border bg-accent/40 p-4">
              <div class="flex items-center gap-3">
                <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                  <x-lucide-file-check-2 class="size-5" />
                </span>
                <div>
                  <p class="text-xs font-bold text-foreground">Dokumen Resmi Tersedia</p>
                  <p class="text-xs text-muted-foreground">Berkas digital kelulusan terverifikasi oleh BLK.</p>
                </div>
              </div>

              <x-ui.button href="{{ Storage::url($sertifikat->file_sertifikat) }}" target="_blank" size="sm" class="shrink-0">
                <x-lucide-external-link />
                Lihat / Unduh
              </x-ui.button>
            </div>
          @else
            <div class="space-y-1 rounded-xl border border-border bg-muted/40 p-4 text-center text-muted-foreground">
              <x-lucide-file-x class="mx-auto size-6" />
              <p class="text-xs font-medium">Belum ada berkas sertifikat yang diunggah</p>
            </div>
          @endif
        </div>
      </x-ui.card-content>

      <div class="flex flex-wrap items-center justify-between gap-3 border-t border-border bg-muted/40 px-6 py-4">
        <span class="text-[10px] text-muted-foreground">
          Diterbitkan pada: {{ $sertifikat->created_at ? $sertifikat->created_at->translatedFormat('d M Y, H:i') : '-' }}
        </span>

        <form
          action="{{ route('sertifikat.destroy', $sertifikat->id_sertifikat ?? $sertifikat->id) }}"
          method="POST"
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')"
        >
          @csrf
          @method('DELETE')

          <x-ui.button type="submit" variant="ghost" size="sm" class="text-destructive hover:bg-destructive/10 hover:text-destructive">
            <x-lucide-trash-2 />
            Hapus Sertifikat
          </x-ui.button>
        </form>
      </div>
    </x-ui.card>
  </div>
@endsection
