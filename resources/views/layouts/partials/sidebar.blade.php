@php
    $user = auth()->user();
    $isAdmin = $user?->role === 'admin_blk';
    $isMitra = $user?->role === 'mitra';
    $isMitraVerified = $user?->mitra?->is_verified;

    $groups = [];

    if ($isAdmin) {
        $groups = [
            [
                'label' => 'Utama',
                'items' => [
                    ['label' => 'Dashboard Ringkasan', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'layout-dashboard'],
                ],
            ],
            [
                'label' => 'Manajemen Data',
                'items' => [
                    ['label' => 'Program Pelatihan', 'route' => 'pelatihan.index', 'active' => 'pelatihan.*', 'icon' => 'book'],
                    ['label' => 'Durasi Pelatihan', 'route' => 'durasi-pelatihan.index', 'active' => 'durasi-pelatihan.*', 'icon' => 'timer'],
                    ['label' => 'Bidang Keahlian', 'route' => 'bidang-keahlian.index', 'active' => 'bidang-keahlian.*', 'icon' => 'tags'],
                    ['label' => 'Instruktur', 'route' => 'instruktur.index', 'active' => 'instruktur.*', 'icon' => 'user-check'],
                    ['label' => 'Ruangan Workshop', 'route' => 'ruangan-workshop.index', 'active' => 'ruangan-workshop.*', 'icon' => 'building-2'],
                    ['label' => 'Jadwal & Kelas', 'route' => 'jadwal-pelatihan.index', 'active' => 'jadwal-pelatihan.*', 'icon' => 'calendar-fold'],
                ],
            ],
            [
                'label' => 'Monitoring Peserta',
                'items' => [
                    ['label' => 'Data Peserta', 'route' => 'pesertas.index', 'active' => 'pesertas.*', 'icon' => 'users-round'],
                    ['label' => 'Presensi Peserta', 'route' => 'absen.index', 'active' => 'absen.*', 'icon' => 'check-square'],
                    ['label' => 'Penerbitan Sertifikat', 'route' => 'sertifikat.index', 'active' => 'sertifikat.*', 'icon' => 'award'],
                ],
            ],
            [
                'label' => 'Mitra & Lowongan',
                'items' => [
                    ['label' => 'Mitra DU/DI', 'route' => 'mitras.index', 'active' => 'mitras.*', 'icon' => 'building-2'],
                    ['label' => 'Lowongan Kerja', 'route' => 'lowongan.index', 'active' => 'lowongan.*', 'icon' => 'briefcase-business'],
                ],
            ],
        ];
    } elseif ($isMitra) {
        $groups = [
            [
                'label' => 'Utama',
                'items' => [
                    ['label' => 'Dashboard Mitra', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'layout-dashboard'],
                ],
            ],
            $isMitraVerified
                ? [
                    'label' => 'Manajemen Lowongan',
                    'items' => [
                        ['label' => 'Lowongan Saya', 'route' => 'lowongan.index', 'active' => 'lowongan.*', 'icon' => 'briefcase-business'],
                    ],
                ]
                : [
                    'label' => 'Status Akun',
                    'items' => [
                        ['label' => 'Menunggu Verifikasi', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'clock-3'],
                    ],
                ],
        ];
    } elseif ($user?->role === 'peserta') {
        $groups = [
            [
                'label' => 'Utama',
                'items' => [
                    ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'layout-dashboard'],
                ],
            ],
            [
                'label' => 'Pelatihan Saya',
                'items' => [
                    ['label' => 'Program Pelatihan', 'route' => 'pelatihan.index', 'active' => 'pelatihan.*', 'icon' => 'book'],
                    ['label' => 'Presensi Saya', 'route' => 'absen.index', 'active' => 'absen.*', 'icon' => 'check-square'],
                    ['label' => 'Sertifikat Saya', 'route' => 'sertifikat.index', 'active' => 'sertifikat.*', 'icon' => 'award'],
                    ['label' => 'Lowongan Saya', 'route' => 'lowongan.index', 'active' => 'lowongan.*', 'icon' => 'briefcase-business'],
                ],
            ],
        ];
    }
@endphp

<x-ui.sidebar collapsible="icon" class="relative" aria-label="Menu navigasi">
    <x-ui.sidebar-header
        class="h-[var(--app-header-height)] shrink-0 justify-center border-b border-sidebar-border px-4 py-0 group-data-[collapsible=icon]:px-0">
        <a href="{{ url('/') }}"
            class="flex min-w-0 items-center gap-2.5 rounded-lg py-1 outline-none transition-colors hover:bg-sidebar-accent/60 focus-visible:ring-2 focus-visible:ring-sidebar-ring group-data-[collapsible=icon]:justify-center">
            <x-app-logo class="size-9 shrink-0 group-data-[collapsible=icon]:hidden" role="img" aria-label="siKarir BLK Jember" />

            <x-app-logo class="hidden size-8 shrink-0 rounded-lg group-data-[collapsible=icon]:block" role="img" aria-label="siKarir" />

            <div class="min-w-0 leading-none group-data-[collapsible=icon]:hidden">
                <span class="block truncate text-sm font-black tracking-[-.04em] text-sidebar-foreground transition group-hover:text-primary">siKarir</span>
                <p class="mt-0.5 whitespace-nowrap text-[9px] font-bold uppercase tracking-[.14em] text-sidebar-foreground/60">UPT BLK JEMBER</p>
            </div>
        </a>
    </x-ui.sidebar-header>

    <x-ui.sidebar-content class="gap-0 py-2">
        <nav class="flex flex-col" aria-label="Navigasi utama">
            @foreach ($groups as $group)
                <x-ui.sidebar-group class="py-1.5">
                    <x-ui.sidebar-group-label class="px-2 text-[10px] font-bold uppercase tracking-[0.13em] text-sidebar-foreground/60">
                        {{ $group['label'] }}
                    </x-ui.sidebar-group-label>

                    <x-ui.sidebar-menu class="gap-0.5">
                        @foreach ($group['items'] as $item)
                            <x-ui.sidebar-menu-item>
                                <x-ui.sidebar-menu-button href="{{ route($item['route']) }}"
                                    :is-active="request()->routeIs($item['active'] ?? $item['route'])"
                                    :tooltip="$item['label']"
                                    class="data-[active=true]:font-semibold data-[active=true]:shadow-[inset_2px_0_0_0_var(--color-sikarir-lime)]">
                                    <x-dynamic-component :component="'lucide-'.$item['icon']" class="size-4 shrink-0" />
                                    <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>

                                    {{-- @isset($item['badge'])
                                        <x-ui.sidebar-menu-badge class="static ms-auto shrink-0 rounded-md bg-sidebar-primary/10 px-1.5 text-[10px] font-semibold text-sidebar-primary">
                                            {{ $item['badge'] }}
                                        </x-ui.sidebar-menu-badge>
                                    @endisset --}}
                                </x-ui.sidebar-menu-button>
                            </x-ui.sidebar-menu-item>
                        @endforeach
                    </x-ui.sidebar-menu>
                </x-ui.sidebar-group>
            @endforeach
        </nav>
    </x-ui.sidebar-content>

    <x-ui.sidebar-footer class="border-t border-sidebar-border p-2">
        <x-ui.sidebar-menu class="gap-0.5">
            <x-ui.sidebar-menu-item>
                <x-ui.sidebar-menu-button href="{{ route('profile.edit') }}"
                    :is-active="request()->routeIs('profile.*')"
                    tooltip="Pengaturan akun">
                    <x-lucide-settings class="size-4 shrink-0" />
                    <span class="min-w-0 flex-1 truncate">Pengaturan</span>
                </x-ui.sidebar-menu-button>
            </x-ui.sidebar-menu-item>

            <x-ui.sidebar-menu-item>
                {{-- A real submit button: x-ui.sidebar-menu-button always renders type="button",
                     so the logout form would never submit. --}}
                <form method="POST" action="{{ route('logout') }}" data-confirm-action="logout">
                    @csrf
                    <button type="submit" data-slot="sidebar-menu-button" data-sidebar="menu-button"
                        class="peer/menu-button flex h-8 w-full items-center gap-2 overflow-hidden rounded-md p-2 text-start text-sm text-destructive outline-none transition-colors hover:bg-destructive/10 hover:text-destructive focus-visible:ring-2 focus-visible:ring-sidebar-ring group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2!">
                        <x-lucide-log-out class="size-4 shrink-0" />
                        <span class="min-w-0 flex-1 truncate">Keluar</span>
                    </button>
                </form>
            </x-ui.sidebar-menu-item>
        </x-ui.sidebar-menu>
    </x-ui.sidebar-footer>

    <x-ui.sidebar-rail class="max-md:hidden" />
</x-ui.sidebar>
