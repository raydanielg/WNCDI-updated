<template>
    <section
        id="home"
        class="relative overflow-hidden bg-gray-900 text-white"
    >
        <!-- Background images - rotating slideshow -->
        <div class="absolute inset-0 flex overflow-hidden">
            <div 
                class="w-full h-full bg-cover bg-center transition-all duration-1000" 
                :style="{ backgroundImage: `url('${backgroundImages[currentSlide]}')` }">
            </div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/20 via-black/10 to-black/20"></div>

        <div class="relative py-16 px-4 mx-auto max-w-screen-xl text-center lg:py-20 lg:px-12">
            <!-- Badge (notification) -->
            <a
                :href="currentNotification ? currentNotification.url : '#'"
                class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700"
                :target="currentNotification ? '_blank' : undefined"
                rel="noopener"
            >
                <span class="text-xs bg-wncdi-accent rounded-full text-white px-4 py-1.5 mr-3">New</span>
                <span class="text-sm font-medium truncate max-w-xs">
                    <span v-if="currentNotification">{{ currentNotification.title }}</span>
                    <span v-else>{{ slides[currentSlide].badge }}</span>
                </span>
                <span class="ml-2 material-icons w-5 h-5 text-gray-500 dark:text-gray-400 text-base">chevron_right</span>
            </a>

            <!-- Heading -->
            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl"
            >
                {{ slides[currentSlide].title }}
            </h1>

            <!-- Description -->
            <p
                class="mb-8 text-lg font-normal text-gray-100/80 lg:text-xl sm:px-16 xl:px-48"
            >
                {{ slides[currentSlide].description }}
            </p>

            <!-- Buttons row -->
            <div
                class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4"
            >
                <a
                    href="/programs"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-wncdi-accent hover:bg-wncdi-dark focus:ring-4 focus:ring-wncdi-light dark:focus:ring-emerald-900"
                >
                    Explore Our Programs
                </a>
                <a
                    href="/donate"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                >
                    Support Our Mission
                </a>
            </div>

            <!-- Slide indicators only (under content) -->
            <div class="flex items-center justify-center gap-4 mt-4">
                <div class="flex gap-2">
                    <button
                        v-for="(slide, index) in slides"
                        :key="index"
                        @click="currentSlide = index"
                        :class="currentSlide === index ? 'bg-gray-900 dark:bg-white' : 'bg-gray-300 dark:bg-gray-600'"
                        class="w-3 h-3 rounded-full transition"
                    ></button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    notifications: {
        type: Array,
        default: () => [],
    },
    slides: {
        type: Array,
        default: () => [],
    },
});

const currentSlide = ref(0);
const currentNotificationIndex = ref(0);
let autoTimer = null;

// Default background images for hero section
const defaultBackgroundImages = [
    '/img/wncdi/about-hero.jpeg',
    '/img/wncdi/moments.jpeg',
    '/img/wncdi/img1.jpeg',
    '/img/wncdi/img2.jpeg',
    '/img/wncdi/pic26.jpeg',
];

const fallbackSlides = [
    {
        title: 'WNCDi Platform',
        badge: 'Empowering Youth Health & Community Development',
        description:
            'Join our comprehensive wellness and educational initiatives focused on diabetes awareness, health education, and community empowerment. Discover programs, resources, and opportunities to make a real difference in people\'s lives.'
    },
    {
        title: 'Fighting Non-Communicable Diseases',
        badge: 'Becoming Healthier Together',
        description:
            'Join us in fighting against Non-Communicable Diseases through advocacy, education, and community engagement with our global network.'
    }
];

const slides = computed(() => {
    return props.slides && props.slides.length
        ? props.slides
        : fallbackSlides;
});

// Background images - use from slides if available, otherwise use defaults
const backgroundImages = computed(() => {
    const slidesArray = slides.value;
    if (!slidesArray || !slidesArray.length) return defaultBackgroundImages;
    
    return slidesArray.map(slide => 
        slide.image_url || '/img/wncdi/about-hero.jpeg'
    );
});

const nextSlide = () => {
    const total = slides.value.length;
    if (!total) return;
    currentSlide.value = (currentSlide.value + 1) % total;
    if (props.notifications && props.notifications.length) {
        currentNotificationIndex.value = (currentNotificationIndex.value + 1) % props.notifications.length;
    }
};

const prevSlide = () => {
    const total = slides.value.length;
    if (!total) return;
    currentSlide.value = (currentSlide.value - 1 + total) % total;
};

const currentNotification = computed(() => {
    if (!props.notifications || !props.notifications.length) {
        return null;
    }
    return props.notifications[currentNotificationIndex.value] ?? props.notifications[0];
});

onMounted(() => {
    autoTimer = window.setInterval(() => {
        nextSlide();
    }, 6000);
});

onBeforeUnmount(() => {
    if (autoTimer) {
        window.clearInterval(autoTimer);
    }
});
</script>
