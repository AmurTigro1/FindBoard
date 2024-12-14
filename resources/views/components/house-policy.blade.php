<div x-data="{ isEditing: false }" class="border mb-6 p-4 bg-white shadow-sm rounded-md">
    <!-- Display Mode -->
    <div x-show="!isEditing">
        @if($house->policies)
            <div class="flex justify-between items-center mb-2">
                <strong class="text-xl font-bold text-gray-800"></i>Policies</strong>
                <button @click="isEditing = true" class="text-blue-600 hover:text-blue-800 transition duration-150 text-sm">
                    <i class="fas fa-edit"></i> Edit
                </button>
            </div>
            <div class="policies-content overflow-hidden transition-all duration-300" id="policies" style="max-height: 6rem;">
                <p class="text-gray-600 text-sm leading-relaxed">{!! nl2br(e($house->policies)) !!}</p>
            </div>
            <button id="toggle-policies-button" class="text-sm text-blue-500 hover:text-blue-600 transition-colors mt-1" onclick="togglePolicies('policies', 'toggle-policies-button')" style="display: none;">Read more</button>
        @else
            <div class="flex justify-between items-center mb-2">
                <strong class="text-base font-medium text-gray-800">Policies</strong>
                <button @click="isEditing = true" class="text-blue-600 hover:text-blue-800 transition duration-150 text-sm">
                    <i class="fas fa-edit"></i> Edit
                </button>
            </div>
            <p class="text-gray-800 text-sm ">No policies available.</p>
        @endif
    </div>

    <!-- Edit Mode -->
    <form x-show="isEditing" x-cloak action="{{ route('boardinghouse.update-policies', $house->id) }}" method="POST">
        @csrf
        <div class="mb-2">
            <label for="policies" class="text-sm font-medium text-gray-800">Edit Policies</label>
            <textarea name="policies" id="policies" rows="5" class="w-full mt-1 border-gray-300 rounded-md shadow-sm transition duration-150 text-gray-800">{{ old('policies', $house->policies) }}</textarea>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-cyan-500 text-sm leading-4 font-medium rounded-md px-2 py-2 text-white shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">Save</button>
            <button type="button" @click="isEditing = false" class="text-gray-600 text-sm hover:underline">Cancel</button>
        </div>
    </form>
</div>

<script>
    function checkPoliciesLength() {
        const content = document.getElementById('policies');
        const button = document.getElementById('toggle-policies-button');
        if (content.scrollHeight > 96) {
            button.style.display = 'inline';
        }
    }

    function togglePolicies(sectionId, buttonId) {
        const content = document.getElementById(sectionId);
        const button = document.getElementById(buttonId);
        const isCollapsed = content.style.maxHeight === '6rem';
        content.style.maxHeight = isCollapsed ? content.scrollHeight + 'px' : '6rem';
        button.textContent = isCollapsed ? 'Show less' : 'Read more';
    }

    window.addEventListener('load', checkPoliciesLength);
</script>
