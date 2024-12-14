<!-- Amenities Component -->
<div class="bg-white p-6 border rounded-md shadow-sm">
    <h3 class="text-xl font-bold text-gray-800 mb-4">What this place offers</h3>
    <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-gray-700 text-sm">
            @if($amenities->bathrooms > 0)
            <div class="flex items-center gap-2">
                <i class="fas fa-bath text-gray-800"></i>
                    <span>{{ $amenities->bathrooms }}</span>
                    <span>Bathrooms</span>
                </div>
            @endif
    
            @foreach([
                'WiFi' => ['value' => $amenities->wifi, 'icon' => 'fas fa-wifi'],
                'CCTV' => ['value' => $amenities->cctv, 'icon' => 'fas fa-video'],
                'Refrigerator' => ['value' => $amenities->refrigerator, 'icon' => 'fas fa-cube'],
                'Kitchen' => ['value' => $amenities->kitchen, 'icon' => 'fas fa-utensils'],
                'Laundry Facilities' => ['value' => $amenities->laundry_service, 'icon' => 'fas fa-tshirt'],
                'Water Bill' => ['value' => $amenities->water_bill, 'icon' => 'fas fa-water'],
                'Electric Bill' => ['value' => $amenities->electric_bill, 'icon' => 'fas fa-plug'],
                'Air Conditioning' => ['value' => $amenities->air_conditioning, 'icon' => 'fas fa-snowflake'],
            ] as $name => $details)
                @if($details['value'])
                <div class="flex items-center gap-2 text-base">
                    <i class="{{ $details['icon'] }} text-gray-800 text-base"></i>
                        {{-- <span>✓</span> --}}
                        <span>{{ $name }}: {{ ucwords($details['value']) }}</span> <!-- Display the value (e.g., Separate, Shared) -->
                    </div>
                @endif
            @endforeach
    </div>
    
    
</div>
