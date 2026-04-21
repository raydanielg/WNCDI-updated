<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { ref } from 'vue';

const openIndex = ref(null);

const faqs = [
    {
        question: 'What is WNCDi?',
        answer:
            'WNCDi is a non-profit organization dedicated to diabetes awareness, health education, and community wellness. We provide evidence-based programs, resources, and initiatives focused on preventing chronic diseases and promoting healthier lifestyles across our communities.',
        image: '/img/wncdi/Diabetes1.jpg',
    },
    {
        question: 'Who can participate in WNCDi programs?',
        answer:
            'Our programs are open to everyone - individuals of all ages, families, healthcare professionals, educators, and organizations interested in improving health outcomes and building healthier communities. No membership fee is required to access most of our educational resources.',
        image: '/img/wncdi/community.png',
    },
    {
        question: 'What programs does WNCDi offer?',
        answer:
            'We offer diabetes awareness workshops, health education seminars, youth wellness initiatives, community screening events, training programs for educators and healthcare providers, and digital health resources. Visit our Programs page for current offerings and registration details.',
        image: '/img/wncdi/graduate.png',
    },
    {
        question: 'How can I register for WNCDi programs?',
        answer:
            'You can register for our programs through our website, via email at info@wncdi.org, or by visiting our office. Most events offer both in-person and online participation options. Registration is typically free or at minimal cost to ensure accessibility.',
        image: '/img/wncdi/chat.png',
    },
    {
        question: 'Does WNCDi provide diabetes screening services?',
        answer:
            'Yes. We organize regular free health screening camps in collaboration with healthcare partners. These events provide diabetes risk assessments, basic health checks, and referrals to healthcare providers when needed. Check our events page for upcoming screening dates.',
        image: '/img/wncdi/Diabetes2.jpg',
    },
    {
        question: 'Can healthcare professionals join our initiatives?',
        answer:
            'Absolutely! We welcome doctors, nurses, nutritionists, and other healthcare professionals to participate in our programs, contribute expertise, and collaborate on health initiatives. Please contact us to learn about partnership opportunities.',
        image: '/img/wncdi/law-scale.png',
    },
    {
        question: 'Are WNCDi resources available online?',
        answer:
            'Yes. We provide digital health resources, educational videos, fact sheets, and wellness guides on our website and social media channels. These resources are designed to be accessible and practical for individuals and families seeking health information.',
        image: '/img/wncdi/impact.jpg',
    },
    {
        question: 'How can I support WNCDi\'s mission?',
        answer:
            'You can support our mission by volunteering, participating in programs, sharing resources with your network, making donations, or partnering with us as an organization. Every contribution helps us reach more people and create lasting health impact.',
        image: '/img/wncdi/moments.jpeg',
    },
    {
        question: 'How can I contact WNCDi?',
        answer:
            'You can reach us via email at info@wncdi.org, through our website contact form, or visit our office during business hours. Our team is available to answer questions about programs, partnerships, volunteering, and health initiatives.',
        image: '/img/wncdi/impact.jpg',
    },
];

const toggleFAQ = (index) => {
    openIndex.value = openIndex.value === index ? null : index;
};
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero section with breadcrumb overlay -->
            <section class="relative h-80 bg-cover bg-center flex flex-col items-center justify-center" style="background-image: url('/img/wncdi/img1.jpeg');">
                <div class="absolute inset-0 bg-gradient-to-b from-wncdi-dark/20 via-wncdi-primary/15 to-wncdi-primary/25 backdrop-blur-sm"></div>
                <div class="relative z-10 text-center text-white px-4 mb-8">
                    <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight">FAQ</h1>
                </div>
                
                <!-- Breadcrumb inside hero -->
                <nav class="relative z-10 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg">
                    <div class="flex items-center gap-2 text-sm text-white">
                        <a href="/" class="hover:text-wncdi-light transition">Home</a>
                        <span class="text-white/60">›</span>
                        <span class="text-white/90 font-medium">FAQ</span>
                    </div>
                </nav>
            </section>

            <!-- FAQ section -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="mx-auto max-w-4xl">
                    <div class="mb-16 text-center">
                        <h2 class="text-3xl font-bold mb-4 text-gray-900">Frequently Asked Questions</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Find answers to common questions about membership, events, and more.
                        </p>
                    </div>

                    <!-- FAQ Accordion with optional images -->
                    <div class="space-y-4">
                        <div
                            v-for="(faq, index) in faqs"
                            :key="index"
                            class="border border-gray-200 rounded-lg overflow-hidden bg-white/80 backdrop-blur"
                        >
                            <button
                                @click="toggleFAQ(index)"
                                class="w-full px-6 py-4 flex items-center justify-between bg-gray-50 hover:bg-gray-100 transition-colors"
                            >
                                <h3 class="text-lg font-semibold text-gray-900 text-left">{{ faq.question }}</h3>
                                <span
                                    class="flex-shrink-0 ml-4 text-wncdi-accent transition-transform"
                                    :class="openIndex === index ? 'rotate-180' : ''"
                                >
                                    <span class="material-icons">expand_more</span>
                                </span>
                            </button>

                            <!-- Answer and image -->
                            <div
                                v-if="openIndex === index"
                                class="px-6 py-5 bg-white border-t border-gray-200"
                            >
                                <div class="grid gap-4 md:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] items-start">
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ faq.answer }}
                                    </p>
                                    <div v-if="faq.image" class="w-full flex justify-end">
                                        <img
                                            :src="faq.image"
                                            :alt="faq.question"
                                            class="w-full max-w-xs rounded-lg shadow-md object-cover"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Mobile App section -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-emerald-50 to-sky-50">
                <div class="mx-auto max-w-6xl">
                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <!-- Left: App info -->
                        <div>
                            <h2 class="text-4xl font-bold mb-6 text-gray-900">Mobile App</h2>
                            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                                Stay connected on the go. Our mobile app brings the power of networking, event registration, and professional development to your fingertips.
                            </p>
                            
                            <div class="space-y-4 mb-8">
                                <div class="flex items-start gap-4">
                                    <span class="material-icons text-wncdi-accent text-2xl flex-shrink-0">check_circle</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Easy Event Registration</h4>
                                        <p class="text-gray-600 text-sm">Register for forums and events in seconds</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <span class="material-icons text-wncdi-accent text-2xl flex-shrink-0">check_circle</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Networking Directory</h4>
                                        <p class="text-gray-600 text-sm">Connect with other logistics professionals</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <span class="material-icons text-wncdi-accent text-2xl flex-shrink-0">check_circle</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Push Notifications</h4>
                                        <p class="text-gray-600 text-sm">Stay updated with latest news and events</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <span class="material-icons text-wncdi-accent text-2xl flex-shrink-0">check_circle</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Exclusive Content</h4>
                                        <p class="text-gray-600 text-sm">Access member-only resources and materials</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-6 border-2 border-wncdi-light">
                                <p class="text-sm text-gray-600 mb-4">
                                    <span class="material-icons text-lg align-middle mr-2">info</span>
                                    Coming soon for iOS and Android
                                </p>
                                <p class="text-xs text-gray-500">
                                    Be the first to know when our app launches. Sign up for notifications below.
                                </p>
                            </div>
                        </div>

                        <!-- Right: App mockup / Coming soon -->
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-full max-w-xs">
                                <!-- App preview box -->
                                <div class="bg-gradient-to-b from-wncdi-dark to-emerald-700 rounded-3xl p-8 shadow-2xl text-center text-white">
                                    <div class="mb-8">
                                        <span class="material-icons text-6xl">phone_iphone</span>
                                    </div>
                                    <h3 class="text-2xl font-bold mb-4">Download Our App</h3>
                                    <p class="text-emerald-100 mb-8">
                                        Available on iOS and Android
                                    </p>
                                    
                                    <div class="space-y-3">
                                        <!-- App Store -->
                                        <a
                                            href="#"
                                            class="flex items-center justify-center gap-3 bg-white text-wncdi-accent px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition"
                                        >
                                            <span class="material-icons">apple</span>
                                            App Store
                                        </a>
                                        
                                        <!-- Google Play -->
                                        <a
                                            href="#"
                                            class="flex items-center justify-center gap-3 bg-white text-wncdi-accent px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition"
                                        >
                                            <span class="material-icons">android</span>
                                            Google Play
                                        </a>
                                    </div>

                                    <div class="mt-8 pt-8 border-t border-wncdi-accent">
                                        <p class="text-xs text-emerald-100">
                                            Coming Soon
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Newsletter signup -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="mx-auto max-w-2xl text-center">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">Get App Launch Notifications</h3>
                    <p class="text-gray-600 mb-6">
                        Be the first to know when the mobile app launches for iOS and Android.
                    </p>
                    <form class="flex flex-col sm:flex-row gap-3">
                        <input
                            type="email"
                            placeholder="Enter your email"
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                        />
                        <button
                            type="submit"
                            class="bg-wncdi-accent text-white px-6 py-3 rounded-lg font-semibold hover:bg-wncdi-dark transition"
                        >
                            Notify Me
                        </button>
                    </form>
                </div>
            </section>
        </main>
        <Footer />
    </div>
</template>
