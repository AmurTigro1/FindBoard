@extends('main_resources.index')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-700">
    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12 space-y-16">
        
        <!-- List Your Boarding House Button -->
        <section id="list-your-boarding-house" class="text-center">
            <a href="{{ route('boarding_house.create') }}" 
            class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700 transition-all">
                List Your Boarding House
            </a>
            <p class="mt-4 text-sm text-gray-600">Ready to earn from your space? Click above to get started with listing your boarding house!</p>
        </section>

        <!-- Steps for Listing a Boarding House -->
        <section id="steps-to-list" class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Steps to List Your Boarding House</h2>
            <p class="text-sm text-gray-600 mb-6">Follow these simple steps to create your boarding house listing and make it available for booking:</p>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <p>Step 1: Provide Boarding House Details</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <p>Step 2: Add Room Details & Amenities</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <p>Step 3: Publish Listing for Booking</p>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="testimonials" class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-indigo-600 mb-4">What Our Users Say</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-lg text-white">
                    <div class="absolute top-2 right-2 text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold">"The future of booking!"</p>
                    <p class="text-sm mt-2">FindBoard made it super easy to find and reserve a boarding house. Highly recommended for busy professionals!</p>
                    <div class="mt-4 flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white">
                            <img src="https://via.placeholder.com/150" alt="User" class="w-full h-full object-cover">
                        </div>
                        <p class="font-medium">Jane Doe</p>
                    </div>
                </div>
                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-lg text-white">
                    <div class="absolute top-2 right-2 text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold">"Seamless experience!"</p>
                    <p class="text-sm mt-2">This platform is light-years ahead. It simplifies the entire process, and landlords are super responsive.</p>
                    <div class="mt-4 flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white">
                            <img src="https://via.placeholder.com/150" alt="User" class="w-full h-full object-cover">
                        </div>
                        <p class="font-medium">John Smith</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Listing Section -->
        <section id="listings" class="space-y-6">
            <h2 class="text-2xl font-semibold text-indigo-600">Available Boarding Houses</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($bh as $index => $house)
                <div class="flex flex-col">
                    <div class="container">
                        <div id="carousel-{{ $index }}" class="relative w-full overflow-hidden rounded-lg group">
                            <!-- Slides -->
                            <div id="slides-{{ $index }}" class="flex transition-transform duration-500">
                                @foreach ($house->images as $image)
                                    <div class="flex-shrink-0 w-full">
                                        <a href="{{ route('boarding_house.show', $house->id) }}">
                                            <img src="{{ asset('storage/' . $image->other_photo_path) }}" alt="" class="w-full aspect-square object-cover">
                                        </a>
                                    </div>
                                    <!-- Wishlist Button -->
                        <button 
                            class="absolute top-4 right-4 bg-white p-3 rounded-full shadow-md transition-all duration-300 hover:bg-red-100" 
                            onclick="toggleWishlist({{ $house->id }})" 
                            id="wishlist-icon-{{ $house->id }}">
                            <i 
                                class="{{ auth()->check() && auth()->user()->wishlists->contains('boarding_house_id', $house->id) ? 'fas fa-heart text-red-500' : 'far fa-heart text-gray-500' }}" 
                                id="wishlist-icon-class-{{ $house->id }}">
                            </i>
                        </button>

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

                    <a href="{{ route('boarding_house.show', $house->id) }}" class="border-b rounded-b-md p-2 block">
                        <strong class="font-black block truncate text-gray-800 mt-3" title="{{ $house->name }}">{{ $house->name }}</strong>
                        {{-- <p class="text-sm text-gray-500 block truncate" title="{{ $house->address }}">{{ $house->address }}</p> --}}
                        <p class="text-sm text-gray-600 flex items-center my-2">
                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i> 
                            {{ $house->address }}
                        </p>

                        <div class="rounded-md mt-6 inline-flex text-sm items-center space-x-1 px-2 py-1 font-bold
                            {{ $house->gender === 'male only' ? 'bg-gradient-to-r from-cyan-400 to-cyan-600 text-white' : '' }}
                            {{ $house->gender === 'female only' ? 'bg-gradient-to-r from-pink-400 to-pink-600 text-white' : '' }}
                            {{ $house->gender === 'male and female' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : '' }}">
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
            </div>
        </section>
    </main>
</div>

@endsection
<script>
        function toggleWishlist(boardingHouseId) {
    if (!'{{ auth()->check() }}') {
        alert('Please log in to add items to your wishlist!');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!csrfToken) {
        console.error('CSRF token is missing!');
        alert('An error occurred. Please refresh the page.');
        return;
    }

    const url = "{{ route('wishlist.store') }}";
    const iconClass = document.getElementById(`wishlist-icon-class-${boardingHouseId}`);
    const toast = document.getElementById('toast-message');
    const toastText = document.getElementById('toast-text');

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ boarding_house_id: boardingHouseId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'added') {
            iconClass.classList.remove('far', 'text-gray-500');
            iconClass.classList.add('fas', 'text-red-500');
            toastText.textContent = 'Added to wishlist!';
        } else if (data.status === 'removed') {
            iconClass.classList.remove('fas', 'text-red-500');
            iconClass.classList.add('far', 'text-gray-500');
            toastText.textContent = 'Removed from wishlist!';
        }

        // Show the toast message
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    })
    .catch(error => console.error('Error:', error));
}

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