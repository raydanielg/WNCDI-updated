<script setup>
import { Head } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
    programs: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Our Programs - WNCDi" />
    
    <div class="min-h-screen bg-gray-50">
        <Header />
        
        <main class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Page Header -->
                <div class="mb-16 text-center">
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                        Our Programs
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        WNCDi runs multiple programs designed to fight against Non-Communicable Diseases through advocacy, education, and community engagement.
                    </p>
                </div>

                <!-- Programs Grid -->
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div 
                        v-for="program in programs" 
                        :key="program.id"
                        class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow overflow-hidden h-full flex flex-col"
                    >
                        <!-- Program Header -->
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-6">
                            <span class="inline-block bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-semibold mb-3">
                                Program {{ program.sort_order }}
                            </span>
                            <h3 class="text-xl font-bold text-white">
                                {{ program.name }}
                            </h3>
                        </div>

                        <!-- Program Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <p v-if="program.short_description" class="text-sm text-wncdi-accent font-semibold mb-3">
                                {{ program.short_description }}
                            </p>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">
                                {{ program.description }}
                            </p>

                            <!-- Learn More Link -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <a href="#" class="inline-flex items-center text-wncdi-accent hover:text-wncdi-dark font-semibold text-sm">
                                    Learn more
                                    <span class="material-icons text-base ml-2">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Section -->
                <div class="mt-20 bg-white rounded-2xl shadow-md p-8 md:p-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        Our Approach
                    </h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        WNCDi implements all these programs with the main aim of aiding the reduction of Non-Communicable Diseases burden in Tanzanian local and regional areas through actual ground activities at all levels:
                    </p>
                    <ul class="space-y-3 ml-6">
                        <li class="flex items-start">
                            <span class="text-wncdi-accent mr-3 mt-1">✓</span>
                            <span class="text-gray-600">Lower Schools</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-wncdi-accent mr-3 mt-1">✓</span>
                            <span class="text-gray-600">Universities</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-wncdi-accent mr-3 mt-1">✓</span>
                            <span class="text-gray-600">General Community</span>
                        </li>
                    </ul>
                    <p class="text-gray-600 mt-6 leading-relaxed">
                        This initiative aligns with the World Health Organization (WHO) Sustainable Development Goal (SDG) 3.4 by the year 2030 - reducing by one-third premature mortality from Non-Communicable diseases.
                    </p>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
