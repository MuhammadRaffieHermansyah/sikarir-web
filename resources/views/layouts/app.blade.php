<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin BLK CONNECT')</title>

  <!-- Tailwind CSS & Lucide Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
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
      @yield('content')
    </main>
  </div>

  <script>
    // Init Lucide Icons
    lucide.createIcons();
  </script>
</body>
</html>