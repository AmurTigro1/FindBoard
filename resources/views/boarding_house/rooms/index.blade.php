<!-- resources/views/rooms/index.blade.php -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

@extends('layouts.sidebar-header')

@section('content')
@if ($errors->any())
<div class="bg-red-500 text-white p-4 rounded mb-4">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(auth()->user()->boardingHouses()->count() > 0 && auth()->user()->boardingHouses()->first()->rooms()->count() >= 1)
<div class="bg-yellow-500 text-white p-4 rounded mb-4">
    <span>You can only create one room during your trial period.</span>
    <a href="{{ route('subscriptions.index') }}" class="text-white underline ml-2 hover:text-blue-600">
        Subscribe now to unlock more features.
    </a>
</div>

@endif
@php
    use Carbon\Carbon;
@endphp
@if (auth()->user() && auth()->user()->trial_ends_at && Carbon::now()->greaterThan(auth()->user()->trial_ends_at))
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        Your free trial has expired. You can no longer create new listings.
    </div>
@endif


<!-- Breadcrumb -->
<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-4 text-gray-600">
        <li>
            <a href="{{ route('boarding_house.view') }}" class="text-gray-600 hover:text-blue-800">
                My Boarding House
            </a>
        </li>
        <li>
            <span class="text-gray-400">/</span>
        </li>
        <li>
            <a href="{{ route('boarding_house.edit', $boardingHouse->id) }}" class="text-gray-600 hover:text-blue-800">
                {{ $boardingHouse->name }}
            </a>
        </li>
        <li>
            <span class="text-gray-400">/</span>
        </li>
        <li class="text-blue-500">Rooms</li>
    </ol>
</nav>

<!-- Add Room Button -->
<div class="flex justify-end mt-10">
    <button id="openModal" class="bg-blue-600 text-white py-3 px-6 rounded-full hover:bg-blue-500 transition duration-300">
        + Add Room
    </button>
</div>

<!-- Add Room Modal -->
<div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl p-8 space-y-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center">
            <h5 class="text-2xl font-semibold text-gray-800">Add a New Room</h5>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form action="{{ route('rooms.store', $boardingHouse->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Room Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Room Type</label>
                    <input type="text" name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Single, Double" required>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 5000" required>
                </div>

                <!-- Number of Beds -->
                <div>
                    <label for="number_of_beds" class="block text-sm font-medium text-gray-700">Number of Beds</label>
                    <input type="number" name="number_of_beds" id="number_of_beds" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 2" required>
                </div>

                <!-- Occupancy -->
                <div>
                    <label for="occupancy" class="block text-sm font-medium text-gray-700">Occupancy</label>
                    <input type="number" name="occupancy" id="occupancy" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 2" required>
                </div>

                <!-- Availability -->
                <div>
                    <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
                    <select name="availability" id="availability" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="available">Available</option>
                        <option value="not_available">Not Available</option>
                    </select>
                </div>

                <!-- Thumbnail Image -->
                <div>
                    <label for="thumbnail_image" class="block text-sm font-medium text-gray-700">Thumbnail Image</label>
                    <input type="file" name="thumbnail_image" id="thumbnail_image" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Main Images -->
                <div>
                    <label for="main_images" class="block text-sm font-medium text-gray-700">Main Images</label>
                    <input type="file" name="main_images[]" id="main_images" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" multiple>
                </div>

                <!-- Description -->
                <div class="col-md-12">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Add a short description about this room..."></textarea>
                </div>

                <!-- Amenities -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Amenities</label>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" name="wifi" id="wifi" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <label for="wifi" class="ml-2 text-gray-700">WiFi</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="cabinet" id="cabinet" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <label for="cabinet" class="ml-2 text-gray-700">Cabinet</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="chair" id="chair" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <label for="chair" class="ml-2 text-gray-700">Chair</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="table" id="table" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <label for="table" class="ml-2 text-gray-700">Table</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="air_conditioning" id="air_conditioning" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <label for="air_conditioning" class="ml-2 text-gray-700">Air Conditioning</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="electric_fan" id="electric_fan" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <label for="electric_fan" class="ml-2 text-gray-700">Electric Fan</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-between mt-6">
                <button type="button" id="closeModal" class="bg-gray-500 text-white py-2 px-6 rounded-md hover:bg-gray-400 transition duration-300">Close</button>
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-500 transition duration-300">Save Room</button>
            </div>
        </form>
    </div>
</div>

<!-- Tailwind JS for Modal Show/Hide -->
<script>
    const openModal = document.getElementById('openModal');
    const closeModal = document.querySelectorAll('#closeModal');
    const modal = document.getElementById('myModal');

    openModal.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    closeModal.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });
</script>
<!-- Available Rooms Section -->
<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Available Rooms</h2>
    @if($boardingHouse->rooms->isEmpty())
        <p class="text-gray-500">No rooms available yet. Add a room to display here.</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full table-auto text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-2">Room #</th>
                    <th class="px-4 py-2">Room Type</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Beds</th>
                    <th class="px-4 py-2">Occupancy</th>
                    <th class="px-4 py-2">Availability</th>
                    <th class="px-4 py-2">Thumbnail</th>
                    <th class="px-4 py-2">Main Images</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($boardingHouse->rooms as $room)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $room->id }}</td>
                        <td class="px-4 py-2">{{ $room->type }}</td>
                        <td class="px-4 py-2">₱{{ number_format($room->price, 2) }}</td>
                        <td class="px-4 py-2 text-center">{{ $room->number_of_beds }}</td>
                        <td class="px-4 py-2 text-center">{{ $room->occupancy }}</td>
                        <td class="px-4 py-2">
                            <div>
                                <!-- Availability Badge -->
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    {{ $room->availability == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($room->availability) }}
                                </span>
                        
                                <!-- Date When Available (if 'Not Available') -->
                                @if($room->availability == 'not_available' && $room->available_date)
                                    <div class="mt-1 text-xs text-gray-600">
                                        Available on: 
                                        <span class="font-medium text-blue-600">
                                            {{ \Carbon\Carbon::parse($room->available_date)->format('F d, Y') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </td>
                        
                        <td class="px-4 py-2">
                            @if($room->thumbnail_image)
                                <img src="{{ asset('storage/' . $room->thumbnail_image) }}" alt="Thumbnail" class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <p class="text-gray-400">No image</p>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($room->main_images)
                                @php
                                    $images = json_decode($room->main_images);
                                @endphp
                                <div class="flex space-x-2">
                                    @foreach($images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Room Image" class="w-12 h-12 object-cover rounded-lg">
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-400">No images</p>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('rooms.edit', $room->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

            
@endsection
