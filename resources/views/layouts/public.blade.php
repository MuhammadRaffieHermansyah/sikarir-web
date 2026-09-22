<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'siKarir - UPT BLK Jember')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#131B2E]">

    @include('layouts.navbar')

    @yield('content')

    @include('layouts.footer')

</body>
</html>
