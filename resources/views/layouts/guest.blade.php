@props(['title' => 'Masuk - siKarir UPT BLK Jember'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/sikarir-logo.png') }}?v=2">
        <link rel="apple-touch-icon" href="{{ asset('images/sikarir-logo.png') }}?v=2">

        <title>{{ $title }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="site-shell flex min-h-screen items-center justify-center bg-background p-4 text-foreground antialiased md:p-6">
        <div class="relative w-full max-w-6xl">
            <div class="pointer-events-none absolute -left-24 -top-24 size-72 rounded-full bg-primary/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -right-24 size-72 rounded-full bg-sikarir-lime/20 blur-3xl"></div>

            <div class="relative">
                {{ $slot }}
            </div>
        </div>

        <x-ui.sonner position="bottom-right" />
    </body>
</html>
