<div x-data="{ isEditing: false }" class="p-4 rounded-md  mb-6 border shadow-sm">
    <!-- Display Mode -->
    <div x-show="!isEditing">
        <div class="flex justify-between">
            <h2 class="text-3xl font-black leading-tight text-black">{{ $house->name }}</h2>
            <button @click="isEditing = true" class="text-blue-600 hover:text-blue-800 transition duration-150 text-sm">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>
        <div class="flex items-center space-x-2 mb-4">
            <p class="text-sm hover:underline text-gray-500">
                <i class="fas fa-map-marker-alt text-red-500"></i>
                {{ $house->address }}
                <a  href="https://www.google.com/maps?q={{ $house->latitude }},{{ $house->longitude }}" 
                    target="_blank" class="text-sm text-blue-500 hover:text-gray-500 transition-transform duration-200 transform hover:scale-105">
                    - view on Google Maps
                </a>
            </p>
        </div>
        <p class="text-sm text-gray-700 mt-4">Curfew Hour: {{ \Carbon\Carbon::parse($house->curfew)->format('h:i A') }}</p>

        <div class="rounded-md mt-3 inline-flex text-sm items-center space-x-1 px-2 py-1 font-bold
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
    </div>

    <!-- Edit Mode -->
    <form x-show="isEditing" x-cloak action="{{ route('boardinghouse.update-info', $house->id) }}" method="POST">
        @csrf
        <div class="mb-2 mt-3">
            <label for="name" class="text-lg font-medium text-gray-800">House Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $house->name) }}" class="text-gray-800 w-full mt-1 border-gray-300 rounded-md shadow-sm transition duration-150">
        </div>
        <div class="mb-2">
            <label for="address" class="text-lg font-medium text-gray-800">Address</label>
            <input type="text" name="address" id="address" value="{{ old('address', $house->address) }}" class="text-gray-800 w-full mt-1 border-gray-300 rounded-md shadow-sm transition duration-150">
        </div>
        <div class="mb-2">
            <label for="maplink" class="text-lg font-medium text-gray-800">Map Link</label>
            <input type="text" name="maplink" id="maplink" value="{{ old('maplink', $house->maplink) }}" class="text-gray-800 w-full mt-1 border-gray-300 rounded-md shadow-sm transition duration-150">
        </div>
        <div class="mb-2">
            <label for="curfew" class="text-lg font-medium text-gray-800">Curfew Hour</label>
            <input type="text" name="curfew" id="curfew" value="{{ old('curfew', $house->curfew) }}" class="text-gray-800 w-full mt-1 border-gray-300 rounded-md shadow-sm transition duration-150">
        </div>
        <div class="mb-2">
            <label for="gender" class="text-lg font-medium text-gray-800">Gender</label>
            <select name="gender" id="gender" class="w-full mt-1 border-gray-300 rounded-md shadow-sm transition duration-150 text-gray-800">
                <option value="male only" {{ $house->gender === 'male only' ? 'selected' : '' }}>Male Only</option>
                <option value="female only" {{ $house->gender === 'female only' ? 'selected' : '' }}>Female Only</option>
                <option value="male and female" {{ $house->gender === 'male and female' ? 'selected' : '' }}>Male and Female</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-cyan-500 text-sm leading-4 font-medium rounded-md px-2 py-2 text-white shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">Save</button>
            <button type="button" @click="isEditing = false" class="text-gray-600 text-sm hover:underline">Cancel</button>
        </div>
    </form>
</div>
