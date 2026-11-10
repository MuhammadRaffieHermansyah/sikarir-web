<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#145642">
    <title>@yield('title', 'siKarir - UPT BLK Jember')</title>

    <!-- Fonts -->
    @fonts
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="site-shell font-sans antialiased min-h-screen flex flex-col justify-between">

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    {{-- KONTEN HALAMAN --}}
    <main class="grow">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('layouts.footer')

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
