@extends('layouts.sidebar-header')

@section('content')
<div class="container mx-auto px-6 py-8">
<!-- Profile Section -->
{{-- <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow-md p-6"> --}}
    <div>
    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
        <!-- Profile Picture -->
        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-700">
            @if (auth()->user()->profile_photo_path)
                <!-- Display Verification Status and Profile Photo -->
                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="w-full h-full object-cover">
            @else
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
            @endif
        </div>
<!-- User Details -->
<div class="flex-1">
    <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
    <p class="text-sm">{{ ucfirst(Auth::user()->role) }}</p>
    <p class="text-sm">{{ Auth::user()->email }}</p>

    <!-- Verified Icon and Status -->
    @if (auth()->user()->hasVerifiedEmail())
        <div class="mt-4 flex items-center space-x-2">
            <svg class="w-6 h-6 text-white bg-green-600 rounded-full p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-semibold">Verified</span>
        </div>
    @endif
    <a href="{{route('free-trial')}}" class="text-sm">Subscriptions</a>

</div>

        <a href="{{ route('profile.edit') }}" class="hover:underline px-6 py-2">Edit</a>
    </div>


</div>

<!-- Upload Photo Form -->
{{-- <form action="{{ route('profile.upload_photo') }}" method="POST" enctype="multipart/form-data" class="mt-6">
    @csrf
    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
        <input type="file" name="profile_picture" class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-gray-600">
        <button type="submit" class="hover:bg-blue-400 text-white py-2 px-2">
            Change Photo
        </button>
        <a href="{{ route('profile.edit') }}" class="hover:underline px-6 py-2">Edit</a>
    </div>
</form> --}}


    <!-- Additional Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            @foreach([
                'Date of Birth' => Auth::user()->date_of_birth ?? 'N/A', 
                'Phone Number' => Auth::user()->phone, 
                'Address' => Auth::user()->address, 
                'Joined On' => Auth::user()->created_at->format('F d, Y')
            ] as $label => $value)
            <div class="flex justify-between">
                <span class="font-medium">{{ $label }}</span>
                <span>{{ $value }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Room Reservation History</h2>
        @forelse($reservations as $reservation)
            <div class="flex flex-col md:flex-row items-center justify-between border-b border-gray-200 py-4">
                <!-- Room and Boarding House Details -->
                <div class="flex-1 mb-4 md:mb-0">
                    <h3 class="font-semibold text-gray-900 text-lg">
                        {{ $reservation->room->boardingHouse->name ?? 'N/A' }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        <strong>Room Type:</strong> {{ $reservation->room->type ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        <strong>Reservation Date:</strong> {{ $reservation->visit_date ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        <strong>Visit Time:</strong> {{ $reservation->visit_time ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        <strong>Reserved On:</strong> {{ $reservation->created_at->format('F d, Y') }}
                    </p>
                </div>
                <!-- Reservation Status and Actions -->
                <div class="flex flex-col items-end md:items-end space-y-2">
                    <span class="{{ $reservation->status == 'accepted' ? 'text-green-500' : ($reservation->status == 'pending' ? 'text-yellow-500' : 'text-red-500') }} font-medium capitalize ">
                        {{ $reservation->status }}
                    </span>
                    <a href="{{ route('rooms.show', $reservation->room->id) }}" 
                       class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-600 transition duration-300">
                        View Room
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">No Room Reservation history available.</p>
        @endforelse
    </div>
    
</div>
@endsection
