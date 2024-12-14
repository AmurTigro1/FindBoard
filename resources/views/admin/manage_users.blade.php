@extends('layouts.admin')

@section('content')
<div class="p-4 bg-gray-100 min-h-screen">

    @if(session('success'))
    <div id="success-message" class="fixed top-4 right-4 p-4 bg-green-500 text-white rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    <h1 class="text-3xl font-extrabold text-gray-900 ml-9">User List</h1>

    <!-- Search Form -->
    <form action="{{ route('admin.manage.users') }}" method="GET" class="flex justify-end space-x-2">
        <input type="text" name="search" value="{{ $searchQuery ?? '' }}" placeholder="Search"
               class="p-2 border rounded-lg w-64 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Search
        </button>
    </form>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{route('admin.users.create')}}" class="p-4 bg-green-500 text-white rounded-lg shadow-lg flex items-center justify-between">
                <span>Add New User</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
                </svg>
            </a>
        </div>

        @if($users->isEmpty())
            <div class="p-4 text-center text-gray-600">
                No users found for "{{ request('search') }}".
            </div>
        @else
            <div class="p-4 text-gray-600">
                Showing 
                <span class="font-semibold">{{ $users->firstItem() }}</span> - 
                <span class="font-semibold">{{ $users->lastItem() }}</span> 
                of 
                <span class="font-semibold">{{ $users->total() }}</span> users
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Created</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b hover:bg-gray-200">
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $user->name }}
                                    </a>
                                </td>                                
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($user->role) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('admin_users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
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
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const message = document.getElementById('success-message');
        if (message) {
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }
    });
</script>
