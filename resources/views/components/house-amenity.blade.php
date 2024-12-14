<!-- Amenities Component -->
<div x-data="{ editing: false }" class="bg-white p-4 border rounded-md shadow-sm">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Amenities</h3>
        <button
            x-show="!editing"
            @click="editing = true"
            class="text-blue-600 hover:text-blue-800 transition duration-150 text-sm"
        ><i class="fas fa-edit"></i>Edit</button>
    </div>

<!-- Display Mode -->
<div x-show="!editing">
    <div class="flex flex-wrap gap-2 text-gray-700 text-sm">
        <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-gray-700 text-sm">
        @if($amenities->bathrooms > 0)
            <li class="border border-gray-300 p-1 px-3 flex items-center gap-2 whitespace-nowrap">
                <i class="fas fa-bath text-black-500"></i>
                <span>{{ $amenities->bathrooms }}</span>
                <span>Bathrooms</span>
            </div>
        @endif
        @foreach([
            'WiFi' => ['value' => $amenities->wifi, 'icon' => 'fas fa-wifi'],
            'CCTV' => ['value' => $amenities->cctv, 'icon' => 'fas fa-video'],
            'Kitchen' => ['value' => $amenities->kitchen, 'icon' => 'fas fa-utensils'],
            'Laundry Facilities' => ['value' => $amenities->laundry_service, 'icon' => 'fas fa-tshirt'],
            'Water Bill' => ['value' => $amenities->water_bill, 'icon' => 'fas fa-water'],
            'Refrigerator' => ['value' => $amenities->refrigerator, 'icon' => 'fas fa-cube'],
            'Electric Bill' => ['value' => $amenities->electric_bill, 'icon' => 'fas fa-plug'],
            'Air Conditioning' => ['value' => $amenities->air_conditioning, 'icon' => 'fas fa-snowflake'],
        ] as $name => $details)
            @if($details['value'] === 'available' || $details['value'] === 'shared' || $details['value'] === 'in-room' || $details['value'] === 'separate' || $details['value'] === 'not-available')
            <div class="flex items-center gap-2 text-base">
                    <i class="{{ $details['icon'] }} text-black-500"></i>
                  
                    <span>{{ $name }}: {{ ucwords($details['value']) }}</span> <!-- Display the value (e.g., Separate, Shared) -->
            </div>
            @endif
        @endforeach
        </div>
</div>


<!-- Edit Mode -->
<form x-show="editing" action="{{ route('boardinghouse.update-amenities', $house->id) }}" method="post">
    @csrf
    @method('PUT') <!-- Use PUT for updates -->

    <div>
        <label for="bathrooms" class="block text-sm font-semibold text-gray-800">Number of Bathrooms</label>
        <input 
            type="number" 
            name="bathrooms" 
            id="bathrooms" 
            value="{{ old('bathrooms', $amenities->bathrooms) }}" 
            class="text-gray-800 mt-1 block w-1/4 border-gray-300 rounded-md shadow-sm transition duration-150" 
        />
        @error('bathrooms')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-4 text-gray-800">
        @foreach ([
            'wifi' => 'WiFi', 
            'cctv' => 'CCTV', 
            'refrigerator' => 'Refrigerator', 
            'water_bill' => 'Water bill', 
            'electric_bill' => 'Electric bill', 
            'laundry_service' => 'Laundry Service',  
            'air_conditioning' => 'Air Conditioning',
            'kitchen' => 'Kitchen'
        ] as $field => $label)
            <div class="inline-flex items-center">
                <label for="{{ $field }}" class="mr-2 text-sm">{{ $label }}</label>
                <select 
                    name="{{ $field }}" 
                    id="{{ $field }}" 
                    class="border-gray-300 text-gray-800 rounded-md shadow-sm mt-1 w-full">
                    <option value="available" @if(old($field, $amenities->$field) === 'available') selected @endif>Available</option>
                    <option value="shared" @if(old($field, $amenities->$field) === 'shared') selected @endif>Shared</option>
                    <option value="in-room" @if(old($field, $amenities->$field) === 'in-room') selected @endif>In-room</option>
                    <option value="not-available" @if(old($field, $amenities->$field) === 'not-available') selected @endif>Not-available</option>
                </select>
                @error($field)
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <!-- Dropdown for Electric and Water Bills -->
        <div class="inline-flex items-center">
            <label for="electric_bill" class="mr-2 text-sm">Electric Bill</label>
            <select 
                name="electric_bill" 
                id="electric_bill" 
                class="border-gray-300 text-gray-800 rounded-md shadow-sm mt-1 w-full">
                <option value="shared" @if(old('electric_bill', $amenities->electric_bill) === 'shared') selected @endif>Shared</option>
                <option value="separate" @if(old('electric_bill', $amenities->electric_bill) === 'separate') selected @endif>Separate</option>
                <option value="available" @if(old('electric_bill', $amenities->electric_bill) === 'available') selected @endif>Available</option>
            </select>
            @error('electric_bill')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="inline-flex items-center">
            <label for="water_bill" class="mr-2 text-sm">Water Bill</label>
            <select 
                name="water_bill" 
                id="water_bill" 
                class="border-gray-300 text-gray-800 rounded-md shadow-sm mt-1 w-full">
                <option value="shared" @if(old('water_bill', $amenities->water_bill) === 'shared') selected @endif>Shared</option>
                <option value="separate" @if(old('water_bill', $amenities->water_bill) === 'separate') selected @endif>Separate</option>
                <option value="available" @if(old('water_bill', $amenities->water_bill) === 'available') selected @endif>Available</option>
            </select>
            @error('water_bill')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="bg-gradient-to-r from-blue-500 to-cyan-500 text-sm leading-4 font-medium rounded-md px-2 py-2 text-white shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">Save</button>

        <button type="button" @click="editing = false" class="ml-2 text-sm text-gray-600 hover:underline">
            Cancel
        </button>
    </div>
</form>


</div>
