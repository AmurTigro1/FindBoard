@extends('main_resources.index')
@section('content')
   
   <!-- Room Listings -->
    <div class="w-3/4 ml-6">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8">Available Rooms</h1>
        @if($rooms->isEmpty())
    <p class="text-gray-500">No rooms available matching the filter.</p>
@else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($rooms as $room)
                <div class="bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                     <!-- Image Carousel -->
                     <div class="relative group">
                        <div id="carousel-{{ $loop->index }}" class="relative overflow-hidden rounded-t-lg">
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
                            <button onclick="prevSlide({{ $loop->index }})" class="absolute top-1/2 left-2 -translate-y-1/2 p-2 bg-white text-gray-700 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:scale-110">
                                ❮
                            </button>
                            <button onclick="nextSlide({{ $loop->index }})" class="absolute top-1/2 right-2 -translate-y-1/2 p-2 bg-white text-gray-700 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:scale-110">
                                ❯
                            </button>
                        @endif
                            
                    </div>
                    <!-- Room details -->
                    <div class="p-4">
                        <a href="{{ route('rooms.show', $room->id) }}" class="block">
                            <h2 class="text-lg font-semibold text-gray-800 truncate" title="{{ $room->type }}">{{ $room->type }}</h2>
                            <p class="text-blue-600 font-semibold text-lg mt-2">${{ number_format($room->price, 2) }} per month</p>
                        </a>
                        <div class="mt-2 text-sm text-gray-600">
                            <p>{{ Str::limit($room->description, 80, '...') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
@endsection