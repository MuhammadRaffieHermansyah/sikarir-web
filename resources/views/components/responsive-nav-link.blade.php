@props(['active' => false])

<a {{ $attributes->merge(['class' => ($active ?? false)
    ? 'block w-full rounded-md bg-accent px-3 py-2 text-start text-base font-semibold text-accent-foreground transition'
    : 'block w-full rounded-md px-3 py-2 text-start text-base font-medium text-muted-foreground transition hover:bg-accent/60 hover:text-accent-foreground']) }}>
    {{ $slot }}
</a>
