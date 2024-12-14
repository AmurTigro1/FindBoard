@extends('main_resources.index')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                     <!-- Breadcrumb Navigation -->
                     <nav class="mb-6" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-4 text-gray-600">
                            <li>
                                <a href="/" class="flex items-center text-blue-600 hover:text-blue-800">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 12l2-2m0 0l7-7 7 7m-9-2v12m4-12l7 7-7 7m0 0l-7-7"></path></svg>
                                    Home
                                </a>
                            </li>
                            <li>
                                <span class="text-gray-400">/</span>
                            </li>
                            <li>
                                <a href="{{ route('boarding_house.show', $boardingHouse->id) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $boardingHouse->name }}
                                </a>
                            </li>
                            <li>
                                <span class="text-gray-400">/</span>
                            </li>
                        </ol>
                    </nav>
                    <div class="mt-4">
                        @if ($availableRoomsCount < 2)
                            <p class="text-lg font-semibold text-red-600">
                                Hurry! Only {{ $availableRoomsCount }} room{{ $availableRoomsCount == 1 ? '' : 's' }} left.
                            </p>
                        @else
                            <p class="text-lg font-semibold text-gray-700">
                                Rooms Available: 
                                <span class="text-blue-600">{{ $availableRoomsCount }}</span>
                            </p>
                        @endif
                    </div>
                    
                    <div class="social-share mt-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Share This Boarding House</h3>
                        <div class="flex items-center gap-4 justify-between">
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
                            
            <!-- Wishlist Button -->
            <button 
                class="p-2 bg-white rounded-full shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 wishlist-button flex items-center space-x-2"
                data-house-id="{{ $boardingHouse->id }}"
                data-added="{{ $boardingHouse->isInWishlist(auth()->id()) ? 'true' : 'false' }}">
                <i class="fas fa-heart {{ $boardingHouse->isInWishlist(auth()->id()) ? 'text-red-500' : 'text-gray-500' }}"></i>
                <span class="text-gray-600 underline">Save</span>
            </button>
                        </div>
                    </div>
                    
            <!-- Display Boarding House Images -->
            <x-house-show-images :house="$boardingHouse"/>
            
            <!-- Boarding House Info and Amenities -->
            <div class="mb-6 flex flex-col lg:flex-row gap-2">
                <div class="flex-1 lg:flex-[2.5] mb-4 lg:mb-0">
                    <x-house-show-info :house="$boardingHouse"/>
                    <x-house-show-amenity :house="$boardingHouse" :amenities="$amenities"/>
                </div>
                <div class="flex-1 border">
                    <div id="display-map" style="width: 100%; height: 390px;"></div>
                    <div class="mt-4">
                        <a 
                            href="https://www.google.com/maps?q={{ $boardingHouse->latitude }},{{ $boardingHouse->longitude }}" 
                            target="_blank"
                            class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition-all duration-300"
                        >
                            View on Google Maps
                        </a>
                    </div>
                </div>
                
                <script>
                    function initMap() {
                        const pinnedLocation = {
                            lat: {{ $boardingHouse->latitude }},
                            lng: {{ $boardingHouse->longitude }}
                        };
                
                        // Initialize the map
                        const map = new google.maps.Map(document.getElementById('display-map'), {
                            center: pinnedLocation,
                            zoom: 15,
                        });
                
                        // Place a marker on the pinned location
                        new google.maps.Marker({
                            position: pinnedLocation,
                            map: map,
                        });
                    }
                </script>
            </div>
            <x-owner-details :owner="$owner" />
            <!-- Description and Policies -->
            <x-house-show-description :house="$boardingHouse"/>
            <x-house-show-policy :house="$boardingHouse"/>
            
          <!-- Available Rooms Section -->
<div class="mt-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900">Available Rooms</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($rooms as $room)
            <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                <a href="{{ route('rooms.show', ['room' => $room->id]) }}" class="block">
                    <!-- Room Image -->
                    @if($room->thumbnail_image)
                        <img src="{{ asset('storage/' . $room->thumbnail_image) }}" alt="Thumbnail for {{ $room->type }}" class="w-full h-48 object-cover transition-transform duration-300 transform hover:scale-105">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex justify-center items-center text-white text-lg">
                            No Image Available
                        </div>
                    @endif
                    <div class="p-4 bg-white">
                        <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition duration-150">{{ $room->type }}</h3>
                       <!-- Availability Display -->
                <div>
                    <div class="mt-1 text-lg font-semibold text-gray-800">
                        @if($room->availability === 'available')
                            <span class="text-green-600">Available</span>
                        @elseif($room->availability === 'not_available')
                            <span class="text-red-600">Not Available</span>
                            <!-- Show Date When Available -->
                            @if($room->available_date)
                                <div class="mt-1 text-sm text-gray-600">
                                    Available on: <span class="font-medium text-blue-500">{{ \Carbon\Carbon::parse($room->available_date)->format('F d, Y') }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                        <p class="text-blue-500 font-medium">{{ number_format($room->price, 2) }} per month</p>
                        <p class="text-gray-600 text-sm">Beds: {{ $room->number_of_beds }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
         <!-- Reviews Section -->
            <x-house-show-reviews :house="$boardingHouse" :reviews="$reviews"/>
            <x-house-show-nearby-bh :nearby="$nearbyBoardingHouses" />


        </div>
    </div>
@endsection
