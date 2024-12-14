@extends('layouts.admin')

@section('content')
<!-- Breadcrumb -->
<nav class="mb-6 ml-6" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-4 text-gray-600">
        <li>
            <a href="{{route('admin.manage.users')}}" class="text-gray-600 hover:text-blue-800">
             Users
            </a>
        </li>
        <li>
            <span class="text-gray-400">/</span>
        </li>
        <li class="text-blue-500">Rooms</li>
    </ol>
</nav>
<div class="p-4 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-900">User Details: {{ $user->name }}</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <h2 class="text-2xl font-semibold">User Information</h2>
        <p class="text-lg text-gray-600">Email: {{ $user->email }}</p>
        <p class="text-lg text-gray-600">Role: {{ ucfirst($user->role) }}</p>
        <p class="text-lg text-gray-600">Joined: {{ $user->created_at->format('M d, Y') }}</p>
    </div>

    <h2 class="text-2xl font-semibold mt-8">Boarding Houses Listed</h2>
    @if($user->boardingHouses->isEmpty())
        <p class="text-gray-600">No boarding houses listed by this user.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
            @foreach ($user->boardingHouses as $boardingHouse)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">{{ $boardingHouse->name }}</h3>
                    <p class="text-sm text-gray-600">Address: {{ $boardingHouse->address }}</p>
                    <p class="text-sm text-gray-600">Description: {{ $boardingHouse->description }}</p>

                    <h4 class="text-lg font-semibold mt-4">Rooms</h4>
                    @if($boardingHouse->rooms->isEmpty())
                        <p class="text-gray-600">No rooms listed for this boarding house.</p>
                    @else
                        <ul class="mt-2">
                            @foreach ($boardingHouse->rooms as $room)
                                <li class="text-sm text-gray-700">{{ $room->type }} - Price: {{ $room->price }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection