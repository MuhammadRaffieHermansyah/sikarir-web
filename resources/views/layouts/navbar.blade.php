{{-- resources/views/layouts/navbar.blade.php --}}
@php
$navLinks = [
['label' => 'Beranda', 'url' => url('/'), 'active' => request()->is('/')],
['label' => 'Pelatihan', 'url' => route('pelatihan.katalog'), 'active' => request()->routeIs('pelatihan.*')],
['label' => 'Lowongan Kerja', 'url' => route('lowongan.katalog'), 'active' => request()->routeIs('lowongan.*')],
['label' => 'Tentang BLK', 'url' => route('tentang.index'), 'active' => request()->routeIs('tentang.*')],
];
@endphp

<header id="siteHeader" class="sticky top-0 z-50 border-b border-border bg-background/90 backdrop-blur-xl">
    <div class="site-container flex items-center justify-between gap-3 py-3 sm:gap-6">

        <a href="{{ url('/') }}" class="group flex min-w-0 shrink-0 items-center gap-2.5 sm:gap-3">
            <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary text-primary-foreground shadow-sm transition group-hover:scale-105">
                <i data-lucide="sparkles" class="size-5"></i>
            </span>
            <div class="min-w-0 leading-none">
                <span class="block text-base font-black tracking-[-.04em] text-foreground transition group-hover:text-primary">siKarir</span>
                <p class="mt-0.5 whitespace-nowrap text-[9px] font-bold uppercase tracking-[.14em] text-muted-foreground">UPT BLK JEMBER</p>
            </div>
        </a>

        <nav class="hidden shrink-0 items-center gap-1 lg:flex" aria-label="Navigasi publik">
            @foreach ($navLinks as $link)
            <a href="{{ $link['url'] }}"
                @class([
                    'site-nav-link whitespace-nowrap',
                    'is-active' => $link['active'],
                ])>
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>

        <div class="flex shrink-0 items-center gap-2 text-xs sm:gap-3">
            <div class="hidden items-center gap-2 sm:flex sm:gap-3">
                @guest
                <x-ui.button variant="ghost" size="sm" href="{{ route('login') }}" class="font-bold">
                    Masuk
                </x-ui.button>
                <x-ui.button size="sm" href="{{ route('register') }}" class="font-bold">
                    <i data-lucide="user-plus" class="size-3.5"></i>
                    <span>Daftar</span>
                </x-ui.button>
                @else
                <x-ui.button size="sm" href="{{ route('dashboard') }}" class="font-bold">
                    <i data-lucide="layout-dashboard" class="size-3.5"></i>
                    <span>Dashboard</span>
                </x-ui.button>
                <x-ui.badge tone="success" class="hidden 2xl:inline-flex">
                    <span class="size-1.5 rounded-full bg-current"></span> Aktif
                </x-ui.badge>
                @endguest
            </div>

            <x-ui.button id="menuToggle" variant="outline" size="icon" class="lg:hidden" aria-label="Buka menu" aria-controls="mobileMenu" aria-expanded="false">
                <span id="iconMenu"><i data-lucide="menu" class="size-5"></i></span>
                <span id="iconClose" class="hidden"><i data-lucide="x" class="size-5"></i></span>
            </x-ui.button>
        </div>
    </div>

    <div id="mobileMenu" class="hidden max-h-[calc(100vh-4rem)] overflow-y-auto border-t border-border bg-background lg:hidden">
        <div class="site-container space-y-4 py-4">
            <nav class="flex flex-col gap-1 text-sm font-semibold" aria-label="Navigasi publik mobile">
                @foreach ($navLinks as $link)
                <a href="{{ $link['url'] }}"
                    @class([
                        'rounded-xl border px-3.5 py-2.5 transition',
                        'border-primary/20 bg-accent font-bold text-accent-foreground' => $link['active'],
                        'border-transparent text-muted-foreground hover:bg-muted hover:text-foreground' => ! $link['active'],
                    ])>
                    {{ $link['label'] }}
                </a>
                @endforeach
            </nav>

            <div class="flex flex-col gap-2 border-t border-border pt-3 text-sm sm:hidden">
                @guest
                <x-ui.button href="{{ route('register') }}" class="w-full font-bold">
                    <i data-lucide="user-plus" class="size-4"></i>
                    <span>Daftar Akun</span>
                </x-ui.button>
                <x-ui.button variant="outline" href="{{ route('login') }}" class="w-full font-bold">
                    <i data-lucide="log-in" class="size-4"></i>
                    <span>Masuk</span>
                </x-ui.button>
                @else
                <x-ui.button href="{{ route('dashboard') }}" class="w-full font-bold">
                    <i data-lucide="layout-dashboard" class="size-4"></i>
                    <span>Dashboard</span>
                </x-ui.button>
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
            menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setOpen(false)));
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') setOpen(false);
            });
            window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
                if (e.matches) setOpen(false);
            });
        })();
    </script>
</header>
