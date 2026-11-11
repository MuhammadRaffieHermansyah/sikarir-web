{{-- resources/views/layouts/navbar.blade.php --}}
@php
$navLinks = [
['label' => 'Beranda', 'url' => url('/'), 'active' => request()->is('/')],
['label' => 'Pelatihan', 'url' => route('pelatihan.katalog'), 'active' => request()->routeIs('pelatihan.*')],
['label' => 'Lowongan Kerja', 'url' => route('lowongan.katalog'), 'active' => request()->routeIs('lowongan.*')],
['label' => 'Tentang BLK', 'url' => route('tentang.index'), 'active' => request()->routeIs('tentang.*')],
];
@endphp

<header id="siteHeader" class="sticky top-0 z-50 border-b border-[#e0e9dd] bg-[#fbfcf8]/92 backdrop-blur-xl">
    <div class="site-container flex items-center justify-between gap-3 py-3 sm:gap-6">

        <!-- Logo Branding -->
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 sm:gap-3 shrink-0 group min-w-0">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#145642] text-[#d8f36a] shadow-[0_8px_18px_rgba(20,86,66,.16)] transition group-hover:scale-105 shrink-0">
                <i data-lucide="sparkles" class="w-5 h-5"></i>
            </span>
            <div class="leading-none min-w-0">
                <span class="block text-base font-black tracking-[-.04em] text-[#173f31] transition group-hover:text-[#39734e]">siKarir</span>
                <p class="mt-0.5 whitespace-nowrap text-[9px] font-extrabold uppercase tracking-[.14em] text-[#789080]">UPT BLK JEMBER</p>
            </div>
        </a>

        <!-- Main Navigation Links (desktop, mulai lg) -->
        <nav class="hidden shrink-0 items-center gap-1 lg:flex">
            @foreach ($navLinks as $link)
            <a href="{{ $link['url'] }}"
                class="site-nav-link {{ $link['active'] ? 'is-active' : '' }} whitespace-nowrap">
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>

        

        <!-- Auth Action Buttons & User Menu -->
        <div class="flex items-center gap-2 sm:gap-3 text-xs shrink-0">

            {{-- Tombol aksi: tampil mulai sm. Di bawah sm dipindah ke menu hamburger --}}
            <div class="hidden sm:flex items-center gap-2 sm:gap-3">
                @guest
                <a href="{{ route('login') }}" class="px-2 py-2 text-xs font-extrabold text-[#476756] transition hover:text-[#145642] sm:px-3">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="site-primary-action">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                    <span>Daftar</span>
                </a>
                @else
                <a href="{{ route('dashboard') }}" class="site-primary-action">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    <span>Dashboard</span>
                </a>
                @endguest

                <span class="h-5 w-px bg-[#dfe8dc]"></span>

                

                @auth
                <span class="hidden 2xl:inline-flex items-center gap-1.5 text-[11px] text-emerald-700 font-bold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                </span>
                @endauth
            </div>

            <!-- Tombol Hamburger (di bawah lg) -->
            <button id="menuToggle" type="button"
                class="lg:hidden grid h-10 w-10 place-items-center rounded-xl border border-[#dfe8dc] bg-white text-[#315d49] shadow-sm transition hover:bg-[#f0f6e8]"
                aria-label="Buka menu" aria-controls="mobileMenu" aria-expanded="false">
                <span id="iconMenu"><i data-lucide="menu" class="w-5 h-5"></i></span>
                <span id="iconClose" class="hidden"><i data-lucide="x" class="w-5 h-5"></i></span>
            </button>
        </div>
    </div>

    <!-- Menu Mobile / Tablet (di bawah lg) -->
    <div id="mobileMenu" class="hidden max-h-[calc(100vh-4rem)] overflow-y-auto border-t border-[#dfe8dc] bg-[#fbfcf8] lg:hidden">
        <div class="site-container space-y-4 py-4">

            <!-- Pencarian cepat -->


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

                @endguest
            </div>
        </div>
    </div>

    <script>
        (function() {
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
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') setOpen(false);
            });

            // Tutup otomatis saat layar dilebarkan ke ukuran desktop
            window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
                if (e.matches) setOpen(false);
            });
        })();
    </script>
</header>