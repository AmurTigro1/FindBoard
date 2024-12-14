@extends('layouts.sidebar-header')

@section('content')
<div class="container mx-auto px-6 py-8">
{{-- Trial Message Popup --}}
@if(session('trial_message'))
    <div id="trialMessage" class="fixed bottom-10 right-10 bg-green-600 text-white p-4 rounded-xl shadow-xl transform transition-all duration-300 ease-in-out opacity-100 scale-100 hover:scale-105 hover:opacity-95">
        <a href="{{ route('free-trial') }}" class="text-white font-semibold underline text-lg">
            {{ session('trial_message') }}
        </a>
    </div>

    <script>
        // Display the message and hide it after 3 seconds
        setTimeout(() => {
            const message = document.getElementById('trialMessage');
            if (message) {
                message.style.display = 'none';
            }
        }, 3000);
    </script>
@endif

{{-- Trial Status Message --}}
@if ($trialStatus)
    <div class="bg-gradient-to-r from-blue-500 to-teal-500 text-white p-6 rounded-xl shadow-lg mb-6">
        <h3 class="text-2xl font-bold">{{ $trialStatus }}</h3>
        @if ($remainingDays > 0)
            <p class="mt-2 text-xl">Remaining Days: <span class="font-semibold text-yellow-300">{{ $remainingDays }}</span></p>
        @else
            <p class="mt-2 text-xl font-semibold text-red-400">Trial expired.</p>
        @endif
    </div>
@endif

{{-- @if($subscriptionDetails)
    <div class="p-6 bg-white shadow-md rounded-lg mt-6">
        <!-- Subscription Plan Section -->
        <h3 class="text-lg font-semibold text-gray-700">Subscription Plan</h3>
        <p class="text-sm text-gray-500">Plan: <span class="font-bold text-blue-600">{{ $subscriptionDetails['plan_name'] }}</span></p>
        <p class="text-sm text-gray-500">Ends on: <span class="font-bold text-green-600">{{ \Carbon\Carbon::parse($subscriptionDetails['end_date'])->format('F j, Y') }}</span></p>
        <p class="text-sm text-gray-500">Days Remaining: <span class="font-bold text-red-600">{{ $subscriptionDetails['remaining_days'] }}</span></p>
        <p class="text-sm text-gray-500">Boarding Houses Allowed: <span class="font-bold">{{ $subscriptionDetails['max_boarding_houses'] }}</span></p>
        <p class="text-sm text-gray-500">Rooms Allowed: <span class="font-bold">{{ $subscriptionDetails['max_rooms'] }}</span></p>
    </div>
@else
    <div class="p-6 bg-white shadow-md rounded-lg mt-6">
        <!-- No Subscription Section -->
        <h3 class="text-lg font-semibold text-gray-700">No Subscription Plan</h3>
        <p class="text-sm text-gray-500">You currently don't have an active subscription plan.</p>
        <p class="text-sm text-gray-500">Explore our subscription plans to unlock additional features.</p>
        <a href="{{ route('subscriptions.index') }}" class="text-blue-600 font-semibold underline hover:text-blue-800">
            View Plans
        </a>
    </div>
@endif --}}
@if($subscriptionDetails)
    <div class="p-6 bg-white shadow-md rounded-lg mt-6">
        <!-- Subscription Plan Section -->
        <h3 class="text-lg font-semibold text-gray-700">Subscription Plan</h3>
        <p class="text-sm text-gray-500">Plan: <span class="font-bold text-blue-600">{{ $subscriptionDetails['plan_name'] }}</span></p>
        <p class="text-sm text-gray-500">Ends on: <span class="font-bold text-green-600">{{ \Carbon\Carbon::parse($subscriptionDetails['end_date'])->format('F j, Y') }}</span></p>
        <p class="text-sm text-gray-500">Days Remaining: <span class="font-bold text-red-600">{{ $subscriptionDetails['remaining_days'] }}</span></p>
        <p class="text-sm text-gray-500">Boarding Houses Allowed: <span class="font-bold">{{ $subscriptionDetails['max_boarding_houses'] }}</span></p>
        <p class="text-sm text-gray-500">Rooms Allowed: <span class="font-bold">{{ $subscriptionDetails['max_rooms'] }}</span></p>
    </div>
@else
    <div class="p-6 bg-white shadow-md rounded-lg mt-6">
        <!-- No Active Subscription Section -->
        <h3 class="text-lg font-semibold text-gray-700">No Active Subscription Plan</h3>
        <p class="text-sm text-gray-500">Your subscription has expired or you currently don't have an active subscription plan.</p>
        <a href="{{ route('subscriptions.index') }}" class="text-blue-600 font-semibold underline hover:text-blue-800">
            View Plans
        </a>
    </div>
@endif

{{-- Free Trial Section --}}
<div class="container max-w-4xl mx-auto p-6">
    <div class="text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Your Free Trial</h1>
        
        {{-- Check if the remaining days are positive or expired --}}
        @if ($remainingDays > 0)
            <p class="text-2xl text-gray-800 font-medium">
                <span class="text-green-500">{{ $remainingDays }}</span> remaining in your trial.
            </p>
        @else
            <p class="text-xl text-red-500 font-semibold">Your trial has expired.</p>
        @endif
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Page Title -->
    <h2 class="text-3xl md:text-5xl font-extrabold text-center text-gray-900 mb-12 tracking-tight">
        Choose the Perfect Subscription Plan
    </h2>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mb-6 text-center text-green-600">
            {{ session('success') }}
        </div>
    @elseif ($errors->any())
        <div class="mb-6 text-center text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Plan Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Basic Plan -->
        <div class="bg-gradient-to-tl from-indigo-500 via-purple-500 to-pink-500 p-8 rounded-3xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl">
            <h3 class="text-3xl font-bold text-white mb-4">Basic Plan</h3>
            <p class="text-lg text-gray-100 mb-4">1 Boarding House | 2 Rooms</p>
            <p class="text-lg text-gray-200 mb-6">Duration: 7 Days</p>
            <div class="flex justify-between items-center">
                <span class="text-xl text-white font-semibold">Free</span>
                <form action="{{ route('subscriptions.subscribe') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan_name" value="basic">
                    <input type="hidden" name="price" value="0"> <!-- Free Plan -->
                    <button type="submit" disabled class="bg-white text-indigo-600 py-2 px-6 rounded-lg font-semibold shadow-md hover:bg-indigo-100 transition duration-200">
                        Free
                    </button>
                </form>
            </div>
        </div>

        @php
        $plans = [
            'pro' => [
                'name' => 'Pro Plan',
                'description' => '2 Boarding Houses | 3 Rooms',
                'duration' => '60 Days',
                'price' => 100000, // Price in cents (PHP 1,000)
                'color' => 'from-blue-500 via-teal-500 to-green-500',
                'button_color' => 'text-teal-600 hover:bg-teal-100',
            ],
            'premium' => [
                'name' => 'Premium Plan',
                'description' => '3 Boarding Houses | 5 Rooms',
                'duration' => '90 Days',
                'price' => 150000, // Price in cents (PHP 1,500)
                'color' => 'from-pink-500 via-red-500 to-yellow-500',
                'button_color' => 'text-red-600 hover:bg-red-100',
            ],
        ];
        @endphp

        @foreach ($plans as $key => $plan)
            <div class="bg-gradient-to-tl {{ $plan['color'] }} p-8 rounded-3xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                <h3 class="text-3xl font-bold text-white mb-4">{{ $plan['name'] }}</h3>
                <p class="text-lg text-gray-100 mb-4">{{ $plan['description'] }}</p>
                <p class="text-lg text-gray-200 mb-6">Duration: {{ $plan['duration'] }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xl text-white font-semibold">₱{{ number_format($plan['price'] / 100, 2) }}</span>
                    <form action="{{ route('subscriptions.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_name" value="{{ $key }}">
                        <button type="submit" class="bg-white py-2 px-6 rounded-lg font-semibold shadow-md {{ $plan['button_color'] }} transition duration-200">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
<!-- Testimonials Section -->
<div class="mt-16 text-center">
    <h3 class="text-3xl font-bold text-gray-900 mb-6">What Our Users Say</h3>
    <div class="flex flex-col md:flex-row md:justify-center gap-6 md:gap-12">
        <div class="w-full md:w-1/3 p-6 md:p-8 bg-white rounded-xl shadow-xl transform transition hover:scale-105">
            <p class="text-gray-600 mb-4">"This platform revolutionized how I manage multiple properties. It’s so easy to use and saves me a lot of time!"</p>
            <p class="font-semibold text-gray-900">John D.</p>
            <p class="text-gray-500">Boarding House Owner</p>
        </div>
        <div class="w-full md:w-1/3 p-6 md:p-8 bg-white rounded-xl shadow-xl transform transition hover:scale-105">
            <p class="text-gray-600 mb-4">"The Pro Plan was a game-changer! My workflow is much more efficient now that I can manage all my boarding houses in one place."</p>
            <p class="font-semibold text-gray-900">Jane S.</p>
            <p class="text-gray-500">Property Manager</p>
        </div>
    </div>
</div>


</div>

</div>
@endsection
