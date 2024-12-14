<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<div class="mb-8 flex flex-col md:flex-row justify-between items-center">
    <div class="text-center md:text-left">
        <h2 class="text-4xl font-extrabold text-gray-800 tracking-wide mb-2">Available Rooms</h2>
    </div>

    <!-- See More Button -->
    <a href="{{ route('rooms.index') }}" id="see-more-rooms"
       class="mt-4 md:mt-0 px-6 py-2 bg-blue-500 text-white text-sm font-medium rounded-md shadow-md transition duration-300 hover:bg-blue-600 hover:shadow-lg">
        Search Rooms
    </a>
</div>
<div id="loading-rooms" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col items-center justify-center">
        <!-- Animation Illustration -->
        <img src="{{asset('loading-img.png')}}" 
             alt="Loading..." 
             class="w-24 h-24 mb-4 animate-bounce">
        
        <!-- Loading Title -->
        <h2 class="text-xl font-semibold text-purple-700 mb-2">Just a moment!</h2>
        
        <!-- Loading Message -->
        <p class="text-gray-600 text-center">   Please wait while we search for available rooms.Thank you for your patience!</p>
    </div>
</div>
<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
const seeMoreBtn = document.getElementById('see-more-rooms');
const loadingDiv = document.getElementById('loading-rooms'); // Target unique ID

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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @if ($rooms->isEmpty())
        <p class="text-gray-500">No rooms available matching the filter.</p>
    @else
        @foreach ($rooms as $index => $room)
            <div class="flex flex-col">
                <div class="relative">
                    <!-- Swiper Container -->
                    <div class="swiper-container" id="swiper-{{ $index }}">
                        <div class="swiper-wrapper">
                            @php
                                $images = is_string($room->main_images) ? json_decode($room->main_images, true) : $room->main_images;
                            @endphp
                            @if (!empty($images) && is_array($images))
                                @foreach ($images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             alt="Room Image" 
                                             class="w-full h-64 object-cover rounded-lg">
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/default.jpg') }}" 
                                         alt="Default Image" 
                                         class="w-full h-64 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>

                        <!-- Swiper Pagination -->
                        <div class="swiper-pagination"></div>

                        <!-- Swiper Navigation -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>

                <!-- Details Section -->
                <a href="{{ route('rooms.show', $room->id) }}" class="border-b rounded-b-md p-2 block">
                    <strong class="font-black block truncate text-gray-800 mt-3" title="{{ $room->type }}">{{ $room->type }}</strong>
                    <p class="text-sm text-gray-600 flex items-center my-2">
                        <i class="fas fa-peso-sign mr-2 text-green-500"></i> 
                        {{ number_format($room->price, 2) }} per month
                    </p>

                    <p class="text-sm text-gray-700 mt-4">{{ Str::limit($room->description, 120) }}</p>
                </a>
            </div>
        @endforeach
    @endif
</div>

<!-- Pagination Links -->
<div class="mt-6">
    {{ $rooms->links('pagination::tailwind') }}
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        @foreach ($rooms as $index => $room)
            new Swiper('#swiper-{{ $index }}', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                slidesPerView: 1, // Display only 1 image at a time
                spaceBetween: 0, // No gap between images
                autoplay: {
                    delay: 5000, // Optional: autoplay every 5 seconds
                    disableOnInteraction: false, // Keeps autoplay active after swiping
                },
            });
        @endforeach
    });
</script>

<style scoped>
    /* Swiper Wrapper and Slide Configuration */
.swiper-container {
    width: 100%;
    overflow: hidden;
}
.swiper-wrapper {
    display: flex;
}
.swiper-slide {
    flex-shrink: 0;
    width: 100%; /* Ensures only one image is visible at a time */
}
.swiper-button-next,
.swiper-button-prev {

    color: gray; /* Gray icon color */
    border-radius: 50%; /* Make the buttons circular */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
    transition: opacity 0.3s ease, transform 0.2s ease; /* Smooth transition */
    transform: scale(0.8); /* Initially scaled down */
}
</style>