@extends('layouts.app')

@section('title', 'Pendaftaran Peserta Vokasi Baru - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Formulir Pendaftaran Peserta Vokasi"
    description="Input data induk siswa pelatihan vokasi untuk penugasan kelas kejuruan dan magang industri."
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
            <x-ui.breadcrumb-page>Registrasi Baru</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('pesertas.index') }}" variant="outline">
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

  <form action="{{ route('pesertas.store') }}" method="POST" class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
    @csrf

    <div class="space-y-6 lg:col-span-2">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <div class="flex items-center gap-3">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
              <x-lucide-user-check class="size-4" />
            </span>
            <div>
              <x-ui.card-title class="text-base font-bold">Akun Pengguna &amp; Nomor Induk</x-ui.card-title>
              <x-ui.card-description>Tautkan akun sistem dan tentukan Nomor Induk Siswa (NIS).</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('id_user') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_user">Pilih Akun Pengguna <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="id_user" id="id_user" native class="w-full" required>
                <option value="">-- Pilih Akun Pengguna Terdaftar --</option>
                @foreach ($users ?? [] as $user)
                  <option value="{{ $user->id }}" @selected(old('id_user') == $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_user')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('nomor_peserta') ? 'true' : 'false' }}">
              <x-ui.field-label for="nomor_peserta">Nomor Induk Siswa / NIS <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input
                id="nomor_peserta"
                name="nomor_peserta"
                type="text"
                :value="old('nomor_peserta', '2025-VOK-' . rand(100, 999))"
                placeholder="Contoh: 2025-VOK-001"
              />
              <x-ui.field-error :messages="$errors->get('nomor_peserta')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jenis_kelamin') ? 'true' : 'false' }}">
              <x-ui.field-label for="jenis_kelamin">Jenis Kelamin <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="jenis_kelamin" id="jenis_kelamin" native class="w-full" required>
                <option value="Laki-laki" @selected(old('jenis_kelamin') == 'Laki-laki')>Laki-laki</option>
                <option value="Perempuan" @selected(old('jenis_kelamin') == 'Perempuan')>Perempuan</option>
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('jenis_kelamin')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jurusan') ? 'true' : 'false' }}">
              <x-ui.field-label for="jurusan">Jurusan / Kejuruan Pelatihan</x-ui.field-label>
              <x-ui.input
                id="jurusan"
                name="jurusan"
                type="text"
                :value="old('jurusan')"
                placeholder="Contoh: Teknik Informatika / Mekatronika"
              />
              <x-ui.field-error :messages="$errors->get('jurusan')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('nomor_wa') ? 'true' : 'false' }}">
              <x-ui.field-label for="nomor_wa">Nomor WhatsApp / HP</x-ui.field-label>
              <x-ui.input
                id="nomor_wa"
                name="nomor_wa"
                type="text"
                :value="old('nomor_wa')"
                placeholder="08xxxxxxxxxx"
              />
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
              <x-ui.card-title class="text-base font-bold">Data Pribadi &amp; Riwayat Pendidikan</x-ui.card-title>
              <x-ui.card-description>Kelengkapan berkas kependudukan dan latar belakang edukasi.</x-ui.card-description>
            </div>
          </div>
        </x-ui.card-header>

        <x-ui.card-content>
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('nomor_kk') ? 'true' : 'false' }}">
              <x-ui.field-label for="nomor_kk">Nomor Kartu Keluarga (KK)</x-ui.field-label>
              <x-ui.input
                id="nomor_kk"
                name="nomor_kk"
                type="text"
                :value="old('nomor_kk')"
                placeholder="16 digit nomor KK"
              />
              <x-ui.field-error :messages="$errors->get('nomor_kk')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('pendidikan_terakhir') ? 'true' : 'false' }}">
              <x-ui.field-label for="pendidikan_terakhir">Pendidikan Terakhir</x-ui.field-label>
              <x-ui.select name="pendidikan_terakhir" id="pendidikan_terakhir" native class="w-full">
                <option value="SMK / SMA" @selected(old('pendidikan_terakhir', 'SMK / SMA') == 'SMK / SMA')>SMK / SMA Sederajat</option>
                <option value="Diploma (D3/D4)" @selected(old('pendidikan_terakhir') == 'Diploma (D3/D4)')>Diploma (D3/D4)</option>
                <option value="Sarjana (S1)" @selected(old('pendidikan_terakhir') == 'Sarjana (S1)')>Sarjana (S1)</option>
                <option value="SMP Sederajat" @selected(old('pendidikan_terakhir') == 'SMP Sederajat')>SMP Sederajat</option>
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('pendidikan_terakhir')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tempat_lahir') ? 'true' : 'false' }}">
              <x-ui.field-label for="tempat_lahir">Tempat Lahir</x-ui.field-label>
              <x-ui.input id="tempat_lahir" name="tempat_lahir" type="text" :value="old('tempat_lahir')" placeholder="Kota kelahiran" />
              <x-ui.field-error :messages="$errors->get('tempat_lahir')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tanggal_lahir') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal_lahir">Tanggal Lahir</x-ui.field-label>
              <x-ui.input id="tanggal_lahir" name="tanggal_lahir" type="date" :value="old('tanggal_lahir')" />
              <x-ui.field-error :messages="$errors->get('tanggal_lahir')" />
            </x-ui.field>

            <x-ui.field class="sm:col-span-2" data-invalid="{{ $errors->has('alamat_lengkap') ? 'true' : 'false' }}">
              <x-ui.field-label for="alamat_lengkap">Alamat Lengkap Domisili</x-ui.field-label>
              <x-ui.textarea
                id="alamat_lengkap"
                name="alamat_lengkap"
                rows="3"
                placeholder="Alamat lengkap sesuai KTP / Domisili..."
              >{{ old('alamat_lengkap') }}</x-ui.textarea>
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
          <x-lucide-save />
          Simpan Data Peserta
        </x-ui.button>
      </div>
    </div>

    <div class="space-y-6">
      <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
          <x-ui.card-title class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-muted-foreground">
            <x-lucide-info class="size-4 text-primary" />
            Panduan Registrasi Siswa
          </x-ui.card-title>
        </x-ui.card-header>

        <x-ui.card-content>
          <ul class="space-y-3 text-xs text-muted-foreground">
            <li class="flex items-start gap-2">
              <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
              <span>Nomor Induk Siswa (NIS) menjadi acuan dalam penerbitan e-sertifikat kelulusan.</span>
            </li>
            <li class="flex items-start gap-2">
              <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
              <span>Pastikan nomor WhatsApp aktif untuk notifikasi jadwal kelas dan seleksi magang.</span>
            </li>
            <li class="flex items-start gap-2">
              <x-lucide-circle-check-big class="mt-0.5 size-4 shrink-0 text-primary" />
              <span>Setelah data tersimpan, peserta dapat di-plot ke dalam jadwal kelas pelatihan aktif.</span>
            </li>
          </ul>
        </x-ui.card-content>
      </x-ui.card>

      <x-ui.card class="border-primary/30 bg-gradient-to-br from-primary to-[#0a2f26] text-primary-foreground">
        <div class="flex items-center gap-2 text-xs font-bold text-sikarir-lime">
          <x-lucide-award class="size-4" />
          <span>Vokasi Siap Kerja</span>
        </div>
        <p class="mt-3 text-xs leading-relaxed text-primary-foreground/80">
          Sistem mencatat rekam jejak pelatihan, absensi kehadiran harian, dan logbook magang industri secara transparan.
        </p>
      </x-ui.card>
    </div>
  </form>
@endsection
