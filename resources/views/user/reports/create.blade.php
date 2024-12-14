@extends('main_resources.index')

@section('content')
<div class="p-4">
    <h2 class="text-2xl font-semibold mb-4">Submit a Report</h2>
    
    @if(session('success'))
    <div class="p-4 bg-green-500 text-white rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST" class="bg-white p-6 shadow-md rounded-lg">
        @csrf
        <div class="mb-4">
            <label for="captcha" class="block text-sm font-medium text-gray-700">CAPTCHA</label>
            <div>
                <img src="{{ captcha_src() }}" alt="CAPTCHA" class="mb-2 rounded">
                <button type="button" onclick="reloadCaptcha()" class="text-sm text-blue-600 underline">Reload CAPTCHA</button>
            </div>
            <input type="text" name="captcha" id="captcha" class="p-2 border rounded-lg w-full" placeholder="Enter CAPTCHA">
            @error('captcha')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        
        
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium">Title</label>
            <input type="text" name="title" id="title" 
                   class="w-full p-2 border rounded-lg @error('title') border-red-500 @enderror">
            @error('title')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea name="description" id="description" rows="4" 
                      class="w-full p-2 border rounded-lg @error('description') border-red-500 @enderror"></textarea>
            @error('description')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right">
            <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg">Submit</button>
        </div>
    </form>
</div>
@endsection


<script>
    function reloadCaptcha() {
        const captcha = document.querySelector('img[alt="CAPTCHA"]');
        captcha.src = "{{ captcha_src() }}?" + Math.random();
    }
</script>
