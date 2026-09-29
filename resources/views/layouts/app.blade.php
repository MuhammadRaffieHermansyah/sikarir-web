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
  <div class="flex-1 flex flex-col h-screen overflow-hidden min-w-0">

    <!-- Include Header Partial -->
    @include('layouts.partials.header')

    <!-- Main Content Body -->
    <main class="flex-1 overflow-y-auto p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
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

      // Drawer sidebar untuk mobile
      (function () {
          const toggle = document.getElementById('sidebarToggle');
          const close = document.getElementById('sidebarClose');
          const sidebar = document.getElementById('sidebar');
          const overlay = document.getElementById('sidebarOverlay');

          if (!toggle || !sidebar || !overlay) return;

          function setOpen(open) {
              sidebar.classList.toggle('-translate-x-full', !open);
              overlay.classList.toggle('pointer-events-none', !open);
              overlay.classList.toggle('opacity-0', !open);
              overlay.classList.toggle('opacity-100', open);
              toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
              toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
          }

          toggle.addEventListener('click', () => setOpen(sidebar.classList.contains('-translate-x-full')));
          close?.addEventListener('click', () => setOpen(false));
          overlay.addEventListener('click', () => setOpen(false));
          sidebar.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setOpen(false)));
          document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
          window.matchMedia('(min-width: 768px)').addEventListener('change', (e) => { if (e.matches) setOpen(false); });
      })();
  </script>
</body>
</html>
