@php
$navLinks = [
    ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard'],
    ['label' => 'Mitra', 'route' => 'mitras.index', 'active' => 'mitras.*', 'roles' => ['admin_blk']],
    ['label' => 'Peserta', 'route' => 'pesertas.index', 'active' => 'pesertas.*', 'roles' => ['admin_blk']],
    ['label' => 'Admin BLK', 'route' => 'admin-blk.index', 'active' => 'admin-blk.*', 'roles' => ['admin_blk']],
    ['label' => 'Lowongan', 'route' => 'lowongan.index', 'active' => 'lowongan.*', 'roles' => ['admin_blk', 'mitra']],
    ['label' => 'Pelatihan', 'route' => 'pelatihan.index', 'active' => 'pelatihan.*', 'roles' => ['admin_blk', 'mitra', 'peserta']],
    ['label' => 'Instruktur', 'route' => 'instruktur.index', 'active' => 'instruktur.*', 'roles' => ['admin_blk']],
    ['label' => 'Jadwal', 'route' => 'jadwal-pelatihan.index', 'active' => 'jadwal-pelatihan.*', 'roles' => ['admin_blk']],
    ['label' => 'Kelas', 'route' => 'kelas-pelatihan.index', 'active' => 'kelas-pelatihan.*', 'roles' => ['admin_blk']],
    ['label' => 'Absensi', 'route' => 'absen.index', 'active' => 'absen.*', 'roles' => ['admin_blk', 'peserta']],
    ['label' => 'Sertifikat', 'route' => 'sertifikat.index', 'active' => 'sertifikat.*', 'roles' => ['admin_blk', 'peserta']],
];

$navLinks = array_values(array_filter(
    $navLinks,
    fn (array $link): bool => ! isset($link['roles']) || in_array(auth()->user()?->role, $link['roles'], true)
));
@endphp

<nav class="border-b border-border bg-card" x-data="{ open: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between gap-4">
            <div class="flex min-w-0 items-center gap-4">
                <a href="{{ route('dashboard') }}" class="shrink-0">
                    <x-application-logo class="block h-9 w-auto fill-current text-primary" />
                </a>

                <div class="hidden flex-wrap items-center gap-1 sm:flex">
                    @foreach ($navLinks as $link)
                        <x-nav-link :href="route($link['route'])" :active="request()->routeIs($link['active'])">
                            {{ __($link['label']) }}
                        </x-nav-link>
                    @endforeach
                </div>
            </div>

            <div class="hidden items-center sm:flex">
                <x-ui.dropdown-menu>
                    <x-ui.dropdown-menu-trigger>
                        <x-ui.button variant="ghost" size="sm">
                            {{ Auth::user()->name }}
                            <x-lucide-chevron-down />
                        </x-ui.button>
                    </x-ui.dropdown-menu-trigger>

                    <x-ui.dropdown-menu-content align="end" class="w-48">
                        <x-ui.dropdown-menu-item href="{{ route('profile.edit') }}">
                            <x-lucide-user-round />
                            {{ __('Profile') }}
                        </x-ui.dropdown-menu-item>
                        <x-ui.dropdown-menu-separator />
                        <form method="POST" action="{{ route('logout') }}" data-confirm-action="logout">
                            @csrf
                            <x-ui.dropdown-menu-item type="submit" variant="destructive">
                                <x-lucide-log-out />
                                {{ __('Log Out') }}
                            </x-ui.dropdown-menu-item>
                        </form>
                    </x-ui.dropdown-menu-content>
                </x-ui.dropdown-menu>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <x-ui.button variant="ghost" size="icon" @click="open = ! open" aria-label="Buka menu">
                    <x-lucide-menu />
                </x-ui.button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden border-t border-border sm:hidden">
        <div class="space-y-1 px-3 py-3">
            @foreach ($navLinks as $link)
                <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs($link['active'])">
                    {{ __($link['label']) }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="border-t border-border px-4 py-3">
            <div class="text-sm font-semibold text-foreground">{{ Auth::user()->name }}</div>
            <div class="text-xs text-muted-foreground">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}" data-confirm-action="logout">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').requestSubmit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
