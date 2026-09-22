<header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0">
  <!-- Search Input -->
  <div class="relative w-96">
    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
    <input type="text" placeholder="Cari peserta, pelatihan, ID magang, atau jurnal..." class="w-full bg-slate-100 text-xs pl-9 pr-4 py-2 rounded-lg focus:outline-none focus:ring-1 focus:ring-emerald-500 text-slate-700">
  </div>

  <!-- Status & Profile -->
  <div class="flex items-center gap-4">
    

    <div class="bg-slate-100 text-slate-700 text-xs px-3 py-1 rounded-full font-medium">
      Gelombang II 2025
    </div>

    <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
      

      <div class="flex items-center gap-3 pl-2">
        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
        <div>
          <div class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</div>
          <div class="text-[10px] text-slate-500">{{ Auth::user()->role ==  'admin_blk' ? "Admin BLK" : (Auth::user()->role ==  'peserta' ? "Peserta" : "Mitra DU/DI")}}</div>
        </div>
      </div>
    </div>
  </div>
</header>