{{-- @extends('main_resources.index')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
    <!-- House Images Section -->
    <x-house-images :house="$boardingHouse" />

    <!-- Add Room Button -->
    <div class="mt-6 text-right">
        <button type="button" class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#addRoomModal">
            + Add Room
        </button>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('rooms.store', $boardingHouse->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addRoomModalLabel">Add a New Room</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- Room Type -->
                            <div class="form-group">
                                <label for="type" class="form-label">Room Type</label>
                                <input type="text" name="type" id="type" class="form-control" placeholder="e.g., Single, Double" required>
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control" placeholder="e.g., 5000" required>
                            </div>

                            <!-- Number of Beds -->
                            <div class="form-group">
                                <label for="number_of_beds" class="form-label">Number of Beds</label>
                                <input type="number" name="number_of_beds" id="number_of_beds" class="form-control" placeholder="e.g., 2" required>
                            </div>

                            <!-- Availability -->
                            <div class="form-group">
                                <label for="availability" class="form-label">Availability</label>
                                <select name="availability" id="availability" class="form-control">
                                    <option value="available">Available</option>
                                    <option value="not_available">Not Available</option>
                                </select>
                            </div>

                            <!-- Thumbnail Image -->
                            <div class="form-group">
                                <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
                                <input type="file" name="thumbnail_image" id="thumbnail_image" class="form-control">
                            </div>

                            <!-- Main Images -->
                            <div class="form-group">
                                <label for="main_images" class="form-label">Main Images</label>
                                <input type="file" name="main_images[]" id="main_images" class="form-control" multiple>
                            </div>

                            <!-- Description -->
                            <div class="form-group lg:col-span-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Add a short description about this room..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Room</button>
                    </div>
                    <div class="form-group">
                        <label for="wifi" class="form-label">
                            <input type="checkbox" name="wifi" id="wifi" value="1">
                            WiFi
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="cabinet" class="form-label">
                            <input type="checkbox" name="cabinet" id="cabinet" value="1">
                            Cabinet
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="chair" class="form-label">
                            <input type="checkbox" name="chair" id="chair" value="1">
                            Chair
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="table" class="form-label">
                            <input type="checkbox" name="table" id="table" value="1">
                            Table
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="air_conditioning" class="form-label">
                            <input type="checkbox" name="air_conditioning" id="air_conditioning" value="1">
                            Air Conditioning
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="electric_fan" class="form-label">
                            <input type="checkbox" name="electric_fan" id="electric_fan" value="1">
                            Electric Fan
                        </label>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

 <!-- Available Rooms Section -->
<div class="mt-8">
    <h2 class="text-lg font-bold mb-4">Available Rooms</h2>
    @if($boardingHouse->rooms->isEmpty())
        <p>No rooms available yet. Add a room to display here.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Price</th>
                    <th>Number of Beds</th>
                    <th>Availability</th>
                    <th>Thumbnail</th>
                    <th>Main Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boardingHouse->rooms as $room)
                    <tr>
                        <td>{{ $room->type }}</td>
                        <td>{{ number_format($room->price, 2) }}</td>
                        <td>{{ $room->number_of_beds }}</td>
                        <td>{{ ucfirst($room->availability) }}</td>
                        <!-- Thumbnail Image -->
                        <td>
                            @if($room->thumbnail_image)
                                <img src="{{ asset('storage/' . $room->thumbnail_image) }}" alt="Thumbnail" class="img-thumbnail" style="width: 100px; height: 100px;">
                            @else
                                <p>No image</p>
                            @endif
                        </td>
                        <!-- Main Images -->
                        <td>
                            @if($room->main_images)
                                @php
                                    $images = json_decode($room->main_images);
                                @endphp
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Room Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                                    @endforeach
                                </div>
                            @else
                                <p>No images</p>
                            @endif
                        </td>
                        <!-- Actions -->
                        <td>
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>


    <!-- Main Section -->
    <div class="mt-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column -->
            <div class="lg:flex-[1.6] space-y-6">
                <!-- House Info -->
                <x-house-info :house="$boardingHouse" />

                <!-- House Amenities -->
                <x-house-amenity :house="$boardingHouse" :amenities="$amenities" />
            </div>

            <!-- Right Column -->
            <div class="lg:flex-1 border bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Other Details</h3>
                <p>Add content for the right column here, if applicable.</p>
            </div>
        </div>

        <!-- House Description -->
        <div class="mt-8">
            <x-house-description :house="$boardingHouse" />
        </div>

        <!-- House Policy -->
        <div class="mt-8">
            <x-house-policy :house="$boardingHouse" />
        </div>
    </div>
</div>
@endsection --}}
@extends('layouts.sidebar-header')

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
@section('content')
    <div>
                 <!-- Breadcrumb Navigation -->
                 <nav class="mb-6 ml-10" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4 text-gray-600">
                        <li>
                            <a href="{{route('profile')}}" class="flex items-center hover:text-blue-800">
                                {{-- <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 12l2-2m0 0l7-7 7 7m-9-2v12m4-12l7 7-7 7m0 0l-7-7"></path></svg> --}}
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <span class="text-gray-400">/</span>
                        </li>
                        <li>
                            <a href="{{ route('boarding_house.view') }}" class="text-gray-600 hover:text-blue-800">
                                My Boarding House
                            </a>
                        </li>
                        <li>
                            <span class="text-gray-400">/</span>
                        </li>
                        <li>
                            <a href="{{ route('boarding_house.view', $boardingHouse->id) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $boardingHouse->name }}
                            </a>
                        </li>
                    </ol>
                </nav>
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-house-images :house="$boardingHouse"/>
            <!-- Redirect Button to Rooms Page -->
            <div class="mt-4 text-end mb-4">
                <a href="{{ route('boarding_house-rooms.index', ['boardingHouse' => $boardingHouse->id]) }}" 
                   class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                    Create Rooms
                </a>  
            </div>
            

            <div class="mb-6 flex flex-col lg:flex-row gap-2">
                <div class="flex-1 lg:flex-[1.6] mb-4 lg:mb-0">
                    <x-house-info :house="$boardingHouse"/>
                    <x-house-amenity :house="$boardingHouse" :amenities="$amenities"/>
                </div>
                <!-- Display the pinned location by the user -->
                <div class="flex-1 border">
                    <div id="display-map" style="width: 100%; height: 400px;"></div>
                </div>
                
                <script>
                    function initMap() {
                        const pinnedLocation = {
                            lat: {{ $boardingHouse->latitude }},
                            lng: {{ $boardingHouse->longitude }}
                        };
                
                        // Initialize the map
                        const map = new google.maps.Map(document.getElementById('display-map'), {
                            center: pinnedLocation,
                            zoom: 15,
                        });
                
                        // Place a marker on the pinned location
                        new google.maps.Marker({
                            position: pinnedLocation,
                            map: map,
                        });
                    }
                </script>
            </div>
            <x-house-description :house="$boardingHouse"/>
            <x-house-policy :house="$boardingHouse"/>
        </div>
    </div>
@endsection

<style>
    .action-btn {
        width: 80px; /* Set a fixed width */
        height: 40px; /* Set a fixed height */
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>