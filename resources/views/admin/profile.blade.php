@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Profile Section -->
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
        <a href="{{route('free-trial')}}" class="text-sm">Trial's day remaining</a>
    
    </div>
    
            <a href="{{ route('profile.edit') }}" class="hover:underline px-6 py-2">Edit</a>
        </div>
    
    
    </div>

    <!-- Additional Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            @foreach([
                'Date of Birth' => Auth::user()->date_of_birth, 
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

    <!-- Booking History Section -->
    {{-- <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking History</h2>
        @forelse($reservations as $reservation)
        <div class="flex flex-col md:flex-row items-center justify-between border-b border-gray-200 py-4">
            <div>
                <h3 class="font-medium text-gray-800">{{ $reservation->room->boardingHouse->name ?? 'N/A' }}</h3>
                <p class="text-sm text-gray-500">{{ $reservation->room->type ?? 'N/A' }}</p>
                <p class="text-sm text-gray-500">{{ $reservation->created_at->format('F d, Y') }}</p>
            </div>
            <span class="{{ $reservation->status == 'confirmed' ? 'text-green-600' : ($reservation->status == 'pending' ? 'text-yellow-600' : 'text-red-600') }} font-medium capitalize">
                {{ $reservation->status }}
            </span>
        </div>
        @empty
        <p class="text-gray-500">No booking history available.</p>
        @endforelse
    </div> --}}
</div>
@endsection
