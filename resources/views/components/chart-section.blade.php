<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <!-- Chart Batang -->
  <div class="lg:col-span-2 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h3 class="font-bold text-slate-800 text-sm">Tren Aktivitas Magang & Log Presensi</h3>
        <p class="text-xs text-slate-500">Tingkat kehadiran harian dan pengisian jurnal industri minggu berjalan</p>
      </div>
      <div class="flex items-center gap-4 text-xs">
        <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-slate-800 rounded-sm"></span> Presensi Masuk</span>
        <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-emerald-400 rounded-sm"></span> Jurnal Terkirim</span>
      </div>
    </div>

    <!-- Chart Visual -->
    <div class="h-44 flex items-end justify-between px-4 pt-6 pb-2 border-b border-slate-100 gap-4">
      <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
        <span class="text-[10px] text-slate-400">98%</span>
        <div class="w-full max-w-[40px] flex gap-1 h-[85%] items-end">
          <div class="bg-slate-800 w-1/2 h-[98%] rounded-t-sm"></div>
          <div class="bg-emerald-400 w-1/2 h-[92%] rounded-t-sm"></div>
        </div>
        <span class="text-xs text-slate-500 font-medium">Senin</span>
      </div>
      <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
        <span class="text-[10px] text-slate-400">97%</span>
        <div class="w-full max-w-[40px] flex gap-1 h-[85%] items-end">
          <div class="bg-slate-800 w-1/2 h-[97%] rounded-t-sm"></div>
          <div class="bg-emerald-400 w-1/2 h-[95%] rounded-t-sm"></div>
        </div>
        <span class="text-xs text-slate-500 font-medium">Selasa</span>
      </div>
      <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
        <span class="text-[10px] text-slate-400">96%</span>
        <div class="w-full max-w-[40px] flex gap-1 h-[85%] items-end">
          <div class="bg-slate-800 w-1/2 h-[96%] rounded-t-sm"></div>
          <div class="bg-emerald-400 w-1/2 h-[90%] rounded-t-sm"></div>
        </div>
        <span class="text-xs text-slate-500 font-medium">Rabu</span>
      </div>
      <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
        <span class="text-[10px] text-slate-400">98%</span>
        <div class="w-full max-w-[40px] flex gap-1 h-[85%] items-end">
          <div class="bg-slate-800 w-1/2 h-[98%] rounded-t-sm"></div>
          <div class="bg-emerald-400 w-1/2 h-[94%] rounded-t-sm"></div>
        </div>
        <span class="text-xs text-slate-500 font-medium">Kamis</span>
      </div>
      <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
        <span class="text-[10px] text-slate-400">95%</span>
        <div class="w-full max-w-[40px] flex gap-1 h-[85%] items-end">
          <div class="bg-slate-800 w-1/2 h-[95%] rounded-t-sm"></div>
          <div class="bg-emerald-400 w-1/2 h-[88%] rounded-t-sm"></div>
        </div>
        <span class="text-xs text-slate-500 font-medium">Jumat</span>
      </div>
    </div>

    <div class="grid grid-cols-3 gap-2 mt-4 text-xs">
      <div class="bg-slate-50 p-2.5 rounded-lg flex items-center gap-2">
        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
        <div>
          <div class="text-[10px] text-slate-400">Rata-rata Presensi</div>
          <div class="font-bold text-slate-800">96.8% Tepat Waktu</div>
        </div>
      </div>
      <div class="bg-slate-50 p-2.5 rounded-lg flex items-center gap-2">
        <i data-lucide="file-check" class="w-4 h-4 text-emerald-600"></i>
        <div>
          <div class="text-[10px] text-slate-400">Log Jurnal Masuk</div>
          <div class="font-bold text-slate-800">821 dari 865</div>
        </div>
      </div>
      <div class="bg-slate-50 p-2.5 rounded-lg flex items-center gap-2">
        <i data-lucide="clock" class="w-4 h-4 text-emerald-600"></i>
        <div>
          <div class="text-[10px] text-slate-400">Total Jam Magang</div>
          <div class="font-bold text-slate-800">34,600 Jam</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Donut Chart Presensi -->
  <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
    <div>
      <div class="flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Presensi Hari Ini
        </h3>
        <span class="text-[10px] text-slate-400">Per 09:30 WIB</span>
      </div>

      <!-- Gauge Container -->
      <div class="relative w-36 h-36 mx-auto my-4 flex items-center justify-center">
        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
          <path class="text-slate-100" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
          <path class="text-emerald-800" stroke-dasharray="96.8, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
        </svg>
        <div class="absolute text-center">
          <span class="text-xl font-black text-slate-800 block leading-none">96.8%</span>
          <span class="text-[9px] font-bold text-emerald-700 tracking-tight">HADIR TERVERIFIKASI</span>
        </div>
      </div>

      <p class="text-center text-xs font-semibold text-slate-700 mb-3">838 dari 865 peserta magang aktif</p>

      <div class="grid grid-cols-3 gap-2 text-center text-xs bg-slate-50 p-2 rounded-lg">
        <div>
          <div class="text-[10px] text-slate-400">Terlambat</div>
          <div class="font-bold text-slate-800">18</div>
        </div>
        <div class="border-x border-slate-200">
          <div class="text-[10px] text-slate-400">Izin / Sakit</div>
          <div class="font-bold text-slate-800">9</div>
        </div>
        <div>
          <div class="text-[10px] text-slate-400">Alpha</div>
          <div class="font-bold text-slate-800">0</div>
        </div>
      </div>
    </div>

    <a href="#" class="text-xs text-center text-emerald-700 font-semibold hover:underline block mt-2">
      Lihat Detail Presensi Real-Time &rarr;
    </a>
  </div>
</div>