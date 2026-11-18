@props(['messages' => null])

<x-ui.field-error :messages="$messages" {{ $attributes }} />
