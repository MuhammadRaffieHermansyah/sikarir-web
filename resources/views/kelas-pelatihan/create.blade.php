@extends('layouts.app')

@section('title', 'Alokasi Siswa ke Kelas Pelatihan - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Penempatan Siswa ke Batch Kelas"
    description="Pilih siswa vokasi dan masukkan ke dalam batch pelatihan kejuruan yang sedang dibuka."
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
            <x-ui.breadcrumb-page>Tambah Peserta</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('kelas-pelatihan.index') }}" variant="outline">
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

  <form action="{{ route('kelas-pelatihan.store') }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-user-plus class="size-4" />
            </span>
            <x-ui.card-title class="text-base font-bold">Pemilihan Siswa & Batch Kelas</x-ui.card-title>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <x-ui.field data-invalid="{{ $errors->has('id_peserta') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_peserta">Pilih Siswa Peserta <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="id_peserta" id="id_peserta" native class="w-full" required>
              <option value="">-- Pilih Siswa Vokasi Terdaftar --</option>
              @foreach ($pesertas as $peserta)
                <option value="{{ $peserta->id_peserta }}" @selected(old('id_peserta') == $peserta->id_peserta)>
                  {{ $peserta->user->name ?? 'Peserta' }} (NIS: {{ $peserta->nomor_peserta }} | Minat: {{ $peserta->jurusan ?? '-' }})
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('id_peserta')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('id_jadwal') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_jadwal">Pilih Batch Jadwal & Kelas <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="id_jadwal" id="id_jadwal" native class="w-full" required>
              <option value="">-- Pilih Batch Jadwal Aktif --</option>
              @foreach ($jadwals as $jadwal)
                <option value="{{ $jadwal->id_jadwal }}" @selected(old('id_jadwal') == $jadwal->id_jadwal)>
                  {{ $jadwal->pelatihan->nama_pelatihan ?? 'Pelatihan' }} - [Batch: #JDW-{{ str_pad((string) $jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}] ({{ $jadwal->tanggal_mulai ? $jadwal->tanggal_mulai->format('d/m/Y') : '' }} s/d {{ $jadwal->tanggal_selesai ? $jadwal->tanggal_selesai->format('d/m/Y') : '' }})
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('id_jadwal')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('status') ? 'true' : 'false' }}">
            <x-ui.field-label for="status">Status Awal Peserta</x-ui.field-label>
            <x-ui.select name="status" id="status" native class="w-full">
              <option value="terdaftar" @selected(old('status', 'terdaftar') == 'terdaftar')>Terdaftar (Menunggu Mulai)</option>
              <option value="aktif" @selected(old('status') == 'aktif')>Aktif (Sedang Mengikuti)</option>
              <option value="lulus" @selected(old('status') == 'lulus')>Lulus (Telah Menyelesaikan)</option>
              <option value="tidak lulus" @selected(old('status') == 'tidak lulus')>Tidak Lulus (Drop Out / Tidak Memenuhi Syarat)</option>
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
            <x-lucide-info class="size-4 text-primary" />
            Ketentuan Penempatan
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Satu peserta tidak dapat didaftarkan dua kali pada batch jadwal & kelas yang sama.
          </p>

          <x-ui.alert tone="warning" class="text-xs">
            <x-lucide-triangle-alert />
            <x-ui.alert-title class="text-xs">Validasi Kuota</x-ui.alert-title>
            <x-ui.alert-description class="text-xs">
              Sistem akan menolak penambahan jika jumlah siswa sudah melampaui kuota maksimal kejuruan tersebut.
            </x-ui.alert-description>
          </x-ui.alert>

          <x-ui.button type="submit" size="lg" class="w-full bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
            <x-lucide-save />
            Simpan Penempatan
          </x-ui.button>

          <x-ui.button href="{{ route('kelas-pelatihan.index') }}" variant="outline" size="lg" class="w-full">
            Batal
          </x-ui.button>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
