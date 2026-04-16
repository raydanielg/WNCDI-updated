<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { ref } from 'vue';

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});

const expandedId = ref(null);

const toggleExpanded = (id) => {
    expandedId.value = expandedId.value === id ? null : id;
};
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero section -->
            <section class="relative h-80 bg-cover bg-center flex flex-col items-center justify-center" style="background-image: url('/img/wncdi/about-hero.jpeg');">
                <div class="absolute inset-0 bg-gradient-to-b from-wncdi-dark/20 via-wncdi-primary/15 to-wncdi-primary/25 backdrop-blur-sm"></div>
                <div class="relative z-10 text-center text-white px-4 mb-8">
                    <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight">Our Services</h1>
                </div>
                <nav class="relative z-10 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg">
                    <div class="flex items-center gap-2 text-sm text-white">
                        <a href="/" class="hover:text-wncdi-light transition">Home</a>
                        <span class="text-white/60">›</span>
                        <span class="text-white/90 font-medium">Services</span>
                    </div>
                </nav>
            </section>

            <!-- Services content -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-16 text-center">
                        <h2 class="text-3xl font-bold mb-4 text-gray-900">What We Offer</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Explore the programs and services WNCDi provides to support health awareness, diabetes prevention, and community wellness initiatives.
                        </p>
                    </div>
                    <div v-if="props.services.length" class="grid md:grid-cols-2 gap-12">
                        <article
                            v-for="service in props.services"
                            :key="service.id"
                            class="rounded-lg border border-gray-100 bg-white shadow-sm hover:shadow-md transition flex flex-col overflow-hidden"
                        >
                            <div v-if="service.image_url" class="h-44 w-full overflow-hidden bg-gray-100">
                                <img
                                    :src="service.image_url"
                                    :alt="service.title"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform"
                                />
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    {{ service.title }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-3">
                                    {{ service.short_description }}
                                </p>
                                <button
                                    type="button"
                                    class="mt-auto inline-flex items-center text-sm font-semibold text-wncdi-accent hover:text-wncdi-dark"
                                    @click="toggleExpanded(service.id)"
                                >
                                    <span>{{ expandedId === service.id ? 'Hide details' : 'Read more' }}</span>
                                    <span class="material-icons text-base ml-1">
                                        {{ expandedId === service.id ? 'expand_less' : 'read_more' }}
                                    </span>
                                </button>
                                <div
                                    v-if="expandedId === service.id"
                                    class="mt-4 border-t border-gray-100 pt-3 text-sm text-gray-700 space-y-2"
                                >
                                    <p
                                        v-for="(paragraph, idx) in service.body.split(/\n+/)"
                                        :key="idx"
                                        class="leading-relaxed"
                                    >
                                        {{ paragraph }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <p v-else class="text-sm text-gray-500 text-center">No services have been published yet.</p>
                </div>
            </section>
        </main>
        <Footer />
    </div>
</template>
