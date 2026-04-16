<script setup>
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    footer: {
        type: Object,
        default: () => null,
    },
});

const mergedFooter = computed(() => {
    const f = props.footer || {};

        const servicesList = (f.services_list || 'Health Education & Awareness\\nCommunity Programs\\nDiabetes Prevention\\nYouth Wellness Initiatives')
            .split(/\r?\n/)
            .map((s) => s.trim())
            .filter(Boolean);

        return {
            logo_url: f.logo_url || '/img/WNCDiLogo.png',
            description:
                f.description ||
                'We are dedicated to promoting health awareness, diabetes prevention, and community wellness through comprehensive education and evidence-based health initiatives.',
            services: servicesList,
            facebook_url: f.facebook_url || '#',
            twitter_url: f.twitter_url || '#',
            linkedin_url: f.linkedin_url || '#',
            instagram_url: f.instagram_url || '#',
            quick_link1_label: f.quick_link1_label || 'About Us',
            quick_link1_url: f.quick_link1_url || '/about',
            quick_link2_label: f.quick_link2_label || 'Contact Us',
            quick_link2_url: f.quick_link2_url || '/contact',
            quick_link3_label: f.quick_link3_label || 'More Resources',
            quick_link3_url: f.quick_link3_url || '#',
            newsletter_text:
                f.newsletter_text || 'Subscribe to get updates about health initiatives and wellness programs.',
            newsletter_button_label: f.newsletter_button_label || 'Subscribe',
            privacy_url: f.privacy_url || '#',
            terms_url: f.terms_url || '#',
            copyright_text:
                f.copyright_text || 'Copyright © 2025 WNCDi. All Rights Reserved.',
        };
    });

const newsletterForm = useForm({
    email: '',
});

const newsletterSuccess = ref('');

const submitNewsletter = () => {
    if (!newsletterForm.email) return;

    newsletterForm.post(route('newsletter.subscribe'), {
        preserveScroll: true,
        onSuccess: () => {
            newsletterSuccess.value = 'Subscribed successfully.';
            newsletterForm.reset();
            setTimeout(() => {
                newsletterSuccess.value = '';
            }, 4000);
        },
    });
};
</script>

<template>
    <footer class="bg-[#050816] text-gray-300 pt-16 pb-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Top content -->
            <div class="grid gap-12 lg:grid-cols-4">
                <!-- Brand + description -->
                <div>
                    <div class="mb-5 flex items-center gap-3 text-white">
                        <div class="flex items-center justify-center rounded-md bg-white px-3 py-2">
                            <img
                                :src="mergedFooter.logo_url"
                                alt="WNCDi logo"
                                class="h-8 w-auto object-contain"
                            />
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6 max-w-xs">
                        {{ mergedFooter.description }}
                    </p>
                    <div class="flex gap-3">
                        <!-- Tailwind-style social icons (Heroicons) -->
                        <a
                            :href="mergedFooter.facebook_url"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-700 text-gray-400 hover:border-wncdi-accent hover:text-wncdi-gold transition-colors"
                            aria-label="WNCDi on Facebook"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07c0 4.51 3.29 8.24 7.59 8.93v-6.32H7.56v-2.61h2.03V9.41c0-2.01 1.2-3.12 3.03-3.12.88 0 1.8.16 1.8.16v1.98h-1.02c-1 0-1.31.62-1.31 1.26v1.51h2.23l-.36 2.61h-1.87V21c4.3-.69 7.59-4.42 7.59-8.93Z"
                                />
                            </svg>
                        </a>
                        <a
                            href="#"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-700 text-gray-400 hover:border-wncdi-accent hover:text-wncdi-gold transition-colors"
                            aria-label="WNCDi on X"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M18.9 4H16.7L13 8.7 9.8 4H5.1L10.3 11.3 4.9 18H7.1L11 13l3.5 5h4.5L13.8 10.4 18.9 4Z"
                                />
                            </svg>
                        </a>
                        <a
                            href="#"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-700 text-gray-400 hover:border-wncdi-accent hover:text-wncdi-gold transition-colors"
                            aria-label="WNCDi on LinkedIn"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M4.98 3.5C4.98 4.88 3.88 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 4.98 2.12 4.98 3.5ZM.3 8.13H4.7V24H.3V8.13ZM8.55 8.13H12.8v2.16h.06c.59-1.12 2.04-2.3 4.2-2.3 4.49 0 5.32 2.96 5.32 6.81V24h-4.4v-7.5c0-1.79-.03-4.09-2.49-4.09-2.5 0-2.88 1.94-2.88 3.96V24h-4.4V8.13Z"
                                />
                            </svg>
                        </a>
                        <a
                            href="#"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-700 text-gray-400 hover:border-wncdi-accent hover:text-wncdi-gold transition-colors"
                            aria-label="WNCDi on Instagram"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7Zm10 2c1.65 0 3 1.35 3 3v10c0 1.65-1.35 3-3 3H7c-1.65 0-3-1.35-3-3V7c0-1.65 1.35-3 3-3h10Zm-5 3.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5Zm0 2A2.5 2.5 0 1 1 9.5 12 2.5 2.5 0 0 1 12 9.5Zm4.75-3.5a1.25 1.25 0 1 0 1.25 1.25A1.25 1.25 0 0 0 16.75 6Z"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Services</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li v-for="item in mergedFooter.services" :key="item">
                            {{ item }}
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Quick Links</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-2 group">
                            <span class="text-wncdi-gold group-hover:text-wncdi-accent transition-colors flex-shrink-0 mt-0.5">→</span>
                            <a :href="mergedFooter.quick_link1_url" class="hover:text-wncdi-gold transition-colors">
                                {{ mergedFooter.quick_link1_label }}
                            </a>
                        </li>
                        <li class="flex items-start gap-2 group">
                            <span class="text-wncdi-gold group-hover:text-wncdi-accent transition-colors flex-shrink-0 mt-0.5">→</span>
                            <a :href="mergedFooter.quick_link2_url" class="hover:text-wncdi-gold transition-colors">
                                {{ mergedFooter.quick_link2_label }}
                            </a>
                        </li>
                        <li class="flex items-start gap-2 group">
                            <span class="text-wncdi-gold group-hover:text-wncdi-accent transition-colors flex-shrink-0 mt-0.5">→</span>
                            <a :href="mergedFooter.quick_link3_url" class="hover:text-wncdi-gold transition-colors">
                                {{ mergedFooter.quick_link3_label }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-white">Newsletter</h3>
                    <p class="mb-4 text-sm text-gray-400">
                        {{ mergedFooter.newsletter_text }}
                    </p>
                    <form class="flex flex-col gap-3" @submit.prevent="submitNewsletter">
                        <div class="flex items-center rounded-full border border-gray-700 bg-transparent px-4 py-2 text-sm text-gray-300">
                            <input
                                type="email"
                                v-model="newsletterForm.email"
                                placeholder="Email address"
                                class="w-full border-0 bg-transparent text-sm text-gray-100 placeholder-gray-500 focus:ring-0"
                            />
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-wncdi-primary px-6 py-2 text-xs font-semibold uppercase tracking-wide text-white transition-all duration-300 hover:bg-wncdi-accent hover:shadow-lg hover:shadow-rose-500/50 hover:scale-105 active:scale-95"
                        >
                            {{ mergedFooter.newsletter_button_label }}
                            <span class="material-icons ml-1 text-xs">arrow_forward</span>
                        </button>
                        <p v-if="newsletterSuccess" class="text-[10px] text-wncdi-gold">
                            {{ newsletterSuccess }}
                        </p>
                    </form>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="mt-10 flex flex-col gap-4 border-t border-gray-800 pt-4 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">
                <p>{{ mergedFooter.copyright_text }}</p>
                <div class="flex items-center gap-2">
                    <a :href="mergedFooter.privacy_url" class="hover:text-gray-300">Privacy Policy</a>
                    <span class="text-gray-600">|</span>
                    <a :href="mergedFooter.terms_url" class="hover:text-gray-300">Terms and Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</template>
