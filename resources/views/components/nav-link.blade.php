@props(['active' => false])

<a {{ $attributes->merge(['class' => ($active ?? false)
    ? 'inline-flex items-center rounded-md bg-accent px-3 py-2 text-sm font-semibold text-accent-foreground transition'
    : 'inline-flex items-center rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition hover:bg-accent/60 hover:text-accent-foreground']) }}>
    {{ $slot }}
</a>
