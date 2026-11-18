@props([
    'action',
    'searchPlaceholder' => 'Cari data...',
    'statusOptions' => [],
    'statusName' => 'status',
    'statusPlaceholder' => 'Semua Status',
])

<form method="GET" action="{{ $action }}" class="flex w-full flex-col items-stretch gap-2.5 sm:flex-row sm:items-center lg:w-auto">
    <div class="flex w-full flex-col items-stretch gap-2 sm:flex-row sm:items-center">
        <div class="relative w-full sm:w-64">
            <x-ui.input name="search" :value="request('search')" :placeholder="$searchPlaceholder" class="pl-9">
                <x-slot:leading>
                    <x-lucide-search />
                </x-slot:leading>
            </x-ui.input>
        </div>

        @if (! empty($statusOptions))
            <x-ui.select name="{{ $statusName }}" native class="w-full capitalize sm:w-auto">
                <option value="">{{ $statusPlaceholder }}</option>
                @foreach ($statusOptions as $key => $label)
                    <option value="{{ $key }}" @selected((string) request($statusName) === (string) $key)>{{ $label }}</option>
                @endforeach
            </x-ui.select>
        @endif
    </div>

    <div class="flex w-full shrink-0 items-center gap-1.5 sm:w-auto">
        <x-ui.button type="submit" size="sm" class="flex-1 font-bold sm:flex-none">
            <x-lucide-search />
            <span>Cari</span>
        </x-ui.button>

        @if (request('search') || request($statusName))
            <x-ui.button variant="outline" size="icon-sm" href="{{ $action }}" aria-label="Reset filter" title="Reset Filter">
                <x-lucide-rotate-ccw />
            </x-ui.button>
        @endif
    </div>
</form>
