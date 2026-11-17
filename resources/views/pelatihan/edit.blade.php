@extends('layouts.app')

@section('title', 'Edit Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
<div class="pelatihan-admin space-y-6 sm:space-y-8">
    <!-- Header Section & Actions -->
    <div class="pelatihan-page-header flex flex-col md:flex-row md:items-end justify-between gap-5 p-6 sm:p-8 relative overflow-hidden">
        <div class="space-y-2 relative z-10 max-w-2xl">
            <p class="pelatihan-breadcrumb">Beranda <span>›</span> Program Pelatihan <span>›</span> Edit Program</p>
            <!-- Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 border border-emerald-200/80 rounded-full text-emerald-800 text-[11px] font-bold tracking-wide">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>PEMBARUAN KURIKULUM</span>
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Edit Program Pelatihan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Perbarui kapasitas kuota, rincian jam pelajaran, penanggung jawab instruktur, atau deskripsi silabus kejuruan.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="pelatihan-header-actions flex items-center gap-2.5 flex-wrap relative z-10 shrink-0">
            <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}"
                class="bg-white hover:bg-slate-50 text-slate-700 hover:text-emerald-800 border border-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm hover:shadow transition-all duration-200 active:scale-[0.98]">
                <i data-lucide="eye" class="w-4 h-4 text-emerald-600"></i>
                <span>Lihat Detail</span>
            </a>

            <a href="{{ route('pelatihan.index') }}"
                class="bg-white hover:bg-slate-50 text-slate-700 hover:text-emerald-800 border border-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm hover:shadow transition-all duration-200 active:scale-[0.98]">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="absolute -right-12 -top-12 w-56 h-56 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Error Validation Banner -->
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-5 rounded-2xl text-xs space-y-2 shadow-sm animate-in fade-in duration-200">
            <div class="font-bold flex items-center gap-2 text-rose-900">
                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                <span>Periksa kembali beberapa input berikut:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-rose-700 pl-4 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Layout: 2 Columns -->
    <form action="{{ route('pelatihan.update', $pelatihan->id_pelatihan) }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 items-start">
        @csrf
        @method('PUT')

        <!-- Main Form Fields (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
                <!-- Section Header with Code Badge -->
                <div class="pb-4 border-b border-slate-100 flex items-center justify-between gap-3 flex-wrap">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                            <i data-lucide="book-open" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h2 class="font-black text-slate-900 text-sm sm:text-base tracking-tight">
                                Informasi Kejuruan &amp; Kurikulum
                            </h2>
                            <p class="text-xs text-slate-500">Sesuaikan kurikulum pelatihan vokasi BLK.</p>
                        </div>
                    </div>

                    <span class="text-xs font-mono font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 px-3 py-1 rounded-full">
                        #PLT-{{ str_pad((string) $pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                <div class="space-y-5">
                    <!-- Nama Program -->
                    <div class="space-y-1.5">
                        <label for="nama_pelatihan" class="block text-xs font-bold text-slate-700">
                            Nama Program Kejuruan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_pelatihan" id="nama_pelatihan"
                            value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan) }}"
                            class="w-full px-4 py-3 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition placeholder-slate-400 @error('nama_pelatihan') border-rose-400 bg-rose-50/50 @enderror" />
                        @error('nama_pelatihan')
                            <p class="text-rose-600 text-[11px] font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kuota & Durasi Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Kuota -->
                        <div class="space-y-1.5">
                            <label for="kuota" class="block text-xs font-bold text-slate-700">
                                Kapasitas Kuota Peserta <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="kuota" id="kuota"
                                    value="{{ old('kuota', $pelatihan->kuota) }}" min="1"
                                    class="w-full pl-4 pr-16 py-3 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition @error('kuota') border-rose-400 bg-rose-50/50 @enderror" />
                                <span class="absolute right-4 top-3 text-xs font-bold text-slate-400">Siswa</span>
                            </div>
                            @error('kuota')
                                <p class="text-rose-600 text-[11px] font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Durasi Pelatihan -->
                        <div class="space-y-1.5">
                            <label for="id_durasi" class="block text-xs font-bold text-slate-700">
                                Standar Durasi Belajar
                            </label>
                            <select name="id_durasi" id="id_durasi"
                                class="w-full px-4 py-3 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer @error('id_durasi') border-rose-400 bg-rose-50/50 @enderror">
                                <option value="" class="text-slate-400">-- Pilih Durasi Pelatihan --</option>
                                @foreach ($durations as $durasi)
                                    <option value="{{ $durasi->id_durasi }}"
                                        {{ old('id_durasi', $pelatihan->id_durasi) == $durasi->id_durasi ? 'selected' : '' }}>
                                        {{ $durasi->durasi_label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_durasi')
                                <p class="text-rose-600 text-[11px] font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Penanggung Jawab Admin BLK -->
                    <div class="space-y-1.5">
                        <label for="id_admin" class="block text-xs font-bold text-slate-700">
                            Penanggung Jawab / Pembina Kejuruan <span class="text-rose-500">*</span>
                        </label>
                        <select name="id_admin" id="id_admin"
                            class="w-full px-4 py-3 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer @error('id_admin') border-rose-400 bg-rose-50/50 @enderror">
                            <option value="" class="text-slate-400">-- Pilih Instruktur / Admin BLK --</option>
                            @foreach ($admins as $admin)
                                <option value="{{ $admin->id_admin }}"
                                    {{ old('id_admin', $pelatihan->id_admin) == $admin->id_admin ? 'selected' : '' }}>
                                    {{ $admin->user->name ?? 'Admin BLK' }} (NIP: {{ $admin->nip ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_admin')
                            <p class="text-rose-600 text-[11px] font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Silabus -->
                    <div class="space-y-1.5">
                        <label for="deskripsi_pelatihan" class="block text-xs font-bold text-slate-700">
                            Deskripsi Silabus &amp; Output Kompetensi
                        </label>
                        <textarea name="deskripsi_pelatihan" id="deskripsi_pelatihan" rows="5"
                            class="w-full px-4 py-3 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition placeholder-slate-400 leading-relaxed @error('deskripsi_pelatihan') border-rose-400 bg-rose-50/50 @enderror">{{ old('deskripsi_pelatihan', $pelatihan->deskripsi_pelatihan) }}</textarea>
                        @error('deskripsi_pelatihan')
                            <p class="text-rose-600 text-[11px] font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Simpan & Danger Zone (1 Col) -->
        <div class="space-y-6">
            <!-- Aksi Pembaruan Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="save" class="w-4 h-4 text-emerald-600"></i>
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Aksi Pembaruan</h3>
                </div>

                <!-- Timestamps Info -->
                <div class="p-3.5 bg-slate-50/80 rounded-2xl border border-slate-100 space-y-2 text-xs text-slate-500">
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

                <div class="space-y-2.5 pt-1">
                    <!-- 10% Accent CTA: Warm Gold (#F59E0B) -->
                    <button type="submit"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs py-3.5 px-4 rounded-xl shadow-md shadow-emerald-900/20 flex items-center justify-center gap-2 active:scale-95 transition-all cursor-pointer">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>

                    <a href="{{ route('pelatihan.index') }}"
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition active:scale-95">
                        <span>Batal</span>
                    </a>
                </div>
            </div>

            <!-- Upload Poster Card -->
                @php $adaGambar = (bool) $pelatihan->gambar_url; @endphp
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                        <i data-lucide="image" class="w-4 h-4 text-emerald-700"></i>
                        <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Poster Program</h3>
                    </div>

                    <label for="gambar" id="dropzone"
                        class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-slate-200 hover:border-emerald-500 bg-slate-50 hover:bg-emerald-50/40 rounded-2xl cursor-pointer overflow-hidden transition @error('gambar') border-rose-400 @enderror">

                    <!-- Placeholder -->
                    <div id="upload-placeholder" class="{{ $adaGambar ? 'hidden' : 'flex' }} flex-col items-center gap-2 text-center px-4">
                        <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-400"></i>
                        <p class="text-xs font-bold text-slate-600">Klik untuk upload gambar</p>
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
                    class="{{ $adaGambar ? '' : 'hidden' }} w-full text-xs font-bold text-rose-600 hover:text-rose-700 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 transition">
                    Hapus gambar
                </button>
                @error('gambar')
                    <p class="text-rose-600 text-[11px] font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </form>
</div>
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
