@extends('layouts.app')

@section('title', 'Edit Presensi Peserta - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Edit Presensi Peserta"
    description="Perbarui data pencatatan kehadiran atau keterangan presensi harian."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('absen.index') }}">Daftar Absensi</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Presensi</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('absen.index') }}" variant="outline">
        <x-lucide-arrow-left />
        Kembali
      </x-ui.button>
    </x-slot:actions>
  </x-ui.page-header>

  <div class="mx-auto max-w-3xl">
    <x-ui.card variant="sectioned">
      <x-ui.card-header class="border-b">
        <div class="flex items-center gap-3">
          <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-accent text-accent-foreground">
            <x-lucide-pencil class="size-4" />
          </span>
          <div>
            <x-ui.card-title class="text-base font-bold">Formulir Perubahan Presensi</x-ui.card-title>
            <x-ui.card-description>
              ID Absen: #ABS-{{ str_pad($absen->id_absen, 4, '0', STR_PAD_LEFT) }}
            </x-ui.card-description>
          </div>
        </div>
      </x-ui.card-header>

      <x-ui.card-content>
        <form method="POST" action="{{ route('absen.update', $absen->id_absen) }}" class="space-y-5">
          @csrf
          @method('PUT')

          @if ($errors->any())
            <x-ui.alert tone="danger">
              <x-lucide-circle-alert />
              <x-ui.alert-title>Gagal memperbarui data:</x-ui.alert-title>
              <x-ui.alert-description>
                <ul class="list-inside list-disc space-y-1">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </x-ui.alert-description>
            </x-ui.alert>
          @endif

          <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <x-ui.field data-invalid="{{ $errors->has('id_peserta') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_peserta">Peserta <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="id_peserta" id="id_peserta" native class="w-full">
                <option value="">-- Pilih Peserta --</option>
                @foreach ($pesertas as $p)
                  <option value="{{ $p->id_peserta }}" @selected(old('id_peserta', $absen->id_peserta) == $p->id_peserta)>
                    {{ $p->nama ?? 'Peserta #' . $p->id_peserta }} {{ isset($p->nomor_peserta) ? '(' . $p->nomor_peserta . ')' : '' }}
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_peserta')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('id_jadwal') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_jadwal">Jadwal & Kelas <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="id_jadwal" id="id_jadwal" native class="w-full">
                <option value="">-- Pilih Jadwal --</option>
                @foreach ($jadwals as $j)
                  <option value="{{ $j->id_jadwal }}" @selected(old('id_jadwal', $absen->id_jadwal) == $j->id_jadwal)>
                    {{ $j->pelatihan->nama_pelatihan ?? '-' }}
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_jadwal')" />
            </x-ui.field>
          </div>

          <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <x-ui.field data-invalid="{{ $errors->has('tanggal') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal">Tanggal Presensi <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.input
                id="tanggal"
                name="tanggal"
                type="date"
                :value="old('tanggal', \Carbon\Carbon::parse($absen->tanggal)->format('Y-m-d'))"
              />
              <x-ui.field-error :messages="$errors->get('tanggal')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('jam_hadir') ? 'true' : 'false' }}">
              <x-ui.field-label for="jam_hadir">Jam Masuk / Hadir</x-ui.field-label>
              <x-ui.input
                id="jam_hadir"
                name="jam_hadir"
                type="time"
                :value="old('jam_hadir', $absen->jam_hadir ? \Carbon\Carbon::parse($absen->jam_hadir)->format('H:i') : '')"
              />
              <x-ui.field-error :messages="$errors->get('jam_hadir')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('status_kehadiran') ? 'true' : 'false' }}">
              <x-ui.field-label for="status_kehadiran">Status <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="status_kehadiran" id="status_kehadiran" native class="w-full">
                @foreach (['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'] as $key => $label)
                  <option value="{{ $key }}" @selected(old('status_kehadiran', $absen->status_kehadiran ?? $absen->status) === $key)>{{ $label }}</option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('status_kehadiran')" />
            </x-ui.field>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('keterangan') ? 'true' : 'false' }}">
            <x-ui.field-label for="keterangan">Keterangan / Catatan</x-ui.field-label>
            <x-ui.textarea
              id="keterangan"
              name="keterangan"
              rows="3"
              placeholder="Catatan tambahan..."
            >{{ old('keterangan', $absen->keterangan) }}</x-ui.textarea>
            <x-ui.field-error :messages="$errors->get('keterangan')" />
          </x-ui.field>

          <div class="flex items-center justify-end gap-2 border-t border-border pt-4">
            <x-ui.button href="{{ route('absen.index') }}" variant="outline">
              Batal
            </x-ui.button>

            <x-ui.button type="submit" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              <x-lucide-check />
              Perbarui Presensi
            </x-ui.button>
          </div>
        </form>
      </x-ui.card-content>
    </x-ui.card>
  </div>
@endsection
