<!-- Amenities Component -->
<div x-data="{ editing: false }" class="bg-white p-4 border rounded-md shadow-sm">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-800 mb-2"><i class="fas fa-check-circle text-teal-500 mr-1"></i>Amenities</h3>
        <button
            x-show="!editing"
            @click="editing = true"
            class="text-teal-600 hover:text-teal-800 transition duration-150 text-sm"
        ><i class="fas fa-edit"></i>Edit</button>
    </div>

    <!-- Display Mode -->
    <div x-show="!editing">
        <ul class="flex flex-wrap gap-2 text-gray-700 text-sm">
            <li class="border border-gray-300 p-1 px-3 flex items-center gap-2 whitespace-nowrap">
                <i class="fas fa-bath text-teal-500"></i>
                <span>{{ $amenities->bathrooms }}</span>
                <span>Bathrooms</span>
            </li>
            @foreach(['WiFi' => $amenities->wifi, 'CCTV' => $amenities->cctv, 'Kitchen Use' => $amenities->kitchen_use,
                     'Laundry Facilities' => $amenities->laundry_facilities, 'Storage Spaces' => $amenities->storage_spaces,
                     'Air Conditioning' => $amenities->air_conditioning, 'Parking Area' => $amenities->parking_area,
                     'Pet Friendly' => $amenities->pet_friendly, 'Study Area' => $amenities->study_area,
                     'Outdoor Space' => $amenities->outdoor_space] as $name => $value)
                @if($value)
                    <li class="border border-gray-300 p-1 px-3 flex items-center gap-2 whitespace-nowrap">
                        @switch($name)
                            @case('WiFi')
                                <i class="fas fa-wifi text-teal-500"></i>
                                @break
                            @case('CCTV')
                                <i class="fas fa-video text-teal-500"></i>
                                @break
                            @case('Kitchen Use')
                                <i class="fas fa-utensils text-teal-500"></i>
                                @break
                            @case('Laundry Facilities')
                                <i class="fas fa-tshirt text-teal-500"></i>
                                @break
                            @case('Storage Spaces')
                                <i class="fas fa-box text-teal-500"></i>
                                @break
                            @case('Air Conditioning')
                                <i class="fas fa-snowflake text-teal-500"></i>
                                @break
                            @case('Parking Area')
                                <i class="fas fa-parking text-teal-500"></i>
                                @break
                            @case('Pet Friendly')
                                <i class="fas fa-paw text-teal-500"></i>
                                @break
                            @case('Study Area')
                                <i class="fas fa-graduation-cap text-teal-500"></i>
                                @break
                            @case('Outdoor Space')
                                <i class="fas fa-tree text-teal-500"></i>
                                @break
                        @endswitch
                        <span>✓</span>
                        <span>{{ $name }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <!-- Edit Mode -->
    <form x-show="editing" action="{{ route('boardinghouse.update-amenities', $house->id) }}" method="post">
        @csrf
        <div>
            <label for="bathrooms" class="block text-sm font-semibold">Number of Bathrooms</label>
            <input type="number" name="bathrooms" id="bathrooms" value="{{ $amenities->bathrooms }}"
                class="mt-1 block w-1/4 border-gray-300 rounded-md shadow-sm transition duration-150" />
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-4">
            @foreach (['wifi' => 'WiFi', 'cctv' => 'CCTV', 'kitchen_use' => 'Kitchen Use',
                       'laundry_facilities' => 'Laundry Facilities', 'storage_spaces' => 'Storage Spaces',
                       'air_conditioning' => 'Air Conditioning', 'parking_area' => 'Parking Area',
                       'pet_friendly' => 'Pet Friendly', 'study_area' => 'Study Area',
                       'outdoor_space' => 'Outdoor Space'] as $field => $label)
                <div class="inline-flex items-center">
                    <input type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1"
                           @if ($amenities->$field) checked @endif
                           class="rounded border-gray-300 text-teal-600 transition duration-150" />
                    <label for="{{ $field }}" class="ml-2 text-sm">{{ $label }}</label>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-gradient-to-r from-teal-500 to-cyan-500 text-sm leading-4 font-medium rounded-md px-2 py-2 text-white shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">
                Save
            </button>
            <button type="button" @click="editing = false" class="ml-2 text-sm text-gray-600 hover:underline">
                Cancel
            </button>
        </div>
    </form>
</div>
