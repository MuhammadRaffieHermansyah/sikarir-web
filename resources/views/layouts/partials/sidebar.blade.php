<aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex shrink-0">
  <div>
    <!-- Logo -->
    <div class="p-4 flex items-center gap-3 border-b border-slate-100">
      <div class="bg-emerald-900 text-white font-bold p-2 rounded text-xs leading-none">
        BLK<br/>CONNECT
      </div>
      <div>
        <span class="text-xs font-bold text-emerald-800 bg-emerald-100 px-1.5 py-0.5 rounded">SIMAGANG</span>
        <p class="text-[10px] text-slate-500 mt-0.5">Sistem Informasi Magang</p>
      </div>
    </div>

    <!-- Menu Navigation -->
    <nav class="p-3 text-xs font-medium space-y-6">
      <div>
        <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Utama</div>
        <a href="{{ route('admin-blk.index') }}" class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('admin-blk.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
          <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
          Dashboard Ringkasan
        </a>
        <a href="{{ route('admin-blk.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-slate-600 hover:bg-slate-50 rounded-lg transition">
          <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
          Laporan & Statistik
        </a>
      </div>

      <div>
        <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Manajemen Data</div>
        <a href="{{ route('admin-blk.index') }}" class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('admin-blk.*') ? 'text-emerald-700 font-medium' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
          <span class="flex items-center gap-2.5">
            <i data-lucide="shield-check" class="w-4 h-4"></i>
            Admin BLK
          </span>
          <span class="bg-emerald-100 text-emerald-800 text-[10px] font-semibold px-1.5 py-0.5 rounded">Kelola</span>
        </a>
        <a href="{{ route('pelatihan.index') }}" class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('pelatihan.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
          <span class="flex items-center gap-2.5">
            <i data-lucide="award" class="w-4 h-4"></i>
            Program Pelatihan
          </span>
          <span class="bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-1.5 py-0.5 rounded">18 Aktif</span>
        </a>
        <a href="{{ route('mitras.index') }}" class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('mitras.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
          <span class="flex items-center gap-2.5">
            <i data-lucide="building-2" class="w-4 h-4"></i>
            Mitra DU/DI
          </span>
          <span class="bg-slate-100 text-slate-600 text-[10px] px-1.5 py-0.5 rounded">64 Mitra</span>
        </a>
      </div>

      <div>
        <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Monitoring Magang</div>
        <a href="{{ route('pesertas.index') }}" class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('pesertas.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
          <i data-lucide="briefcase" class="w-4 h-4"></i>
          Data Magang
        </a>
        <a href="{{ route('absen.index') }}" class="flex items-center justify-between px-3 py-2 {{ request()->routeIs('absen.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
          <span class="flex items-center gap-2.5">
            <i data-lucide="file-text" class="w-4 h-4"></i>
            Jurnal & Verifikasi
          </span>
          <span class="bg-emerald-500 text-white font-semibold text-[10px] px-1.5 py-0.5 rounded-full">12 Baru</span>
        </a>
        <a href="{{ route('absen.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-slate-600 hover:bg-slate-50 rounded-lg transition">
          <i data-lucide="check-square" class="w-4 h-4"></i>
          Presensi Peserta
        </a>
      </div>

      <div>
        <div class="text-[10px] uppercase font-bold text-slate-400 mb-2 px-3">Kelulusan & Evaluasi</div>
        <a href="{{ route('sertifikat.index') }}" class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('sertifikat.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }} rounded-lg transition">
          <i data-lucide="award" class="w-4 h-4"></i>
          Penerbitan Sertifikat
        </a>
        <a href="{{ route('sertifikat.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-slate-600 hover:bg-slate-50 rounded-lg transition">
          <i data-lucide="file-check-2" class="w-4 h-4"></i>
          Nilai & Rekomendasi
        </a>
      </div>
    </nav>
  </div>

  <!-- Footer Sidebar -->
  <div class="p-3 border-t border-slate-200">
    <div class="bg-indigo-50/80 p-2.5 rounded-lg mb-2 flex items-center justify-between">
      <div>
        <div class="text-[10px] text-indigo-500 font-medium">UNIT PELAKSANA</div>
        <div class="text-xs font-bold text-indigo-950">BLK Pusat Vokasi</div>
      </div>
      <i data-lucide="arrow-left-right" class="w-4 h-4 text-indigo-400"></i>
    </div>

    <div class="flex items-center justify-between pt-1 text-xs text-slate-600">
      <a href="#" class="flex items-center gap-2 hover:text-slate-900">
        <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan
      </a>
      <a href="#" class="flex items-center gap-1.5 text-rose-600 font-medium hover:text-rose-700">
        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
      </a>
    </div>
  </div>
</aside>