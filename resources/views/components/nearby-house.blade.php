<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Title -->
        <div class="mb-8 text-left">
            <h2 class="text-3xl font-bold text-gray-800 tracking-wide mb-2">Nearest Boarding Houses For You</h2>
            <p class="text-lg text-gray-600">Find the closest boarding houses based on your current location.</p>
        </div>

        <!-- Nearest Boarding Houses -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($houses as $index => $house)
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <!-- Image Carousel -->
                    <div id="carousel-{{ $index }}" class="relative w-full overflow-hidden rounded-lg group">
                        <div id="slides-{{ $index }}" class="flex transition-transform duration-500">
                            @if ($house->images && count($house->images) > 0)
                                @foreach ($house->images as $image)
                                    <div class="flex-shrink-0 w-full">
                                        <a href="{{ route('boarding_house.show', $house->id) }}">
                                            <img src="{{ asset('storage/' . $image->other_photo_path) }}" alt="Boarding House Image" class="w-full aspect-square object-cover">
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex-shrink-0 w-full">
                                    <img src="{{ asset('images/default-placeholder.png') }}" alt="No Image Available" class="w-full aspect-square object-cover">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Boarding House Details -->
                    <div class="p-6">
                        <a href="{{ route('boarding_house.show', $house->id) }}">
                            <h4 class="text-xl font-semibold text-gray-900 hover:text-blue-500">{{ $house->name }}</h4>
                        </a>
                        <p class="text-sm text-gray-600 flex items-center my-2">
                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i> {{ $house->address }}
                        </p>
                        <p class="text-sm text-gray-700">{{ number_format($house->distance, 2) }} km away</p>
                        <p class="text-sm text-gray-700 mt-2">{{ Str::limit($house->description, 120, '...') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-700 text-lg">No nearby boarding houses found.</p>
            @endforelse
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector('.grid');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                try {
                    const response = await fetch(`{{ route('boarding_houses.nearby') }}?latitude=${latitude}&longitude=${longitude}`);
                    const data = await response.json();

                    if (data.houses.length > 0) {
                        container.innerHTML = '';
                        data.houses.forEach(house => {
                            container.innerHTML += `
                                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:scale-105">
                                    <div class="relative w-full overflow-hidden rounded-lg">
                                        <a href="/boarding_house/${house.id}">
                                            <img src="${house.images && house.images.length > 0 
                                                ? '/storage/' + house.images[0].other_photo_path 
                                                : '/images/default-placeholder.png'}" 
                                                alt="Boarding House Image" 
                                                class="w-full aspect-square object-cover">
                                        </a>
                                    </div>
                                    <div class="p-6">
                                        <a href="/boarding_house/${house.id}">
                                            <h4 class="text-xl font-semibold text-gray-900 hover:text-blue-500">${house.name}</h4>
                                        </a>
                                        <p class="text-sm text-gray-600 flex items-center my-2">
                                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i> ${house.address}
                                        </p>
                                        <p class="text-sm text-gray-700">${house.distance.toFixed(2)} km away</p>
                                        <p class="text-sm text-gray-700 mt-2">${house.description.substring(0, 120)}...</p>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        container.innerHTML = '<p class="text-center text-gray-700 text-lg">No nearby boarding houses found.</p>';
                    }
                } catch (error) {
                    console.error('Error fetching nearby boarding houses:', error);
                }
            }, function (error) {
                console.error('Geolocation error:', error.message);
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    });
</script>
