<div class="border p-2 mb-2 bg-white shadow-sm rounded-md">
    <form id="reviewForm" method="POST" action="{{ route('reviews.store', $house->id) }}" class="space-y-4">
        @csrf
        <div class="flex items-center mb-2">
            <label class="block text-gray-700 font-semibold">Rate:</label>
            <div class="flex items-center ml-4 star-rating">
                <label class="star text-2xl cursor-pointer" data-value="5">&#9733;</label>
                <label class="star text-2xl cursor-pointer" data-value="4">&#9733;</label>
                <label class="star text-2xl cursor-pointer" data-value="3">&#9733;</label>
                <label class="star text-2xl cursor-pointer" data-value="2">&#9733;</label>
                <label class="star text-2xl cursor-pointer" data-value="1">&#9733;</label>
                <input type="hidden" name="rating" id="rating" value="">
            </div>
        </div>

        <div class="mb-2">
            <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-gray-800" placeholder="Share your thoughts...">{{ old('comment') }}</textarea>
            @error('comment')
                <div class="text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div id="warningMessage" class="text-red-600 hidden">
            Please provide at least a rating or a comment before submitting your review.
        </div>

        @if ($errors->any())
            <div class="text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="flex justify-end">
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-700 text-sm leading-4 font-medium rounded-md px-2 py-2 text-white shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-200">Submit Review</button>
        </div>
    </form>
</div>

<div class="border p-4 mb-4 bg-white shadow">
    <strong class="text-lg text-gray-800">Reviews:</strong>
    <div class="mt-4">
        @if($house->reviews->isNotEmpty())

            <div class="mt-2">
                {{ $reviews->links() }}
            </div>

            @foreach ($house->reviews as $review)
                <div class="border-b py-4">
                    <div class="flex items-center mt-2">
                        <i class="fas fa-user-circle text-gray-700 text-sm"></i>
                        <span class="text-gray-600 ml-1 text-sm">{{ $review->user->name }}</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <strong class="text-gray-700 text-sm">Rating:</strong>
                        @if($review->rating !== null)
                            <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}</span>
                            <span class="text-gray-600 text-sm">{{ $review->rating }}/5</span>
                        @else
                            <span class="text-gray-600 text-sm">No rating</span>
                        @endif
                    </div>

                    <div class="mt-2">
                        @if(!empty($review->comment))
                            <div class="text-gray-800 p-3 rounded-lg mt-1">
                                <p class="text-sm">{{ $review->comment }}</p>
                                <span class="text-gray-600 text-xs block mt-1">{{ $review->created_at->format('F j, Y, h:i A') }}</span>
                            </div>
                        @else
                            <p class="text-gray-600 text-sm">No comment provided.</p>
                            <p class="text-gray-600 text-xs block mt-1">{{ $review->created_at->format('F j, Y, h:i A') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="mt-2">
                {{ $reviews->links() }}
            </div>
        @else
            <p class="text-gray-500">No reviews yet.</p>
        @endif
    </div>
</div>

<style>
    .star {
        color: #d1d5db;
    }

    .star:hover,
    .star:hover ~ .star {
        color: #fbbf24;
    }

    input[type="hidden"]:valid + label,
    input[type="hidden"]:valid + label ~ label {
        color: #fbbf24;
    }
</style>

<script>
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;

            stars.forEach(s => {
                s.style.color = s.getAttribute('data-value') <= value ? '#fbbf24' : '#d1d5db';
            });
        });
    });

    document.getElementById('reviewForm').addEventListener('submit', function(event) {
        const rating = ratingInput.value;
        const comment = this.querySelector('textarea[name="comment"]').value.trim();

        if (!rating && !comment) {
            event.preventDefault();
            document.getElementById('warningMessage').classList.remove('hidden');
        } else {
            document.getElementById('warningMessage').classList.add('hidden');
        }
    });
</script>
