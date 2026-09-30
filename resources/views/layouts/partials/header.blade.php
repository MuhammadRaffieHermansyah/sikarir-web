<header class="h-16 shrink-0 bg-white border-b border-slate-200 px-3 sm:px-4 lg:px-6 flex items-center gap-3">

  <!-- Tombol menu (khusus mobile) -->
  <button id="sidebarToggle" type="button"
    class="md:hidden w-9 h-9 shrink-0 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 flex items-center justify-center transition active:scale-95"
    aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
    <i data-lucide="menu" class="w-5 h-5"></i>
  </button>

  <!-- Search Input -->
  <div class="relative flex-1 sm:flex-none sm:w-72 lg:w-96 min-w-0">
    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
    <input type="text" placeholder="Cari peserta, pelatihan, ID magang, atau jurnal..."
      class="w-full bg-slate-100 text-xs pl-9 pr-3 sm:pr-4 py-2 rounded-lg focus:outline-none focus:ring-1 focus:ring-emerald-500 text-slate-700 placeholder:text-slate-400">
  </div>

  <!-- Status & Profile -->
  <div class="flex items-center gap-3 sm:gap-4 ml-auto min-w-0">

    <div class="hidden sm:block bg-slate-100 text-slate-700 text-xs px-3 py-1 rounded-full font-medium whitespace-nowrap">
      Gelombang II 2025
    </div>

    <div class="flex items-center gap-2 sm:gap-3 pl-2 sm:pl-2 border-l border-slate-200 min-w-0">

      <div class="flex items-center gap-3 pl-2 min-w-0">
        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Avatar"
          class="w-8 h-8 shrink-0 rounded-full object-cover">

        <div class="hidden sm:block min-w-0">
          <div class="text-xs font-bold text-slate-800 leading-tight truncate">
            {{ Auth::user()->name }}
          </div>
          <div class="text-[10px] text-slate-500 truncate">
            {{ Auth::user()->role == 'admin_blk' ? "Admin BLK" : (Auth::user()->role == 'peserta' ? "Peserta" : "Mitra DU/DI") }}
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
