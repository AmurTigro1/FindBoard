@extends('main_resources.index')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center text-gray-800 mt-10">
    <div class="max-w-3xl w-full bg-white rounded-lg shadow-xl p-8">
        <h1 class="text-3xl font-semibold text-center mb-6 text-indigo-600">Verify Your Account</h1>
        <p class="text-center text-gray-500 mb-8">
            Complete the steps below to unlock the ability to create a boarding house.
        </p>

        <!-- Success or Error Messages -->
        @if (session('success'))
            <div class="bg-green-50 text-green-800 text-sm rounded-lg p-4 mb-4 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 text-red-800 text-sm rounded-lg p-4 mb-4 border border-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profile Photo Upload Section -->
           <!-- Verification Section -->
<div class="p-6 bg-gray-100 rounded-2xl shadow-md">
    <h3 class="text-xl font-semibold mb-4 text-indigo-600">Step 1: Upload Profile Photo</h3>
    @if (auth()->user()->profile_photo_path)
        <!-- Display Verification Status and Profile Photo -->
        <div class="flex flex-col items-center">
            <p class="text-green-500 mb-2 font-medium">Status: Verified</p>
            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="w-32 h-32 rounded-full border-4 border-green-500">
        </div>
    @else
        {{-- <!-- Photo not uploaded yet -->
        <form action="{{ route('verification.photo') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-600 mb-1">Upload Photo:</label>
                <input type="file" name="photo" id="photo" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-100 file:text-indigo-600 hover:file:bg-indigo-200 focus:ring-indigo-300">
            </div>
            @error('photo')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 rounded-lg transition">
                Upload Photo
            </button>
        </form> --}}

        <form action="{{ route('verification.photo') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-600 mb-1">Upload Photo:</label>
                <input type="file" name="photo" id="photo" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-100 file:text-indigo-600 hover:file:bg-indigo-200 focus:ring-indigo-300">
            </div>
            @error('photo')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 rounded-lg transition">
                Upload Photo
            </button>
        </form>
        
    @endif
</div>

            <!-- Phone Verification Section -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Step 2: Verify Phone Number</h3>
                @if (auth()->user()->phone_verified_at)
                    <div class="flex flex-col items-center">
                        <p class="text-green-500 mb-2 font-medium">Status: Verified</p>
                        <p class="text-gray-600">Phone Number: {{ auth()->user()->phone }}</p>
                    </div>
                @else
                    <form action="{{ route('verification.phone') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-600 mb-1">Enter Phone Number:</label>
                            <input type="text" name="phone" id="phone" class="w-full bg-white border border-gray-300 rounded-lg text-gray-700 px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-300" placeholder="e.g., 09123456789" value="{{ old('phone', auth()->user()->phone) }}" required>
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 rounded-lg transition">
                            Verify Phone
                        </button>
                    </form>
                @endif
            </div>

            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Step 3: Verify Business Permit</h3>
                
                @if (auth()->user()->business_permit_status === 'approved')
                    <div class="flex flex-col items-center">
                        <p class="text-green-500 mb-2 font-medium">Status: Verified</p>
                        <p class="text-gray-600">Business Permit: 
                            <a href="{{ asset('storage/' . auth()->user()->business_permit) }}" 
                               target="_blank" class="text-blue-500 underline">
                                View Document
                            </a>
                        </p>
                    </div>
                @elseif (auth()->user()->business_permit_status === 'approved')
                    <div class="flex flex-col items-center">
                        <p class="text-green-500 mb-2 font-medium">Status: Approved</p>
                        <p class="text-gray-600">Your business permit has been approved. Thank you for verifying!</p>
                    </div>
                @elseif (auth()->user()->business_permit && auth()->user()->business_permit_status === 'pending')
                    <div class="flex flex-col items-center">
                        <p class="text-yellow-500 mb-2 font-medium">Status: Pending Verification</p>
                        <p class="text-gray-600">Your business permit is under review. Please check back later.</p>
                    </div>
                @else
                    <div class="flex flex-col items-center">
                        <p class="text-red-500 mb-2 font-medium">Status: Not Uploaded</p>
                        <p class="text-gray-600">Please upload your business permit for verification.</p>
                    </div>
                    <form action="{{ route('verification.business_permit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="business_permit" class="block text-sm font-medium text-gray-700">Upload Business Permit</label>
                            <input type="file" name="business_permit" id="business_permit" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                   required>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-white hover:bg-indigo-700">
                            Submit for Verification
                        </button>
                    </form>
                @endif
            </div>
            
            
            
            {{-- <hr class="border-gray-200 my-8"> --}}
            
            <!-- Email Verification Section -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Step 4: Verify Email Address</h3>
                @if (auth()->user()->hasVerifiedEmail())
                    <div class="flex flex-col items-center">
                        <p class="text-green-500 mb-2 font-medium">Status: Verified</p>
                        <p class="text-gray-600">Email: {{ auth()->user()->email }}</p>
                    </div>
                @else
                    <form action="{{ route('verification.send') }}" method="POST" class="space-y-4">
                        @csrf
                        <p class="text-gray-600 mb-4">
                            Please verify your email address by clicking the link sent to <strong>{{ auth()->user()->email }}</strong>.
                        </p>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 rounded-lg transition">
                            Resend Verification Email
                        </button>
                    </form>
                    @if (session('resent'))
                        <p class="text-green-500 mt-4 text-sm">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                @endif
            </div>
            
            <hr class="border-gray-200 my-8">
            
<!-- Action Buttons -->
<div class="text-center mt-10 bg-gray-100 rounded-2xl shadow-md py-5">
    @if (
        auth()->user()->profile_photo_path &&
        auth()->user()->phone_verified_at &&
        auth()->user()->hasVerifiedEmail() &&
        auth()->user()->business_permit_status === 'approved'
    )
        <a href="{{ route('boardinghouse.create') }}" 
           class="inline-block bg-green-600 hover:bg-green-500 text-white py-3 px-6 rounded-lg transition shadow-md">
            Proceed to Create Boarding House
        </a>
    @else
        <p class="text-red-500 mb-4 font-medium">Complete all steps above to unlock the boarding house creation feature.</p>
    @endif
</div>

    </div>
</div>
@endsection
