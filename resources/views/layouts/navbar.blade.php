{{-- resources/views/layouts/navbar.blade.php --}}
<header class="bg-white border-b border-slate-200/80 sticky top-0 z-50 backdrop-blur-md bg-white/95">
    <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-6">
        <!-- Logo Branding -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 group">
            <div class="w-9 h-9 bg-emerald-900 text-white rounded-xl flex items-center justify-center font-black text-xs shadow-md group-hover:bg-emerald-950 transition">
                <i data-lucide="layers" class="w-5 h-5 text-emerald-400"></i>
            </div>
            <div class="leading-none">
                <span class="font-black text-slate-900 text-base tracking-tight group-hover:text-emerald-700 transition">siKarir</span>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">UPT BLK JEMBER</p>
            </div>
        </a>

        <!-- Main Navigation Links -->
        <nav class="hidden md:flex items-center gap-1 text-xs font-semibold shrink-0">
            <a href="{{ url('/') }}"
               class="{{ request()->is('/') ? 'bg-emerald-50 text-emerald-800 font-bold px-3.5 py-2 rounded-xl border border-emerald-200/80' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-50 px-3.5 py-2 rounded-xl' }} transition">
                Beranda
            </a>
            <a href="{{ route('pelatihan.katalog') }}" 
               class="{{ request()->routeIs('pelatihan.*') ? 'bg-emerald-50 text-emerald-800 font-bold px-3.5 py-2 rounded-xl border border-emerald-200/80' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-50 px-3.5 py-2 rounded-xl' }} transition">
                Pelatihan
            </a>
            <a href="{{ route('lowongan.katalog') }}" 
               class="{{ request()->routeIs('lowongan.*') ? 'bg-emerald-50 text-emerald-800 font-bold px-3.5 py-2 rounded-xl border border-emerald-200/80' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-50 px-3.5 py-2 rounded-xl' }} transition">
                Lowongan Kerja
            </a>
            <a href="{{ route('tentang.index') }}" 
               class="{{ request()->routeIs('tentang.*') ? 'bg-emerald-50 text-emerald-800 font-bold px-3.5 py-2 rounded-xl border border-emerald-200/80' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-50 px-3.5 py-2 rounded-xl' }} transition">
                Tentang BLK
            </a>
        </nav>

        <!-- Quick Search Bar -->
        <div class="hidden lg:flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs flex-1 max-w-xs focus-within:bg-white focus-within:border-emerald-600 focus-within:ring-1 focus-within:ring-emerald-600 transition shadow-sm">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
            <input type="text" placeholder="Cari kejuruan, sertifikasi, posisi..." class="bg-transparent outline-none w-full text-xs font-medium text-slate-800 placeholder:text-slate-400">
        </div>

        <!-- Auth Action Buttons & User Menu -->
        <div class="flex items-center gap-3 text-xs shrink-0">
            @guest
                <a href="{{ route('login') }}" class="font-bold text-slate-700 hover:text-emerald-700 px-3 py-2 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white px-4 py-2 rounded-xl font-bold shadow-sm transition flex items-center gap-1.5">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                    <span>Daftar</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white px-4 py-2 rounded-xl font-bold shadow-sm transition flex items-center gap-1.5">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    <span>Dashboard</span>
                </a>
            @endguest

            <span class="w-px h-5 bg-slate-200"></span>

            <!-- Notification Bell -->
            <button class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition" title="Notifikasi">
                <i data-lucide="bell" class="w-4 h-4"></i>
            </button>

            <!-- User Profile Avatar -->
            <a href="{{ auth()->check() ? route('profile.edit') : route('login') }}"
               class="w-8 h-8 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 hover:text-emerald-700 hover:border-emerald-300 transition shadow-sm" title="Profil Saya">
                <i data-lucide="user" class="w-4 h-4"></i>
            </a>

            @auth
                <span class="hidden xl:inline-flex items-center gap-1.5 text-[11px] text-emerald-700 font-bold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                </span>
            @endauth
        </div>
    </div>
</header>