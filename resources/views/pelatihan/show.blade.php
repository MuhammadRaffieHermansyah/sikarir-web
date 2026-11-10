@extends('layouts.app')

@section('title', 'Detail Program Pelatihan - ' . $pelatihan->nama_pelatihan)

@section('content')
<div class="space-y-6 sm:space-y-8">
    <!-- Header Section & Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm relative overflow-hidden">
        <div class="space-y-2 relative z-10 max-w-2xl">
            <!-- Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 border border-emerald-200/80 rounded-full text-emerald-800 text-[11px] font-bold tracking-wide">
                <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span>
                <span>RINCIAN KURIKULUM &amp; KELAS</span>
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                {{ $pelatihan->nama_pelatihan }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Spesifikasi kompetensi vokasi, silabus pembelajaran, kapasitas kuota, dan jadwal batch pelaksanaan kelas.
            </p>
        </div>

        <!-- Action CTAs -->
        <div class="flex items-center gap-2.5 flex-wrap relative z-10 shrink-0">
            <a href="{{ route('pelatihan.index') }}"
                class="bg-white hover:bg-slate-50 text-slate-700 hover:text-emerald-800 border border-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm hover:shadow transition-all duration-200 active:scale-[0.98]">
                <i data-lucide="arrow-left" class="w-4 h-4 text-emerald-600"></i>
                <span>Kembali</span>
            </a>

            <!-- 10% Accent CTA: Warm Gold (#F59E0B) -->
            <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}"
                class="bg-lime-1000 hover:bg-lime-300 text-emerald-950 text-xs font-black px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-md shadow-lime-400/30 active:scale-[0.98] transition-all duration-200">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Kurikulum</span>
            </a>
        </div>

        <div class="absolute -right-12 -top-12 w-56 h-56 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Hero Profile Banner Card (30% Emerald Brand Identity) -->
    

    <!-- Quick Stats Bento Grid (3 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
        <!-- Stat 1: Total Batch -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Batch Jadwal</div>
                <div class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">
                    {{ count($pelatihan->jadwal ?? []) }} Batch
                </div>
            </div>
        </div>

        <!-- Stat 2: Kuota / Angkatan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-lime-100 text-lime-700 flex items-center justify-center shrink-0">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kapasitas / Angkatan</div>
                <div class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">
                    {{ $pelatihan->kuota }} Peserta
                </div>
            </div>
        </div>

        <!-- Stat 3: Standar Kompetensi -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Standar Sertifikasi</div>
                <div class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">
                    BNSP &amp; SKKNI
                </div>
            </div>
        </div>
    </div>

    <!-- Main Detail Grid (2 Cols left, 1 Col right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 items-start">
        <!-- Left 2 Cols: Silabus & Jadwal Batch -->
        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
            <!-- Card 1: Silabus & Deskripsi -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base tracking-tight">
                            Deskripsi Silabus &amp; Output Kejuruan
                        </h3>
                        <p class="text-xs text-slate-500">Materi dan keahlian kerja yang dipelajari selama pelatihan vokasi.</p>
                    </div>
                </div>

                <div class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-100 font-normal">
                    {{ $pelatihan->deskripsi_pelatihan ?: 'Belum ada silabus / deskripsi pelatihan yang ditambahkan untuk kejuruan ini.' }}
                </div>
            </div>

            <!-- Card 2: Jadwal Kelas Aktif -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-6 sm:p-7 border-b border-slate-100 bg-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                            <i data-lucide="calendar-check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm sm:text-base tracking-tight">
                                Batch &amp; Jadwal Kelas
                            </h3>
                            <p class="text-xs text-slate-500">Jadwal yang dibuka untuk program kejuruan ini.</p>
                        </div>
                    </div>

                    <!-- 10% Accent Link CTA: Cyan -->
                    <a href="{{ route('jadwal-pelatihan.create') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-950 bg-emerald-50 hover:bg-emerald-100 px-3.5 py-2 rounded-xl transition">
                        <i data-lucide="plus" class="w-4 h-4 text-emerald-700"></i>
                        <span>Buka Batch Baru</span>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50/80 text-slate-400 border-b border-slate-100 uppercase tracking-wider text-[11px] font-bold">
                                <th class="px-6 py-4">Instruktur</th>
                                <th class="px-6 py-4">Ruangan</th>
                                <th class="px-6 py-4">Hari &amp; Jam</th>
                                <th class="px-6 py-4">Peserta Terdaftar</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pelatihan->jadwal ?? [] as $jadwal)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-900">
                                        {{ $jadwal->instruktur ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 font-medium">
                                        {{ $jadwal->ruangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 font-medium">
                                        {{ $jadwal->hari ?? '-' }} <span class="text-slate-400">({{ $jadwal->jam ?? '-' }})</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-lime-100 text-lime-800 border border-lime-300/80">
                                            <i data-lucide="users" class="w-3.5 h-3.5 text-lime-600"></i>
                                            {{ count($jadwal->kelas ?? []) }} Siswa
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('jadwal-pelatihan.show', $jadwal->id_jadwal) }}"
                                            class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-900 font-bold hover:underline">
                                            <span>Rincian</span>
                                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                            <i data-lucide="calendar" class="w-5 h-5"></i>
                                        </div>
                                        <p class="font-medium text-xs">Belum ada batch jadwal kelas yang dibuat untuk program ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Metadata & Aksi -->
        <div class="space-y-6">
            <!-- Metadata Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="info" class="w-4 h-4 text-emerald-700"></i>
                    <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Metadata Pelatihan</h4>
                </div>

                <div class="space-y-3.5 text-xs">
                    <div class="flex items-center justify-between text-slate-700">
                        <span class="text-slate-400">Durasi Pelatihan:</span>
                        <span class="font-bold text-slate-900">{{ $pelatihan->durasi_label ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-700">
                        <span class="text-slate-400">Target Kuota Siswa:</span>
                        <span class="font-bold text-lime-800 bg-lime-100 px-2 py-0.5 rounded-md">{{ $pelatihan->kuota }} Siswa / Batch</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-700">
                        <span class="text-slate-400">Terdaftar Pada:</span>
                        <span class="font-bold text-slate-900">
                            {{ $pelatihan->created_at ? $pelatihan->created_at->translatedFormat('d M Y') : '-' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-slate-700">
                        <span class="text-slate-400">Terakhir Diperbarui:</span>
                        <span class="font-bold text-slate-900">
                            {{ $pelatihan->updated_at ? $pelatihan->updated_at->translatedFormat('d M Y') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Aksi Administratif Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-3">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="sliders" class="w-4 h-4 text-emerald-700"></i>
                    <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Aksi Administratif</h4>
                </div>

                <div class="space-y-2.5">
                    <!-- 10% Accent CTA: Warm Gold (#F59E0B) -->
                    <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}"
                        class="w-full px-4 py-3 bg-lime-1000 hover:bg-lime-300 text-emerald-950 text-xs font-black rounded-xl shadow-md shadow-lime-400/30 flex items-center justify-center gap-2 active:scale-95 transition-all">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        <span>Edit Kurikulum</span>
                    </a>

                    <a href="{{ route('jadwal-pelatihan.create') }}"
                        class="w-full px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl flex items-center justify-center gap-2 transition active:scale-95">
                        <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                        <span>Buat Jadwal Baru</span>
                    </a>

                    <form action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kejuruan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-3 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-xl flex items-center justify-center gap-2 transition active:scale-95 cursor-pointer">
                            <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i>
                            <span>Hapus Program</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
