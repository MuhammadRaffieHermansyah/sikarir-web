@extends('layouts.app')

@section('title', 'Edit Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
  <!-- Title & Breadcrumbs -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin-blk.index') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span>&gt;</span>
        <a href="{{ route('pelatihan.index') }}" class="hover:text-emerald-700 transition">Program Pelatihan</a>
        <span>&gt;</span>
        <span class="text-slate-600 font-medium">Edit Program</span>
      </div>
      <h1 class="text-xl font-black text-slate-900 tracking-tight">Edit Program Pelatihan</h1>
      <p class="text-xs text-slate-500 mt-0.5">Perbarui kapasitas kuota, rincian jam pelajaran, penanggung jawab instruktur, atau deskripsi silabus kejuruan.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="eye" class="w-4 h-4"></i> Lihat Detail
      </a>
      <a href="{{ route('pelatihan.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
      </a>
    </div>
  </div>

  @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
      <div class="font-bold flex items-center gap-1.5">
        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
        Mohon perbaiki beberapa kesalahan berikut:
      </div>
      <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-4">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form Layout: 2 Columns -->
  <form action="{{ route('pelatihan.update', $pelatihan->id_pelatihan) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    @csrf
    @method('PUT')

    <!-- Main Form Fields (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between gap-3 flex-wrap">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
              <i data-lucide="book-open" class="w-4 h-4"></i>
            </div>
            <h2 class="font-bold text-slate-800 text-sm">Informasi Kejuruan &amp; Kurikulum</h2>
          </div>
          <span class="font-mono text-[11px] text-slate-400">
            #PLT-{{ str_pad((string) $pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
          </span>
        </div>

        <!-- Nama Program -->
        <div>
          <label for="nama_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
            Nama Program Kejuruan <span class="text-rose-500">*</span>
          </label>
          <input type="text" name="nama_pelatihan" id="nama_pelatihan"
            value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan) }}"
            class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent placeholder-slate-400 @error('nama_pelatihan') border-rose-400 bg-rose-50/50 @enderror" />
          @error('nama_pelatihan')
            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Kuota & Durasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="kuota" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Kapasitas Kuota Peserta <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
              <input type="number" name="kuota" id="kuota" value="{{ old('kuota', $pelatihan->kuota) }}" min="1"
                class="w-full pl-3 pr-14 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent @error('kuota') border-rose-400 bg-rose-50/50 @enderror" />
              <span class="absolute right-3 top-2 text-xs text-slate-400 font-medium">Siswa</span>
            </div>
            @error('kuota')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="id_durasi" class="block text-xs font-semibold text-slate-700 mb-1.5">
              Standar Durasi Belajar
            </label>
            <select name="id_durasi" id="id_durasi"
              class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent cursor-pointer @error('id_durasi') border-rose-400 bg-rose-50/50 @enderror">
              <option value="">-- Pilih Durasi Pelatihan --</option>
              @foreach ($durations as $durasi)
                <option value="{{ $durasi->id_durasi }}"
                  {{ old('id_durasi', $pelatihan->id_durasi) == $durasi->id_durasi ? 'selected' : '' }}>
                  {{ $durasi->durasi_label }}
                </option>
              @endforeach
            </select>
            @error('id_durasi')
              <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Instruktur Penanggung Jawab -->
        <div>
          <label for="id_instruktur" class="block text-xs font-semibold text-slate-700 mb-1.5">
            Instruktur Penanggung Jawab <span class="text-rose-500">*</span>
          </label>
          <select name="id_instruktur" id="id_instruktur"
            class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent cursor-pointer @error('id_instruktur') border-rose-400 bg-rose-50/50 @enderror">
            <option value="">-- Pilih Instruktur --</option>
            @foreach ($instrukturs as $instruktur)
              <option value="{{ $instruktur->id }}"
                {{ old('id_instruktur', $pelatihan->id_instruktur) == $instruktur->id ? 'selected' : '' }}>
                {{ $instruktur->nama }} — {{ $instruktur->bidang_keahlian ?: 'Bidang belum diisi' }}
              </option>
            @endforeach
          </select>
          @error('id_instruktur')
            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Deskripsi -->
        <div>
          <label for="deskripsi_pelatihan" class="block text-xs font-semibold text-slate-700 mb-1.5">
            Deskripsi Silabus &amp; Output Kompetensi
          </label>
          <textarea name="deskripsi_pelatihan" id="deskripsi_pelatihan" rows="5"
            class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent placeholder-slate-400 leading-relaxed @error('deskripsi_pelatihan') border-rose-400 bg-rose-50/50 @enderror">{{ old('deskripsi_pelatihan', $pelatihan->deskripsi_pelatihan) }}</textarea>
          @error('deskripsi_pelatihan')
            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <!-- Right Column: Poster & Simpan -->
    <div class="space-y-6">
      <!-- Upload Poster Card -->
      @php $adaGambar = (bool) $pelatihan->gambar_url; @endphp
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="image" class="w-4 h-4 text-emerald-700"></i>
          Poster Program
        </h3>

        <label for="gambar" id="dropzone"
          class="relative flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-slate-200 hover:border-emerald-500 bg-slate-50 hover:bg-emerald-50/40 rounded-lg cursor-pointer overflow-hidden transition @error('gambar') border-rose-400 @enderror">
          <!-- Placeholder -->
          <div id="upload-placeholder" class="{{ $adaGambar ? 'hidden' : 'flex' }} flex-col items-center gap-2 text-center px-4">
            <i data-lucide="upload-cloud" class="w-7 h-7 text-slate-400"></i>
            <p class="text-xs font-semibold text-slate-600">Klik untuk upload gambar</p>
            <p class="text-[11px] text-slate-400">JPG, PNG, WEBP. Maks 2 MB.</p>
          </div>

          <!-- Preview (gambar lama kalau ada) -->
          <img id="upload-preview" src="{{ $pelatihan->gambar_url }}" alt="Preview poster"
            class="{{ $adaGambar ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover" />

          <input type="file" name="gambar" id="gambar" accept="image/png,image/jpeg,image/webp" class="hidden" />
        </label>

        <!-- Penanda: 1 = hapus gambar lama -->
        <input type="hidden" name="hapus_gambar" id="hapus_gambar" value="0">
        <button type="button" id="remove-image"
          class="{{ $adaGambar ? '' : 'hidden' }} w-full text-xs font-semibold text-rose-600 hover:text-rose-700 py-2 rounded-lg bg-rose-50 hover:bg-rose-100 transition">
          Hapus gambar
        </button>
        @error('gambar')
          <p class="text-rose-600 text-[11px]">{{ $message }}</p>
        @enderror
      </div>

      <!-- Info & Simpan -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
        <h3 class="font-bold text-slate-800 text-xs pb-2 border-b border-slate-100 flex items-center gap-2">
          <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
          Informasi Program
        </h3>

        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 space-y-2 text-[11px] text-slate-500">
          <div class="flex items-center justify-between">
            <span>Dibuat:</span>
            <span class="font-bold text-slate-700">
              {{ $pelatihan->created_at ? $pelatihan->created_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
          <div class="flex items-center justify-between">
            <span>Terakhir diubah:</span>
            <span class="font-bold text-slate-700">
              {{ $pelatihan->updated_at ? $pelatihan->updated_at->translatedFormat('d M Y') : '-' }}
            </span>
          </div>
        </div>

        <div class="pt-2 space-y-2">
          <button type="submit" class="w-full bg-emerald-900 hover:bg-emerald-950 text-white font-semibold text-xs py-2.5 px-4 rounded-lg shadow-sm flex items-center justify-center gap-2 transition cursor-pointer">
            <i data-lucide="check" class="w-4 h-4"></i> Simpan Perubahan
          </button>
          <a href="{{ route('pelatihan.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition">
            Batal
          </a>
        </div>
      </div>
    </div>
  </form>
@push('scripts')
<script>
    const input = document.getElementById('gambar');
    const preview = document.getElementById('upload-preview');
    const placeholder = document.getElementById('upload-placeholder');
    const removeBtn = document.getElementById('remove-image');
    const hapusInput = document.getElementById('hapus_gambar');
    const adaGambarLama = {{ $adaGambar ? 'true' : 'false' }};

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2 MB.');
            input.value = '';
            return;
        }
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        placeholder.classList.remove('flex');
        removeBtn.classList.remove('hidden');
        hapusInput.value = '0';
    });

    removeBtn.addEventListener('click', () => {
        input.value = '';
        preview.removeAttribute('src');
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        placeholder.classList.add('flex');
        removeBtn.classList.add('hidden');
        hapusInput.value = adaGambarLama ? '1' : '0';
    });
</script>
@endpush
@endsection
