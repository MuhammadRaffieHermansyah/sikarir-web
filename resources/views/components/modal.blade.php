@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
$maxWidthClass = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<x-ui.dialog :open="$show">
    <div
        x-on:open-modal.window="if ($event.detail === @js($name)) open = true"
        x-on:close.window="open = false"
    >
        <x-ui.dialog-content :class="$maxWidthClass">
            {{ $slot }}
        </x-ui.dialog-content>
    </div>
</x-ui.dialog>
