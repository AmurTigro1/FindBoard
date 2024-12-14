@extends('layouts.admin')
@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 p-4 bg-green-500 text-white rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif
    <h2 class="text-2xl font-semibold mb-4">List of Properties</h2>

    <!-- Search Form -->
    <form action="{{ route('admin.manage.listings') }}" method="GET" class="mb-4 flex justify-end">
        <input type="text" name="search" value="{{ $searchQuery ?? '' }}" placeholder="Search"
               class="p-2 border rounded-lg w-64 mr-2">
        <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg">Search</button>
    </form>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if($listings->isEmpty())
            <div class="p-4 text-center text-gray-600">
                No properties found for "{{ request('search') }}".
            </div>
        @else
            <div class="p-4 text-gray-600">
                Showing 
                <span class="font-semibold">{{ $listings->firstItem() }}</span> - 
                <span class="font-semibold">{{ $listings->lastItem() }}</span> 
                of 
                <span class="font-semibold">{{ $listings->total() }}</span> properties
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Owner</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Address</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Created</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listings as $listing)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-800">{{ ($listings->currentPage() - 1) * $listings->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $listing->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $listing->user->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $listing->address }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $listing->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('admin_properties.destroy', $listing->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this boarding house? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-400">
                                            <img src="{{ asset('trash.png') }}" alt="Delete" class="w-5 h-5 mr-1">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $listings->links() }}
    </div>
</div>

@endsection

<script>
    window.onload = function() {
        const message = document.getElementById('success-message');
        if (message) {
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }
    };
</script>