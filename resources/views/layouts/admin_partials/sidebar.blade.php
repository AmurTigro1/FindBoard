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
    <nav class="mt-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium hover:text-blue-400 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
            Dashboard
        </a>
        <a href="{{route('admin.manage.users')}}" 
           class="flex items-center px-4 py-2 text-sm font-medium hover:text-blue-400 {{ request()->routeIs('admin.manage.users') || request()->routeIs('admin.users.show') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
            Manage Users
        </a>
        <a href="{{route('admin.pending-permits') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium hover:text-blue-400 {{ request()->routeIs('admin.pending-permits') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
            Pending Business Permits
        </a>
        <a href="{{ route('admin.manage.listings') }}"
        class="flex items-center px-4 py-2 text-sm font-medium hover:text-blue-400 {{ request()->routeIs('admin.manage.listings') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
         Manage Listings
     </a>
        <a href="{{ route('admin.profile')}}" 
        class="flex items-center px-4 py-2 text-sm font-medium hover:text-blue-400 {{ request()->routeIs('admin.profile') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
         Profile
     </a>
        @if (auth()->user()->role === 'landlord')
            <a href="{{ route('landlord.room.reservation') }}" 
               class="flex items-center px-4 py-2 text-sm font-medium hover:text-blue-400 {{ request()->routeIs('landlord.room.reservation') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
                Room Reservation
            </a>
        @endif
    </nav>
    
</div>
