@if ($paginator->hasPages() || $paginator->total() > 0)
    <div class="w-full border-t border-border bg-card px-4 py-3 sm:px-6">
        <div class="flex w-full flex-col items-center justify-between gap-3 lg:flex-row lg:gap-6">
            <p class="w-full shrink-0 text-center text-xs font-medium text-muted-foreground lg:w-auto lg:text-left">
                Menampilkan
                <span class="font-semibold text-foreground">{{ $paginator->firstItem() ?? 0 }}</span>
                sampai
                <span class="font-semibold text-foreground">{{ $paginator->lastItem() ?? 0 }}</span>
                dari
                <span class="font-semibold text-foreground">{{ $paginator->total() }}</span> data
            </p>

            @if ($paginator->hasPages())
                <div class="scrollbar-none w-full shrink-0 overflow-x-auto lg:w-auto">
                    <x-ui.pagination class="justify-center lg:justify-start">
                        <x-ui.pagination-content class="w-max">
                            <x-ui.pagination-item>
                                <x-ui.pagination-link
                                    :href="$paginator->previousPageUrl() ?? '#'"
                                    size="icon-sm"
                                    aria-label="Halaman sebelumnya"
                                    @class(['pointer-events-none opacity-50' => $paginator->onFirstPage()])
                                >
                                    <x-lucide-chevron-left />
                                </x-ui.pagination-link>
                            </x-ui.pagination-item>

                            @foreach ($elements as $element)
                                @if (is_string($element))
                                    <x-ui.pagination-item class="hidden lg:block">
                                        <x-ui.pagination-ellipsis />
                                    </x-ui.pagination-item>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @php($isFarPage = abs($page - $paginator->currentPage()) > 2)
                                        <x-ui.pagination-item @class(['hidden lg:block' => $isFarPage])>
                                            <x-ui.pagination-link :href="$url" :is-active="$page == $paginator->currentPage()" size="icon-sm">
                                                {{ $page }}
                                            </x-ui.pagination-link>
                                        </x-ui.pagination-item>
                                    @endforeach
                                @endif
                            @endforeach

                            <x-ui.pagination-item>
                                <x-ui.pagination-link
                                    :href="$paginator->nextPageUrl() ?? '#'"
                                    size="icon-sm"
                                    aria-label="Halaman berikutnya"
                                    @class(['pointer-events-none opacity-50' => ! $paginator->hasMorePages()])
                                >
                                    <x-lucide-chevron-right />
                                </x-ui.pagination-link>
                            </x-ui.pagination-item>
                        </x-ui.pagination-content>
                    </x-ui.pagination>
                </div>
            @endif
        </div>
    </div>
@endif
