<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#145642">
    @include('layouts.partials.favicon')
    <title>@yield('title', 'siKarir - UPT BLK Jember')</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell flex min-h-screen flex-col justify-between bg-background font-sans text-foreground antialiased">

    @include('layouts.navbar')

    <main class="grow">
        @yield('content')
    </main>

    @include('layouts.footer')

    <x-ui.sonner position="bottom-right" />
</body>
</html>
