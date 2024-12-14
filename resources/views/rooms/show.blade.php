@extends('main_resources.index')
<!-- Pannellum 360° Viewer CSS -->
<link href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css" rel="stylesheet">
<!-- Pannellum 360° Viewer JS -->
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                   <!-- Breadcrumb Navigation -->
                   <nav class="mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4 text-gray-600">
                        <li>
                            <a href="/" class="flex items-center text-gray-600 hover:text-blue-800">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 12l2-2m0 0l7-7 7 7m-9-2v12m4-12l7 7-7 7m0 0l-7-7"></path></svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <span class="text-gray-400">/</span>
                        </li>
                        <li>
                            <a href="{{ route('boarding_house.show', $boardingHouse->id) }}" class="text-gray-600 hover:text-blue-800">
                                {{ $boardingHouse->name }}
                            </a>
                        </li>
                        <li>
                            <span class="text-gray-400">/</span>
                        </li>
                        <li>
                            <span class="text-blue-800">{{ $room->type }}</span>
                        </li>
                    </ol>
                </nav>
   <!-- Room Gallery -->
   <div class="mb-10">
    <div class="relative">
        <div class="social-share mt-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Share This Room</h3>
            <div class="flex items-center gap-4">
                <!-- Facebook Share Button -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                   target="_blank" 
                   class="flex items-center space-x-2 text-blue-600 hover:text-blue-700">
                    <i class="fab fa-facebook-square text-2xl"></i>
                    <span class="text-gray-600">Facebook</span>
                </a>
                <!-- Messenger Share Button -->
                <a href="https://www.messenger.com/t/?link={{ urlencode(request()->fullUrl()) }}" 
                    target="_blank" 
                    class="flex items-center space-x-2 text-blue-600 hover:text-blue-700">
                    <i class="fab fa-facebook-messenger text-2xl"></i>
                    <span class="text-gray-600">Messenger</span>
                </a>
                
                <!-- Instagram Share Button -->
                <a href="https://www.instagram.com/" 
                   target="_blank" 
                   class="flex items-center space-x-2 text-pink-600 hover:text-pink-700">
                    <i class="fab fa-instagram text-2xl"></i>
                    <span class="text-gray-600">Instagram</span>
                </a>
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-2 w-full h-[400px] mb-5 overflow-hidden relative rounded-lg">
            <!-- Photo Container with Custom Carousel -->
            <div id="carouselContainer" class="w-full lg:w-2/3 h-1/2 lg:h-full relative cursor-pointer">
                <div id="carousel" class="carousel-wrapper w-full h-full relative overflow-hidden">
                    <div class="carousel-inner w-full h-full flex transition-all duration-500 ease-in-out">
                        <div class="carousel-item w-full h-full flex-shrink-0">
                            <img src="{{ asset('storage/' . $room->thumbnail_image) }}" 
                                 alt="Thumbnail Image" 
                                 class="w-full h-full object-cover rounded-lg">
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Grid Container with Images -->
            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2 w-full h-1/2 lg:h-full">
                @if($room->main_images)
                    @php
                        $images = json_decode($room->main_images);
                    @endphp
                    @foreach(array_slice($images, 0, 4) as $image)
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="Room Image" 
                                 class="w-full h-full object-cover rounded-lg">
                        </div>
                    @endforeach
                @else
                    <!-- Fallback: No Images Available -->
                    <div class="col-span-2 flex items-center justify-center bg-gray-100 h-full rounded-lg">
                        <p class="text-gray-500">No additional images available</p>
                    </div>
                @endif
            </div>
        </div>
        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Available Now</span>
         <!-- Show All Photos Button -->
         <div class="mt-4 text-right">
            <button onclick="showAllPhotos()" 
                    class="bg-blue-600 text-white py-2 px-4 rounded shadow hover:bg-blue-700 transition">
                Show All Photos
            </button>
        </div>
<!-- Modal for Viewing Images -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="relative bg-white rounded-lg p-4 max-w-2xl w-full h-3/4 overflow-y-scroll">
        <span class="absolute top-2 right-2 text-gray-600 text-4xl p-2 cursor-pointer z-10 hover:text-red-600" onclick="closeModal()">×</span>
        <div class="grid grid-cols-2 gap-4">
            @if($room->main_images)
                @foreach($images as $image)
                    <img src="{{ asset('storage/' . $image) }}" 
                         alt="Room Image" 
                         class="w-full h-40 object-cover rounded-lg">
                @endforeach
            @endif
        </div>
    </div>
</div>
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Room Amenities</h2>
            @if($room->roomAmenity && $room->roomAmenity->isNotEmpty())
                <div class="mt-6">
                    <div class="flex items-center gap-6">
                        @foreach($room->roomAmenity as $amenity)
                            @if($amenity->wifi)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-wifi text-blue-500 text-xl"></i>
                                    <span class="text-gray-600">Free WiFi</span>
                                </div>
                            @endif
                            @if($amenity->air_conditioning)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-snowflake text-blue-500 text-xl"></i>
                                    <span class="text-gray-600">Air Conditioning</span>
                                </div>
                            @endif
                            @if($amenity->refrigerator)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-snowman text-blue-500 text-xl"></i> <!-- Snowman icon for Refrigerator -->
                                    <span class="text-gray-600">Refrigerator</span>
                                </div>
                            @endif

                            @if($amenity->cabinet)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-suitcase text-blue-500 text-xl"></i> <!-- Example icon for a cabinet -->
                                    <span class="text-gray-600">Cabinet</span>
                                </div>
                            @endif
                            @if($amenity->electric_fan)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-fan text-blue-500 text-xl"></i>
                                    <span class="text-gray-600">Electric Fan</span>
                                </div>
                            @endif
                            @if($amenity->table)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-table text-blue-500 text-xl"></i>
                                    <span class="text-gray-600">Table</span>
                                </div>
                            @endif
                            @if($amenity->chair)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chair text-blue-500 text-xl"></i>
                                    <span class="text-gray-600">Chair</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-gray-500">No room amenities available for this room.</p>
            @endif
            <div class="p-6 bg-blue-100 text-blue-800 rounded-lg mt-4">
                <p class="font-semibold">Limited-Time Offer!</p>
                <p>Visit this room and save 10% off your first month.</p>
            </div>
            
        
    </div>
    



    <!-- Modal Scripts -->
    <script>
        function openModal(imageSrc) {
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        function showAllPhotos() {
            openModal(); // Opens the modal for all images
        }
    </script>
            <!-- Room Info Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ $room->name }}</h1>

                <div class="mt-4">
                    <p class="text-lg font-semibold text-gray-800">Price: <span class="text-green-600">{{ number_format($room->price, 2) }} / month</span></p>
                    <p class="text-lg font-semibold text-gray-800">Occupancy: <span class="text-gray-600">{{ $room->occupancy }}</span></p>
                </div>
                <p class="text-gray-600 mt-2">{{ $room->description }}</p>
            </div>


    <!-- resources/views/rooms/show.blade.php -->
<div class="bg-white p-6 rounded-lg shadow-lg">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Reserve a visit for this Room</h2>
    <form action="{{ route('reservations.store') }}" method="POST" class="text-gray-800">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Your Name</label>
            <input type="text" id="name" name="name" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Your Email</label>
            <input type="email" id="email" name="email" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-semibold mb-2">Your Contact Number</label>
            <input type="text" id="phone" name="phone" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-semibold mb-2">Your Address</label>
            <input type="text" id="address" name="address" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label for="visit_date" class="block text-gray-700 font-semibold mb-2">Visit Date</label>
            <input type="date" id="visit_date" name="visit_date" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>
        
        <div class="mb-4">
            <label for="visit_time" class="block text-gray-700 font-semibold mb-2">Around What Time?</label>
            <input type="time" id="visit_time" name="visit_time" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>
        

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Reserve</button>
    </form>
    </div>

        </div>
 </div>

 <div class="mt-8">
    <h3 class="text-xl font-bold text-gray-800 mb-2">Frequently Asked Questions</h3>
    <div class="space-y-4">
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">How many bathrooms are available?</summary>
            <p class="text-gray-600 mt-2">- We have 2 shared bathrooms available for tenants.</p>
        </details>
    
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">Is there free Wi-Fi?</summary>
            <p class="text-gray-600 mt-2">- Yes, we provide free Wi-Fi with a stable connection for all tenants.</p>
        </details>
    
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">What is the curfew policy?</summary>
            <p class="text-gray-600 mt-2">- The curfew is set at 10:00 PM for safety and security purposes.</p>
        </details>
    
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">Are pets allowed?</summary>
            <p class="text-gray-600 mt-2">- Unfortunately, pets are not allowed in the boarding house.</p>
        </details>
    
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">Is there a refrigerator available?</summary>
            <p class="text-gray-600 mt-2">- Yes, a shared refrigerator is available for storing your food and drinks.</p>
        </details>
    
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">What are the room amenities?</summary>
            <p class="text-gray-600 mt-2">- Each room includes a bed, cabinet, table, chair, and an electric fan. Air conditioning is available in select rooms.</p>
        </details>
    
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">Is there parking space available?</summary>
            <p class="text-gray-600 mt-2">- Yes, we offer limited parking spaces for tenants with vehicles.</p>
        </details>
    
        <details class="bg-gray-100 p-4 rounded-lg text-gray-800">
            <summary class="font-semibold">Are guests allowed to visit?</summary>
            <p class="text-gray-600 mt-2">- Guests are allowed during the day but must leave by 9:00 PM.</p>
        </details>
    </div>
    
</div>
        
  </div>
@endsection