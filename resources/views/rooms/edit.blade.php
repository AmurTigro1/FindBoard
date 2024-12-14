{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> --}}
@extends('layouts.sidebar-header')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 bg-white shadow-lg rounded-xl">
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-8">
    <ol class="flex text-sm text-gray-600 space-x-2">
        <li>
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 transition-colors duration-300">Dashboard</a>
        </li>
        <li>
            <span class="text-gray-500">/</span>
            <a href="{{ route('boarding_house-rooms.index', $room->boarding_house_id) }}" class="text-gray-600 hover:text-indigo-600 transition-colors duration-300">Rooms</a>
        </li>
        <li>
            <span class="text-gray-500">/</span>
            <span class="text-indigo-600">Edit Room</span>
        </li>
    </ol>
</nav>


    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Room</h1>

    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Room Type -->
            <div class="form-group">
                <label for="type" class="text-lg font-medium text-gray-700">Room Type</label>
                <input type="text" name="type" id="type" value="{{ old('type', $room->type) }}" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price" class="text-lg font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price', $room->price) }}" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <!-- Number of Beds -->
            <div class="form-group">
                <label for="number_of_beds" class="text-lg font-medium text-gray-700">Number of Beds</label>
                <input type="number" name="number_of_beds" id="number_of_beds" value="{{ old('number_of_beds', $room->number_of_beds) }}" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <!-- Number of Beds -->
            <div class="form-group">
                <label for="occupancy" class="text-lg font-medium text-gray-700">Occupancy</label>
                <input type="number" name="occupancy" id="occupancy" value="{{ old('occupancy', $room->occupancy) }}" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
<!-- Availability -->
<div x-data="{ availability: '{{ old('availability', $room->availability) }}' }" class="form-group">
    <label for="availability" class="text-lg font-medium text-gray-700">Availability</label>
    <select 
        name="availability" 
        id="availability" 
        class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
        x-model="availability"
    >
        <option value="available" {{ old('availability', $room->availability) == 'available' ? 'selected' : '' }}>Available</option>
        <option value="not_available" {{ old('availability', $room->availability) == 'not_available' ? 'selected' : '' }}>Not Available</option>
    </select>

    <!-- Conditional Date Input -->
    <div x-show="availability === 'not_available'" class="mt-4">
        <label for="available_date" class="text-lg font-medium text-gray-700">Date Available</label>
        <input 
            type="date" 
            name="available_date" 
            id="available_date" 
            value="{{ old('available_date', $room->available_date) }}"
            class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
    </div>
</div>


            <!-- Thumbnail Image -->
            <div class="form-group">
                <label for="thumbnail_image" class="text-lg font-medium text-gray-700">Thumbnail Image</label>
                @if($room->thumbnail_image)
                    <img src="{{ asset('storage/' . $room->thumbnail_image) }}" alt="Current Thumbnail" class="mb-2 w-32 h-32 object-cover rounded-lg">
                @endif
                <input type="file" name="thumbnail_image" id="thumbnail_image" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Main Images -->
            <div class="form-group">
                <label for="main_images" class="text-lg font-medium text-gray-700">Main Images</label>
                @if($room->main_images)
                    @php
                        $images = json_decode($room->main_images);
                    @endphp
                    <div class="flex gap-2 mb-4">
                        @foreach($images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Room Image" class="w-20 h-20 object-cover rounded-lg">
                        @endforeach
                    </div>
                @endif
                <input type="file" name="main_images[]" id="main_images" multiple class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Amenities -->
            <div class="form-group">
                <label class="text-lg font-medium text-gray-700">Amenities</label>
                <div class="space-y-4">
                    @php
                        $selectedAmenities = json_decode($room->amenities ?? '[]');
                    @endphp

                    <div class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="wifi" id="wifi" @if(in_array('wifi', $selectedAmenities)) checked @endif class="text-indigo-600">
                        <label for="wifi" class="ml-2 text-gray-700">WiFi</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="cabinet" id="cabinet" @if(in_array('cabinet', $selectedAmenities)) checked @endif class="text-indigo-600">
                        <label for="cabinet" class="ml-2 text-gray-700">Cabinet</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="chair" id="chair" @if(in_array('chair', $selectedAmenities)) checked @endif class="text-indigo-600">
                        <label for="chair" class="ml-2 text-gray-700">Chair</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="table" id="table" @if(in_array('table', $selectedAmenities)) checked @endif class="text-indigo-600">
                        <label for="table" class="ml-2 text-gray-700">Table</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="air_conditioning" id="air_conditioning" @if(in_array('air_conditioning', $selectedAmenities)) checked @endif class="text-indigo-600">
                        <label for="air_conditioning" class="ml-2 text-gray-700">Air Conditioning</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="electric_fan" id="electric_fan" @if(in_array('electric_fan', $selectedAmenities)) checked @endif class="text-indigo-600">
                        <label for="electric_fan" class="ml-2 text-gray-700">Electric Fan</label>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="text-lg font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $room->description) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('boarding_house-rooms.index', $room->boarding_house_id) }}" class="text-gray-600 hover:text-indigo-600">Cancel</a>
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">Save Changes</button>
        </div>
    </form>
</div>
@endsection
