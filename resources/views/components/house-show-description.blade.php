<div class="border mb-6 p-6 bg-white shadow-sm rounded-md">
    <!-- Display Mode -->
    <div>
        @if($house->description)
            <h3 class="text-xl font-bold text-gray-800 mb-4">About this place</h3>
            <div class="description-content text-gray-600 text-sm leading-relaxed transition-all duration-300 overflow-hidden" id="description" style="max-height: 4.5rem;">
                {!! nl2br(e($house->description)) !!}
            </div>
            <button id="toggle-button" class="text-sm text-blue-500 hover:text-blue-600 transition-colors mt-2 flex items-center" onclick="toggleDescription('description')" style="display: none;">
                <span>Show more</span>
                <svg class="ml-1 w-4 h-4 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @else
            <h3 class="text-xl font-bold text-gray-800 mb-2">About this place</h3>
            <p class="text-gray-500 text-sm">No description available.</p>
        @endif
    </div>
</div>

<script>
    function checkDescriptionLength() {
        const content = document.getElementById('description');
        const button = document.getElementById('toggle-button');
        if (content.scrollHeight > 72) { // Adjusted height to match ~3 lines of text
            button.style.display = 'inline-flex';
        }
    }

    function toggleDescription(sectionId) {
        const content = document.getElementById(sectionId);
        const button = document.getElementById('toggle-button');
        const isCollapsed = content.style.maxHeight === '4.5rem';
        content.style.maxHeight = isCollapsed ? content.scrollHeight + 'px' : '4.5rem';
        button.querySelector('span').textContent = isCollapsed ? 'Show less' : 'Show more';
        button.querySelector('svg').classList.toggle('rotate-180', !isCollapsed);
    }

    window.addEventListener('load', checkDescriptionLength);
</script>
