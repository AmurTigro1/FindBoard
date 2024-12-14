@extends('main_resources.index')

@section('content')
    <div class="py-12">
        @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    use Carbon\Carbon;
@endphp

{{-- @if(auth()->user()->trial_ends_at && Carbon::now()->lessThanOrEqualTo(auth()->user()->trial_ends_at))
    @if(auth()->user()->boardingHouses()->count() >= 1)
        <div class="bg-yellow-500 text-white p-4 rounded mb-4">
            <span>You can only create one boarding house during your trial period.</span>
            <a href="{{ route('subscriptions.index') }}" class="text-white underline ml-2 hover:text-blue-400">
                Subscribe now to unlock more features.
            </a>
        </div>
    @endif
@elseif(auth()->user()->trial_ends_at && Carbon::now()->greaterThan(auth()->user()->trial_ends_at))
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <span>Your free trial has expired. Please subscribe to continue using our features.</span>
        <a href="{{ route('subscriptions.index') }}" class="text-white underline ml-2 hover:text-blue-400">
            Subscribe now
        </a>
    </div>
@endif --}}
@php
    $hasActiveSubscription = auth()->user()->subscription 
        && auth()->user()->subscription->status === 'active' 
        && Carbon::now()->lessThanOrEqualTo(auth()->user()->subscription->end_date);
@endphp

@if(!$hasActiveSubscription)
    @if(auth()->user()->trial_ends_at && Carbon::now()->lessThanOrEqualTo(auth()->user()->trial_ends_at))
        @if(auth()->user()->boardingHouses()->count() >= 1)
            <div class="bg-yellow-500 text-white p-4 rounded mb-4">
                <span>You can only create one boarding house during your trial period.</span>
                <a href="{{ route('subscriptions.index') }}" class="text-white underline ml-2 hover:text-blue-400">
                    Subscribe now to unlock more features.
                </a>
            </div>
        @endif
    @elseif(auth()->user()->trial_ends_at && Carbon::now()->greaterThan(auth()->user()->trial_ends_at))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <span>Your free trial has expired. Please subscribe to continue using our features.</span>
            <a href="{{ route('subscriptions.index') }}" class="text-white underline ml-2 hover:text-blue-400">
                Subscribe now
            </a>
        </div>
    @endif
@endif


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-200">
                    <form action="{{ route('boardinghouse.store') }}" method="post" id="create-house-form">
                        @csrf

                        <!-- Step 1: House Name -->
                        <div id="step-1" class="p-6 bg-white rounded-lg shadow-lg space-y-6">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="name" class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                        <i class="fas fa-house-user text-blue-500"></i>
                                        <span>House Name</span>
                                    </label>
                                    <input type="text" name="name" id="name" required placeholder="Enter house name"
                                        class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400 focus:border-blue-500 transition-all duration-150" />
                                    <p class="mt-1 text-sm text-gray-500">Choose a unique and descriptive name for your boarding house that helps others easily find it!</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="facebook_link" class="text-lg font-semibold text-gray-900 flex items-center space-x-3 mb-2">
                                        <i class="fab fa-facebook text-blue-500"></i>
                                        <span>Facebook Link</span>
                                    </label>
                                    <input type="text" name="facebook_link" id="facebook_link" required placeholder="Enter Facebook Link"
                                        class="mt-2 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 p-3 text-gray-900 placeholder-gray-400 transition-all duration-200 hover:border-blue-400 focus:outline-none" />
                                    <p class="mt-2 text-sm text-gray-600">Enter your Facebook link to allow tenants to communicate online!</p>
                                </div>
                                
                            </div>
                            <div class="flex justify-between mt-6">
                                <button type="button" id="next-step-1"
                                    class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold py-3 px-6 rounded-md shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
                                    Next
                                </button>
                            </div>
                        </div>


                        <!-- Step 2: Input Map-->
                        <div id="step-2" class="hidden p-6 bg-white rounded-lg shadow-lg space-y-6">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="address" class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-blue-500"></i>
                                        <span>Address</span>
                                    </label>
                                    <input 
                                        name="address" 
                                        id="address" 
                                        required 
                                        placeholder="Enter address"
                                        class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-400 focus:border-blue-500 transition-all duration-150"
                                    ></input>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Provide the full address of your boarding house for easy location identification. Example: 123 Main St, Purok, City/Municipality, Province
                                    </p>
                                </div>
                                
                                <script>
                                    function initAutocomplete() {
                                        // Restrict the autocomplete search to the Philippines
                                        const options = {
                                            componentRestrictions: { country: 'ph' },
                                            fields: ['formatted_address', 'geometry'],
                                        };
                                
                                        // Get the address input element
                                        const addressInput = document.getElementById('address');
                                
                                        // Initialize the Places Autocomplete
                                        const autocomplete = new google.maps.places.Autocomplete(addressInput, options);
                                
                                        // Listen for the place_changed event to handle selected address
                                        autocomplete.addListener('place_changed', () => {
                                            const place = autocomplete.getPlace();
                                
                                            if (place.geometry) {
                                                console.log('Selected Address:', place.formatted_address);
                                                console.log('Latitude:', place.geometry.location.lat());
                                                console.log('Longitude:', place.geometry.location.lng());
                                
                                                // Optionally populate hidden fields for latitude and longitude
                                                document.getElementById('latitude').value = place.geometry.location.lat();
                                                document.getElementById('longitude').value = place.geometry.location.lng();
                                            }
                                        });
                                    }
                                </script>

                                <div>
                                    <label for="map" class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                        <i class="fas fa-map-marker text-blue-500"></i>
                                        <span>Pin Location</span>
                                    </label>
                                    <div id="map" style="width: 100%; height: 400px;" class="mt-4"></div>
                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">
                                    <p class="mt-1 text-sm text-gray-500">Click on the map to set the exact location of your boarding house.</p>
                                </div>
                                
                            </div>
                            <div class="flex justify-between mt-6 space-x-4">
                                <button type="button" id="previous-step-2"
                                    class="w-full md:w-auto bg-gray-500 text-white font-semibold py-3 px-6 rounded-md shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                                    Previous
                                </button>
                                <button type="button" id="next-step-2"
                                    class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold py-3 px-6 rounded-md shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
                                    Next
                                </button>
                            </div>
                        </div>


                        <!-- Step 3: Gender -->
                        <div id="step-3" class="hidden p-6 bg-white rounded-lg shadow-lg space-y-6">
                            <div>
                                <label for="gender" class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                    <i class="fas fa-venus-mars text-blue-500"></i>
                                    <span>Gender</span>
                                </label>
                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div id="male-only" class="cursor-pointer p-4 border border-gray-300 rounded-md text-center hover:bg-blue-200 focus:ring-2 focus:ring-blue-500 transition-all duration-150"
                                         onclick="selectGender('male only', this)">
                                        <i class="fas fa-mars text-blue-500 text-3xl mb-2"></i>
                                        <h3 class="text-lg font-semibold text-gray-900">Male Only</h3>
                                    </div>
                                    <div id="female-only" class="cursor-pointer p-4 border border-gray-300 rounded-md text-center hover:bg-blue-200 focus:ring-2 focus:ring-blue-500 transition-all duration-150"
                                         onclick="selectGender('female only', this)">
                                        <i class="fas fa-venus text-blue-500 text-3xl mb-2"></i>
                                        <h3 class="text-lg font-semibold text-gray-900">Female Only</h3>
                                    </div>
                                    <div id="male-female" class="cursor-pointer p-4 border border-gray-300 rounded-md text-center hover:bg-blue-200 focus:ring-2 focus:ring-blue-500 transition-all duration-150"
                                         onclick="selectGender('male and female', this)">
                                        <i class="fas fa-genderless text-blue-500 text-3xl mb-2"></i>
                                        <h3 class="text-lg font-semibold text-gray-900">Male and Female</h3>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Select the gender preference for your boarding house to help people find the right fit!</p>
                            </div>
                            <div class="flex justify-between mt-6 space-x-4">
                                <button type="button" id="previous-step-3"
                                    class="w-full md:w-auto bg-gray-500 text-white font-semibold py-3 px-6 rounded-md shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                                    Previous
                                </button>
                                <button type="button" id="next-step-3"
                                    class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold py-3 px-6 rounded-md shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
                                    Next
                                </button>
                            </div>
                            <input type="hidden" id="gender" name="gender" required />
                        </div>

                        <!-- Step 4: Description -->
                        <div id="step-4" class="hidden p-6 bg-white rounded-lg shadow-lg space-y-6">
                            <div>
                                <label for="description" class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                    <i class="fas fa-align-left text-blue-500"></i>
                                    <span>Description</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required placeholder="Enter description"
                                    class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"></textarea>
                                <p class="mt-2 text-sm text-gray-500">Provide a detailed description of your boarding house to help others understand its features and atmosphere. Be descriptive!</p>
                            </div>
                            <div class="flex justify-between mt-6 space-x-4">
                                <button type="button" id="previous-step-4"
                                    class="w-full md:w-auto bg-gray-500 text-white font-semibold py-3 px-6 rounded-md shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                                    Previous
                                </button>
                                <button type="button" id="next-step-4"
                                    class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold py-3 px-6 rounded-md shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
                                    Next
                                </button>
                            </div>
                        </div>


                        <!-- Step 5: Policies -->
                        <div id="step-5" class="hidden p-6 bg-white rounded-lg shadow-lg space-y-6">
                            <div>
                                <label for="policies" class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                                    <i class="fas fa-file-alt text-blue-500"></i>
                                    <span>Policies</span>
                                </label>
                                <textarea name="policies" id="policies" rows="4" required placeholder="Enter policies"
                                    class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"></textarea>
                                <p class="mt-2 text-sm text-gray-500">Please provide the policies for your boarding house, including rules regarding check-ins, check-outs, noise, guests, etc. Make it clear and concise.</p>
                            </div>
                            <div>
                                <div>
                                    <label for="curfew" class="text-lg font-semibold text-gray-900 flex items-center space-x-3 mb-2">
                                        <i class="fas fa-clock text-blue-500"></i>
                                        <span>Curfew</span>
                                    </label>
                                    <input type="text" name="curfew" id="curfew" placeholder="HH:MM AM/PM"
                                        class="mt-2 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 p-3 text-gray-900 placeholder-gray-400 transition-all duration-200 hover:border-blue-400 focus:outline-none" />
                                    <p class="mt-2 text-sm text-gray-600">Enter curfew hour in the format HH:MM AM/PM (e.g., 10:30 PM).</p>
                                </div>
                                
                                
                            <div class="flex justify-between mt-6 space-x-4">
                                <button type="button" id="previous-step-5"
                                    class="w-full md:w-auto bg-gray-500 text-white font-semibold py-3 px-6 rounded-md shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                                    Previous
                                </button>
                                <button type="button" id="next-step-5"
                                    class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold py-3 px-6 rounded-md shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>


                        <!-- Step 6: Amenities -->
                        <div id="step-6" class="hidden p-6 bg-white rounded-lg shadow-lg space-y-6">
                            <h2 class="text-2xl font-semibold text-gray-900 flex items-center space-x-2">
                                <i class="fas fa-concierge-bell text-blue-500"></i>
                                <span>Amenities</span>
                            </h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                                @foreach ([
                                    'wifi' => 'fas fa-wifi',
                                    'cctv' => 'fas fa-video',
                                    'kitchen' => 'fas fa-utensils',
                                    'laundry_service' => 'fas fa-tshirt',
                                    'electric_bill' => 'fas fa-plug',
                                    'water_bill' => 'fas fa-water',
                                    'air_conditioning' => 'fas fa-snowflake',
                                    'refrigerator' => 'fas fa-cube',
                                ] as $amenity => $icon)
                                    <div class="relative bg-gray-100 hover:bg-blue-200 rounded-lg p-4 shadow-sm transition-all duration-200">
                                        <div class="flex flex-col items-center text-blue-600 space-y-2">
                                            <i class="{{ $icon }} text-3xl"></i>
                                            <span class="text-sm font-medium text-gray-800">{{ ucwords(str_replace('_', ' ', $amenity)) }}</span>
                                        </div>
                                        
                                        {{-- Dynamic Dropdown Options --}}
                                        <select name="{{ $amenity }}" id="{{ $amenity }}" class="mt-4 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                            @if ($amenity == 'electric_bill' || $amenity == 'water_bill')
                                                <option value="" disabled selected>Select {{ ucwords(str_replace('_', ' ', $amenity)) }}</option>
                                                <option value="separate">Separate</option>
                                                <option value="shared">Shared</option>
                                            @elseif ($amenity == 'refrigerator')
                                                <option value="" disabled selected>Select {{ ucwords(str_replace('_', ' ', $amenity)) }}</option>
                                                <option value="available">Available</option>
                                                <option value="shared">Shared</option>
                                                <option value="in-room">Personal</option>
                                            @else
                                                <option value="available">Available</option>
                                                <option value="shared">Shared</option>
                                                <option value="not-available">Not Available</option>
                                            @endif
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            


                            <!-- Number of Bathrooms -->
                            <div class="mt-6">
                                <label for="bathrooms-count" class="text-sm font-semibold text-gray-900 flex items-center space-x-2">
                                    <i class="fas fa-bath text-blue-500"></i>
                                    <span>Number of Bathrooms</span>
                                </label>
                                <input type="number" name="bathrooms" id="bathrooms" required placeholder="Enter number of bathrooms"
                                    class="mt-2 block w-[1/4] border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" />
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-between mt-6 space-x-4">
                                <button type="button" id="previous-step-6"
                                    class="w-full md:w-auto bg-gray-500 text-white font-semibold py-3 px-6 rounded-md shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                                    Previous
                                </button>
                                <button type="submit" id="submit-btn"
                                    class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold py-3 px-6 rounded-md shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleStep(currentStep, nextStep) {
            document.getElementById(currentStep).classList.add('hidden');
            document.getElementById(nextStep).classList.remove('hidden');
        }

        function validateStep(stepId) {
            const requiredFields = document.querySelectorAll(`#${stepId} input[required], #${stepId} textarea[required], #${stepId} select[required]`);
            for (const field of requiredFields) {
                if (!field.value) {
                    alert('Please fill in all required fields.');
                    return false;
                }
            }
            return true;
        }

        document.getElementById('next-step-1').addEventListener('click', () => {
            if (validateStep('step-1')) {
                toggleStep('step-1', 'step-2');
            }
        });
        document.getElementById('previous-step-2').addEventListener('click', () => toggleStep('step-2', 'step-1'));
        document.getElementById('next-step-2').addEventListener('click', () => {
            if (validateStep('step-2')) {
                toggleStep('step-2', 'step-3');
            }
        });
        document.getElementById('previous-step-3').addEventListener('click', () => toggleStep('step-3', 'step-2'));
        document.getElementById('next-step-3').addEventListener('click', () => {
            if (validateStep('step-3')) {
                toggleStep('step-3', 'step-4');
            }
        });
        document.getElementById('previous-step-4').addEventListener('click', () => toggleStep('step-4', 'step-3'));
        document.getElementById('next-step-4').addEventListener('click', () => {
            if (validateStep('step-4')) {
                toggleStep('step-4', 'step-5');
            }
        });
        document.getElementById('previous-step-5').addEventListener('click', () => toggleStep('step-5', 'step-4'));
        document.getElementById('next-step-5').addEventListener('click', () => {
            if (validateStep('step-5')) {
                toggleStep('step-5', 'step-6');
            }
        });

        function selectGender(gender, element) {
            // Remove 'selected' class from all cards
            const allCards = document.querySelectorAll('#step-3 .cursor-pointer');
            allCards.forEach(card => {
                card.classList.remove('bg-blue-200', 'border-blue-500');
            });

            // Add 'selected' class to the clicked card
            element.classList.add('bg-blue-200', 'border-blue-500');

            // Set the gender value in the hidden input
            document.getElementById('gender').value = gender;
        }
    </script>
    <script>
        let map, marker;
    
        function initMap() {
            const defaultLocation = { lat: 9.91559079398741, lng: 123.9630119144708 }; // Default to Bohol, Philippines
            
            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 14,
            });
    
            marker = new google.maps.Marker({
                position: defaultLocation,
                map,
                draggable: true,
            });
    
            google.maps.event.addListener(marker, 'dragend', function () {
                const position = marker.getPosition();
                document.getElementById('latitude').value = position.lat();
                document.getElementById('longitude').value = position.lng();
            });
    
            map.addListener("click", (event) => {
                const { latLng } = event;
                marker.setPosition(latLng);
                document.getElementById('latitude').value = latLng.lat();
                document.getElementById('longitude').value = latLng.lng();
            });
        }
    </script>
    
@endsection
