<div class=" mx-auto p-6 bg-white shadow-lg rounded-lg space-y-6">
    <!-- Host Information -->
    <div class="flex items-center space-x-4">
        <!-- Profile Photo -->
        <img src="{{ asset('storage/' . $owner->profile_photo_path ?? 'images/default-profile.png') }}" alt="Host Profile" class="w-16 h-16 rounded-full object-cover border-2 border-gray-300">
        
        <!-- Host Name and Superhost Info -->
        <div>
            <h3 class="text-2xl font-semibold text-gray-900">Hosted by {{ $owner->name }}</h3>
            {{-- <p class="text-sm text-gray-600">Superhost · {{$owner->created_at}} years hosting</p> --}}
            <p class="text-sm text-gray-600">Started on · {{ $owner->created_at->format('F j, Y') }}</p>



        </div>
    </div>

    <!-- Host Details -->
    <div class="space-y-4">
        <!-- Contact Information -->
        <div class="flex items-start space-x-3">
            <i class="fas fa-phone text-gray-600 text-xl"></i>
            <div>
                <p class="text-sm font-medium text-gray-700">Contact:</p>
                <p class="text-sm text-gray-500">{{ $owner->phone }}</p>
            </div>
        </div>

        <!-- Email Information -->
        <div class="flex items-start space-x-3">
            <i class="fas fa-envelope text-gray-600 text-xl"></i>
            <div>
                <p class="text-sm font-medium text-gray-700">Email:</p>
                <p class="text-sm text-gray-500">
                    <a href="mailto:{{ $owner->email }}" class="text-blue-500">{{ $owner->email }}</a>
                </p>
            </div>
        </div>

        <!-- Address Information -->
        <div class="flex items-start space-x-3">
            <i class="fas fa-map-marker-alt text-gray-600 text-xl"></i>
            <div>
                <p class="text-sm font-medium text-gray-700">Address:</p>
                <p class="text-sm text-gray-500">{{ $owner->address }}</p>
            </div>
        </div>

        <!-- Facebook Profile Link -->
        <div class="flex items-start space-x-3">
            <i class="fab fa-facebook text-gray-600 text-xl"></i>
            <div>
                <p class="text-sm font-medium text-gray-700">Facebook:</p>
                <p class="text-sm text-gray-500">
                             <!-- Check if the owner has a related boarding house and a valid facebook_link -->
           @if ($owner && $owner->boardingHouse && $owner->boardingHouse->facebook_link)
           <a href="{{ $owner->boardingHouse->facebook_link }}" target="_blank" class="text-blue-500">View Facebook Profile</a>
       @else
           <span class="text-gray-400">Facebook Profile not available</span>
       @endif
                </p>
            </div>
        </div>

        <!-- Boarding Houses and Rooms Count -->
        <div class="flex items-start space-x-3">
            <i class="fas fa-building text-gray-600 text-xl"></i>
            <div>
                <p class="text-sm font-medium text-gray-700">Boarding Houses Owned:</p>
                <p class="text-sm text-gray-500">{{ $owner->boardingHouses->count() }}</p>
            </div>
        </div>

        <div class="flex items-start space-x-3">
            <i class="fas fa-bed text-gray-600 text-xl"></i>
            <div>
                <p class="text-sm font-medium text-gray-700">Rooms Owned:</p>
                <p class="text-sm text-gray-500">
                    {{ $owner->boardingHouses->sum(function($boardingHouse) {
                        return $boardingHouse->rooms->count();
                    }) }}
                </p>
            </div>
        </div>
    </div>
</div>
