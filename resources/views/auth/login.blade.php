@extends('main_resources.index')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-md">
        <!-- Logo Section -->
        <div class="flex justify-center mb-6">
            <a href="/" class="text-blue-600 font-bold text-2xl">FindBoard</a>
        </div>
        <!-- Validation Errors -->
        @if ($errors->any())
        
            <div class="text-red-600 font-medium">
                Whoops! Something went wrong.
            </div>
        
        
        @endif

        <!-- Success Message -->
        @if (session('status'))
        <div class="mb-4 text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-indigo-600 text-gray-800 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-indigo-600 text-gray-800 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Forgot your password?</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 mt-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none">Log
                    in</button>
            </div>
        </form>

        <!-- Sign Up Link -->
        <div class="mt-6 text-center">
            <span class="text-sm text-gray-600">Don't have an account? </span>
            <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Sign up</a>
        </div>
    </div>
</div>
@endsection