@extends('layouts.app')

@section('title', 'Edit Status Kelas Pelatihan - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Perbarui Status Siswa di Kelas"
    description="Ubah status keaktifan, kelulusan, atau pemindahan batch kelas."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('kelas-pelatihan.index') }}">Kelas Pelatihan</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Penempatan</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('kelas-pelatihan.show', $kelas->id_kelas) }}" variant="outline">
        <x-lucide-eye />
        Lihat Detail
      </x-ui.button>

      <x-ui.button href="{{ route('kelas-pelatihan.index') }}" variant="outline">
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

  <form action="{{ route('kelas-pelatihan.update', $kelas->id_kelas) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
              <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
                <x-lucide-graduation-cap class="size-4" />
              </span>
              <x-ui.card-title class="text-base font-bold">Informasi Penempatan Siswa</x-ui.card-title>
            </div>

            <x-ui.badge variant="secondary" class="font-mono">
              ID: #KLS-{{ str_pad((string) $kelas->id_kelas, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <x-ui.field data-invalid="{{ $errors->has('id_peserta') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_peserta">Siswa Peserta <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="id_peserta" id="id_peserta" native class="w-full" required>
              @foreach ($pesertas as $peserta)
                <option value="{{ $peserta->id_peserta }}" @selected(old('id_peserta', $kelas->id_peserta) == $peserta->id_peserta)>
                  {{ $peserta->nama ?? 'Peserta' }} (NIS: {{ $peserta->nomor_peserta }})
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('id_peserta')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('id_jadwal') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_jadwal">Batch Jadwal & Kelas <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="id_jadwal" id="id_jadwal" native class="w-full" required>
              @foreach ($jadwals as $jadwal)
                <option value="{{ $jadwal->id_jadwal }}" @selected(old('id_jadwal', $kelas->id_jadwal) == $jadwal->id_jadwal)>
                  {{ $jadwal->pelatihan->nama_pelatihan ?? 'Pelatihan' }} - [Batch: #JDW-{{ str_pad((string) $jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}]
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('id_jadwal')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('status') ? 'true' : 'false' }}">
            <x-ui.field-label for="status">Status Kelulusan / Keaktifan Siswa <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="status" id="status" native class="w-full" required>
              <option value="terdaftar" @selected(old('status', $kelas->status) == 'terdaftar')>Terdaftar (Menunggu Mulai)</option>
              <option value="aktif" @selected(old('status', $kelas->status) == 'aktif')>Aktif (Sedang Mengikuti)</option>
              <option value="lulus" @selected(old('status', $kelas->status) == 'lulus')>Lulus (Telah Menyelesaikan)</option>
              <option value="tidak lulus" @selected(old('status', $kelas->status) == 'tidak lulus')>Tidak Lulus (Drop Out / Tidak Memenuhi Syarat)</option>
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('status')" />
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
              <span>Didaftarkan:</span>
              <span class="font-bold text-foreground">
                {{ $kelas->created_at ? $kelas->created_at->translatedFormat('d M Y') : '-' }}
              </span>
            </div>
            <div class="flex items-center justify-between gap-3">
              <span>Status Saat Ini:</span>
              <x-ui.badge variant="secondary" class="uppercase">{{ $kelas->status }}</x-ui.badge>
            </div>
          </div>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-check />
            Simpan Perubahan
          </x-ui.button>

          <x-ui.button href="{{ route('kelas-pelatihan.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="border-destructive/30 bg-destructive/5">
        <x-ui.card-header class="border-b border-destructive/20">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-destructive">
            <x-lucide-triangle-alert class="size-4" />
            Hapus dari Kelas
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content>
          <p class="text-xs leading-relaxed text-muted-foreground">
            Mengeluarkan siswa dari kelas akan membatalkan status keikutsertaan dalam batch ini.
          </p>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
