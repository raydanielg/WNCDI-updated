<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { ref } from 'vue';

const searchQuery = ref('');

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    relatedPosts: {
        type: Array,
        default: () => [],
    },
    recentPosts: {
        type: Array,
        default: () => [],
    },
    galleryImages: {
        type: Array,
        default: () => [],
    },
});

const post = props.post;
const relatedPosts = props.relatedPosts;
const recentPosts = props.recentPosts;
const galleryImages = props.galleryImages;
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero section with image carousel -->
            <section class="relative h-96 bg-cover bg-center flex flex-col items-center justify-center overflow-hidden">
                <div class="absolute inset-0 flex">
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('/img/wncdi/about-hero.jpeg');"></div>
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('/img/wncdi/moments.jpeg');"></div>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-wncdi-dark/20 via-wncdi-primary/15 to-wncdi-primary/25"></div>
                <div class="relative z-10 text-center text-white px-4 mb-8">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Blog</h1>
                </div>
                <nav class="relative z-10 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg">
                    <div class="flex items-center gap-2 text-sm text-white">
                        <a href="/" class="hover:text-wncdi-light transition">Tanford</a>
                        <span class="text-white/60">›</span>
                        <a href="/blog" class="hover:text-wncdi-light transition">Blog</a>
                        <span class="text-white/60">›</span>
                        <a href="#" class="hover:text-wncdi-light transition">{{ post.category || 'News' }}</a>
                        <span class="text-white/60">›</span>
                        <span class="text-white/90 font-medium line-clamp-1">{{ post.title }}</span>
                    </div>
                </nav>
            </section>

            <!-- Blog detail content -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="mx-auto max-w-6xl">
                    <!-- Main content -->
                    <div class="grid md:grid-cols-3 gap-12">
                        <div class="md:col-span-2">
                            <!-- Title -->
                            <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ post.title }}</h1>

                            <!-- Meta info -->
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-8 pb-8 border-b border-gray-200">
                                <span class="flex items-center gap-1">
                                    <span class="material-icons text-sm">calendar_today</span>
                                    {{ post.published_at ? new Date(post.published_at).toLocaleDateString() : '' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-icons text-sm">person</span>
                                    {{ post.author_name || 'Admin' }}
                                </span>
                            </div>

                            <!-- Featured image -->
                            <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                                <img
                                    :src="post.image_url"
                                    :alt="post.title"
                                    class="w-full h-96 object-cover"
                                />
                            </div>

                            <!-- Content -->
                            <div class="prose prose-lg max-w-none mb-12">
                                <div
                                    class="text-gray-700 leading-relaxed"
                                    v-html="post.body"
                                ></div>
                            </div>

                            <!-- Gallery -->
                            <div class="mb-12">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Gallery</h3>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div
                                        v-for="(image, index) in galleryImages"
                                        :key="index"
                                        class="h-64 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition"
                                    >
                                        <img
                                            :src="image"
                                            alt="Gallery image"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- You may also like -->
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">You may also like these</h3>
                                <div class="w-12 h-1 bg-wncdi-accent mb-8"></div>
                                <div class="grid md:grid-cols-2 gap-8">
                                    <a
                                        :href="route('blog.show', relatedPost.slug)"
                                        v-for="relatedPost in relatedPosts"
                                        :key="relatedPost.id"
                                        class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition block"
                                    >
                                        <div class="h-48 overflow-hidden">
                                            <img
                                                :src="relatedPost.image_url"
                                                :alt="relatedPost.title"
                                                class="w-full h-full object-cover hover:scale-105 transition-transform"
                                            />
                                        </div>
                                        <div class="p-6">
                                            <h4 class="text-lg font-bold text-gray-900 hover:text-wncdi-accent transition cursor-pointer">
                                                {{ relatedPost.title }}
                                            </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="md:col-span-1">
                            <!-- Search -->
                            <div class="mb-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Search</h3>
                                <div class="flex gap-2">
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Search posts..."
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent text-sm"
                                    />
                                    <button class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm font-semibold">
                                        Search
                                    </button>
                                </div>
                            </div>

                            <!-- Recent posts -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 uppercase tracking-wide">Recent Posts</h3>
                                <ul class="space-y-4">
                                    <li
                                        v-for="(postTitle, index) in recentPosts"
                                        :key="index"
                                        class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0"
                                    >
                                        <a href="#" class="text-wncdi-accent hover:text-wncdi-dark text-sm font-bold leading-relaxed transition-colors duration-300 block hover:translate-x-1 transition-transform">
                                            {{ postTitle }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <Footer />
    </div>
</template>
