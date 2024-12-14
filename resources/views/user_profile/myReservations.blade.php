@extends('layouts.sidebar-header')

@section('content')
<div class="container mx-auto py-8 overflow-auto">
<!-- Breadcrumbs -->
<nav class="mb-6">
    <ol class="flex text-sm font-medium text-gray-500">
        <li>
            <a href="/" class="hover:text-blue-600">Home</a>
        </li>
        <li class="mx-2">/</li>
        <li class="text-blue-600 font-semibol">My Reservations</li>
    </ol>
</nav>


    <h1 class="text-3xl font-bold mb-6">My Reservations</h1>
    @foreach($reservations as $reservation)
    @if($reservation->status == 'accepted')
        <a href="{{ route('reservation.download', $reservation->id) }}" class="btn btn-primary">Download Reservation Details</a>

        <a href="{{ route('reservation.receipt.download', $reservation->id) }}" class="btn btn-success">Download Receipt</a>
    @endif
@endforeach


    @if ($reservations->isEmpty())
        <div class="text-lg text-gray-700">
            You have no active reservations.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Table -->
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-4 border-b text-sm font-semibold text-gray-600">Boarding Image</th>
                        <th class="p-4 border-b text-sm font-semibold text-gray-600">Room Image</th>
                        <th class="p-4 border-b text-sm font-semibold text-gray-600">Room Number</th>
                        <th class="p-4 border-b text-sm font-semibold text-gray-600">Name</th>
                        <th class="p-4 border-b text-sm font-semibold text-gray-600">Visit Date</th>
                        <th class="p-4 border-b text-sm font-semibold text-gray-600">Visit Time</th>
                        <th class="p-4 border-b text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-center border-b text-sm font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr class="hover:bg-gray-50">
                            <!-- Boarding House Image -->
                            <td class="p-4 border-b">
                                @if ($reservation->room->boardingHouse->images->isNotEmpty())
                                    <img class="w-16 h-16 object-cover rounded" 
                                         src="{{ asset('storage/' . $reservation->room->boardingHouse->images->first()->other_photo_path) }}" 
                                         alt="Boarding House Image">
                                @else
                                    <span class="text-gray-500">No image available</span>
                                @endif
                            </td>

                      
                            <!-- Room Image -->
                            <td class="p-4 border-b">
                                @if ($reservation->room->thumbnail_image)
                                    <img class="w-16 h-16 object-cover rounded" 
                                         src="{{ asset('storage/' . $reservation->room->thumbnail_image) }}" 
                                         alt="Room Image">
                                @else
                                    <span class="text-gray-500">No image available</span>
                                @endif
                            </td>
                            <!-- Room Number -->
                            <td class="p-4 border-b text-center">{{ $reservation->room->id }}</td>

                            <!-- Reservation Details -->
                            <td class="p-4 border-b">{{ $reservation->name }}</td>
                            <td class="p-4 border-b">{{ $reservation->visit_date }}</td>
                            <td class="p-4 border-b">{{ $reservation->visit_time }}</td>
                            <td class="p-4 border-b capitalize 
                            @if ($reservation->status === 'accepted') 
                                text-green-500 
                            @elseif ($reservation->status === 'pending') 
                                text-yellow-500 
                            @elseif ($reservation->status === 'declined') 
                                text-red-500 
                            @endif">
                            {{ $reservation->status }}
                        </td>
                        
                            
                            <!-- Action: Cancel Reservation Button -->
                            <td class="p-4 border-b">
                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500 px-4 py-2 rounded hover:bg-red-600">
                                        Cancel Reservation
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination & Entry Info -->
            <div class="flex justify-between items-center mt-4">
                <!-- Showing info -->
                <div class="text-sm text-gray-600">
                    Showing 
                    <span class="font-semibold">{{ $reservations->firstItem() }}</span> 
                    to 
                    <span class="font-semibold">{{ $reservations->lastItem() }}</span> 
                    of 
                    <span class="font-semibold">{{ $reservations->total() }}</span> entries
                </div>

                <!-- Pagination Links -->
                <div class="flex space-x-2">
                    {{ $reservations->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
