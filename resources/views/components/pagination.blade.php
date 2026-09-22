@if ($paginator->hasPages() || $paginator->total() > 0)
    <div class="w-full bg-white border-t border-slate-200/80 px-4 py-3 sm:px-6 rounded-b-2xl">
        <!-- justify-start biar SEMUA elemen mepet ke KIRI -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 w-full">
            
            <!-- INFO TOTAL ENTRIES (Di Kiri) -->
            <div class="text-xs text-slate-500 font-medium text-left shrink-0">
                Menampilkan 
                <span class="font-bold text-slate-800">{{ $paginator->firstItem() ?? 0 }}</span> 
                sampai 
                <span class="font-bold text-slate-800">{{ $paginator->lastItem() ?? 0 }}</span> 
                dari 
                <span class="font-bold text-slate-800">{{ $paginator->total() }}</span> data
            </div>

            <!-- TOMBOL ANGKA PAGINATION (Nempel di Sebelah Kanan Info Entri / Tetap di Kiri) -->
            @if ($paginator->hasPages())
                <div class="flex items-center justify-start shrink-0">
                    <nav role="navigation" aria-label="Pagination Navigation" class="inline-flex gap-1">
                        
                        {{-- Tombol Previous --}}
                        @if ($paginator->onFirstPage())
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-slate-300 bg-slate-50 cursor-not-allowed">
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            </span>
                        @else
                            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-slate-600 bg-white border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 font-semibold transition shadow-xs">
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-slate-400">
                                    {{ $element }}
                                </span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-900 text-xs font-black text-white shadow-xs">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 transition shadow-xs">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Tombol Next --}}
                        @if ($paginator->hasMorePages())
                            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-slate-600 bg-white border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 font-semibold transition shadow-xs">
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        @else
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-slate-300 bg-slate-50 cursor-not-allowed">
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </span>
                        @endif

                    </nav>
                </div>
            @endif

        </div>
    </div>
@endif