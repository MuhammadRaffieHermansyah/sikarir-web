{{-- resources/views/layouts/navbar.blade.php --}}
<header class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-4">
        <div class="flex items-center gap-2 shrink-0">
            <div class="w-9 h-9 bg-[#00652C] text-white rounded-lg flex items-center justify-center font-bold">S</div>
            <div class="leading-tight">
                <p class="font-bold text-[#00652C] text-sm">siKarir</p>
                <p class="text-[10px] text-[#3F493F]">UPT BLK JEMBER</p>
            </div>
        </div>

        <nav class="hidden md:flex items-center gap-2 text-sm font-medium shrink-0">
            <a href="{{ url('/') }}"
               class="{{ request()->is('/') ? 'bg-[#D3FFD5] text-[#00652C] px-4 py-1.5 rounded-full' : 'text-[#3F493F] hover:text-[#00652C] px-2' }}">
                Beranda
            </a>
            <a href="{{ route('pelatihan.katalog') }}" class="text-[#3F493F] hover:text-[#00652C] px-2">Pelatihan</a>
            <a href="{{ route('lowongan.katalog') }}" class="text-[#3F493F] hover:text-[#00652C] px-2">Lowongan Kerja</a>
            <a href="{{ route('tentang.index') }}" class="text-[#3F493F] hover:text-[#00652C] px-2">Tentang BLK</a>
        </nav>

        <div class="hidden md:flex items-center gap-2 bg-[#F2F3FF] rounded-full px-4 py-2 text-sm flex-1 max-w-xs">
            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
            </svg>
            <input type="text" placeholder="Cari kejuruan, sertifikasi, posisi..." class="bg-transparent outline-none w-full text-sm placeholder:text-gray-400">
        </div>

        <div class="flex items-center gap-3 text-sm shrink-0">
            @guest
                <a href="{{ route('login') }}" class="font-medium text-[#3F493F]">Masuk</a>
                <a href="{{ route('register') }}" class="bg-[#00652C] text-white px-4 py-2 rounded-lg font-medium">Daftar</a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-[#00652C] text-white px-4 py-2 rounded-lg font-medium">Dashboard</a>
            @endguest

            <span class="w-px h-6 bg-gray-200"></span>

            <button class="text-lg text-[#3F493F]" title="Notifikasi (segera hadir)">🔔</button>
            <a href="{{ auth()->check() ? route('profile.edit') : route('login') }}"
               class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[#3F493F]" title="Profil">
                👤
            </a>
            @auth
                <span class="hidden lg:flex items-center gap-1 text-xs text-[#00652C] font-medium">
                    <span class="w-2 h-2 rounded-full bg-[#00652C] inline-block"></span> Aktif
                </span>
            @endauth
        </div>
    </div>
</header>
