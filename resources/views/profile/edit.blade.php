@extends('layouts.sidebar-header')
@section('title', 'FindBoard')

@section('content')

        {{-- Success Message --}}
        @if(!empty($success))
        <div class="mb-4 px-4 py-3 text-green-800 bg-green-100 border border-green-200 rounded">
            {{ $success }}
        </div>
    @endif


    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
             <!-- Breadcrumbs -->
    <nav class="mb-4">
        <ol class="flex text-sm font-medium text-gray-500">
            <li>
                <a href="/" class="hover:text-blue-600">Home</a>
            </li>
            <li class="mx-2">/</li>
            <li>
                <a href="{{ route('profile') }}" class="hover:text-blue-600">Profile</a>
            </li>
            <li class="mx-2">/</li>
            <li class="text-blue-600">
                <a href="{{ route('profile.edit') }}" class="hover:text-blue-600">Edit</a>
            </li>
        </ol>
    </nav>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

@endsection
