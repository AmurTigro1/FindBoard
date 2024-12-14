@extends('layouts.sidebar-header')

@section('content')
    <div class="flex flex-col mb-2 space-y-4">
        @if ($boardinghouses->isNotEmpty())
            <div class="text-center items-center text-gray-700 dark:text-gray-300 py-4">
                <p class="text-lg font-medium">Manage Your Properties</p>
                <p class="text-sm">You can add more listings or update your existing Properties.</p>
                <a href="{{ route('boarding_house.create') }}" class="mt-4 inline-block bg-gradient-to-r from-blue-500 to-blue-700 text-sm leading-4 font-medium rounded-md px-2 py-2 text-white shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">Add Another Property
                    <i class="fas fa-home text-white"></i>
                    <span class="text-white">+</span>
                </a>
            </div>
        @endif
    </div>
    @if($boardinghouses->isEmpty() && auth()->user()->trial_ends_at && \Carbon\Carbon::now()->greaterThan(auth()->user()->trial_ends_at))
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <span>Your free trial has ended. Subscribe to unlock access to your listings.</span>
        <a href="{{ route('subscriptions.index') }}" class="text-white underline ml-2 hover:text-blue-400">
            Subscribe now
        </a>
    </div>
@endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($boardinghouses->isEmpty())
                <div class="text-center text-gray-700 dark:text-gray-300 py-12">
                    <p class="text-lg font-medium">No boarding houses found.</p>
                    <p class="text-sm">Start by adding your first boarding house to manage your listings.</p>
                    <a href="{{ route('boarding_house.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white text-sm rounded-md px-6 py-2 transition duration-200">Add Your First House</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($boardinghouses as $index => $house)
                        <div class="flex flex-col">
                            <div class="container">
                                <div id="carousel-{{ $index }}" class="relative w-full overflow-hidden rounded-lg group">
                                    <!-- Slides -->
                                    <div id="slides-{{ $index }}" class="flex transition-transform duration-500">
                                        @foreach ($house->images as $image)
                                            <div class="flex-shrink-0 w-full">
                                                <a href="{{ route('boarding_house.edit', $house->id) }}">
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

                            <a href="{{ route('boarding_house.edit', $house->id) }}" class="bg-white border-b rounded-b-md p-2 block">
                                <strong class="font-black block truncate" title="{{ $house->name }}">{{ $house->name }}</strong>
                                <p class="text-sm text-gray-500 block truncate" title="{{ $house->address }}">{{ $house->address }}</p>
                                <div class="rounded-md mt-6 inline-flex text-sm items-center space-x-1 px-2 py-1 font-bold
                                    {{ $house->gender === 'male only' ? 'bg-gradient-to-r from-cyan-400 to-cyan-600 text-white' : '' }}
                                    {{ $house->gender === 'female only' ? 'bg-gradient-to-r from-pink-400 to-pink-600 text-white' : '' }}
                                    {{ $house->gender === 'male and female' ? 'bg-gradient-to-r from-purple-400 to-purple-600 text-white' : '' }}">
                                    @if($house->gender === 'male only')
                                        <i class="fas fa-mars"></i>
                                    @elseif($house->gender === 'female only')
                                        <i class="fas fa-venus"></i>
                                    @else
                                        <i class="fas fa-venus-mars"></i>
                                    @endif
                                    <span>{{ ucfirst($house->gender) }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
                <div class="mt-6">
                    {{ $boardinghouses->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        const carousels = [];

        document.addEventListener('DOMContentLoaded', () => {
            @foreach ($boardinghouses as $index => $house)
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
@endsection
