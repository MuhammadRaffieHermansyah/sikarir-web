@props([
    'action',                 // Route URL form
    'searchPlaceholder' => 'Cari data...', 
    'statusOptions' => [],    // Array key-value buat dropdown status/filter (opsional)
    'statusName' => 'status', // Nama parameter select filter (misal: 'status' atau 'jurusan')
    'statusPlaceholder' => 'Semua Status',
])

<form method="GET" action="{{ $action }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full lg:w-auto">
  
  <!-- Wrapper Input & Dropdown Filter -->
  <div class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
    <!-- Input Search -->
    <div class="relative w-full sm:w-64">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
        <i data-lucide="search" class="w-4 h-4"></i>
      </div>
      <input type="text" 
             name="search" 
             value="{{ request('search') }}" 
             placeholder="{{ $searchPlaceholder }}" 
             class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 shadow-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition duration-150">
    </div>

    <!-- Filter Select Dropdown -->
    @if(!empty($statusOptions))
      <div class="relative w-full sm:w-auto">
        <select name="{{ $statusName }}" 
                class="w-full sm:w-auto bg-white border border-slate-200 rounded-lg pl-3 pr-8 py-2 text-xs font-semibold text-slate-700 shadow-sm appearance-none focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 transition duration-150 cursor-pointer capitalize">
          <option value="" class="text-slate-400 font-normal">{{ $statusPlaceholder }}</option>
          @foreach($statusOptions as $key => $label)
            <option value="{{ $key }}" @selected((string)request($statusName) === (string)$key)>{{ $label }}</option>
          @endforeach
        </select>
        <!-- Custom Dropdown Chevron Icon -->
        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400">
          <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
        </div>
      </div>
    @endif
  </div>

  <!-- Action Buttons (Submit & Reset) -->
  <div class="flex items-center gap-1.5 w-full sm:w-auto shrink-0">
    <!-- Tombol Cari -->
    <button type="submit" 
            class="flex-1 sm:flex-none px-4 py-2 bg-emerald-900 hover:bg-emerald-950 active:bg-emerald-900 text-white text-xs font-bold rounded-lg shadow-sm hover:shadow transition-all duration-150 flex items-center justify-center gap-1.5 cursor-pointer">
      <i data-lucide="search" class="w-3.5 h-3.5"></i>
      <span>Cari</span>
    </button>

    <!-- Tombol Reset Filter (Hanya muncul jika ada pencarian/filter aktif) -->
    @if(request('search') || request($statusName))
      <a href="{{ $action }}" 
         class="p-2 border border-slate-200 bg-slate-50 hover:bg-slate-100 active:bg-slate-200 text-slate-600 rounded-lg transition duration-150 flex items-center justify-center shadow-sm group" 
         title="Reset Filter">
        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 group-hover:-rotate-45 transition-transform duration-200"></i>
      </a>
    @endif
  </div>

</form>