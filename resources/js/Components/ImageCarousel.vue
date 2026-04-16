<template>
    <section class="w-full bg-white overflow-hidden">
        <div class="relative h-80 md:h-96 lg:h-screen/2 bg-gray-900">
            <!-- Carousel Container -->
            <div class="absolute inset-0 flex items-center justify-center">
                <!-- Images wrapper with transition -->
                <div class="relative w-full h-full">
                    <!-- Current slide -->
                    <div
                        v-for="(image, index) in images"
                        :key="index"
                        class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                        :class="index === currentSlide ? 'opacity-100' : 'opacity-0'"
                    >
                        <img
                            :src="image.url"
                            :alt="image.alt"
                            class="w-full h-full object-cover"
                        />
                        <!-- Overlay gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button
                    @click="prevSlide"
                    class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-10 bg-white/30 hover:bg-white/50 text-white p-2 md:p-3 rounded-full transition backdrop-blur-sm group"
                >
                    <span class="material-icons text-2xl md:text-3xl">chevron_left</span>
                </button>

                <button
                    @click="nextSlide"
                    class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-10 bg-white/30 hover:bg-white/50 text-white p-2 md:p-3 rounded-full transition backdrop-blur-sm group"
                >
                    <span class="material-icons text-2xl md:text-3xl">chevron_right</span>
                </button>

                <!-- Slide indicators at bottom -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                    <button
                        v-for="(image, index) in images"
                        :key="`indicator-${index}`"
                        @click="goToSlide(index)"
                        :class="index === currentSlide ? 'bg-wncdi-accent w-8' : 'bg-white/50 hover:bg-white/70 w-3'"
                        class="h-1 rounded-full transition-all duration-300"
                    ></button>
                </div>
            </div>

            <!-- Auto-play indicator -->
            <div class="absolute bottom-4 right-4 z-10 text-white text-xs md:text-sm bg-black/40 px-3 py-1.5 rounded-full backdrop-blur-sm">
                {{ currentSlide + 1 }} / {{ images.length }}
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const currentSlide = ref(0);
let autoPlayTimer = null;

const images = [
    { url: '/img/gallery/aba.png', alt: 'ABA Partners' },
    { url: '/img/gallery/app.png', alt: 'Mobile App' },
    { url: '/img/gallery/change.png', alt: 'Change Initiative' },
    { url: '/img/gallery/image.png', alt: 'Gallery Image' },
    { url: '/img/gallery/pharma.png', alt: 'Pharma Partners' },
    { url: '/img/gallery/philips.png', alt: 'Philips Partnership' },
    { url: '/img/gallery/playstore.png', alt: 'PlayStore' },
    { url: '/img/gallery/scie.png', alt: 'Science' },
    { url: '/img/gallery/vital.png', alt: 'Vital Health' },
];

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % images.length;
    resetAutoPlay();
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + images.length) % images.length;
    resetAutoPlay();
};

const goToSlide = (index) => {
    currentSlide.value = index;
    resetAutoPlay();
};

const startAutoPlay = () => {
    autoPlayTimer = setInterval(() => {
        nextSlide();
    }, 5000); // Change slide every 5 seconds
};

const resetAutoPlay = () => {
    if (autoPlayTimer) {
        clearInterval(autoPlayTimer);
    }
    startAutoPlay();
};

onMounted(() => {
    startAutoPlay();
});

onBeforeUnmount(() => {
    if (autoPlayTimer) {
        clearInterval(autoPlayTimer);
    }
});
</script>
