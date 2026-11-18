@props(['status' => null])

@if ($status)
    <x-ui.alert tone="success" {{ $attributes }}>
        <x-lucide-circle-check />
        <x-ui.alert-description>{{ $status }}</x-ui.alert-description>
    </x-ui.alert>
@endif
