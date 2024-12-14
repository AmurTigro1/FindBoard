<div class="flex p-4 rounded-md border  mb-6 bg-white shadow-sm">
    <div class="flex-1 lg:flex-[5]">
        <div class="flex justify-between">
            <h2 class="text-3xl font-black leading-tight text-gray-800">{{ $house->name }}</h2>
        </div>
        <div class="flex items-center space-x-2 mb-4">
            <p class="text-sm hover:underline text-gray-800">
                <i class="fas fa-map-marker-alt text-red-500"></i>
                {{ $house->address }}
                <a  href="https://www.google.com/maps?q={{ $house->latitude }},{{ $house->longitude }}" 
                    target="_blank" class="text-sm text-blue-500 hover:text-gray-500 transition-transform duration-200 transform hover:scale-105">
                    - view on Google Maps
                </a>
            </p>
        </div>
        <p class="text-sm text-gray-700 mt-4">Curfew Hour: {{ \Carbon\Carbon::parse($house->curfew)->format('h:i A') }}</p>

        <div class="rounded-md mt-6 inline-flex text-sm items-center space-x-1 px-2 py-1 font-bold
            {{ $house->gender === 'male only' ? 'bg-gradient-to-r from-cyan-400 to-cyan-600 text-white' : '' }}
            {{ $house->gender === 'female only' ? 'bg-gradient-to-r from-pink-400 to-pink-600 text-white' : '' }}
            {{ $house->gender === 'male and female' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : '' }}">
            @if($house->gender === 'male only')
                <i class="fas fa-mars"></i>
            @elseif($house->gender === 'female only')
                <i class="fas fa-venus"></i>
            @else
                <i class="fas fa-venus-mars"></i>
            @endif
            <span>{{ ucfirst($house->gender) }}</span>
        </div>
    </div>
    <div class="flex flex-1 flex-col justify-center items-center space-y-1 border-l pl-4">
        <strong class="text-[50px] text-gray-800 font-extrabold">
            {{ number_format($house->averageRating() ?? 0, 1) }}
        </strong>
        <div class="flex">
            @for($i = 1; $i <= 5; $i++)
                <svg
                    class="w-4 h-4 {{ $i <= $house->averageRating() ? 'text-yellow-400' : 'text-gray-300' }} transition-transform duration-200 hover:scale-110"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 .587l3.668 7.431L23.327 9.9l-5.327 5.176 1.257 7.337L12 18.896l-6.927 3.517 1.257-7.337L.673 9.9l7.659-1.882L12 .587z" />
                </svg>
            @endfor
        </div>
        <p class="text-sm text-gray-500">({{ $house->reviews()->count() }} reviews)</p>
    </div>

</div>
