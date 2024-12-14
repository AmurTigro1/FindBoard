@extends('main_resources.index')

@section('content')
<div class="container mx-auto flex mt-8 px-4 py-12">
    <!-- Filter Sidebar -->
    <aside class="w-full md:w-1/4 bg-white border border-gray-200 shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Filter Rooms by Amenities</h2>
        <form action="{{ route('rooms.index') }}" method="GET">
            <div class="filter-section space-y-4">
                <label class="block text-sm font-medium text-gray-700">Amenities:</label>
                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="amenities[]" value="wifi" id="wifi" class="text-blue-600" {{ in_array('wifi', request('amenities', [])) ? 'checked' : '' }}>
                        <label for="wifi" class="text-gray-600">Wi-Fi</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="amenities[]" value="cabinet" id="cabinet" class="text-blue-600" {{ in_array('cabinet', request('amenities', [])) ? 'checked' : '' }}>
                        <label for="cabinet" class="text-gray-600">Cabinet</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="amenities[]" value="chair" id="chair" class="text-blue-600" {{ in_array('chair', request('amenities', [])) ? 'checked' : '' }}>
                        <label for="chair" class="text-gray-600">Chair</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="amenities[]" value="table" id="table" class="text-blue-600" {{ in_array('table', request('amenities', [])) ? 'checked' : '' }}>
                        <label for="table" class="text-gray-600">Table</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="amenities[]" value="air_conditioning" id="air_conditioning" class="text-blue-600" {{ in_array('air_conditioning', request('amenities', [])) ? 'checked' : '' }}>
                        <label for="air_conditioning" class="text-gray-600">Air Conditioning</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="amenities[]" value="electric_fan" id="electric_fan" class="text-blue-600" {{ in_array('electric_fan', request('amenities', [])) ? 'checked' : '' }}>
                        <label for="electric_fan" class="text-gray-600">Electric Fan</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg transition-all duration-300 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Apply Filters
            </button>
        </form>
    </aside>

    <!-- Room Listings -->
    <div class="w-full md:w-3/4 md:ml-6 mt-6 md:mt-0">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 tracking-tight">Available Rooms</h1>
        @if($rooms->isEmpty())
            <p class="text-gray-500 text-lg">No rooms available matching the filter.</p>
        @else
            <!-- Vertical scrolling container -->
            <div class="space-y-6 px-6 py-8 bg-gray-50 rounded-xl shadow-md">
                @foreach ($rooms as $room)
                    <div class="flex bg-white border border-gray-200 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                        <!-- Image Carousel -->
                        <div class="relative w-1/4 overflow-hidden rounded-l-2xl group">
                            <div id="carousel-{{ $loop->index }}" class="relative w-full h-full">
                                <div id="slides-{{ $loop->index }}" class="flex transition-transform duration-500">
                                    @php
                                        $images = is_string($room->main_images) ? json_decode($room->main_images, true) : $room->main_images;
                                    @endphp
                                    @if (!empty($images))
                                        @foreach ($images as $image)
                                            <div class="flex-shrink-0 w-full">
                                                <a href="{{ route('rooms.show', $room->id) }}">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Room Image" class="w-full h-48 object-cover">
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex-shrink-0 w-full">
                                            <img src="{{ asset('storage/default.jpg') }}" alt="Default Image" class="w-full h-48 object-cover">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if (!empty($images) && count($images) > 1)
                                <button onclick="prevSlide({{ $loop->index }})" class="absolute top-1/2 left-4 -translate-y-1/2 p-2 bg-gray-900 text-white rounded-full opacity-70 hover:opacity-100 transition-opacity duration-300 hover:scale-110">
                                    ❮
                                </button>
                                <button onclick="nextSlide({{ $loop->index }})" class="absolute top-1/2 right-4 -translate-y-1/2 p-2 bg-gray-900 text-white rounded-full opacity-70 hover:opacity-100 transition-opacity duration-300 hover:scale-110">
                                    ❯
                                </button>
                            @endif
                        </div>

                        <!-- Room Details -->
                        <div class="p-6 flex flex-col justify-between w-1/2">
                            <div>
                                <a href="{{ route('rooms.show', $room->id) }}" class="block">
                                    <h2 class="text-xl font-bold text-gray-800 truncate hover:text-blue-600 transition-colors duration-200" title="{{ $room->type }}">
                                        {{ $room->type }}
                                    </h2>
                                </a>
                                <p class="text-indigo-500 font-semibold text-lg mt-2">
                                    ${{ number_format($room->price, 2) }}
                                    <span class="text-sm font-light text-gray-400">/ month</span>
                                </p>
                                <p class="text-sm text-gray-600 mt-4">{{ Str::limit($room->description, 80, '...') }}</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 mt-4">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                    Occupancy: {{ $room->occupancy }}
                                </span>
                                @if ($room->wifi)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Wi-Fi</span>
                                @endif
                                @if ($room->table)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Table</span>
                                @endif
                                @if ($room->chair)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Chair</span>
                                @endif
                                @if ($room->cabinet)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Cabinet</span>
                                @endif
                                @if ($room->air_conditioning)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Air Conditioning</span>
                                @endif
                                @if ($room->electric_fan)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Electric Fan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection


<script>
    const carousels = [];

    document.addEventListener('DOMContentLoaded', () => {
    @foreach ($rooms as $index => $room)
        const images_{{ $index }} = @json(is_string($room->main_images) ? json_decode($room->main_images, true) : $room->main_images);
        carousels[{{ $index }}] = {
            currentIndex: 0,
            totalSlides: images_{{ $index }} ? images_{{ $index }}.length : 1,
            slides: document.getElementById('slides-{{ $index }}'),
        };
        updateSlidePosition({{ $index }});
    @endforeach
});

function updateSlidePosition(index) {
    const carousel = carousels[index];
    if (carousel && carousel.slides) {
        carousel.slides.style.transform = `translateX(-${carousel.currentIndex * 100}%)`;
    }
}

function nextSlide(index) {
    const carousel = carousels[index];
    if (carousel) {
        carousel.currentIndex = (carousel.currentIndex + 1) % carousel.totalSlides;
        updateSlidePosition(index);
    }
}

function prevSlide(index) {
    const carousel = carousels[index];
    if (carousel) {
        carousel.currentIndex = (carousel.currentIndex - 1 + carousel.totalSlides) % carousel.totalSlides;
        updateSlidePosition(index);
    }
}
</script>
