@php
    $user = Auth::user();
    $roleLabel = match ($user?->role) {
        'admin_blk' => 'Admin BLK',
        'peserta' => 'Peserta',
        default => 'Mitra DU/DI',
    };
    $initial = mb_strtoupper(mb_substr($user?->name ?? 'U', 0, 1));
@endphp

<header class="flex h-[var(--app-header-height)] shrink-0 items-center gap-3 border-b border-border bg-background/95 px-4 backdrop-blur sm:px-6 lg:px-8">
    <x-ui.sidebar-trigger label="Buka atau tutup menu navigasi"
        class="size-9 shrink-0 rounded-lg border border-border bg-background text-muted-foreground shadow-xs hover:bg-muted hover:text-foreground md:size-8" />

    <div class="hidden min-w-0 lg:block">
        <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-muted-foreground">Ruang kerja</p>
        <p class="mt-0.5 truncate text-sm font-bold tracking-tight text-foreground">siKarir Dashboard</p>
    </div>

    <form class="relative min-w-0 flex-1 sm:max-w-md lg:ml-2" role="search">
        <label class="sr-only" for="dashboard-search">Cari di dashboard</label>
        <x-ui.input id="dashboard-search" type="search" placeholder="Cari peserta, kelas, atau lowongan..." class="h-10 pl-10">
            <x-slot:leading>
                <x-lucide-search />
            </x-slot:leading>
        </x-ui.input>
    </form>

    <div class="ml-auto flex shrink-0 items-center gap-2 sm:gap-3">
        <x-ui.badge variant="secondary" class="hidden gap-1.5 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wide sm:inline-flex">
            <span class="size-1.5 rounded-full bg-primary"></span>
            Gelombang II 2025
        </x-ui.badge>

        <x-ui.button variant="outline" size="icon" aria-label="Notifikasi" class="relative">
            <x-lucide-bell />
            <span class="absolute right-2.5 top-2.5 size-1.5 rounded-full bg-primary ring-2 ring-background"></span>
        </x-ui.button>

        <x-ui.dropdown-menu>
            <x-ui.dropdown-menu-trigger>
                <x-ui.button variant="ghost" class="h-auto gap-2 px-2 py-1.5" aria-label="Buka profil {{ $user?->name }}">
                    <x-ui.avatar class="size-9 rounded-xl">
                        <x-ui.avatar-fallback class="rounded-xl bg-primary text-xs font-bold text-primary-foreground">
                            {{ $initial }}
                        </x-ui.avatar-fallback>
                    </x-ui.avatar>
                    <span class="hidden min-w-0 text-left sm:block">
                        <span class="block max-w-32 truncate text-xs font-bold leading-tight text-foreground">{{ $user?->name }}</span>
                        <span class="mt-0.5 block text-[10px] font-medium text-muted-foreground">{{ $roleLabel }}</span>
                    </span>
                    <x-lucide-chevron-down class="hidden size-3.5 text-muted-foreground sm:block" />
                </x-ui.button>
            </x-ui.dropdown-menu-trigger>

            <x-ui.dropdown-menu-content align="end" class="w-56">
                <x-ui.dropdown-menu-label>
                    <span class="block truncate font-semibold">{{ $user?->name }}</span>
                    <span class="block truncate text-xs font-normal text-muted-foreground">{{ $user?->email }}</span>
                </x-ui.dropdown-menu-label>
                <x-ui.dropdown-menu-separator />
                <x-ui.dropdown-menu-item href="{{ route('profile.edit') }}">
                    <x-lucide-user-round />
                    Profil Saya
                </x-ui.dropdown-menu-item>
                <x-ui.dropdown-menu-item href="{{ url('/api/documentation') }}" target="_blank">
                    <x-lucide-file-code />
                    Dokumentasi API
                </x-ui.dropdown-menu-item>
                <x-ui.dropdown-menu-separator />
                <form method="POST" action="{{ route('logout') }}" data-confirm-action="logout">
                    @csrf
                    <x-ui.dropdown-menu-item type="submit" variant="destructive">
                        <x-lucide-log-out />
                        Keluar
                    </x-ui.dropdown-menu-item>
                </form>
            </x-ui.dropdown-menu-content>
        </x-ui.dropdown-menu>
    </div>
</header>
