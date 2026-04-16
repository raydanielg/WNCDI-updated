<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    posts: {
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

const searchQuery = ref('');

// WNCDi Blog Posts
const wncdiPosts = [
    {
        id: 1,
        slug: 'understanding-diabetes',
        title: 'Understanding Non-Communicable Diseases: A Comprehensive Guide',
        excerpt: 'Learn about the key facts, prevention strategies, and management approaches for NCDs. Non-communicable diseases are a growing health challenge affecting millions worldwide.',
        content: 'Non-Communicable Diseases (NCDs) represent a significant health challenge globally. Understanding these conditions is crucial for prevention and early intervention. This guide covers the main types of NCDs including diabetes, heart disease, respiratory diseases, and cancers.',
        image_url: '/img/wncdi/health-awareness.jpeg',
        category: 'Health & Wellness',
        author_name: 'WNCDi Team',
        published_at: '2026-04-10',
        comments: 12
    },
    {
        id: 2,
        slug: 'community-health-initiative',
        title: 'Community Health Initiative: Building Healthier Communities',
        excerpt: 'Discover how community involvement and education can reduce the burden of NCDs. Our grassroots approach focuses on prevention and awareness.',
        content: 'Community engagement is essential in combating non-communicable diseases. Through education programs, awareness campaigns, and preventive health initiatives, we empower communities to take action against NCDs.',
        image_url: '/img/wncdi/community-care.jpeg',
        category: 'Community',
        author_name: 'WNCDi Team',
        published_at: '2026-04-08',
        comments: 8
    },
    {
        id: 3,
        slug: 'prevention-strategies',
        title: 'Five Key Prevention Strategies to Reduce NCD Risk',
        excerpt: 'Explore evidence-based prevention strategies that can significantly reduce your risk of developing non-communicable diseases.',
        content: 'Prevention is the most effective approach to combating NCDs. Key strategies include regular physical activity, healthy nutrition, stress management, avoiding tobacco and limiting alcohol consumption. Small lifestyle changes can have a profound impact on your long-term health.',
        image_url: '/img/wncdi/impact-diabetes.jpeg',
        category: 'Prevention',
        author_name: 'Dr. Health Expert',
        published_at: '2026-04-05',
        comments: 15
    },
    {
        id: 4,
        slug: 'research-breakthroughs',
        title: 'Latest Research Breakthroughs in NCD Treatment',
        excerpt: 'Stay informed about cutting-edge research and innovative treatment approaches for non-communicable diseases.',
        content: 'Recent medical research has yielded promising results in NCD treatment and management. New diagnostic tools, targeted therapies, and digital health solutions are revolutionizing how we approach disease prevention and care.',
        image_url: '/img/wncdi/ncd-prevention.jpeg',
        category: 'Research',
        author_name: 'WNCDi Research Team',
        published_at: '2026-04-01',
        comments: 22
    },
    {
        id: 5,
        slug: 'youth-health-education',
        title: 'Youth Health Education: Empowering the Next Generation',
        excerpt: 'Education programs designed to equip young people with knowledge and skills to maintain healthy lifestyles and prevent NCDs.',
        content: 'Early health education is crucial in preventing NCDs. Our youth programs focus on building healthy habits, promoting physical activity, nutritional awareness, and stress management techniques.',
        image_url: '/img/wncdi/about-hero.jpeg',
        category: 'Education',
        author_name: 'WNCDi Team',
        published_at: '2026-03-28',
        comments: 9
    },
    {
        id: 6,
        slug: 'digital-health-solutions',
        title: 'Digital Health Solutions for NCD Management',
        excerpt: 'Explore how technology and digital tools are transforming disease management and patient monitoring for better health outcomes.',
        content: 'Technology plays an increasingly important role in healthcare. Mobile apps, telemedicine, and digital monitoring devices enable better disease management, remote consultations, and real-time health tracking.',
        image_url: '/img/wncdi/moments.jpeg',
        category: 'Technology',
        author_name: 'WNCDi Team',
        published_at: '2026-03-25',
        comments: 11
    }
];

// Gallery images from WNCDi collection
const blogGalleryImages = [
    '/img/wncdi/health-awareness.jpeg',
    '/img/wncdi/community-care.jpeg',
    '/img/wncdi/impact-diabetes.jpeg',
    '/img/wncdi/ncd-prevention.jpeg',
    '/img/wncdi/about-hero.jpeg',
    '/img/wncdi/moments.jpeg',
];

// Use WNCDi posts if no posts from database
const displayPosts = computed(() => {
    return props.posts && props.posts.length > 0 ? props.posts : wncdiPosts;
});

// Featured posts (first 3)
const featuredPosts = computed(() => {
    return displayPosts.value.slice(0, 3);
});

// Recent posts from featured
const displayRecentPosts = computed(() => {
    return displayPosts.value.slice(0, 5).map(p => p.title);
});
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero section with breadcrumb -->
            <section class="relative h-80 bg-cover bg-center flex flex-col items-center justify-center" style="background-image: url('/img/wncdi/health-awareness.jpeg');">
                <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/10 to-black/20 backdrop-blur-sm"></div>
                <div class="relative z-10 text-center text-white px-4 mb-8">
                    <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight">WNCDi Blog</h1>
                    <p class="text-lg mt-2 text-gray-100">Health insights, research, and community stories</p>
                </div>
                <nav class="relative z-10 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg">
                    <div class="flex items-center gap-2 text-sm text-white">
                        <a href="/" class="hover:text-wncdi-light transition">Home</a>
                        <span class="text-white/60">›</span>
                        <span class="text-white/90 font-medium">Blog</span>
                    </div>
                </nav>
            </section>

            <!-- Blog content -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="mx-auto max-w-6xl">
                    <div class="grid md:grid-cols-3 gap-12">
                        <!-- Main content -->
                        <div class="md:col-span-2">
                            <!-- Featured posts grid -->
                            <div class="mb-16">
                                <h2 class="text-2xl font-bold mb-8 text-gray-900">Latest Posts</h2>
                                <div class="grid gap-8">
                                    <div
                                        v-for="post in featuredPosts"
                                        :key="post.id"
                                        class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition"
                                    >
                                        <div class="grid md:grid-cols-3 gap-6">
                                            <div class="md:col-span-1 h-48 md:h-auto overflow-hidden">
                                                <img
                                                    :src="post.image_url"
                                                    :alt="post.title"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform"
                                                />
                                            </div>
                                            <div class="md:col-span-2 p-6 flex flex-col justify-between">
                                                <div>
                                                    <div class="flex items-center gap-2 mb-3">
                                                        <span class="bg-wncdi-gold text-gray-900 text-xs font-semibold px-3 py-1 rounded">{{ post.category }}</span>
                                                    </div>
                                                    <a href="#" class="text-xl font-bold text-gray-900 mb-3 hover:text-wncdi-accent transition cursor-pointer block">
                                                        {{ post.title }}
                                                    </a>
                                                    <p class="text-gray-600 text-sm mb-4">{{ post.excerpt }}</p>
                                                </div>
                                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                                    <span class="flex items-center gap-1">
                                                        <span class="material-icons text-sm">calendar_today</span>
                                                        {{ new Date(post.published_at).toLocaleDateString() }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <span class="material-icons text-sm">person</span>
                                                        {{ post.author_name }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <span class="material-icons text-sm">comment</span>
                                                        {{ post.comments }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Highlighted posts -->
                            <div class="mb-16">
                                <h2 class="text-2xl font-bold mb-8 text-gray-900">More Articles</h2>
                                <div class="grid md:grid-cols-3 gap-6">
                                    <div
                                        v-for="post in displayPosts.slice(3)"
                                        :key="post.id"
                                        class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition"
                                    >
                                        <div class="relative h-48 overflow-hidden">
                                            <img
                                                :src="post.image_url"
                                                :alt="post.title"
                                                class="w-full h-full object-cover hover:scale-105 transition-transform"
                                            />
                                            <span class="absolute top-3 left-3 bg-wncdi-accent text-white text-xs font-semibold px-3 py-1 rounded">
                                                {{ post.category }}
                                            </span>
                                        </div>
                                        <div class="p-4">
                                            <a href="#" class="text-lg font-bold text-gray-900 mb-4 line-clamp-2 hover:text-wncdi-accent transition-colors duration-300 cursor-pointer leading-snug block">
                                                {{ post.title }}
                                            </a>
                                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                                <span class="flex items-center gap-1">
                                                    <span class="material-icons text-sm">calendar_today</span>
                                                    {{ new Date(post.published_at).toLocaleDateString() }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <span class="material-icons text-sm">person</span>
                                                    {{ post.author_name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gallery -->
                            <div>
                                <h2 class="text-2xl font-bold mb-8 text-gray-900">WNCDi Gallery</h2>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div
                                        v-for="(image, index) in blogGalleryImages"
                                        :key="index"
                                        class="h-64 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition"
                                    >
                                        <img
                                            :src="image"
                                            alt="WNCDi Gallery image"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="md:col-span-1">
                            <!-- Search -->
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Search</h3>
                                <div class="flex gap-2">
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Search posts..."
                                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent text-sm font-medium"
                                    />
                                    <button class="bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-300 text-sm font-bold uppercase tracking-wide">
                                        Search
                                    </button>
                                </div>
                            </div>

                            <!-- Recent posts -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-8 shadow-md">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 uppercase tracking-widest text-center pb-4 border-b-2 border-wncdi-accent">Recent Posts</h3>
                                <ul class="space-y-5">
                                    <li
                                        v-for="(post, index) in displayRecentPosts"
                                        :key="index"
                                        class="border-b border-gray-300 pb-5 last:border-b-0 last:pb-0"
                                    >
                                        <a href="#" class="text-wncdi-accent hover:text-wncdi-dark text-sm font-bold leading-relaxed transition-colors duration-300 block hover:translate-x-1 transition-transform">
                                            {{ post }}
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
