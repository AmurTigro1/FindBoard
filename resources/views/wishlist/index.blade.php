@extends('main_resources.index')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Your Wishlist</h1>
    <p class="font-semibold mb-6 flex items-center space-x-2 text-red-500">
        <i class="fas fa-heart"></i>
        <span class="mb-1">{{ $bh->count() }} boarding house saved</span>
    </p>
    
    @if($bh->isEmpty())
    <div class="flex flex-col items-center justify-center px-4 md:px-8">
        <p class="text-gray-700 text-xl md:text-2xl font-semibold text-center mb-8 max-w-2xl">
            Your wishlist is empty. Start exploring and add your favorite boarding houses!
        </p>
        <img src="https://img.freepik.com/free-vector/christmas-character-holding-blank-banner_23-2148769994.jpg?ga=GA1.1.427397176.1730898402&semt=ais_hybrid" alt="Empty bh" class="w-1/2 md:w-1/3 h-auto rounded-lg shadow-lg mb-8">
        <a href="/" class="inline-block bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 px-6 rounded-full shadow-lg hover:scale-105 transform transition duration-300 ease-in-out">
            Explore Boarding Houses
        </a>
    </div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($bh as $index => $house)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="container relative"> <!-- Ensure container is relative -->
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
    
    <!-- X Icon for Removal -->
    <button 
        onclick="removeFromWishlist({{ $house->id }})"
        class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-md hover:scale-105 transition-transform duration-300 group-hover:opacity-100 opacity-0">
        <i class="fas fa-times"></i>
    </button>
    
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
            <div class="p-6">
                <a href="{{ route('boarding_house.show', $house->id) }}">
                    <h4 class="text-xl font-semibold text-gray-900 hover:text-blue-500" title="{{ $house->name }}">{{ $house->name }}</h4>
                </a>
                <p class="text-sm text-gray-600 flex items-center my-2">
                    <i class="fas fa-map-marker-alt mr-2 text-red-500"></i> 
                    {{ $house->address }}
                </p>
                <p class="text-sm text-gray-700 mt-4">{{ Str::limit($house->description, 120) }}</p>
            </div>
        </div>
    @endforeach
</div>
</div>
    @endif
</div>
@endsection

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
    function removeFromWishlist(houseId) {
    if (confirm('Are you sure you want to remove this boarding house from your wishlist?')) {
        fetch(`/wishlist/remove/${houseId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                location.reload(); // Reload the page to reflect changes
            } else {
                alert('Failed to remove the boarding house from your wishlist.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the boarding house.');
        });
    }
}

</script>