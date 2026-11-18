@extends('layouts.app')

@section('title', 'Edit Peserta Vokasi - ' . ($peserta->user->name ?? 'Peserta'))

@section('content')
  <x-ui.page-header
    title="Edit Data Peserta Vokasi"
    description="Perbarui biodata siswa, kontak komunikasi, nomor kependudukan, dan riwayat pendidikan."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('admin-blk.index') }}">Beranda</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('pesertas.index') }}">Peserta</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Data #{{ $peserta->nomor_peserta }}</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('pesertas.show', $peserta->id_peserta) }}" variant="outline">
        <x-lucide-eye />
        Lihat Profil
      </x-ui.button>

      <x-ui.button href="{{ route('pesertas.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <x-ui.card variant="sectioned">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
      <div class="flex items-center gap-4">
        <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-primary text-lg font-black uppercase text-primary-foreground shadow-sm">
          {{ strtoupper(substr($peserta->user->name ?? 'P', 0, 2)) }}
        </span>

        <div>
          <div class="flex flex-wrap items-center gap-2">
            <h2 class="text-base font-bold text-foreground">{{ $peserta->user->name ?? 'Tanpa Nama' }}</h2>
            <x-ui.badge variant="secondary" class="font-mono">NIS: {{ $peserta->nomor_peserta }}</x-ui.badge>
            <x-ui.badge variant="secondary">{{ $peserta->jurusan ?? 'Kejuruan Vokasi' }}</x-ui.badge>
          </div>

          <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-muted-foreground">
            <span class="flex items-center gap-1">
              <x-lucide-mail class="size-3.5" />
              {{ $peserta->user->email ?? '-' }}
            </span>
            <span class="flex items-center gap-1">
              <x-lucide-phone class="size-3.5" />
              {{ $peserta->nomor_wa ?? '-' }}
            </span>
          </div>
        </div>
      </div>

      <div class="flex items-end justify-between gap-1 border-t border-border pt-3 text-xs text-muted-foreground sm:flex-col sm:border-t-0 sm:pt-0">
        <div>
          Terdaftar:
          <span class="font-medium text-foreground">
            {{ $peserta->created_at ? $peserta->created_at->translatedFormat('d M Y') : '-' }}
          </span>
        </div>
        <div>
          Pembaruan Terakhir:
          <span class="font-medium text-foreground">
            {{ $peserta->updated_at ? $peserta->updated_at->diffForHumans() : '-' }}
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

  <form action="{{ route('pesertas.update', $peserta->id_peserta) }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-user-check class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Akun Sistem &amp; Nomor Induk</x-ui.card-title>
              <x-ui.card-description>Tautan akun login dan nomor identitas peserta.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('id_user') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_user">Akun Pengguna Terkait <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="id_user" id="id_user" native class="w-full" required>
                @foreach ($users ?? [] as $user)
                  <option value="{{ $user->id }}" @selected(old('id_user', $peserta->id_user) == $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_user')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('nomor_peserta') ? 'true' : 'false' }}">
              <x-ui.field-label for="nomor_peserta">Nomor Peserta (NIS) <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input id="nomor_peserta" name="nomor_peserta" type="text" :value="old('nomor_peserta', $peserta->nomor_peserta)" />
              <x-ui.field-error :messages="$errors->get('nomor_peserta')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jenis_kelamin') ? 'true' : 'false' }}">
              <x-ui.field-label for="jenis_kelamin">Jenis Kelamin <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="jenis_kelamin" id="jenis_kelamin" native class="w-full" required>
                <option value="Laki-laki" @selected(old('jenis_kelamin', $peserta->jenis_kelamin) == 'Laki-laki')>Laki-laki</option>
                <option value="Perempuan" @selected(old('jenis_kelamin', $peserta->jenis_kelamin) == 'Perempuan')>Perempuan</option>
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('jenis_kelamin')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jurusan') ? 'true' : 'false' }}">
              <x-ui.field-label for="jurusan">Kejuruan / Jurusan</x-ui.field-label>
              <x-ui.input id="jurusan" name="jurusan" type="text" :value="old('jurusan', $peserta->jurusan)" />
              <x-ui.field-error :messages="$errors->get('jurusan')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('nomor_wa') ? 'true' : 'false' }}">
              <x-ui.field-label for="nomor_wa">Nomor WhatsApp</x-ui.field-label>
              <x-ui.input id="nomor_wa" name="nomor_wa" type="text" :value="old('nomor_wa', $peserta->nomor_wa)" />
              <x-ui.field-error :messages="$errors->get('nomor_wa')" />
            </x-ui.field>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-id-card class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Data Kependudukan &amp; Domisili</x-ui.card-title>
              <x-ui.card-description>Perbarui identitas kependudukan dan riwayat edukasi.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('nomor_kk') ? 'true' : 'false' }}">
              <x-ui.field-label for="nomor_kk">Nomor Kartu Keluarga (KK)</x-ui.field-label>
              <x-ui.input id="nomor_kk" name="nomor_kk" type="text" :value="old('nomor_kk', $peserta->nomor_kk)" />
              <x-ui.field-error :messages="$errors->get('nomor_kk')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('pendidikan_terakhir') ? 'true' : 'false' }}">
              <x-ui.field-label for="pendidikan_terakhir">Pendidikan Terakhir</x-ui.field-label>
              <x-ui.select name="pendidikan_terakhir" id="pendidikan_terakhir" native class="w-full">
                <option value="SMK / SMA" @selected(old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'SMK / SMA')>SMK / SMA Sederajat</option>
                <option value="Diploma (D3/D4)" @selected(old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'Diploma (D3/D4)')>Diploma (D3/D4)</option>
                <option value="Sarjana (S1)" @selected(old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'Sarjana (S1)')>Sarjana (S1)</option>
                <option value="SMP Sederajat" @selected(old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == 'SMP Sederajat')>SMP Sederajat</option>
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('pendidikan_terakhir')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tempat_lahir') ? 'true' : 'false' }}">
              <x-ui.field-label for="tempat_lahir">Tempat Lahir</x-ui.field-label>
              <x-ui.input id="tempat_lahir" name="tempat_lahir" type="text" :value="old('tempat_lahir', $peserta->tempat_lahir)" />
              <x-ui.field-error :messages="$errors->get('tempat_lahir')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tanggal_lahir') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal_lahir">Tanggal Lahir</x-ui.field-label>
              <x-ui.input
                id="tanggal_lahir"
                name="tanggal_lahir"
                type="date"
                :value="old('tanggal_lahir', $peserta->tanggal_lahir ? $peserta->tanggal_lahir->format('Y-m-d') : '')"
              />
              <x-ui.field-error :messages="$errors->get('tanggal_lahir')" />
            </x-ui.field>

            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('alamat_lengkap') ? 'true' : 'false' }}">
              <x-ui.field-label for="alamat_lengkap">Alamat Lengkap</x-ui.field-label>
              <x-ui.textarea id="alamat_lengkap" name="alamat_lengkap" rows="3">{{ old('alamat_lengkap', $peserta->alamat_lengkap) }}</x-ui.textarea>
              <x-ui.field-error :messages="$errors->get('alamat_lengkap')" />
            </x-ui.field>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <div class="flex items-center justify-end gap-2">
        <x-ui.button href="{{ route('pesertas.index') }}" variant="outline">
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
            <x-lucide-layers class="size-4 text-primary" />
            Kelas &amp; Sertifikat
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-2 text-xs">
          <div class="flex items-center justify-between rounded-lg bg-muted/40 p-2.5">
            <span class="text-muted-foreground">Kelas Diikuti</span>
            <span class="font-bold text-foreground">{{ count($peserta->kelas ?? []) }} Kelas</span>
          </div>
          <div class="flex items-center justify-between rounded-lg bg-muted/40 p-2.5">
            <span class="text-muted-foreground">Sertifikat Diraih</span>
            <span class="font-bold text-foreground">{{ count($peserta->sertifikat ?? []) }} Sertifikat</span>
          </div>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card variant="sectioned" class="border-destructive/30 bg-destructive/5">
        <x-ui.card-header class="border-b border-destructive/20">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-destructive">
            <x-lucide-triangle-alert class="size-4" />
            Hapus Data Peserta
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content class="space-y-3">
          <p class="text-xs leading-relaxed text-muted-foreground">
            Tindakan ini akan menghapus data induk peserta, riwayat kelas, dan absensi yang terkait dari database.
          </p>

          <form
            action="{{ route('pesertas.destroy', $peserta->id_peserta) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peserta ini?')"
          >
            @csrf
            @method('DELETE')

            <x-ui.button type="submit" variant="destructive" class="w-full">
              <x-lucide-trash-2 />
              Hapus Peserta
            </x-ui.button>
          </form>
        </x-ui.card-content>
      </x-ui.card>
    </div>
  </form>
@endsection
