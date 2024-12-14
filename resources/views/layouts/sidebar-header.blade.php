<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindBoard</title>
    <link rel="icon" href="{{ asset('public/logo.png') }}" type="image/png">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyiLn56FbWmeObOoirjVkwjJEiMxkszh02v&callback=initMap" async defer></script> --}}
    <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyeVok9doy4ubsLyKcu3pfocjc-Xxf2tOKB&callback=initMap" async defer></script>

</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Include Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Include Header -->
            @include('layouts.partials.header')

            <!-- Page Content -->
            <main class="p-6 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
