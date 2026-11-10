@extends('layouts.app')

@section('title', 'Edit Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
<div class="space-y-6 sm:space-y-8">
    <!-- Header Section & Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm relative overflow-hidden">
        <div class="space-y-2 relative z-10 max-w-2xl">
            <!-- Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 border border-emerald-200/80 rounded-full text-emerald-800 text-[11px] font-bold tracking-wide">
                <span class="w-2 h-2 rounded-full bg-lime-1000"></span>
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
        <div class="flex items-center gap-2.5 flex-wrap relative z-10 shrink-0">
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
    <form action="{{ route('pelatihan.update', $pelatihan->id_pelatihan) }}" method="POST"
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

                    <span class="text-xs font-mono font-bold bg-lime-100 text-lime-800 border border-lime-300/80 px-3 py-1 rounded-full">
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
                        class="w-full bg-lime-1000 hover:bg-lime-300 text-emerald-950 font-black text-xs py-3.5 px-4 rounded-xl shadow-md shadow-lime-400/30 flex items-center justify-center gap-2 active:scale-95 transition-all cursor-pointer">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>

                    <a href="{{ route('pelatihan.index') }}"
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition active:scale-95">
                        <span>Batal</span>
                    </a>
                </div>
            </div>

            <!-- Zona Berbahaya Card -->
            <div class="bg-rose-50/60 rounded-3xl border border-rose-200 shadow-sm p-6 space-y-3">
                <div class="flex items-center gap-2 text-rose-800">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                    <h4 class="font-black text-xs uppercase tracking-wider">Zona Perhatian</h4>
                </div>
                <p class="text-xs text-rose-700/90 leading-relaxed font-medium">
                    Perubahan kapasitas kuota atau durasi belajar akan langsung berlaku untuk pendaftaran batch jadwal kelas selanjutnya.
                </p>
            </div>
        </div>
    </form>
</div>
@endsection
