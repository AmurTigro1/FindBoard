@extends('layouts.sidebar-header')

@section('content')
<div class="container mx-auto py-8">
    <!-- Breadcrumbs -->
    <nav class="mb-4">
        <ol class="flex text-sm font-medium text-gray-500">
            <li>
                <a href="{{route('profile')}}" class="hover:text-blue-600">Home</a>
            </li>
            <li class="mx-2">/</li>
            <li>
                <a href="{{ route('reservations.index') }}" class="hover:text-blue-600">Reservations</a>
            </li>
            <li class="mx-2">/</li>
            <li class="text-blue-500">Accepted Reservations</li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold mb-6">Accepted Reservations</h1>

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white rounded-lg shadow-lg p-6">
        <table class="min-w-full table-auto border-collapse shadow-lg rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-sm font-medium text-gray-700">
                    <th class="px-4 py-2 text-left">Boarding Image</th> 
                    <th class="px-4 py-2 text-left">Room Image</th>
                    <th class="px-4 py-2 text-left">Room #</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Contact #</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Visit Date</th>
                    <th class="px-4 py-2 text-left">Visit Time</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Actions</th> 
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($acceptedReservations as $reservation)
                    <tr class="border-b">
                        <!-- Display Boarding House Image -->
                        <td class="px-4 py-2 text-center">
                            @if ($reservation->room->boardingHouse->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $reservation->room->boardingHouse->images->first()->other_photo_path) }}" 
                                     alt="Boarding House Image" class="w-16 h-16 object-cover rounded">
                            @else
                                <span>No image available</span>
                            @endif
                        </td>
    
                        <!-- Display Room Image -->
                        <td class="px-4 py-2 text-center">
                            @if ($reservation->room->thumbnail_image)
                                <img src="{{ asset('storage/' . $reservation->room->thumbnail_image) }}" 
                                     alt="Room Image" class="w-16 h-16 object-cover rounded">
                            @else
                                <span>No image available</span>
                            @endif
                        </td>
    
                        <!-- Reservation Details -->
                        <td class="px-4 py-2">{{ $reservation->room->id }}</td>
                        <td class="px-4 py-2">{{ $reservation->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->user->phone }}</td>
                        <td class="px-4 py-2">{{ $reservation->user->email }}</td>
                        <td class="px-4 py-2">{{ $reservation->visit_date }}</td>
                        <td class="px-4 py-2">{{ $reservation->visit_time }}</td>
                        <td class="px-4 py-2 capitalize
                            @if ($reservation->status === 'accepted') 
                                text-green-500 
                            @elseif ($reservation->status === 'pending') 
                                text-yellow-500 
                            @elseif ($reservation->status === 'declined') 
                                text-red-500 
                            @endif">
                            {{ $reservation->status }}
                        </td>
    
                        <!-- Delete Button -->
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('reservations.accepted_destroy', $reservation->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <span class="material-icons">Delete</span> <!-- You can replace this with a text or icon for delete -->
                                </button>
                            </form>
                            <script>
                                function confirmDelete() {
                                    return confirm('Are you sure you want to delete this accepted reservation? This action cannot be undone.');
                                }
                            </script>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">No accepted reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
       <!-- Showing X to Y of Z entries -->
       <div class="mt-4">
        <p class="text-sm text-gray-700">
            Showing {{ $acceptedReservations->firstItem() }} to {{ $acceptedReservations->lastItem() }} of {{ $acceptedReservations->total() }} entries
        </p>
    </div>

        <!-- Pagination -->
         <div class="mt-4">
        {{ $acceptedReservations->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
