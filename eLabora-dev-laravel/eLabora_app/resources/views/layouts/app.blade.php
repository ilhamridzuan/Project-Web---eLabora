<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR (sama untuk semua) --}}
    @include('components.navbar')

    {{-- BODY --}}
    <div class="flex flex-1 pt-[60px]">
        {{-- SIDEBAR (opsional, tergantung role) --}}
        @isset($sidebar)
            <aside class="w-64 bg-white shadow">
                @include('components.sidebar.' . $sidebar)
            </aside>
        @endisset

        {{-- CONTENT --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    {{-- FOOTER (sama untuk semua) --}}
    {{-- @include('components.footer') --}}

    {{-- Alpine.js CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</body>
</html>
