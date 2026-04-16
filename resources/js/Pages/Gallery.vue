<script setup>
import { ref } from 'vue';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    mediaItems: {
        type: Array,
        default: () => [],
    },
});

// All WNCDi images
const wncdiImages = [
    { id: 1, title: 'About Hero', file_url: '/img/wncdi/about-hero.jpeg', category: 'hero' },
    { id: 2, title: 'Community', file_url: '/img/wncdi/community.png', category: 'community' },
    { id: 3, title: 'Graduate Program', file_url: '/img/wncdi/graduate.png', category: 'program' },
    { id: 4, title: 'Chat & Support', file_url: '/img/wncdi/chat.png', category: 'support' },
    { id: 5, title: 'Diabetes Awareness 1', file_url: '/img/wncdi/Diabetes1.jpg', category: 'health' },
    { id: 6, title: 'Diabetes Awareness 2', file_url: '/img/wncdi/Diabetes2.jpg', category: 'health' },
    { id: 7, title: 'Diabetes Awareness 3', file_url: '/img/wncdi/Diabetes3.jpg', category: 'health' },
    { id: 8, title: 'Diabetes Awareness 4', file_url: '/img/wncdi/Diabetes4.jpg', category: 'health' },
    { id: 9, title: 'Diabetes Outreach 1', file_url: '/img/wncdi/Diabetes Outreach-2.jpg', category: 'outreach' },
    { id: 10, title: 'Diabetes Outreach 2', file_url: '/img/wncdi/Diabetes Outreach-19.jpg', category: 'outreach' },
    { id: 11, title: 'Law & Justice', file_url: '/img/wncdi/law-scale.png', category: 'advocacy' },
    { id: 12, title: 'Impact Report', file_url: '/img/wncdi/impact.jpg', category: 'impact' },
    { id: 13, title: 'Community Moments', file_url: '/img/wncdi/moments.jpeg', category: 'moments' },
    { id: 14, title: 'Event Photo 1', file_url: '/img/wncdi/pic22.JPG', category: 'events' },
    { id: 15, title: 'Event Photo 2', file_url: '/img/wncdi/pic26.jpeg', category: 'events' },
    { id: 16, title: 'Event Photo 3', file_url: '/img/wncdi/pic28.JPG', category: 'events' },
    { id: 17, title: 'Statistics', file_url: '/img/wncdi/stats.JPG', category: 'data' },
    { id: 18, title: 'Campaign Image 1', file_url: '/img/wncdi/img1.jpeg', category: 'campaign' },
    { id: 19, title: 'Campaign Image 2', file_url: '/img/wncdi/img2.jpeg', category: 'campaign' },
    { id: 20, title: 'Campaign Image 3', file_url: '/img/wncdi/img3.jpeg', category: 'campaign' },
];

// Gallery partner logos
const galleryImages = [
    { id: 101, title: 'ABA Partners', file_url: '/img/gallery/aba.png', category: 'partners' },
    { id: 102, title: 'Mobile App', file_url: '/img/gallery/app.png', category: 'tech' },
    { id: 103, title: 'Change Initiative', file_url: '/img/gallery/change.png', category: 'initiative' },
    { id: 104, title: 'Gallery Image', file_url: '/img/gallery/image.png', category: 'general' },
    { id: 105, title: 'Pharma Partners', file_url: '/img/gallery/pharma.png', category: 'partners' },
    { id: 106, title: 'Philips Partnership', file_url: '/img/gallery/philips.png', category: 'partners' },
    { id: 107, title: 'Play Store', file_url: '/img/gallery/playstore.png', category: 'tech' },
    { id: 108, title: 'Science', file_url: '/img/gallery/scie.png', category: 'research' },
    { id: 109, title: 'Vital Health', file_url: '/img/gallery/vital.png', category: 'health' },
];

// Combine all images: hardcoded + admin uploaded
const uploadedImages = props.mediaItems.map((item, index) => ({
    id: 1000 + index,
    title: item.title,
    file_url: item.file_url,
    category: 'uploaded',
}));
const allImages = [...wncdiImages, ...galleryImages, ...uploadedImages];
const selectedCategory = ref('all');

const categories = [
    { value: 'all', label: 'All Images' },
    { value: 'health', label: 'Health & Wellness' },
    { value: 'community', label: 'Community' },
    { value: 'events', label: 'Events' },
    { value: 'partners', label: 'Partners' },
    { value: 'campaign', label: 'Campaigns' },
    { value: 'impact', label: 'Impact' },
    ...(uploadedImages.length > 0 ? [{ value: 'uploaded', label: 'Uploaded Media' }] : []),
];

const filteredImages = ref(allImages);

const filterByCategory = (category) => {
    selectedCategory.value = category;
    if (category === 'all') {
        filteredImages.value = allImages;
    } else {
        filteredImages.value = allImages.filter(img => img.category === category);
    }
};
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero -->
            <section class="relative h-72 bg-cover bg-center flex flex-col items-center justify-center" style="background-image: url('/img/wncdi/moments.jpeg');">
                <div class="absolute inset-0 bg-gradient-to-b from-wncdi-dark/20 via-wncdi-primary/15 to-wncdi-primary/25 backdrop-blur-sm"></div>
                <div class="relative z-10 text-center text-white px-4 mb-4">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Gallery</h1>
                </div>
                <nav class="relative z-10 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg">
                    <div class="flex items-center gap-2 text-sm text-white">
                        <a href="/" class="hover:text-wncdi-light transition">Home</a>
                        <span class="text-white/60">›</span>
                        <span class="text-white/90 font-medium">Gallery</span>
                    </div>
                </nav>
            </section>

            <!-- Gallery grid -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="mx-auto max-w-6xl">
                    <h2 class="text-2xl font-bold mb-8 text-gray-900">WNCDi Media Gallery</h2>
                    
                    <!-- Category filters -->
                    <div class="mb-8 flex flex-wrap gap-2">
                        <button
                            v-for="cat in categories"
                            :key="cat.value"
                            @click="filterByCategory(cat.value)"
                            :class="selectedCategory === cat.value 
                                ? 'bg-wncdi-primary text-white' 
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="px-4 py-2 rounded-full text-sm font-medium transition"
                        >
                            {{ cat.label }}
                        </button>
                    </div>

                    <!-- Image grid -->
                    <div
                        v-if="filteredImages.length"
                        class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                    >
                        <div
                            v-for="item in filteredImages"
                            :key="item.id"
                            class="group bg-gray-50 border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col"
                        >
                            <div class="relative aspect-square bg-black overflow-hidden">
                                <img
                                    :src="item.file_url"
                                    :alt="item.title"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                />
                                <div class="absolute inset-0 bg-wncdi-primary/0 group-hover:bg-wncdi-primary/20 transition-colors duration-300"></div>
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2">
                                    {{ item.title }}
                                </h3>
                                <p class="text-[11px] text-wncdi-primary font-medium capitalize mt-auto">
                                    {{ item.category }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- No results message -->
                    <div
                        v-else
                        class="text-center py-12"
                    >
                        <p class="text-sm text-gray-500">
                            No images found in this category.
                        </p>
                    </div>

                    <!-- Stats -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <p class="text-sm text-gray-600 text-center">
                            Displaying <span class="font-semibold text-gray-900">{{ filteredImages.length }}</span> of 
                            <span class="font-semibold text-gray-900">{{ allImages.length }}</span> images
                        </p>
                    </div>
                </div>
            </section>
        </main>
        <Footer />
    </div>
</template>
