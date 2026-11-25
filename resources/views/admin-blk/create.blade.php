@extends('layouts.app')

@section('title', 'Tambah Administrator BLK - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Registrasi Administrator BLK"
    description="Daftarkan personel pengelola balai latihan kerja untuk mengelola pelatihan, mitra industri, dan verifikasi sertifikat."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Admin BLK</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Tambah Baru</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('admin-blk.index') }}" variant="outline">
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

  <form action="{{ route('admin-blk.store') }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-user-check class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Akun Pengguna</x-ui.card-title>
              <x-ui.card-description>Pilih akun pengguna yang akan diberikan hak akses sebagai Administrator BLK.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <x-ui.field data-invalid="{{ $errors->has('id_user') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_user">Pilih Pengguna <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="id_user" id="id_user" native class="w-full" required>
              <option value="">-- Pilih Akun Pengguna Terdaftar --</option>
              @foreach ($users ?? [] as $user)
                <option value="{{ $user->id }}" @selected(old('id_user') == $user->id)>
                  {{ $user->name }} ({{ $user->email }}) - Role: {{ $user->role ?? 'User' }}
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-description>Hanya akun pengguna aktif yang dapat ditugaskan sebagai Administrator Balai.</x-ui.field-description>
            <x-ui.field-error :messages="$errors->get('id_user')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('nama') ? 'true' : 'false' }}">
            <x-ui.field-label for="nama">Nama Administrator <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.input id="nama" name="nama" type="text" :value="old('nama')" required />
            <x-ui.field-error :messages="$errors->get('nama')" />
          </x-ui.field>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-building class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Penugasan & Balai Operasional</x-ui.card-title>
              <x-ui.card-description>Tentukan unit balai dan cakupan kewenangan staf administrator.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
              <x-ui.field-label for="unit_balai">Unit Balai Kerja</x-ui.field-label>
              <x-ui.input
                id="unit_balai"
                type="text"
                value="BLK Pusat Vokasi & Pelatihan Kerja"
                readonly
                class="bg-muted text-muted-foreground"
              />
              <p class="mt-1 text-xs text-muted-foreground">Unit default sistem saat ini</p>
            </div>

            <div>
              <x-ui.field-label>Level Hak Akses</x-ui.field-label>
              <div class="flex items-center gap-2 rounded-lg border border-border bg-accent px-3.5 py-2 text-xs font-semibold text-accent-foreground">
                <x-lucide-shield class="size-4" />
                <span>Super Administrator BLK</span>
              </div>
            </div>
          </div>

          <div>
            <x-ui.field-label>Cakupan Otoritas Sistem yang Diberikan:</x-ui.field-label>
            <div class="mt-2 grid grid-cols-1 gap-2.5 sm:grid-cols-2">
              <div class="flex items-start gap-2 rounded-lg border border-border bg-muted/40 p-2.5">
                <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
                <div>
                  <div class="text-xs font-bold text-foreground">Manajemen Pelatihan</div>
                  <div class="text-xs text-muted-foreground">Membuat dan mengelola silabus kelas & jadwal.</div>
                </div>
              </div>

              <div class="flex items-start gap-2 rounded-lg border border-border bg-muted/40 p-2.5">
                <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
                <div>
                  <div class="text-xs font-bold text-foreground">Approval Jurnal & Presensi</div>
                  <div class="text-xs text-muted-foreground">Validasi kegiatan harian peserta magang.</div>
                </div>
              </div>

              <div class="flex items-start gap-2 rounded-lg border border-border bg-muted/40 p-2.5">
                <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
                <div>
                  <div class="text-xs font-bold text-foreground">Kerjasama Mitra Industri</div>
                  <div class="text-xs text-muted-foreground">Posting lowongan dan sinkronisasi kuota magang.</div>
                </div>
              </div>

              <div class="flex items-start gap-2 rounded-lg border border-border bg-muted/40 p-2.5">
                <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
                <div>
                  <div class="text-xs font-bold text-foreground">Penerbitan Sertifikat</div>
                  <div class="text-xs text-muted-foreground">Validasi kelulusan dan nomor sertifikat resmi.</div>
                </div>
              </div>
            </div>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <div class="flex items-center justify-end gap-2">
        <x-ui.button href="{{ route('admin-blk.index') }}" variant="outline">
          Batalkan
        </x-ui.button>

        <x-ui.button type="submit" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
          <x-lucide-save />
          Simpan Administrator
        </x-ui.button>
      </div>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-info class="size-4 text-primary" />
            Panduan Pengisian
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content>
          <ul class="space-y-3 text-xs text-muted-foreground">
            <li class="flex items-start gap-2">
              <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-accent text-[10px] font-bold text-accent-foreground">1</span>
              <span>Pastikan akun pengguna sudah dibuat dan memiliki status aktif di sistem.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-accent text-[10px] font-bold text-accent-foreground">2</span>
              <span>Satu akun pengguna hanya dapat ditugaskan untuk satu profil administrator BLK.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-accent text-[10px] font-bold text-accent-foreground">3</span>
              <span>Setelah disimpan, administrator dapat langsung login dan mengelola modul BLK.</span>
            </li>
          </ul>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card class="border-primary/30 bg-gradient-to-br from-primary to-[#0a2f26] text-primary-foreground">
        <div class="flex items-center gap-2 text-xs font-bold text-sikarir-lime">
          <x-lucide-lock class="size-4" />
          <span>Keamanan & Otoritas</span>
        </div>
        <p class="mt-3 text-xs leading-relaxed text-primary-foreground/80">
          Hak akses Administrator BLK memiliki wewenang penuh dalam mengesahkan jurnal harian peserta magang dan validasi kelulusan program kejuruan.
        </p>
        <div class="mt-4 flex items-center justify-between border-t border-primary-foreground/20 pt-3 text-xs text-primary-foreground/60">
          <span>SiKarir Vokasi</span>
          <span class="font-semibold text-sikarir-lime">Terkoneksi BLK</span>
        </div>
      </x-ui.card>
    </div>
  </form>
@endsection
