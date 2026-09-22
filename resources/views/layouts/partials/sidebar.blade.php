<aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex shrink-0">
    <div>
        <div class="p-4 flex items-center gap-3 border-b border-slate-100 bg-white">
    <!-- Gambar Logo -->
    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
        <img src="{{ asset('images/logo-sikarir.png') }}" 
             alt="Logo siKarir BLK Jember" 
             class="h-10 w-auto object-contain">
    </a>
</div>

        <!-- Menu Navigation -->
        <nav class="p-3 text-xs font-medium space-y-6">
            @if (auth()->user()->role === 'admin_blk')
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Utama</div>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        Dashboard Ringkasan
                    </a>
                </div>

                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Manajemen Data</div>
                    <a href="{{ route('admin-blk.index') }}"
                        class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('admin-blk.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <span class="flex items-center gap-2.5">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            Admin BLK
                        </span>
                        <span
                            class="bg-emerald-100 text-emerald-800 text-[10px] font-semibold px-1.5 py-0.5 rounded">Kelola</span>
                    </a>
                    <a href="{{ route('pelatihan.index') }}"
                        class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('pelatihan.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <span class="flex items-center gap-2.5">
                            <i data-lucide="book" class="w-4 h-4"></i>
                            Program Pelatihan
                        </span>
                        <span class="bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">18
                            Aktif</span>
                    </a>
                    <a href="{{ route('jadwal-pelatihan.index') }}"
                        class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('jadwal-pelatihan.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <span class="flex items-center gap-2.5">
                            <i data-lucide="calendar-fold" class="w-4 h-4"></i>
                            Jadwal Pelatihan
                        </span>
                        <span class="bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">18
                            Aktif</span>
                    </a>
                    <a href="{{ route('lowongan.index') }}"
                        class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('lowongan.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <span class="flex items-center gap-2.5">
                            <i data-lucide="briefcase-business" class="w-4 h-4"></i>
                            Lowongan
                        </span>
                        <span class="bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">18
                            Aktif</span>
                    </a>
                    <a href="{{ route('mitras.index') }}"
                        class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('mitras.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <span class="flex items-center gap-2.5">
                            <i data-lucide="building-2" class="w-4 h-4"></i>
                            Mitra DU/DI
                        </span>
                        <span class="bg-slate-100 text-slate-600 text-[10px] px-1.5 py-0.5 rounded">64 Mitra</span>
                    </a>
                </div>

                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Monitoring Magang</div>
                    <a href="{{ route('pesertas.index') }}"
                        class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('pesertas.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <i data-lucide="users-round" class="w-4 h-4"></i>
                        Data Peserta
                    </a>
                    <a href="{{ route('absen.index') }}"
                        class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('absen.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <i data-lucide="check-square" class="w-4 h-4"></i>
                        Presensi Peserta
                    </a>
                </div>

                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Kelulusan & Evaluasi</div>
                    <a href="{{ route('sertifikat.index') }}"
                        class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('sertifikat.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <i data-lucide="award" class="w-4 h-4"></i>
                        Penerbitan Sertifikat
                    </a>
                </div>
            @elseif(auth()->user()->role === 'mitra')
                <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Manajemen Data</div>
                <div>
                    <a href="{{ route('lowongan.index') }}"
                        class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('lowongan.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
                        <span class="flex items-center gap-2.5">
                            <i data-lucide="briefcase-business" class="w-4 h-4"></i>
                            Lowongan
                        </span>
                        <span class="bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">18
                            Aktif</span>
                    </a>
                </div>
            @endif
        </nav>
    </div>

    <!-- Footer Sidebar -->
    <div class="p-3 border-t border-slate-200">
        <div class="bg-indigo-50/80 p-2.5 rounded-lg mb-2 flex items-center justify-between">
            <div>
                <div class="text-[10px] text-indigo-500 font-medium">UNIT PELAKSANA</div>
                <div class="text-xs font-bold text-indigo-950">BLK Pusat Vokasi</div>
            </div>
            <i data-lucide="arrow-left-right" class="w-4 h-4 text-indigo-400"></i>
        </div>

        <div class="flex items-center justify-between pt-1 text-xs text-slate-600">
            <a href="#" class="flex items-center gap-2 hover:text-slate-900">
                <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 text-rose-600 font-medium hover:text-rose-700">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
