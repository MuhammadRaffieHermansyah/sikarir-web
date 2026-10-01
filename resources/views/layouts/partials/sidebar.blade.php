{{-- Sidebar responsif: drawer (mobile < md), kolom tetap (tablet/desktop >= md) --}}
<div id="sidebarOverlay"
    class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-[2px] opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"
    aria-hidden="true"></div>

<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85vw] md:static md:z-auto md:w-60 md:max-w-none lg:w-64
           h-screen shrink-0 bg-white border-r border-slate-200 flex flex-col
           shadow-2xl md:shadow-none
           -translate-x-full md:translate-x-0 transition-transform duration-300 ease-out md:transition-none"
    aria-label="Menu navigasi">

    <div class="scrollbar-none flex-1 min-h-0 overflow-y-auto overscroll-contain">
        <div class="p-4 flex items-center justify-between gap-3 border-b border-slate-100 bg-white sticky top-0 z-10">
            <!-- Gambar Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 min-w-0 group">
                <img src="{{ asset('images/logo-sikarir.png') }}" alt="Logo siKarir BLK Jember"
                    class="h-10 w-auto object-contain">
            </a>

            <!-- Tombol tutup (khusus mobile) -->
            <button id="sidebarClose" type="button"
                class="md:hidden w-8 h-8 shrink-0 rounded-lg border border-slate-200 bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-slate-800 flex items-center justify-center transition active:scale-95"
                aria-label="Tutup menu">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Menu Navigation -->
        <nav class="p-3 text-xs font-medium space-y-6">

            @if (auth()->user()->role === 'admin_blk')
                <!-- UTAMA -->
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">
                        Utama
                    </div>

                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('dashboard')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <i data-lucide="layout-dashboard"
                            class="w-4 h-4 shrink-0 transition-colors duration-200
                           {{ request()->routeIs('dashboard') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                        </i>

                        Dashboard Ringkasan
                    </a>
                </div>


                <!-- MANAJEMEN DATA -->
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">
                        Manajemen Data
                    </div>

                    <!-- Admin BLK -->
                    {{-- <a href="{{ route('admin-blk.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('admin-blk.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="shield-check"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                               {{ request()->routeIs('admin-blk.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Admin BLK</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-800 text-[10px] font-semibold px-1.5 py-0.5 rounded">
                            {{ \App\Models\AdminBlk::count() }} Admin
                        </span>
                    </a> --}}


                    <!-- Program Pelatihan -->
                    <a href="{{ route('pelatihan.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('pelatihan.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="book"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                               {{ request()->routeIs('pelatihan.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Program Pelatihan</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\DaftarPelatihan::count() }} Aktif
                        </span>
                    </a>


                    <!-- Durasi Pelatihan -->
                    <a href="{{ route('durasi-pelatihan.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('durasi-pelatihan.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="timer"
                               class="w-4 h-4 shrink-0 transition-colors duration-200
                                   {{ request()->routeIs('durasi-pelatihan.*')
                                       ? 'text-emerald-600'
                                       : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Durasi Pelatihan</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\DurasiPelatihan::count() }} Data
                        </span>
                    </a>


                    <!-- Instruktur -->
                    <a href="{{ route('instruktur.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('instruktur.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="user-check"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                                   {{ request()->routeIs('instruktur.*')
                                       ? 'text-emerald-600'
                                       : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Instruktur</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\Instruktur::count() }} Orang
                        </span>
                    </a>


                    <!-- Ruangan Workshop -->
                    <a href="{{ route('ruangan-workshop.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('ruangan-workshop.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="building-2"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                                   {{ request()->routeIs('ruangan-workshop.*')
                                       ? 'text-emerald-600'
                                       : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Ruangan Workshop</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\RuanganWorkshop::count() }} Ruangan
                        </span>
                    </a>


                    <!-- Jadwal Pelatihan -->
                    <a href="{{ route('jadwal-pelatihan.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('jadwal-pelatihan.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="calendar-fold"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                                   {{ request()->routeIs('jadwal-pelatihan.*')
                                       ? 'text-emerald-600'
                                       : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Jadwal Pelatihan</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\JadwalPelatihan::count() }} Aktif
                        </span>
                    </a>


                    <!-- Lowongan -->
                    <a href="{{ route('lowongan.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('lowongan.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="briefcase-business"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                               {{ request()->routeIs('lowongan.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Lowongan</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\DaftarLowongan::count() }} Aktif
                        </span>
                    </a>


                    <!-- Mitra -->
                    <a href="{{ route('mitras.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('mitras.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="building-2"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                               {{ request()->routeIs('mitras.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Mitra DU/DI</span>
                        </span>

                        <span class="shrink-0 bg-slate-100 text-slate-600 text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\Mitra::count() }} Mitra
                        </span>
                    </a>
                </div>


                <!-- MONITORING MAGANG -->
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">
                        Monitoring Magang
                    </div>

                    <!-- Peserta -->
                    <a href="{{ route('pesertas.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('pesertas.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="users-round"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                               {{ request()->routeIs('pesertas.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Data Peserta</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\Peserta::count() }} Peserta
                        </span>
                    </a>


                    <!-- Presensi -->
                    <a href="{{ route('absen.index') }}"
                        class="group flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('absen.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <i data-lucide="check-square"
                            class="w-4 h-4 shrink-0 transition-colors duration-200
                           {{ request()->routeIs('absen.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                        </i>

                        Presensi Peserta
                    </a>
                </div>


                <!-- KELULUSAN & EVALUASI -->
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">
                        Kelulusan & Evaluasi
                    </div>

                    <a href="{{ route('sertifikat.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('sertifikat.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="award"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                               {{ request()->routeIs('sertifikat.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Penerbitan Sertifikat</span>
                        </span>

                        <span class="shrink-0 bg-slate-100 text-slate-600 text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\Sertifikat::count() }}
                        </span>
                    </a>
                </div>
            @elseif(auth()->user()->role === 'mitra')
                <!-- MITRA -->
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">
                        Manajemen Data
                    </div>

                    <a href="{{ route('lowongan.index') }}"
                        class="group flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-all duration-200
                        {{ request()->routeIs('lowongan.*')
                            ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700 hover:translate-x-0.5 hover:shadow-sm' }}">

                        <span class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="briefcase-business"
                                class="w-4 h-4 shrink-0 transition-colors duration-200
                               {{ request()->routeIs('lowongan.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}">
                            </i>

                            <span class="truncate">Lowongan Saya</span>
                        </span>

                        <span class="shrink-0 bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">
                            {{ \App\Models\DaftarLowongan::where('id_mitra', auth()->user()->mitra->id_mitra ?? null)->count() }}
                            Aktif
                        </span>
                    </a>
                </div>
            @endif
        </nav>
    </div>


    <!-- Footer Sidebar -->
    <div class="shrink-0 p-3 border-t border-slate-200">

        <div class="bg-indigo-50/80 p-2.5 rounded-lg mb-2 flex items-center justify-between gap-2">
            <div class="min-w-0">
                <div class="text-[10px] text-indigo-500 font-medium">
                    UNIT PELAKSANA
                </div>

                <div class="text-xs font-bold text-indigo-950 truncate">
                    BLK Pusat Vokasi
                </div>
            </div>

            <i data-lucide="arrow-left-right" class="w-4 h-4 shrink-0 text-indigo-400"></i>
        </div>


        <div class="flex items-center justify-between gap-2 pt-1 text-xs text-slate-600">

            <!-- Pengaturan -->
            <a href="#"
                class="group flex items-center gap-2 px-2 py-1.5 rounded-md
                transition-all duration-200
                hover:bg-slate-50
                hover:text-slate-900
                hover:shadow-sm">

                <i data-lucide="settings"
                    class="w-4 h-4 shrink-0 text-slate-400
                   group-hover:text-emerald-600
                   transition-colors duration-200">
                </i>

                Pengaturan
            </a>


            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf

                <button type="submit"
                    class="group flex items-center gap-1.5 px-2 py-1.5 rounded-md
                    text-rose-600 font-medium
                    hover:bg-rose-50
                    hover:text-rose-700
                    hover:shadow-sm
                    transition-all duration-200">

                    <i data-lucide="log-out"
                        class="w-4 h-4 shrink-0
                       group-hover:translate-x-0.5
                       transition-transform duration-200">
                    </i>

                    Keluar
                </button>
            </form>

        </div>
    </div>
</aside>
