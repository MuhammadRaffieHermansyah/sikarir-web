@extends('layouts.app')

@section('title', 'Tambah Program Pelatihan Vokasi - Disnaker BLK')

@section('content')
<div class="space-y-6 sm:space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm relative overflow-hidden">
        <div class="space-y-2 relative z-10 max-w-2xl">
            <!-- Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 border border-emerald-200/80 rounded-full text-emerald-800 text-[11px] font-bold tracking-wide">
                <span class="w-2 h-2 rounded-full bg-lime-1000"></span>
                <span>FORMULIR KEJURUAN BARU</span>
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Tambah Program Pelatihan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Daftarkan kurikulum pelatihan vokasi baru dengan alokasi kuota peserta dan estimasi standar jam pelajaran.
            </p>
        </div>

        <!-- Back Button -->
        <div class="relative z-10 shrink-0">
            <a href="{{ route('pelatihan.index') }}"
                class="bg-white hover:bg-slate-50 text-slate-700 hover:text-emerald-800 border border-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm hover:shadow transition-all duration-200 active:scale-[0.98]">
                <i data-lucide="arrow-left" class="w-4 h-4 text-emerald-600"></i>
                <span>Kembali ke Daftar</span>
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
    <form action="{{ route('pelatihan.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 items-start">
        @csrf

        <!-- Main Form Fields (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
                <!-- Card Section Header -->
                <div class="pb-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                        <i data-lucide="book-open" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-900 text-sm sm:text-base tracking-tight">
                            Informasi Kejuruan & Kurikulum
                        </h2>
                        <p class="text-xs text-slate-500">Isi detail spesifikasi kejuruan yang akan dibuka.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Nama Program -->
                    <div class="space-y-1.5">
                        <label for="nama_pelatihan" class="block text-xs font-bold text-slate-700">
                            Nama Program Kejuruan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_pelatihan" id="nama_pelatihan" value="{{ old('nama_pelatihan') }}"
                            placeholder="Contoh: Teknik Las Fabrikasi / Desain Grafis Multimedia"
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
                                <input type="number" name="kuota" id="kuota" value="{{ old('kuota', 16) }}"
                                    min="1"
                                    class="w-full pl-4 pr-16 py-3 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition @error('kuota') border-rose-400 bg-rose-50/50 @enderror" />
                                <span class="absolute right-4 top-3 text-xs font-bold text-slate-400">Siswa</span>
                            </div>
                            <p class="text-[11px] text-slate-400">Standar kelas vokasi: 16 - 20 peserta/batch.</p>
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
                                        {{ old('id_durasi') == $durasi->id_durasi ? 'selected' : '' }}>
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
                                    {{ old('id_admin') == $admin->id_admin ? 'selected' : '' }}>
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
                            Deskripsi Silabus & Output Kompetensi
                        </label>
                        <textarea name="deskripsi_pelatihan" id="deskripsi_pelatihan" rows="5"
                            placeholder="Jelaskan ringkasan materi, standar kompetensi kerja, kurikulum kejuruan, dan sertifikasi BNSP..."
                            class="w-full px-4 py-3 text-xs sm:text-sm font-medium border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition placeholder-slate-400 leading-relaxed @error('deskripsi_pelatihan') border-rose-400 bg-rose-50/50 @enderror">{{ old('deskripsi_pelatihan') }}</textarea>
                        @error('deskripsi_pelatihan')
                            <p class="text-rose-600 text-[11px] font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Simpan & Panduan (1 Col) -->
        <div class="space-y-6">
            <!-- Aksi Simpan Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Aksi Simpan</h3>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed">
                    Setelah program disimpan, Anda dapat langsung mengatur ruangan dan membuka batch jadwal kelas.
                </p>

                <div class="space-y-2.5 pt-1">
                    <!-- 10% Accent CTA: Warm Gold (#F59E0B) -->
                    <button type="submit"
                        class="w-full bg-lime-1000 hover:bg-lime-300 text-emerald-950 font-black text-xs py-3.5 px-4 rounded-xl shadow-md shadow-lime-400/30 flex items-center justify-center gap-2 active:scale-95 transition-all cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Program Baru</span>
                    </button>

                    <a href="{{ route('pelatihan.index') }}"
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition active:scale-95">
                        <span>Batal</span>
                    </a>
                </div>
            </div>

            <!-- Panduan Vokasi Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Panduan Kurikulum</h3>
                </div>

                <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
                    <p>
                        Pastikan nama kejuruan mengacu pada Standar Kompetensi Kerja Nasional Indonesia (<strong>SKKNI</strong>) Disnakertrans.
                    </p>

                    <div class="p-4 bg-emerald-50/60 rounded-2xl border border-emerald-100 space-y-2 text-[11px]">
                        <div class="font-bold text-emerald-900 flex items-center gap-1.5">
                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span>Alur Pembukaan Kelas:</span>
                        </div>
                        <ol class="list-decimal list-inside space-y-1 text-emerald-800/90 pl-1 font-medium">
                            <li>Buat Program Pelatihan (di sini)</li>
                            <li>Tentukan Jadwal &amp; Ruangan</li>
                            <li>Buka Pendaftaran Siswa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
