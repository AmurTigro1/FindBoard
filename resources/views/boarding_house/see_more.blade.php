@extends('main_resources.index')

@section('title', 'FindBoard')

@section('content')
<section class="bg-gradient-to-b from-gray-50 via-white to-gray-100">

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
<form id="search-form" action="{{ route('boarding_house.search') }}" method="GET" class="bg-white p-8 rounded-2xl shadow-xl grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-center  transform transition-all hover:scale-105 duration-300">
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

<!-- Results Container -->
<div id="search-results" class="mt-8"></div>

            </div>
        
            <!-- Background Element (Optional for extra design) -->
            {{-- <div class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0 bg-[url('/public/bg-homepage.avif')]" style=" opacity: 0.15;"></div> --}}
        </section>

<div class="container mx-auto px-6">
    <div class="flex flex-col lg:flex-row gap-8 mt-10">
        <!-- Sidebar Section -->
        <aside class="lg:w-1/3 xl:w-1/4 bg-white shadow-lg rounded-lg p-6 border border-gray-200 text-gray-800">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Filter Boarding Houses</h2>
            <form id="filterForm" class="space-y-6">
                <!-- Address Filter -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" id="address" name="address" value="{{ request('address') }}" 
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring focus:ring-blue-500 focus:outline-none">
                </div>
                <!-- Gender Filter -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender Preference</label>
                    <select name="gender" id="gender" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
                        <option value="">Select</option>
                        <option value="male only" {{ request('gender') == 'male only' ? 'selected' : '' }}>Male</option>
                        <option value="female only" {{ request('gender') == 'female only' ? 'selected' : '' }}>Female</option>
                        <option value="male and female" {{ request('gender') == 'male and female' ? 'selected' : '' }}>Male and Female</option>
                    </select>
                </div>
                <!-- Rating Filter -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <select name="rating" id="rating" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
                        <option value="">Select</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    </select>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all">
                    Apply Filters
                </button>
            </form>
        </aside>

        <!-- Main Content Section -->
        <div class="lg:w-2/3 xl:w-3/4 space-y-6" id="filterResults">
            <!-- Render filtered results -->
            @foreach ($bh as $index => $house)
            <div class="flex items-start gap-6 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                <!-- Image Carousel -->
                <div class="w-1/3">
                    <div id="carousel-{{ $index }}" class="relative w-full overflow-hidden rounded-l-lg group">
                        <div id="slides-{{ $index }}" class="flex transition-transform duration-500">
                            @foreach ($house->images as $image)
                                <div class="flex-shrink-0 w-full">
                                    <a href="{{ route('boarding_house.show', $house->id) }}">
                                        <img src="{{ asset('storage/' . $image->other_photo_path) }}" 
                                             alt="" class="w-full h-48 object-cover">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                
                        <!-- Slide Indicator -->
                        <div id="slideIndicator-{{ $index }}" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white text-sm py-1 px-3 rounded">
                            1/{{ count($house->images) }}
                        </div>
                
                        <!-- Controls -->
                        <button onclick="prevSlide({{ $index }})" 
                                class="absolute top-1/2 left-2 transform -translate-y-1/2 p-2 text-black bg-white rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110">
                            ❮
                        </button>
                        <button onclick="nextSlide({{ $index }})" 
                                class="absolute top-1/2 right-2 transform -translate-y-1/2 p-2 text-black bg-white rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110">
                            ❯
                        </button>
                    </div>
                </div>
                
                <!-- Details Section -->
                <div class="w-2/3 p-4">
                    <a href="{{ route('boarding_house.show', $house->id) }}" class="block">
                        <h3 class="text-lg font-bold text-gray-800 truncate" title="{{ $house->name }}">
                            {{ $house->name }}
                        </h3>
                        <p class="text-sm text-gray-600 flex items-center mt-2">
                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                            {{ $house->address }}
                        </p>
                        <!-- Gender Label -->
                        <div class="rounded-md mt-6 inline-flex text-sm items-center space-x-1 px-2 py-1 font-bold
                            {{ $house->gender === 'male only' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white' : '' }}
                            {{ $house->gender === 'female only' ? 'bg-gradient-to-r from-pink-400 to-pink-600 text-white' : '' }}
                            {{ $house->gender === 'male and female' ? 'bg-gradient-to-r from-blue-400 to-pink-600 text-white' : '' }}">
                            @if($house->gender === 'male only')
                                <i class="fas fa-mars"></i>
                            @elseif($house->gender === 'female only')
                                <i class="fas fa-venus"></i>
                            @else
                                <i class="fas fa-venus-mars"></i>
                            @endif
                            <span>{{ ucfirst($house->gender) }}</span>
                        </div>
                        <!-- Ratings -->
                        <div class="mt-4 flex items-center">
                            <strong class="text-xl text-gray-800 font-bold">
                                {{ number_format($house->averageRating() ?? 0, 1) }}
                            </strong>
                            <div class="flex ml-2">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $house->averageRating() ? 'text-yellow-400' : 'text-gray-300' }}" 
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.431L23.327 9.9l-5.327 5.176 1.257 7.337L12 18.896l-6.927 3.517 1.257-7.337L.673 9.9l7.659-1.882L12 .587z" />
                                </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500 ml-2">({{ $house->reviews()->count() }} reviews)</span>
                        </div>
                    </a>
                    <p class="text-sm text-gray-700 mt-2">
                        {{ Str::limit($house->description, 100) }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('boarding_house.show', $house->id) }}" 
                           class="text-blue-500 hover:text-blue-600 font-semibold text-sm underline">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.getElementById('filterForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);
        const params = new URLSearchParams(formData).toString();

        fetch(`{{ route('boarding_house.search_filter') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(response => response.text())
            .then(data => {
                document.getElementById('filterResults').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

</section>
@endsection

<script>
    document.getElementById('search-form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent the form from refreshing the page

    // Get the form action and the input value
    const form = event.target;
    const url = form.action;
    const address = form.querySelector('input[name="address"]').value;

    // Use Fetch API to send a GET request
    try {
        const response = await fetch(`${url}?address=${encodeURIComponent(address)}`);
        const data = await response.text();

        // Update the results container with the response
        document.getElementById('search-results').innerHTML = data;
    } catch (error) {
        console.error('Error fetching search results:', error);
    }
});

</script>
<script>
    const bhCarousels = [];

document.addEventListener('DOMContentLoaded', () => {
    @foreach ($bh as $index => $house)
        bhCarousels[{{ $index }}] = {
            currentIndex: 0,
            totalSlides: {{ count($house->images) }},
            slides: document.getElementById('slides-{{ $index }}'),
            indicator: document.getElementById('slideIndicator-{{ $index }}'),
        };
        updateIndicator({{ $index }}, bhCarousels);
    @endforeach
});

function updateSlidePosition(index, carouselArray) {
    const carousel = carouselArray[index];
    carousel.slides.style.transform = `translateX(-${carousel.currentIndex * 100}%)`;
    updateIndicator(index, carouselArray);
}

function updateIndicator(index, carouselArray) {
    const carousel = carouselArray[index];
    if (carousel.indicator) {
        carousel.indicator.textContent = `${carousel.currentIndex + 1}/${carousel.totalSlides}`;
    }
}

function nextSlide(index) {
    const carousel = bhCarousels[index];
    if (carousel) {
        carousel.currentIndex = (carousel.currentIndex + 1) % carousel.totalSlides;
        updateSlidePosition(index, bhCarousels);
    }
}

function prevSlide(index) {
    const carousel = bhCarousels[index];
    if (carousel) {
        carousel.currentIndex = (carousel.currentIndex - 1 + carousel.totalSlides) % carousel.totalSlides;
        updateSlidePosition(index, bhCarousels);
    }
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