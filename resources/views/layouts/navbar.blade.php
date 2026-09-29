{{-- resources/views/layouts/navbar.blade.php --}}
@php
    $navLinks = [
        ['label' => 'Beranda',        'url' => url('/'),                    'active' => request()->is('/')],
        ['label' => 'Pelatihan',      'url' => route('pelatihan.katalog'),  'active' => request()->routeIs('pelatihan.*')],
        ['label' => 'Lowongan Kerja', 'url' => route('lowongan.katalog'),   'active' => request()->routeIs('lowongan.*')],
        ['label' => 'Tentang BLK',    'url' => route('tentang.index'),      'active' => request()->routeIs('tentang.*')],
    ];
@endphp

<header id="siteHeader" class="bg-white border-b border-slate-200/80 sticky top-0 z-50 backdrop-blur-md bg-white/95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-3 sm:gap-6">

        <!-- Logo Branding -->
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 sm:gap-3 shrink-0 group min-w-0">
            <div class="w-9 h-9 bg-emerald-900 text-white rounded-xl flex items-center justify-center font-black text-xs shadow-md group-hover:bg-emerald-950 transition shrink-0">
                <i data-lucide="layers" class="w-5 h-5 text-emerald-400"></i>
            </div>
            <div class="leading-none min-w-0">
                <span class="block font-black text-slate-900 text-base tracking-tight group-hover:text-emerald-700 transition">siKarir</span>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5 whitespace-nowrap">UPT BLK JEMBER</p>
            </div>
        </a>

        <!-- Main Navigation Links (desktop, mulai lg) -->
        <nav class="hidden lg:flex items-center gap-1 text-xs font-semibold shrink-0">
            @foreach ($navLinks as $link)
                <a href="{{ $link['url'] }}"
                   class="{{ $link['active'] ? 'bg-emerald-50 text-emerald-800 font-bold px-3.5 py-2 rounded-xl border border-emerald-200/80' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-50 px-3.5 py-2 rounded-xl' }} transition whitespace-nowrap">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <!-- Quick Search Bar (layar lebar, mulai xl) -->
        <div class="hidden xl:flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs flex-1 max-w-xs focus-within:bg-white focus-within:border-emerald-600 focus-within:ring-1 focus-within:ring-emerald-600 transition shadow-sm">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
            <input type="text" placeholder="Cari kejuruan, sertifikasi, posisi..." class="bg-transparent outline-none w-full text-xs font-medium text-slate-800 placeholder:text-slate-400">
        </div>

        <!-- Auth Action Buttons & User Menu -->
        <div class="flex items-center gap-2 sm:gap-3 text-xs shrink-0">

            {{-- Tombol aksi: tampil mulai sm. Di bawah sm dipindah ke menu hamburger --}}
            <div class="hidden sm:flex items-center gap-2 sm:gap-3">
                @guest
                    <a href="{{ route('login') }}" class="font-bold text-slate-700 hover:text-emerald-700 px-2 sm:px-3 py-2 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white px-3 sm:px-4 py-2 rounded-xl font-bold shadow-sm transition flex items-center gap-1.5">
                        <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                        <span>Daftar</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white px-3 sm:px-4 py-2 rounded-xl font-bold shadow-sm transition flex items-center gap-1.5">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                        <span>Dashboard</span>
                    </a>
                @endguest

                <span class="w-px h-5 bg-slate-200"></span>

                <!-- Notification Bell -->
                <button type="button" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition" title="Notifikasi" aria-label="Notifikasi">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                </button>

                <!-- User Profile Avatar -->
                <a href="{{ auth()->check() ? route('profile.edit') : route('login') }}"
                   class="w-8 h-8 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 hover:text-emerald-700 hover:border-emerald-300 transition shadow-sm" title="Profil Saya" aria-label="Profil Saya">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </a>

                @auth
                    <span class="hidden 2xl:inline-flex items-center gap-1.5 text-[11px] text-emerald-700 font-bold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                    </span>
                @endauth
            </div>

            <!-- Tombol Hamburger (di bawah lg) -->
            <button id="menuToggle" type="button"
                    class="lg:hidden w-9 h-9 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 flex items-center justify-center transition active:scale-95"
                    aria-label="Buka menu" aria-controls="mobileMenu" aria-expanded="false">
                <span id="iconMenu"><i data-lucide="menu" class="w-5 h-5"></i></span>
                <span id="iconClose" class="hidden"><i data-lucide="x" class="w-5 h-5"></i></span>
            </button>
        </div>
    </div>

    <!-- Menu Mobile / Tablet (di bawah lg) -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-200/80 bg-white max-h-[calc(100vh-4rem)] overflow-y-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 space-y-4">

            <!-- Pencarian cepat -->
            <form method="GET" action="{{ route('pelatihan.katalog') }}"
                  class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus-within:bg-white focus-within:border-emerald-600 focus-within:ring-1 focus-within:ring-emerald-600 transition">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 shrink-0"></i>
                <input type="text" name="q" placeholder="Cari kejuruan, sertifikasi, posisi..."
                       class="bg-transparent outline-none w-full text-sm font-medium text-slate-800 placeholder:text-slate-400">
            </form>

            <!-- Link navigasi -->
            <nav class="flex flex-col gap-1 text-sm font-semibold">
                @foreach ($navLinks as $link)
                    <a href="{{ $link['url'] }}"
                       class="{{ $link['active'] ? 'bg-emerald-50 text-emerald-800 font-bold border border-emerald-200/80' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-50 border border-transparent' }} px-3.5 py-2.5 rounded-xl transition">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Aksi akun (khusus layar di bawah sm; di sm ke atas sudah ada di bar atas) -->
            <div class="sm:hidden pt-3 border-t border-slate-100 flex flex-col gap-2 text-sm">
                @guest
                    <a href="{{ route('register') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white px-4 py-2.5 rounded-xl font-bold shadow-sm transition flex items-center justify-center gap-1.5">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Daftar Akun</span>
                    </a>
                    <a href="{{ route('login') }}" class="border border-slate-200 text-slate-700 hover:bg-slate-50 px-4 py-2.5 rounded-xl font-bold transition flex items-center justify-center gap-1.5">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-emerald-900 hover:bg-emerald-950 text-white px-4 py-2.5 rounded-xl font-bold shadow-sm transition flex items-center justify-center gap-1.5">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="border border-slate-200 text-slate-700 hover:bg-slate-50 px-4 py-2.5 rounded-xl font-bold transition flex items-center justify-center gap-1.5">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>Profil Saya</span>
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('menuToggle');
            const menu = document.getElementById('mobileMenu');
            const iconMenu = document.getElementById('iconMenu');
            const iconClose = document.getElementById('iconClose');

            function setOpen(open) {
                menu.classList.toggle('hidden', !open);
                iconMenu.classList.toggle('hidden', open);
                iconClose.classList.toggle('hidden', !open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
            }

            toggle.addEventListener('click', () => setOpen(menu.classList.contains('hidden')));

            // Tutup saat link diklik atau tombol Escape ditekan
            menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setOpen(false)));
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });

            // Tutup otomatis saat layar dilebarkan ke ukuran desktop
            window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
                if (e.matches) setOpen(false);
            });
        })();
    </script>
</header>
