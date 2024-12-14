@extends('main_resources.index')

@section('title', 'FindBoard')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="ph-address-selector.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.0/lottie.min.js"></script>


<section class="hero-section relative text-white py-24 inset-0 bg-cover bg-center bg-no-repeat bg-[url('/public/bg-homepage.avif')]">
    <div class="absolute inset-0 bg-black opacity-50 z-0"></div> <!-- Background Overlay -->
    <div class="container mx-auto px-4 text-center relative z-10">
        <!-- Hero Section Title -->
        <h1 class="text-6xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-200 via-purple-400 to-indigo-600 mb-6">
            Discover Your Ideal Boarding House
        </h1>
        <p class="text-xl md:text-2xl mb-10 font-light">
            Explore a curated selection of boarding houses, customized to meet your needs and preferences.
        </p>

        <!-- Search Form -->
        <form action="{{ route('boarding_house.search') }}" method="GET" class="bg-white p-8 rounded-2xl shadow-xl grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-center  transform transition-all hover:scale-105 duration-300">
            <!-- Address Search Input -->
            <div class="relative">
                <input 
                    type="text" 
                    name="address" 
                    placeholder="Enter address or area" 
                    value="{{ request('address') }}" 
                    class="w-full border border-transparent bg-gray-100 text-gray-800 p-4 rounded-lg shadow-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-lg transition-all duration-300 ease-in-out"
                >
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 10a6.65 6.65 0 11-13.3 0 6.65 6.65 0 0113.3 0z"></path>
                    </svg>
                </span>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105"
                >
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Background Element (Optional for extra design) -->
    {{-- <div class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0 bg-[url('/public/bg-homepage.avif')]" style="opacity: 0.15;"></div> --}}
</section>
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div id="loading" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col items-center justify-center">
                <!-- Animation Illustration -->
                <img src="{{asset('loading-img.png')}}" 
                     alt="Loading..." 
                     class="w-24 h-24 mb-4 animate-bounce">
                
                <!-- Loading Title -->
                <h2 class="text-xl font-semibold text-purple-700 mb-2">Just a moment!</h2>
                
                <!-- Loading Message -->
                <p class="text-gray-600 text-center">We’re searching for the best boarding houses to match your needs.</p>
            </div>
        </div>
        
        
 <!-- Title and Description -->
<div class="mb-8 flex flex-col md:flex-row justify-between items-center">
    <div class="text-center md:text-left">
        <h2 class="text-4xl font-extrabold text-gray-800 tracking-wide mb-2">Available Boarding Houses</h2>
        <p class="text-lg text-gray-600">Browse through the most popular and top-rated options available.</p>
    </div>
    
    <!-- See More Button -->
    <a href="{{ route('boarding_house.see_more') }}" 
       id="see-more-btn" 
       class="mt-4 md:mt-0 px-6 py-2 bg-blue-500 text-white text-sm font-medium rounded-md shadow-md transition duration-300 hover:bg-blue-600 hover:shadow-lg">
        See more
    </a>

    <!-- Loading Animation for "See More" -->
    <div id="see-more-loading" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col items-center justify-center">
            <!-- Animation Illustration -->
            <img src="{{asset('loading-img.png')}}" 
                 alt="Loading..." 
                 class="w-24 h-24 mb-4 animate-bounce">
            
            <!-- Loading Title -->
            <h2 class="text-xl font-semibold text-purple-700 mb-2">Just a moment!</h2>
            
            <!-- Loading Message -->
            <p class="text-gray-600 text-center">We’re loading more boarding houses for you...<//p>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seeMoreBtn = document.getElementById('see-more-btn');
        const loadingDiv = document.getElementById('see-more-loading'); // Target unique ID

        seeMoreBtn.addEventListener('click', function (event) {
            // Prevent immediate navigation
            event.preventDefault();

            // Show the correct loading animation
            loadingDiv.classList.remove('hidden');

            // Delay navigation to give the loading effect
            setTimeout(() => {
                window.location.href = seeMoreBtn.href;
            }, 1500); // Adjust the delay (in milliseconds) as needed
        });
    });
</script>

        <!-- Display Current Search Filters -->
        <div class="mb-6 text-gray-700 {{ request()->hasAny(['address', 'gender_preference', 'price_min', 'price_max']) ? '' : 'hidden' }}">
            @if(request()->hasAny(['address', 'gender_preference', 'price_min', 'price_max']))
                <p class="font-medium">
                    <strong>Results for:</strong>
                    @if($searchAddress)
                        Address: "<span class="font-semibold">{{ $searchAddress }}</span>"
                    @endif
                    @if($searchGender)
                        | Gender Preference: "<span class="font-semibold">{{ ucwords(str_replace('_', ' ', $searchGender)) }}</span>"
                    @endif
                    @if($priceMin)
                        | Min Price: "<span class="font-semibold">₱{{ number_format($priceMin) }}</span>"
                    @endif
                    @if($priceMax)
                        | Max Price: "<span class="font-semibold">₱{{ number_format($priceMax) }}</span>"
                    @endif
                </p>
            @else
                <p class="font-medium text-gray-600">Showing all results</p>
            @endif
        </div>
        <!-- This is for the home page that shows all the boarding houses-->
        <!-- Search Results -->
        @if($bh->isEmpty())
            <p class="text-center text-gray-700 text-lg">No results found for your search criteria. Try adjusting your filters.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($bh->isEmpty())
                <div class="text-center text-gray-700 dark:text-gray-300 py-12">
                    <p class="text-lg font-medium">No boarding houses found.</p>
                </div>
            @else
            
            @foreach ($bh as $index => $house)
            <div class="flex flex-col">
                <div class="container relative"> <!-- Ensure container is relative -->
                    <!-- Wishlist Icon -->
                    <div class="absolute top-2 right-2 z-20">
                        <button 
                            class="p-2 bg-white rounded-full shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 wishlist-button"
                            data-house-id="{{ $house->id }}"
                            data-added="{{ $house->isInWishlist(auth()->id()) ? 'true' : 'false' }}">
                            <i class="fas fa-heart {{ $house->isInWishlist(auth()->id()) ? 'text-red-500' : 'text-gray-500' }}"></i>
                        </button>
                    </div>                 
                    <!-- Image Carousel -->
                    <div id="carousel-{{ $index }}" class="relative w-full overflow-hidden rounded-lg group">
                        <!-- Slides -->
                        <div id="slides-{{ $index }}" class="flex transition-transform duration-500">
                            @foreach ($house->images as $image)
                                <div class="flex-shrink-0 w-full">
                                    <a href="{{ route('boarding_house.show', $house->id) }}">
                                        <img src="{{ asset('storage/' . $image->other_photo_path) }}" alt="" class="w-full aspect-square object-cover">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Number Indicator -->
                        <div id="slideIndicator-{{ $index }}" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white bg-gray-800 bg-opacity-50 px-2 py-1 rounded-md text-sm opacity-0 group-hover:opacity-100 transition-all duration-300">
                            1/{{ count($house->images) }}
                        </div>
        
                        <!-- Controls -->
                        <button onclick="prevSlide({{ $index }})" class="px-4 absolute top-1/2 left-2 transform -translate-y-1/2 p-2 text-black bg-white rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110">
                            ❮
                        </button>
                        <button onclick="nextSlide({{ $index }})" class="px-4 absolute top-1/2 right-2 transform -translate-y-1/2 p-2 text-black bg-white rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110">
                            ❯
                        </button>
                    </div>
                </div>
                <!-- Details Section -->
                <a href="{{ route('boarding_house.show', $house->id) }}" class=" border-b rounded-b-md p-2 block">
                    <strong class="font-black block truncate text-gray-800 mt-3" title="{{ $house->name }}">{{ $house->name }}</strong>
                    <p class="text-sm text-gray-600 flex items-center my-2">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i> 
                        {{ $house->address }}
                    </p>
                    <p class="text-sm text-gray-700 mt-4">Curfew Hour: {{ \Carbon\Carbon::parse($house->curfew)->format('h:i A') }}</p>
                            <!-- Show available rooms count -->
                    @if ($house->available_rooms_count < 2)
                    <p class="text-sm font-semibold text-red-600">
                        Hurry! Only {{ $house->available_rooms_count }} room{{ $house->available_rooms_count == 1 ? '' : 's' }} left!
                    </p>
                @else
                    <p class="text-sm font-semibold text-green-600">
                        Available Rooms: {{ $house->available_rooms_count }}
                    </p>
                @endif
                    <!-- Gender Label -->
                    <div class="rounded-md mt-6 inline-flex text-sm items-center space-x-1 px-2 py-1 font-bold
                        {{ $house->gender === 'male only' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white' : '' }}
                        {{ $house->gender === 'female only' ? 'bg-gradient-to-r from-pink-400 to-pink-600 text-white' : '' }}
                        {{ $house->gender === 'male and female' ? 'bg-gradient-to-r from-blue-500 to-pink-600 text-white' : '' }}">
                        @if($house->gender === 'male only')
                            <i class="fas fa-mars"></i>
                        @elseif($house->gender === 'female only')
                            <i class="fas fa-venus"></i>
                        @else
                            <i class="fas fa-venus-mars"></i>
                        @endif
                        <span>{{ ucfirst($house->gender) }}</span>
                    </div>
                    <p class="text-sm text-gray-700 mt-4">{{ Str::limit($house->description, 120) }}</p>
                    <div>
                        <div class="flex flex-1 justify-end items-center gap-2">
                            <strong class="text-lg text-gray-800 font-extrabold">
                                {{ number_format($house->averageRating() ?? 0, 1) }}
                            </strong>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg
                                        class="w-4 h-4 {{ $i <= $house->averageRating() ? 'text-yellow-400' : 'text-gray-300' }} transition-transform duration-200 hover:scale-110"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 .587l3.668 7.431L23.327 9.9l-5.327 5.176 1.257 7.337L12 18.896l-6.927 3.517 1.257-7.337L.673 9.9l7.659-1.882L12 .587z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500">({{ $house->reviews()->count() }} reviews)</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
        

                    
                <div class="mt-6">
                    {{ $bh->links() }}
                </div>
            @endif
            </div>
        @endif
        <!-- Pagination Controls -->
        <div class="flex justify-center mt-8">
            {{ $bh->links() }}
        </div>
        <x-all-rooms :rooms="$rooms" />
        {{-- <x-nearby-house :houses="$nearby" /> --}}



        <x-steps/>
 

        <div class="hero-section bg-gradient-to-r from-indigo-500 to-blue-500 text-white py-16 text-center">
            <h1 class="text-5xl font-extrabold mb-6">Start Managing Your Boarding Houses Today</h1>
            <p class="text-lg mb-8">Choose the perfect subscription plan to get started!</p>
            <a href="{{ route('subscriptions.index') }}" class="bg-white text-blue-500 py-3 px-8 rounded-full text-xl font-semibold hover:bg-blue-100 transition-all">
                See Plans and Subscribe
            </a>
        </div>
    </div>
    
</section>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadingDiv = document.getElementById('loading');

        // Show loading animation when a form is submitted
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', () => {
                loadingDiv.classList.remove('hidden');
            });
        });
    });
</script>
<script>
    const carousels = [];

    document.addEventListener('DOMContentLoaded', () => {
        @foreach ($bh as $index => $house)
            carousels[{{ $index }}] = {
                currentIndex: 0,
                totalSlides: {{ count($house->images) }},
                slides: document.getElementById('slides-{{ $index }}'),
                indicator: document.getElementById('slideIndicator-{{ $index }}')
            };
            updateIndicator({{ $index }});
        @endforeach
    });

    function updateSlidePosition(index) {
        carousels[index].slides.style.transform = `translateX(-${carousels[index].currentIndex * 100}%)`;
        updateIndicator(index);
    }

    function updateIndicator(index) {
        carousels[index].indicator.textContent = `${carousels[index].currentIndex + 1}/${carousels[index].totalSlides}`;
    }

    function nextSlide(index) {
        carousels[index].currentIndex = (carousels[index].currentIndex + 1) % carousels[index].totalSlides;
        updateSlidePosition(index);
    }

    function prevSlide(index) {
        carousels[index].currentIndex = (carousels[index].currentIndex - 1 + carousels[index].totalSlides) % carousels[index].totalSlides;
        updateSlidePosition(index);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.wishlist-button').forEach(button => {
        button.addEventListener('click', async function () {
            const houseId = this.dataset.houseId;
            const isAdded = this.dataset.added === 'true';

            if (!houseId) return;

            // Check if the user is logged in (you can verify this via a backend endpoint)
            const userLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

            if (!userLoggedIn) {
                alert('You need to log in first to add items to your wishlist.');
                return;
            }

            try {
                const response = await fetch(`/wishlist/${isAdded ? 'remove' : 'add'}/${houseId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                });

                const result = await response.json();

                if (response.ok) {
                    this.dataset.added = isAdded ? 'false' : 'true';
                    this.querySelector('i').classList.toggle('text-red-500', !isAdded);
                    this.querySelector('i').classList.toggle('text-gray-500', isAdded);

                    // Show success message
                    const message = isAdded
                        ? 'Removed from the wishlist'
                        : 'Added to the wishlist';
                    const messageContainer = document.createElement('div');
                    messageContainer.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-md';
                    messageContainer.innerHTML = `
                        ${message} ${
                        !isAdded
                            ? `<a href="/wishlist" class="underline font-bold ml-2">Go to Wishlist</a>`
                            : ''
                    }`;
                    document.body.appendChild(messageContainer);

                    setTimeout(() => {
                        messageContainer.remove();
                    }, 3000);
                } else {
                    throw new Error(result.message || 'Something went wrong');
                }
            } catch (error) {
                console.error(error);
                alert('Unable to update the wishlist at this time. Please try again later.');
            }
        });
    });
});

</script>