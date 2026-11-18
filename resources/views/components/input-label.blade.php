@props(['value' => null, 'for' => null])

<x-ui.label :for="$for" {{ $attributes }}>
    {{ $value ?? $slot }}
</x-ui.label>
