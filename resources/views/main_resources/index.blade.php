<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stern - FindBoard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyIZTAMfgudfInlQ8xQ9qn_Cww76FCkUXUg&callback=initMap" async defer></script> --}}
    <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyeVok9doy4ubsLyKcu3pfocjc-Xxf2tOKB&callback=initMap" async defer></script>

    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AlzaSyIZTAMfgudfInlQ8xQ9qn_Cww76FCkUXUg&libraries=places&callback=initMap" async defer></script> --}}

     {{-- <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSymRKtJm-OpZEd7qYa4N5I0Taa8jLpL8uiU&libraries=places" async defer></script> --}}
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('public/logo.png') }}" type="image/png">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite('resources/css/app.css')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @push('scripts')
    @endpush



</head>
<body class=" text-gray-300 font-poppins">
    @include('main_resources.header')
    


    <div class="content">
        @yield('content')
    </div>
     <!-- Push scripts to this stack -->
    @stack('scripts')

    <footer class="bg-gray-200 py-12 px-4">
        <div class="container mx-auto text-center text-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About Section -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700">About Us</h4>
                    <p class="mt-4">
                        Stern - FindBoard is your trusted platform for finding affordable and comfortable boarding houses. Our mission is to make your housing search seamless and stress-free.
                    </p>
                </div>
                
                <!-- Quick Links Section -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700">Quick Links</h4>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="hover:underline">Home</a></li>
                        <li><a href="#" class="hover:underline">Search Boarding Houses</a></li>
                        <li><a href="#" class="hover:underline">Contact Us</a></li>
                        <li><a href="#" class="hover:underline">Terms of Service</a></li>
                        <li><a href="#" class="hover:underline">Privacy Policy</a></li>
                    </ul>
                </div>
    
                <!-- Contact Section -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700">Contact Us</h4>
                    <p class="mt-4">Phone: (123) 456-7890</p>
                    <p>Email: info@findboard.com</p>
                    <p class="mt-4">
                        Follow us:
                        <a href="#" class="hover:text-gray-700 mx-2">Facebook</a> | 
                        <a href="#" class="hover:text-gray-700 mx-2">Twitter</a> | 
                        <a href="#" class="hover:text-gray-700 mx-2">Instagram</a>
                    </p>
                </div>
            </div>
    
            <!-- Bottom Bar -->
            <div class="mt-8 border-t border-gray-700 pt-4">
                <p>&copy; 2024 Stern - FindBoard. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
</body>
</html>
