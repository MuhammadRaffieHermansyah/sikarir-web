@extends('layouts.app')

@section('title', 'Katalog Program Pelatihan Vokasi - Disnaker BLK')

@section('content')
<div class="space-y-6 sm:space-y-8">
    <!-- Header Section & Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm relative overflow-hidden">
        <div class="space-y-2 relative z-10 max-w-2xl">
            <!-- Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 border border-emerald-200/80 rounded-full text-emerald-800 text-[11px] font-bold tracking-wide">
                <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span>
                <span>KEJURUAN & KURIKULUM VOKASI</span>
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Katalog Program Pelatihan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Kelola kurikulum kejuruan, kuota siswa, durasi jam pelatihan, dan alokasi instruktur vokasi terstandarisasi.
            </p>
        </div>

        <!-- Action CTAs -->
        <div class="flex items-center gap-2.5 flex-wrap relative z-10 shrink-0">
            <a href="{{ route('jadwal-pelatihan.index') }}"
                class="bg-white hover:bg-slate-50 text-slate-700 hover:text-emerald-800 border border-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-sm hover:shadow transition-all duration-200 active:scale-[0.98]">
                <i data-lucide="calendar" class="w-4 h-4 text-emerald-600"></i>
                <span>Jadwal Kelas</span>
            </a>

            <!-- 10% Accent CTA: Warm Gold (#F59E0B) -->
            <a href="{{ route('pelatihan.create') }}"
                class="bg-lime-400 hover:bg-lime-300 text-emerald-950 text-xs font-black px-4 py-2.5 rounded-xl flex items-center gap-2 shadow-md shadow-lime-400/30 active:scale-[0.98] transition-all duration-200">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Program Baru</span>
            </a>
        </div>

        <!-- Decorative Subtle Glow -->
        <div class="absolute -right-12 -top-12 w-56 h-56 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Flash Alert Success -->
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-5 py-4 rounded-2xl text-xs font-semibold flex items-center justify-between shadow-sm animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 p-1.5 rounded-lg hover:bg-emerald-100/60 transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    <!-- Metrics Bento Grid (4 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Card 1: Total Program -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between gap-3 mb-3">
                <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider bg-emerald-50 px-2.5 py-1 rounded-lg">
                    Kejuruan Aktif
                </span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $pelatihans->total() }}
                </div>
                <p class="text-xs text-slate-500 mt-1 font-medium">Program kejuruan terdaftar</p>
            </div>
        </div>

        <!-- Card 2: Kuota Siswa -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between gap-3 mb-3">
                <span class="text-[11px] font-bold text-lime-800 uppercase tracking-wider bg-lime-100 px-2.5 py-1 rounded-lg">
                    Kapasitas Siswa
                </span>
                <div class="w-10 h-10 rounded-xl bg-lime-100 text-lime-700 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $pelatihans->sum('kuota') }}
                </div>
                <p class="text-xs text-slate-500 mt-1 font-medium">Total alokasi kursi batch</p>
            </div>
        </div>

        <!-- Card 3: Standar Durasi -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between gap-3 mb-3">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider bg-slate-100 px-2.5 py-1 rounded-lg">
                    Standar Jam
                </span>
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    240 - 320
                </div>
                <p class="text-xs text-slate-500 mt-1 font-medium">Jam Pelajaran (JP) reguler</p>
            </div>
        </div>

        <!-- Card 4: Standar Kompetensi -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between gap-3 mb-3">
                <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider bg-emerald-50 px-2.5 py-1 rounded-lg">
                    Sertifikasi
                </span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    BNSP & SKKNI
                </div>
                <p class="text-xs text-slate-500 mt-1 font-medium">Uji kompetensi terakreditasi</p>
            </div>
        </div>
    </div>

    <!-- Table Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Table Card Header & Search Bar -->
        <div class="p-6 sm:p-7 border-b border-slate-100 bg-white flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h2 class="text-base sm:text-lg font-black text-emerald-900 tracking-tight">
                        Daftar Kejuruan & Kurikulum Pelatihan
                    </h2>
                    <span class="bg-lime-100 text-lime-800 border border-lime-300/80 text-[10px] font-bold px-2.5 py-0.5 rounded-full inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-lime-500"></span>
                        {{ $pelatihans->total() }} Program
                    </span>
                </div>
                <p class="text-xs text-slate-500">
                    Menampilkan seluruh program kejuruan aktif berbasis kompetensi kerja Disnakertrans.
                </p>
            </div>

            <!-- Form Pencarian Search Filter Component -->
            <x-search-filter :action="route('pelatihan.index')" search-placeholder="Cari program kejuruan..." />
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 border-b border-slate-100 uppercase tracking-wider text-[11px] font-bold">
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Program Kejuruan</th>
                        <th class="px-6 py-4">Alokasi Kuota</th>
                        <th class="px-6 py-4">Durasi Belajar</th>
                        <th class="px-6 py-4">Penanggung Jawab</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($pelatihans as $pelatihan)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                            <!-- Kode / ID -->
                            <td class="px-6 py-4.5 font-mono text-[11px] font-bold text-slate-400 group-hover:text-emerald-700 transition">
                                #PLT-{{ str_pad((string) $pelatihan->id_pelatihan, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <!-- Program Kejuruan -->
                            <td class="px-6 py-4.5">
                                <div class="flex items-center gap-3.5 min-w-[240px]">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs shrink-0 group-hover:scale-105 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-200">
                                        <i data-lucide="book-open" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}"
                                            class="font-bold text-slate-900 group-hover:text-emerald-700 text-xs sm:text-sm tracking-tight transition line-clamp-1">
                                            {{ $pelatihan->nama_pelatihan }}
                                        </a>
                                        <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5 max-w-sm">
                                            {{ $pelatihan->deskripsi_pelatihan ?? 'Belum ada deskripsi kurikulum terlampir.' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Alokasi Kuota -->
                            <td class="px-6 py-4.5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-lime-100 text-lime-800 border border-lime-300/80">
                                    <i data-lucide="users" class="w-3.5 h-3.5 text-lime-600"></i>
                                    {{ $pelatihan->kuota }} Kursi
                                </span>
                            </td>

                            <!-- Durasi Belajar -->
                            <td class="px-6 py-4.5">
                                <span class="inline-flex items-center gap-1.5 text-slate-700 font-semibold text-xs">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    {{ $pelatihan->durasi_label ?? '-' }}
                                </span>
                            </td>

                            <!-- Penanggung Jawab -->
                            <td class="px-6 py-4.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($pelatihan->admin->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="text-slate-700 font-medium text-xs truncate max-w-[150px]">
                                        {{ $pelatihan->admin->user->name ?? 'Admin BLK' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4.5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('pelatihan.show', $pelatihan->id_pelatihan) }}"
                                        class="p-2 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition"
                                        title="Lihat Detail">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>

                                    <a href="{{ route('pelatihan.edit', $pelatihan->id_pelatihan) }}"
                                        class="p-2 text-slate-500 hover:text-lime-700 hover:bg-lime-100 rounded-xl transition"
                                        title="Edit Kurikulum">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>

                                    <form action="{{ route('pelatihan.destroy', $pelatihan->id_pelatihan) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kejuruan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                                            title="Hapus Program">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3.5">
                                    <i data-lucide="book-open" class="w-7 h-7"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-sm">Tidak Ada Program Kejuruan Ditemukan</h3>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Coba ubah kata kunci pencarian atau bersihkan filter yang aktif.
                                </p>
                                @if (request('search'))
                                    <a href="{{ route('pelatihan.index') }}"
                                        class="inline-flex items-center gap-1.5 mt-4 text-emerald-700 hover:text-emerald-800 text-xs font-bold hover:underline">
                                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter Pencarian
                                    </a>
                                @else
                                    <a href="{{ route('pelatihan.create') }}"
                                        class="inline-flex items-center gap-2 mt-4 bg-lime-400 hover:bg-lime-300 text-emerald-950 text-xs font-black px-4 py-2 rounded-xl shadow-sm transition">
                                        <i data-lucide="plus" class="w-4 h-4"></i> Buat Program Baru
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($pelatihans->hasPages())
            <div class="p-6 border-t border-slate-100 bg-white">
                {{ $pelatihans->withQueryString()->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
