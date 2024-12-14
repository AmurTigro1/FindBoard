
    @if ($bh->isEmpty())
    <div class="text-center text-gray-500 bg-gray-100 p-6 rounded-lg shadow-lg border border-gray-200">
        <p class="text-lg font-semibold">No results found</p>
        <p class="text-sm">Try adjusting your filters or search terms.</p>
    </div>
@else
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
 @endif
</div>