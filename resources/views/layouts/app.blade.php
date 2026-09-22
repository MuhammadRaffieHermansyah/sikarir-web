<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin BLK CONNECT')</title>

  <!-- Tailwind CSS & Lucide Icons -->
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 flex h-screen overflow-hidden">

  <!-- Include Sidebar Partial -->
  @include('layouts.partials.sidebar')

  <!-- Main Content Wrapper -->
  <div class="flex-1 flex flex-col h-screen overflow-hidden">

    <!-- Include Header Partial -->
    @include('layouts.partials.header')

    <!-- Main Content Body -->
    <main class="flex-1 overflow-y-auto p-6 space-y-6">
      @if (session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700" role="alert">
          {{ session('error') }}
        </div>
      @endif
      @yield('content')
    </main>
  </div>

  <script>
    // Init Lucide Icons
    lucide.createIcons();
  </script>
</body>
</html>
