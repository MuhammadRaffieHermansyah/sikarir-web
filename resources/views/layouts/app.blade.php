<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('layouts.partials.favicon')
  <title>@yield('title', 'Dashboard Admin BLK CONNECT')</title>

  @fonts
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell h-full font-sans text-foreground antialiased">
  <x-ui.sidebar-provider persist class="h-screen overflow-hidden">
    @include('layouts.partials.sidebar')

    <div class="flex min-h-0 min-w-0 flex-1 flex-col overflow-hidden">
      @include('layouts.partials.header')

      <main class="min-w-0 flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        <div class="mx-auto w-full max-w-[1440px] space-y-6">
          @if (session('error'))
            <x-ui.alert tone="danger">
              <x-lucide-circle-alert />
              <x-ui.alert-title>Terjadi kesalahan</x-ui.alert-title>
              <x-ui.alert-description>{{ session('error') }}</x-ui.alert-description>
            </x-ui.alert>
          @endif

          @yield('content')
        </div>
      </main>
    </div>
  </x-ui.sidebar-provider>

  <x-ui.sonner position="bottom-right" />

  @stack('scripts')
</body>
</html>
