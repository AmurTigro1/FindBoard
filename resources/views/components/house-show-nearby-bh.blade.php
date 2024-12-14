<!-- Nearby Boarding nearbyHouses Section -->
<section class="py-10 bg-gray-50">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Nearby Boarding Houses</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach ($nearby as $index => $nearbyHouse)
    <div class="flex flex-col">
        <div class="container relative"> <!-- Ensure container is relative -->
          <!-- Wishlist Icon -->
          <div class="absolute top-2 right-2 z-20">
              <button 
                  class="p-2 bg-white rounded-full shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 wishlist-button"
                  data-house-id="{{ $nearbyHouse->id }}"
                  data-added="{{ $nearbyHouse->isInWishlist(auth()->id()) ? 'true' : 'false' }}">
                  <i class="fas fa-heart {{ $nearbyHouse->isInWishlist(auth()->id()) ? 'text-red-500' : 'text-gray-500' }}"></i>
              </button>
          </div>        
            

            <!-- Image Carousel -->
            <div id="carousel-{{ $index }}" class="relative w-full overflow-hidden rounded-lg group">
                <!-- Slides -->
                <div id="slides-{{ $index }}" class="flex transition-transform duration-500">
                    @foreach ($nearbyHouse->images as $image)
                        <div class="flex-shrink-0 w-full">
                            <a href="{{ route('boarding_house.show', $nearbyHouse->id) }}">
                                <img src="{{ asset('storage/' . $image->other_photo_path) }}" alt="" class="w-full aspect-square object-cover">
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <!-- Number Indicator -->
                <div id="slideIndicator-{{ $index }}" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white bg-gray-800 bg-opacity-50 px-2 py-1 rounded-md text-sm opacity-0 group-hover:opacity-100 transition-all duration-300">
                    1/{{ count($nearbyHouse->images) }}
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
        <a href="{{ route('boarding_house.show', $nearbyHouse->id) }}" class="border-b rounded-b-md p-2 block">
            <strong class="font-black block truncate text-gray-800 mt-3" title="{{ $nearbyHouse->name }}">{{ $nearbyHouse->name }}</strong>
            <p class="text-sm text-gray-600 flex items-center my-2">
                <i class="fas fa-map-marker-alt mr-2 text-red-500"></i> 
                {{ $nearbyHouse->address }}
            </p>
            <!-- Gender Label -->
            <div class="rounded-md mt-6 inline-flex text-sm items-center space-x-1 px-2 py-1 font-bold
                {{ $nearbyHouse->gender === 'male only' ? 'bg-gradient-to-r from-cyan-400 to-cyan-600 text-white' : '' }}
                {{ $nearbyHouse->gender === 'female only' ? 'bg-gradient-to-r from-pink-400 to-pink-600 text-white' : '' }}
                {{ $nearbyHouse->gender === 'male and female' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : '' }}">
                @if($nearbyHouse->gender === 'male only')
                    <i class="fas fa-mars"></i>
                @elseif($nearbyHouse->gender === 'female only')
                    <i class="fas fa-venus"></i>
                @else
                    <i class="fas fa-venus-mars"></i>
                @endif
                <span>{{ ucfirst($nearbyHouse->gender) }}</span>
            </div>
            <p class="text-sm text-gray-700 mt-4">{{ Str::limit($nearbyHouse->description, 120) }}</p>
            <div>
                <div class="flex flex-1 justify-end items-center gap-2">
                    <strong class="text-lg text-gray-800 font-extrabold">
                        {{ number_format($nearbyHouse->averageRating() ?? 0, 1) }}
                    </strong>
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg
                                class="w-4 h-4 {{ $i <= $nearbyHouse->averageRating() ? 'text-yellow-400' : 'text-gray-300' }} transition-transform duration-200 hover:scale-110"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 .587l3.668 7.431L23.327 9.9l-5.327 5.176 1.257 7.337L12 18.896l-6.927 3.517 1.257-7.337L.673 9.9l7.659-1.882L12 .587z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-500">({{ $nearbyHouse->reviews()->count() }} reviews)</p>
                </div>
            </div>
        </a>
    </div>
@endforeach
</div>
</section>

    {{-- <p class="text-sm text-gray-600 mb-2"><i class="fas fa-map-marker-alt mr-2 text-red-500"></i> {{ $nearbynearbyHouse->address }}</p>
    <p class="text-sm text-gray-500">{{ round($nearbynearbyHouse->distance, 2) }} km away</p> --}}
    <script>
        const carousels = [];
    
        document.addEventListener('DOMContentLoaded', () => {
            @foreach ($nearby as $index => $house)
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