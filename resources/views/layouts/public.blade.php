<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'siKarir - UPT BLK Jember')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans antialiased text-slate-800 bg-white min-h-screen flex flex-col justify-between">

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
