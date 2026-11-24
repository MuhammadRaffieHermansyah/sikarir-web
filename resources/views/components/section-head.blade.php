@props(['badge', 'title', 'center' => false])

<div {{ $attributes->class(['mx-auto max-w-xl text-center' => $center]) }}>
    <x-ui.badge variant="secondary" class="uppercase tracking-wide">{{ $badge }}</x-ui.badge>
    <h2 class="mt-3 text-2xl font-black tracking-tight text-foreground">{{ $title }}</h2>
    @if ($slot->isNotEmpty())
        <p class="mt-1.5 text-sm text-muted-foreground {{ $center ? '' : 'max-w-2xl' }}">{{ $slot }}</p>
    @endif
</div>
