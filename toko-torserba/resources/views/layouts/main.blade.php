<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Online')</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tailwind dari Vite --}}
    @vite('resources/css/app.css')

    <style>
        /* Supaya Bootstrap tidak mengubah link di sidebar */
        .sidebar a {
            text-decoration: none !important;
            color: inherit !important;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="flex-shrink-0 sidebar">
            @include('layouts.sidebar')
        </div>

        {{-- Main Content --}}
        <main class="flex-fill p-4">
            @yield('content')
        </main>
    </div>

    {{-- Bootstrap 5 JS Bundle (Popper + JS) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
