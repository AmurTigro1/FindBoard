@extends('layouts.admin')

@section('content')
<!-- Use this as a reference -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Pending Business Permits</h1>

        @if ($landlords->isEmpty())
            <p class="text-gray-500 text-center">No pending business permits at this time.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Address</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Profile</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">Business Permit</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($landlords as $landlord)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $landlord->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $landlord->address }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $landlord->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $landlord->phone }}</td>
                                <td class="px-4 py-3">
                                    <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('default-avatar.png') }}" 
                                         alt="Profile Image" 
                                         class="w-10 h-10 rounded-full">
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ asset('storage/' . $landlord->business_permit) }}" 
                                       target="_blank" 
                                       class="text-blue-500 underline hover:text-blue-700">
                                        View Permit
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('business-permit.update', $landlord->id) }}" method="POST" class="inline-block" onsubmit="return confirmReject()">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="status" value="approved" 
                                                class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">
                                            Approve
                                        </button>
                                        <button type="submit" name="status" value="rejected" 
                                        class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-300">
                                        Reject
                                    </button>
                                </form>
                                
                                <script>
                                    function confirmReject() {
                                        return confirm('Are you sure you want to reject this reservation? This action cannot be undone.');
                                    }
                                </script>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
