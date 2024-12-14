<header class="py-4 px-6 bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Mobile Menu Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-900">
            ☰
        </button>

        <!-- Logo -->
        <a href="/" class="text-blue-600 font-bold text-2xl">FindBoard</a>

    <!-- User Greeting and Actions -->
    {{-- <div class="flex items-center space-x-4 md:mt-0"> --}}
        <!-- Greeting -->
        {{-- <span class="text-gray-600 text-sm md:text-base">
            Hello, <span class="font-medium">{{ Auth::user()->name }}</span>
        </span> --}}

        @if (Auth::check())
        <!-- Profile Dropdown -->
        <div class="relative group">
            <button id="dropdown-btn" class="flex items-center text-gray-600 font-semibold px-2 py-1 rounded-lg hover:bg-gray-100 focus:outline-none">
                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center mr-2">
                    @if (auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                        </svg>
                    @endif
                </div>
                {{ Auth::user()->name }}
                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5.292 7.292a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <!-- Dropdown Menu -->
            {{-- group-hover:block --}}
            <div id="dropdown-menu" class="absolute right-0 hidden bg-white shadow-md rounded-lg mt-2 w-48 z-50">
                <ul class="py-2 text-sm text-gray-600">
                    <li class="block md:hidden">
                        <a href="{{ route('boarding_house.guide') }}" class="block px-4 py-2 hover:bg-gray-100 hover:text-blue-500">
                            List your Boarding House
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 hover:bg-gray-100 hover:text-blue-500">
                            Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="{{ 
                            Auth::user()->role === 'landlord' ? route('profile') : 
                            (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('profile')) 
                        }}" 
                        class="block px-4 py-2 hover:bg-gray-100 hover:text-blue-500">Profile</a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 hover:bg-gray-100 hover:text-blue-500">
                            @csrf
                            <button type="submit" class="w-full text-left">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @else
        <div class="flex items-center space-x-4">
            <a href="{{ route('wishlist.index') }}" class="text-gray-700 hover:text-blue-500">
                <i class="fas fa-heart"></i> Wishlist
            </a>
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-semibold">
                Login
            </a>
            <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600 font-semibold">
                Register
            </a>
        </div>
    @endif
   
</div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const dropdownBtn = document.getElementById("dropdown-btn");
        const dropdownMenu = document.getElementById("dropdown-menu");

        dropdownBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent event propagation to document
            dropdownMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", () => {
            if (!dropdownMenu.classList.contains("hidden")) {
                dropdownMenu.classList.add("hidden");
            }
        });
    });
</script>
