@extends('layouts.app')

@section('title', 'Edit Sertifikat - SiKarir BLK')

@section('content')
  <x-ui.page-header
    title="Edit Data Sertifikat"
    description="Perbarui informasi sertifikat atau ganti berkas sertifikat digital peserta."
  >
    <x-slot:breadcrumb>
      <x-ui.breadcrumb>
        <x-ui.breadcrumb-list>
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-link href="{{ route('sertifikat.index') }}">Daftar Sertifikat</x-ui.breadcrumb-link>
          </x-ui.breadcrumb-item>
          <x-ui.breadcrumb-separator />
          <x-ui.breadcrumb-item>
            <x-ui.breadcrumb-page>Edit Sertifikat</x-ui.breadcrumb-page>
          </x-ui.breadcrumb-item>
        </x-ui.breadcrumb-list>
      </x-ui.breadcrumb>
    </x-slot:breadcrumb>

    <x-slot:actions>
      <x-ui.button href="{{ route('sertifikat.index') }}" variant="outline">
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
            <x-ui.card-title class="text-base font-bold">Formulir Perubahan Sertifikat</x-ui.card-title>
            <x-ui.card-description>
              ID Sertifikat: #CERT-{{ str_pad($sertifikat->id_sertifikat ?? $sertifikat->id, 4, '0', STR_PAD_LEFT) }}
            </x-ui.card-description>
          </div>
        </div>
      </x-ui.card-header>

      <x-ui.card-content>
        <form method="POST" action="{{ route('sertifikat.update', $sertifikat->id_sertifikat ?? $sertifikat->id) }}" enctype="multipart/form-data" class="space-y-5">
          @csrf
          @method('PUT')

          @if ($errors->any())
            <x-ui.alert tone="danger">
              <x-lucide-circle-alert />
              <x-ui.alert-title>Gagal memperbarui sertifikat:</x-ui.alert-title>
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
              <x-ui.field-label for="id_peserta">Peserta Penerima <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="id_peserta" id="id_peserta" native class="w-full">
                <option value="">-- Pilih Peserta --</option>
                @foreach ($pesertas ?? [] as $p)
                  <option value="{{ $p->id_peserta ?? $p->id }}" @selected(old('id_peserta', $sertifikat->id_peserta) == ($p->id_peserta ?? $p->id))>
                    {{ $p->user->name ?? 'Peserta #' . ($p->id_peserta ?? $p->id) }} {{ isset($p->nomor_peserta) ? '(' . $p->nomor_peserta . ')' : '' }}
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_peserta')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('id_jadwal') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_jadwal">Program / Jadwal & Kelas <span class="text-destructive">*</span></x-ui.field-label>
              <x-ui.select name="id_jadwal" id="id_jadwal" native class="w-full">
                <option value="">-- Pilih Jadwal --</option>
                @foreach ($jadwals ?? [] as $j)
                  <option value="{{ $j->id_jadwal ?? $j->id }}" @selected(old('id_jadwal', $sertifikat->id_jadwal) == ($j->id_jadwal ?? $j->id))>
                    {{ $j->pelatihan->nama_pelatihan ?? '-' }} {{ $j->tanggal_mulai ? '— ' . \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') : '' }}
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_jadwal')" />
            </x-ui.field>
          </div>

          <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <x-ui.field data-invalid="{{ $errors->has('no_sertifikat') ? 'true' : 'false' }}">
              <x-ui.field-label for="no_sertifikat">Nomor Sertifikat</x-ui.field-label>
              <x-ui.input
                id="no_sertifikat"
                name="no_sertifikat"
                type="text"
                :value="old('no_sertifikat', $sertifikat->no_sertifikat ?? $sertifikat->nomor_sertifikat)"
                placeholder="Contoh: SERT/BLK/2026/001"
              />
              <x-ui.field-error :messages="$errors->get('no_sertifikat')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('tanggal_terbit') ? 'true' : 'false' }}">
              <x-ui.field-label for="tanggal_terbit">Tanggal Terbit</x-ui.field-label>
              <x-ui.input
                id="tanggal_terbit"
                name="tanggal_terbit"
                type="date"
                :value="old('tanggal_terbit', $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('Y-m-d') : '')"
              />
              <x-ui.field-error :messages="$errors->get('tanggal_terbit')" />
            </x-ui.field>

            <x-ui.field data-invalid="{{ $errors->has('id_admin') ? 'true' : 'false' }}">
              <x-ui.field-label for="id_admin">Admin Penanggung Jawab</x-ui.field-label>
              <x-ui.select name="id_admin" id="id_admin" native class="w-full">
                <option value="">-- Pilih Admin --</option>
                @foreach ($admins ?? [] as $a)
                  <option value="{{ $a->id_admin ?? $a->id }}" @selected(old('id_admin', $sertifikat->id_admin) == ($a->id_admin ?? $a->id))>
                    {{ $a->user->name ?? 'Admin #' . ($a->id_admin ?? $a->id) }}
                  </option>
                @endforeach
              </x-ui.select>
              <x-ui.field-error :messages="$errors->get('id_admin')" />
            </x-ui.field>
          </div>

          <x-ui.field data-invalid="{{ $errors->has('file_sertifikat') ? 'true' : 'false' }}">
            <x-ui.field-label for="file_sertifikat">
              Berkas Sertifikat Baru
              <span class="font-normal text-muted-foreground">(Biarkan kosong jika tidak ingin mengganti file)</span>
            </x-ui.field-label>

            @if ($sertifikat->file_sertifikat)
              <div class="mb-2 flex flex-wrap items-center gap-2 rounded-lg border border-border bg-muted/40 p-2.5 text-xs">
                <x-lucide-file-check class="size-4 shrink-0 text-primary" />
                <span class="font-medium text-muted-foreground">Berkas tersimpan saat ini:</span>
                <a
                  href="{{ Storage::url($sertifikat->file_sertifikat) }}"
                  target="_blank"
                  class="inline-flex items-center gap-1 font-bold text-primary hover:underline"
                >
                  <span>Lihat Dokumen</span>
                  <x-lucide-external-link class="size-3" />
                </a>
              </div>
            @endif

            <input
              id="file_sertifikat"
              type="file"
              name="file_sertifikat"
              accept=".pdf,.jpg,.jpeg,.png"
              class="w-full rounded-md border border-border bg-card px-3 py-2 text-xs font-medium text-foreground shadow-xs file:me-4 file:rounded-md file:border-0 file:bg-accent file:px-3 file:py-1 file:text-xs file:font-semibold file:text-accent-foreground hover:file:bg-accent/80 focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:outline-none"
            >
            <x-ui.field-error :messages="$errors->get('file_sertifikat')" />
          </x-ui.field>

          <div class="flex items-center justify-end gap-2 border-t border-border pt-4">
            <x-ui.button href="{{ route('sertifikat.index') }}" variant="outline">
              Batal
            </x-ui.button>

            <x-ui.button type="submit" class="bg-sikarir-lime font-bold text-sikarir-ink hover:bg-[#e5ff83]">
              <x-lucide-check />
              Perbarui Sertifikat
            </x-ui.button>
          </div>
        </form>
      </x-ui.card-content>
    </x-ui.card>
  </div>
@endsection
