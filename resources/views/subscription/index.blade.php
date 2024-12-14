@extends('main_resources.index')

@section('content')
<div class="max-w-screen-xl mx-auto px-8 py-16">
    <!-- Page Title -->
    <h2 class="text-5xl font-extrabold text-center text-gray-900 mb-12 tracking-tight">
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

    <!-- FAQ Section -->
    <div class="mt-16 bg-gray-100 p-12 rounded-3xl shadow-lg">
        <h3 class="text-3xl font-bold text-center text-gray-900 mb-6">Frequently Asked Questions</h3>
        <div class="space-y-8">
            <div class="flex items-start space-x-4">
                <div class="text-2xl text-blue-500">Q:</div>
                <div class="text-lg text-gray-700">
                    <p class="font-semibold">What’s included in each plan?</p>
                    <p class="text-gray-600">Each plan includes a different set of features. The Basic Plan is free and suitable for small-scale users, while the Pro and Premium Plans provide more advanced features and support for larger businesses.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="text-2xl text-blue-500">Q:</div>
                <div class="text-lg text-gray-700">
                    <p class="font-semibold">Can I upgrade my plan later?</p>
                    <p class="text-gray-600">Yes! You can easily upgrade your plan through your user dashboard. Any unused portion of your current plan will be credited towards your new plan.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="text-2xl text-blue-500">Q:</div>
                <div class="text-lg text-gray-700">
                    <p class="font-semibold">Do you offer a money-back guarantee?</p>
                    <p class="text-gray-600">Yes, we offer a 7-day money-back guarantee for all paid plans. If you're not satisfied, we'll refund you within the first 7 days.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="mt-16 text-center">
        <h3 class="text-3xl font-bold text-gray-900 mb-6">What Our Users Say</h3>
        <div class="flex justify-center gap-12">
            <div class="w-1/3 p-8 bg-white rounded-xl shadow-xl transform transition hover:scale-105">
                <p class="text-gray-600 mb-4">"This platform revolutionized how I manage multiple properties. It’s so easy to use and saves me a lot of time!"</p>
                <p class="font-semibold text-gray-900">John D.</p>
                <p class="text-gray-500">Boarding House Owner</p>
            </div>
            <div class="w-1/3 p-8 bg-white rounded-xl shadow-xl transform transition hover:scale-105">
                <p class="text-gray-600 mb-4">"The Pro Plan was a game-changer! My workflow is much more efficient now that I can manage all my boarding houses in one place."</p>
                <p class="font-semibold text-gray-900">Jane S.</p>
                <p class="text-gray-500">Property Manager</p>
            </div>
        </div>
    </div>

    <!-- Contact Form Section -->
    {{-- <div class="mt-16 bg-gray-200 p-12 rounded-3xl shadow-lg">
        <h3 class="text-3xl font-bold text-center text-gray-900 mb-6">Have Questions? Reach Out!</h3>
        <form action="" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div>
                    <label for="name" class="block text-gray-800 font-semibold">Your Name</label>
                    <input type="text" id="name" name="name" class="w-full p-4 rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label for="email" class="block text-gray-800 font-semibold">Your Email</label>
                    <input type="email" id="email" name="email" class="w-full p-4 rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>
            <div class="mt-6">
                <label for="message" class="block text-gray-800 font-semibold">Your Message</label>
                <textarea id="message" name="message" class="w-full p-4 rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500" rows="4" required></textarea>
            </div>
            <button type="submit" class="mt-6 bg-blue-600 text-white py-3 px-8 rounded-full text-lg font-semibold transition-all hover:bg-blue-700">
                Submit
            </button>
        </form>
    </div> --}}
</div>
@endsection
