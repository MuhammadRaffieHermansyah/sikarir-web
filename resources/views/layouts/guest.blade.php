<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/sikarir-logo.png') }}?v=2">
        <link rel="apple-touch-icon" href="{{ asset('images/sikarir-logo.png') }}?v=2">

        <title>Masuk - siKarir UPT BLK Jember</title>
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Scripts -->
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="site-shell font-sans text-slate-900 antialiased min-h-screen flex items-center justify-center p-4 md:p-6">

        <div class="w-full max-w-6xl mx-auto">
            {{ $slot }}
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
