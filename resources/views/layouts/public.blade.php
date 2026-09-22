<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'siKarir - UPT BLK Jember')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- CDN Lucide Icons (WAJIB ADA) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-white">

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    <!-- Init Lucide Icons (WAJIB ADA BIAR ICON MUNCUL) -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>