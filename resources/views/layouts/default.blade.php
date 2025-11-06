<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", "PRINTING_SHOP")</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  {{-- Use Vite to load app.css and app.js (matches guest layout) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
    <div class="layout-wrapper">
      @include('layouts.sidebarReceiving') <!-- Shared sidebar -->
      <main class="main-panel">
          @yield('content') <!-- Page-specific content (e.g., receiving.blade.php) -->
      </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    @stack('scripts')
  </body>
</html>
