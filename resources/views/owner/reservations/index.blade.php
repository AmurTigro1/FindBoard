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
            <li class="text-blue-600">
                <a href="{{ route('reservations.index') }}" class="hover:text-blue-600">Reservations</a>
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold mb-6">Reservations</h1>

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <div class="mb-6 flex justify-between items-center">
        <form action="{{ route('reservations.index') }}" method="GET" class="flex items-center w-1/2 space-x-2">
            <input type="text" name="search" value="{{ request()->search }}" 
                   class="w-full border border-gray-300 px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Search by name or room">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 transition">
                Search
            </button>
        </form>
        <div class="ml-6">
            <a href="{{ route('reservations.accepted') }}" 
               class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 hover:text-blue-500 {{ request()->routeIs('reservations.accepted') ? 'text-white bg-blue-500' : 'text-gray-600' }}">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16"></path>
                </svg>
                Accepted Reservations
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <table class="min-w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-visible shadow-lg">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">BH Name</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">Room</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">Name</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">Contact #</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">Email</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">Visit Date</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">Visit Time</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-gray-700">Status</th>
                    <th class="p-4 border-b border-gray-300 text-sm font-semibold text-center text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $reservation)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b border-gray-300">{{ $reservation->room->boardingHouse->name }}</td>
                        <td class="p-4 border-b border-gray-300">{{ $reservation->room->id }}</td>
                        <td class="p-4 border-b border-gray-300">{{ $reservation->name }}</td>
                        <td class="p-4 border-b border-gray-300">{{ $reservation->user->phone }}</td>
                        <td class="p-4 border-b border-gray-300">{{ $reservation->user->email }}</td>
                        <td class="p-4 border-b border-gray-300">{{ $reservation->visit_date }}</td>
                        <td class="p-4 border-b border-gray-300">{{ $reservation->visit_time }}</td>
                        <td class="p-4 border-b border-gray-300 capitalize 
                            @if ($reservation->status === 'accepted') 
                                text-green-600 
                            @elseif ($reservation->status === 'pending') 
                                text-yellow-600 
                            @elseif ($reservation->status === 'declined') 
                                text-red-600 
                            @endif">
                            {{ $reservation->status }}
                        </td>
                        <td class="p-4 border-b border-gray-300 text-center">
                            <div class="relative inline-block overflow-visible">
                                <button 
                                    class="bg-gray-100 text-gray-600 px-4 py-2 rounded shadow-sm hover:bg-gray-200 transition focus:outline-none"
                                    id="actionMenuButton"
                                    onclick="toggleMenu(this)">
                                    Actions
                                </button>
                                <div 
                                    class="absolute top-full right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50" 
                                    id="actionMenu">
                                    @if ($reservation->status === 'pending')
                                        <form action="{{ route('reservations.accept', $reservation) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-100">Accept</button>
                                        </form>
                                        <form action="{{ route('reservations.decline', $reservation) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-100">Decline</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                            Delete
                                        </button>
                                    </form>
                                    
                                    <script>
                                        function confirmDelete() {
                                            return confirm('Are you sure you want to delete this reservation? This action cannot be undone.');
                                        }
                                    </script>
                                    
                                </div>
                            </div>
                        </td>
                        
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-500">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        

        <!-- Showing X to Y of Z entries -->
        <div class="mt-4">
            <p class="text-sm text-gray-700">
                Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of {{ $reservations->total() }} entries
            </p>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reservations->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
<script>
    function toggleMenu(button) {
    const menu = button.nextElementSibling;
    menu.classList.toggle('hidden');
    document.addEventListener('click', (event) => {
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    }, { once: true });
}

</script>