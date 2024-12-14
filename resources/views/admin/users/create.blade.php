@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h2 class="text-2xl font-semibold mb-4">Add New User</h2>

    <!-- Success Message -->
    @if(session('success'))
    <div id="success-message" class="p-4 bg-green-500 text-white rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 shadow-md rounded-lg">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   class="p-2 border rounded-lg w-full @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                   class="p-2 border rounded-lg w-full @error('email') border-red-500 @enderror">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <!-- Addess form -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}" 
                   class="p-2 border rounded-lg w-full @error('address') border-red-500 @enderror">
            @error('address')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <!-- Phone Number -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                   class="p-2 border rounded-lg w-full @error('phone') border-red-500 @enderror">
            @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" 
                   class="p-2 border rounded-lg w-full @error('password') border-red-500 @enderror">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="p-2 border rounded-lg w-full">
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="p-2 border rounded-lg w-full @error('role') border-red-500 @enderror">
                <option value="" disabled selected>Select Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg">Add User</button>
        </div>
    </form>
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