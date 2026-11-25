@extends('layouts.app')

@section('title', 'Edit Administrator BLK - ' . ($admin->nama ?? 'Admin'))

@section('content')
  <x-ui.page-header
    title="Edit Data Administrator BLK"
    description="Perbarui informasi akun, penugasan balai, atau alokasi kewenangan personel pengelola."
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
            <x-ui.breadcrumb-page>Edit Data #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('admin-blk.show', $admin->id_admin) }}" variant="outline">
        <x-lucide-eye />
        Lihat Profil
      </x-ui.button>

      <x-ui.button href="{{ route('admin-blk.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
      <div class="flex items-center gap-4">
        <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-primary text-lg font-black text-primary-foreground shadow-sm">
          {{ strtoupper(substr($admin->nama ?? 'A', 0, 2)) }}
        </span>

        <div>
          <div class="flex flex-wrap items-center gap-2">
            <h2 class="text-base font-bold text-foreground">{{ $admin->nama ?? 'Tanpa Nama' }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">
              ID Admin: #BLK-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}
            </x-ui.badge>
            <x-ui.badge tone="success">Aktif Bertugas</x-ui.badge>
          </div>

          <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-muted-foreground">
            <span class="flex items-center gap-1">
              <x-lucide-mail class="size-3.5" />
              {{ $admin->user->email ?? '-' }}
            </span>
            <span class="flex items-center gap-1">
              <x-lucide-building-2 class="size-3.5" />
              BLK Pusat Vokasi
            </span>
          </div>
        </div>
      </div>

      <div class="flex items-end justify-between gap-1 border-t border-border pt-3 text-xs text-muted-foreground sm:flex-col sm:border-t-0 sm:pt-0">
        <div>
          Terdaftar:
          <span class="font-medium text-foreground">
            {{ $admin->created_at ? $admin->created_at->translatedFormat('d M Y') : '-' }}
          </span>
        </div>
        <div>
          Pembaruan Terakhir:
          <span class="font-medium text-foreground">
            {{ $admin->updated_at ? $admin->updated_at->diffForHumans() : '-' }}
          </span>
        </div>
      </div>
    </div>
  </x-ui.card>

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

  <form action="{{ route('admin-blk.update', $admin->id_admin) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-user-cog class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Pengaturan Akun Pengguna</x-ui.card-title>
              <x-ui.card-description>Tentukan tautan akun pengguna untuk administrator ini.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-5">
          <x-ui.field data-invalid="{{ $errors->has('id_user') ? 'true' : 'false' }}">
            <x-ui.field-label for="id_user">Akun Pengguna Terkait <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.select name="id_user" id="id_user" native class="w-full" required>
              @foreach ($users ?? [] as $user)
                <option value="{{ $user->id }}" @selected(old('id_user', $admin->id_user) == $user->id)>
                  {{ $user->name }} ({{ $user->email }}) - Role: {{ $user->role ?? 'User' }}
                </option>
              @endforeach
            </x-ui.select>
            <x-ui.field-error :messages="$errors->get('id_user')" />
          </x-ui.field>

          <x-ui.field data-invalid="{{ $errors->has('nama') ? 'true' : 'false' }}">
            <x-ui.field-label for="nama">Nama Administrator <span class="text-destructive">*</span></x-ui.field-label>
            <x-ui.input id="nama" name="nama" type="text" :value="old('nama', $admin->nama)" required />
            <x-ui.field-error :messages="$errors->get('nama')" />
          </x-ui.field>

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
            </div>

            <div>
              <x-ui.field-label for="peran_otoritas">Peran Otoritas</x-ui.field-label>
              <x-ui.input
                id="peran_otoritas"
                type="text"
                value="Super Administrator BLK"
                readonly
                class="bg-muted text-muted-foreground"
              />
            </div>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <div class="flex items-center justify-end gap-2">
        <x-ui.button href="{{ route('admin-blk.index') }}" variant="outline">
          Batalkan
        </x-ui.button>

        <x-ui.button type="submit" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
          <x-lucide-check />
          Simpan Perubahan
        </x-ui.button>
      </div>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-shield-check class="size-4 text-primary" />
            Status Akses Administrator
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-2.5 text-xs">
          <div class="flex items-center justify-between rounded-lg bg-muted/40 p-2.5">
            <span class="text-muted-foreground">Status Operasional</span>
            <span class="flex items-center gap-1 font-semibold text-primary">
              <span class="size-2 rounded-full bg-emerald-500"></span>
              Aktif
            </span>
          </div>
          <div class="flex items-center justify-between rounded-lg bg-muted/40 p-2.5">
            <span class="text-muted-foreground">Hak Persetujuan Jurnal</span>
            <span class="font-semibold text-foreground">Ya (Penuh)</span>
          </div>
          <div class="flex items-center justify-between rounded-lg bg-muted/40 p-2.5">
            <span class="text-muted-foreground">Hak Terbit Sertifikat</span>
            <span class="font-semibold text-foreground">Ya (Penuh)</span>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="border-destructive/30 bg-destructive/5">
        <x-ui.card-header class="border-b border-destructive/20">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-destructive">
            <x-lucide-triangle-alert class="size-4" />
            Hapus Administrator
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Tindakan ini akan mencabut hak akses administrator BLK untuk akun pengguna ini. Data pelatihan atau sertifikat yang pernah divalidasi akan tetap tersimpan di riwayat sistem.
          </p>

          <form
            action="{{ route('admin-blk.destroy', $admin->id_admin) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus administrator ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Administrator
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
