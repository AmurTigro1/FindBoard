<div class="relative">
    <div class="flex flex-col lg:flex-row gap-2 w-full h-[400px] mb-5  overflow-hidden relative rounded-lg">
        <!-- Photo Container with Custom Carousel -->
        <div id="carouselContainer" class="w-full lg:w-2/3 h-1/2 lg:h-full relative cursor-pointer" onclick="openModal()">
            <div id="carousel" class="carousel-wrapper w-full h-full relative overflow-hidden">
                <div class="carousel-inner w-full h-full flex transition-all duration-500 ease-in-out">
                    @foreach ($house->images as $image)
                        @if ($image->other_photo_path)
                            <div class="carousel-item w-full h-full flex-shrink-0">
                                <img src="{{ asset('storage/' . $image->other_photo_path) }}" alt="House Image" class="w-full h-full object-cover">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Grid Container with Images -->
        <div class="grid grid-cols-2 sm:grid-cols-2 gap-2 w-full h-1/2 lg:h-full" onclick="openModal()">
            @foreach ($house->images->take(4) as $image)
                @if ($image->other_photo_path)
                    <div class="relative overflow-hidden ">
                        <img src="{{ asset('storage/' . $image->other_photo_path) }}" alt="House Image" class="w-full h-full object-cover">
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="photoModal" class="fixed inset-0 bg-gray-900 bg-opacity-80 hidden z-50" onclick="closeModal(event)">
    <div class="bg-white w-11/12 md:w-3/4 lg:w-2/3 xl:w-[1400px] h-5/6 p-4 pt-12 rounded-xl shadow-2xl text-black absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-black text-2xl font-bold hover:text-gray-500 focus:outline-none">&times;</button>

        <div class="flex flex-col lg:flex-row h-full">
            <div class="flex-1 lg:flex-[3] mb-4 lg:mb-0 p-4 h-full overflow-y-auto">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($house->images as $image)
                        @if ($image->other_photo_path)
                            <div class="relative overflow-hidden bg-gray-200 rounded-lg shadow-md hover:border-2 hover:border-teal-500 transition duration-300 ease-in-out">
                                <img src="{{ asset('storage/' . $image->other_photo_path) }}" alt="House Image"
                                    class="w-full h-32 sm:h-40 md:h-48 object-cover transition-transform duration-300 ease-in-out hover:scale-105">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="flex-1 border flex flex-col justify-center border-gray-300 shadow-md hover:shadow-lg transition-shadow duration-200 p-4">
                <!-- Additional modal content (optional) -->
            </div>
        </div>
    </div>
</div>

<script>
    let currentSlide = 0;
    const carouselItems = document.querySelectorAll('.carousel-item');
    const totalSlides = carouselItems.length;

    function changeSlide(index) {
        if (index >= totalSlides) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide = index;
        }

        // Move carousel
        const carouselInner = document.querySelector('.carousel-inner');
        carouselInner.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    // Auto next every 5 seconds
    setInterval(() => {
        changeSlide(currentSlide + 1);
    }, 5000);

    // Modal open function
    function openModal() {
        const photoModal = document.getElementById('photoModal');
        photoModal.classList.remove('hidden');
    }

    // Modal close function
    function closeModal(event = null) {
        if (!event || event.target === document.getElementById('photoModal')) {
            const photoModal = document.getElementById('photoModal');
            photoModal.classList.add('hidden');
        }
    }

    // Initial slide setup
    changeSlide(currentSlide);
</script>