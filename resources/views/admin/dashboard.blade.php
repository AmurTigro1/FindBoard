@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    @if(session('success'))
    <div id="success-message" class="fixed top-4 right-4 p-4 bg-green-500 text-white rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-700">Admin Dashboard</h1>
        <p class="text-sm text-gray-500">Welcome back! Here's an overview of the platform's current activity.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="p-6 bg-white shadow-md rounded-lg text-center">
            <h3 class="text-sm font-semibold text-gray-500">Total Users</h3>
            <p class="text-4xl font-bold text-blue-600">{{$totalUsers}}</p>
      
        </div>
        <div class="p-6 bg-white shadow-md rounded-lg text-center">
            <h3 class="text-sm font-semibold text-gray-500">Total Listings</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $totalListings }}</p>

        </div>
        <div class="p-6 bg-white shadow-md rounded-lg text-center">
            <h3 class="text-sm font-semibold text-gray-500">Pending Business Permit</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $pendingPermits }}</p>

        </div>
        <div class="p-6 bg-white shadow-md rounded-lg text-center">
            <h3 class="text-sm font-semibold text-gray-500">Revenue</h3>
            <p class="text-4xl font-bold text-green-600">₱{{ number_format($revenue['totalRevenue'], 2) }}</p>
            <p class="text-4xl font-bold text-green-600"></p>
        </div>
    </div>

  
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h3 class="text-sm font-semibold text-gray-500">User Growth</h3>
        <canvas id="userGrowthChart"></canvas>
    </div>
    
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h3 class="text-sm font-semibold text-gray-500">Revenue Growth</h3>
        <canvas id="revenueChart"></canvas>
    </div>
    
    <script>
        const userGrowthChart = document.getElementById('userGrowthChart');
        const revenueChart = document.getElementById('revenueChart');
    
        new Chart(userGrowthChart, {
            type: 'line',
            data: {
                labels: {!! json_encode($userGrowthLabels) !!},
                datasets: [{
                    label: 'New Users',
                    data: {!! json_encode($userGrowthData) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }]
            }
        });
    
        new Chart(revenueChart, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Revenue (₱)',
                    data: {!! json_encode($revenueData) !!},
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }]
            }
        });
    </script>
    
    <!-- Recent Activity -->
    {{-- <div class="p-6 bg-white shadow-md rounded-lg">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Activity</h3>
        <ul class="space-y-4">
            @foreach($recentActivities as $activity)
            <li class="flex justify-between items-center border-b pb-2">
                <div class="text-sm text-gray-600">
                    {{ $activity->description }}
                </div>
                <span class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
            @endforeach
        </ul>
    </div> --}}
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');

        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($userGrowthLabels) !!},
                datasets: [{
                    label: 'Users',
                    data: {!! json_encode($userGrowthData) !!},
                    borderColor: '#1D4ED8',
                    backgroundColor: 'rgba(29, 78, 216, 0.1)',
                    fill: true,
                }]
            }
        });

        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($revenueData) !!},
                    backgroundColor: '#10B981',
                }]
            }
        });

        const message = document.getElementById('success-message');
        if (message) {
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }
    });
</script>
