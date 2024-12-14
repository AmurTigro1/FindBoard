@php
    $hasBoardingHouseWithRooms = $hasBoardingHouseWithRooms ?? (auth()->check() && auth()->user()->boardingHouses()->whereHas('rooms')->exists());
@endphp
<div 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg text-gray-600 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
>
    <!-- Header Section -->
    <div class="flex items-center justify-between px-4 py-1 border-b border-gray-200">
        <!-- User Info Section -->
        <div class="flex items-center space-x-4">
            <!-- User Profile Picture -->
            <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                @if (auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="w-full h-full object-cover">
                @else
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                @endif
            </div>
            <!-- User Greeting -->
            <div class="flex-1">
                <p 
                    class="text-lg font-semibold text-gray-800 truncate" 
                    title="{{ Auth::user()->name }}" 
                    style="max-width: 8rem;" >
                
                    Hello, {{ Auth::user()->name }}
                </p>
                <p class="text-sm text-gray-500">Welcome back!</p>
            </div>
        </div>
        
        <!-- Close Button -->
        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-800 lg:hidden" aria-label="Close Sidebar">
            ✕
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-6">
        <a href="{{ route('profile') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:text-blue-500 hover:bg-blue-100 
           {{ request()->routeIs('profile') || request()->routeIs('profile.edit') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
            Dashboard
        </a>
        <a href="{{ route('boarding_house.view') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:text-blue-500 hover:bg-blue-100 
           {{ request()->routeIs('boarding_house.view')  || request()->routeIs('boarding_house.edit') || request()->routeIs('rooms.edit') || request()->routeIs('boarding_house-rooms.index') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
            My Boarding House 
        </a>
        <a href="{{ route('reservations.myReservations') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:text-blue-500 hover:bg-blue-100 
           {{ request()->routeIs('reservations.myReservations') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
            My Reservations
        </a>
        <a href="{{ route('free-trial') }}" 
        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:text-blue-500 hover:bg-blue-100 
        {{ request()->routeIs('free-trial') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
         Subscription
     </a>
        @if ($hasBoardingHouseWithRooms)
            <a href="{{ route('reservations.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:text-blue-500 hover:bg-blue-100 
               {{ request()->routeIs('reservations.index') || request()->routeIs('reservations.accepted') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
                Room Reservation
            </a>
        @endif
    </nav>
</div>
