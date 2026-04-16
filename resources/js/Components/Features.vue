<script setup>
import { computed } from 'vue';

const props = defineProps({
    focusAreas: {
        type: Array,
        default: () => [],
    },
});

const fallbackAreas = [
    {
        title: 'Health Education',
        description:
            'Comprehensive education on Non-Communicable Diseases, risk factors and prevention strategies for individuals and communities.',
        icon: 'school',
        image_url: '/img/wncdi/img1.jpeg',
    },
    {
        title: 'Youth Empowerment',
        description:
            'Creating younger NCDs champions and ambassadors through health clubs in schools and mentorship programs.',
        icon: 'favorite',
        image_url: '/img/wncdi/moments.jpeg',
    },
    {
        title: 'Community Screening',
        description:
            'Organizing collaborative health screening camps with professional doctors for early disease detection and management.',
        icon: 'health_and_safety',
        image_url: '/img/wncdi/img2.jpeg',
    },
];

const areas = computed(() => {
    return props.focusAreas && props.focusAreas.length ? props.focusAreas : fallbackAreas;
});
</script>

<template>
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Our Focus Areas</h2>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <div
                    v-for="area in areas"
                    :key="area.id || area.title"
                    class="rounded-3xl bg-white overflow-hidden shadow-[0_18px_45px_rgba(15,23,42,0.06)] hover:shadow-[0_25px_50px_rgba(15,23,42,0.12)] transition-shadow"
                >
                    <!-- Image section -->
                    <div v-if="area.image_url" class="relative h-48 bg-gray-200 overflow-hidden">
                        <img 
                            :src="area.image_url" 
                            :alt="area.title"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>
                    
                    <!-- Content section -->
                    <div class="p-8">
                        <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-full bg-wncdi-light text-wncdi-accent">
                            <span class="material-icons text-2xl">
                                {{ area.icon || 'category' }}
                            </span>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-900">
                            {{ area.title }}
                        </h3>
                        <p class="text-sm text-slate-500">
                            {{ area.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
