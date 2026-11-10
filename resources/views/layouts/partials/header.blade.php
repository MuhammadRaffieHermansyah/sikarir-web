@php
    $user = Auth::user();
    $roleLabel = match ($user?->role) {
        'admin_blk' => 'Admin BLK',
        'peserta' => 'Peserta',
        default => 'Mitra DU/DI',
    };
@endphp

<header class="h-[72px] shrink-0 border-b border-[#dfe8dc] bg-[#fbfcf8]/95 px-3 backdrop-blur sm:px-5 lg:px-7">
    <div class="flex h-full items-center gap-3 sm:gap-4">
        <button id="sidebarToggle" type="button"
            class="grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-[#d9e4d4] bg-white text-[#1d4939] shadow-sm transition hover:-translate-y-0.5 hover:border-[#a9c786] hover:bg-[#f1f6e7] active:translate-y-0 md:hidden"
            aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>

        <div class="hidden min-w-0 lg:block">
            <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#6d8b74]">Ruang kerja</p>
            <p class="mt-0.5 truncate text-sm font-extrabold tracking-tight text-[#173f31]">siKarir Dashboard</p>
        </div>

        <form class="relative min-w-0 flex-1 sm:max-w-md lg:ml-2" role="search">
            <label class="sr-only" for="dashboard-search">Cari di dashboard</label>
            <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#74907a]"></i>
            <input id="dashboard-search" type="search" placeholder="Cari peserta, kelas, atau lowongan..."
                class="h-11 w-full rounded-xl border border-[#dfe8dc] bg-white py-2 pl-10 pr-4 text-xs font-medium text-[#244638] outline-none transition placeholder:text-[#91a298] focus:border-[#83a968] focus:ring-4 focus:ring-[#dff0c7]/70">
        </form>

        <div class="ml-auto flex shrink-0 items-center gap-2 sm:gap-3">
            <div class="hidden items-center gap-2 rounded-full border border-[#d3e4bc] bg-[#eff7df] px-3 py-2 text-[10px] font-extrabold uppercase tracking-[0.08em] text-[#3e6a45] sm:flex">
                <span class="h-1.5 w-1.5 rounded-full bg-[#78a744]"></span>
                Gelombang II 2025
            </div>

            <button type="button"
                class="relative grid h-10 w-10 place-items-center rounded-xl border border-[#dfe8dc] bg-white text-[#486556] shadow-sm transition hover:-translate-y-0.5 hover:border-[#a9c786] hover:bg-[#f1f6e7] hover:text-[#1d4939] active:translate-y-0"
                aria-label="Notifikasi">
                <i data-lucide="bell" class="h-4 w-4"></i>
                <span class="absolute right-2.5 top-2.5 h-1.5 w-1.5 rounded-full bg-[#a7c748] ring-2 ring-white"></span>
            </button>

            <a href="{{ route('profile.edit') }}"
                class="group flex min-w-0 items-center gap-2 rounded-xl border border-transparent py-1.5 pl-1.5 pr-2 transition hover:border-[#d3e4bc] hover:bg-[#f1f6e7] sm:gap-2.5 sm:pr-3"
                aria-label="Buka profil {{ $user?->name }}">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-[#164637] text-xs font-black text-[#d8f36a] shadow-sm transition group-hover:scale-105">
                    <i data-lucide="user-round" class="h-4 w-4"></i>
                </span>
                <span class="hidden min-w-0 sm:block">
                    <span class="block max-w-28 truncate text-xs font-extrabold leading-tight text-[#173f31]">{{ $user?->name }}</span>
                    <span class="mt-0.5 block text-[10px] font-semibold text-[#71877a]">{{ $roleLabel }}</span>
                </span>
                <i data-lucide="chevron-down" class="hidden h-3.5 w-3.5 text-[#789080] sm:block"></i>
            </a>
        </div>
    </div>
</header>
