<script setup>
import { computed } from 'vue';

const props = defineProps({
    about: {
        type: Object,
        default: () => null,
    },
});

const fallback = {
    badge_label: 'About WNCDi',
    title_line1: 'Fighting Non-Communicable',
    title_line2: 'Diseases Together',
    intro_text:
        'WNCDi is a youth-led NGO dedicated to raising awareness about Non-Communicable Diseases and promoting healthy lifestyles through education, community engagement and advocacy programs.',
    bullet1: 'Comprehensive NCDs education programs reaching schools and communities.',
    bullet2: 'Collaborative screening camps with professional health services and guidance.',
    bullet3: 'Youth empowerment through health mentorship and NCD prevention advocacy.',
    cta_label: 'Learn More About Us',
    cta_url: '/about',
    left_image_url: '/img/wncdi/health-awareness.jpeg',
    right_image_url: '/img/wncdi/community-care.jpeg',
    experience_label: 'Since',
    experience_text: 'December 2024',
};

const about = computed(() => ({
    ...fallback,
    ...(props.about || {}),
}));
</script>

<template>
    <section class="bg-white py-20">
        <div class="mx-auto flex max-w-6xl flex-col items-center gap-12 px-4 sm:px-6 lg:flex-row lg:px-8">
            <!-- Left content -->
            <div class="w-full lg:w-1/2 text-left lg:pr-8">
                <button
                    type="button"
                    class="mb-5 inline-flex items-center rounded-full border border-blue-100 bg-wncdi-light px-4 py-1 text-xs font-semibold uppercase tracking-wide text-wncdi-dark"
                >
                    {{ about.badge_label }}
                </button>

                <h2 class="mb-4 text-3xl font-extrabold leading-snug text-slate-900 sm:text-4xl lg:text-5xl">
                    {{ about.title_line1 }}
                    <br />
                    {{ about.title_line2 }}
                </h2>

                <p class="mb-6 max-w-xl text-sm sm:text-base text-slate-500">
                    {{ about.intro_text }}
                </p>

                <ul class="mb-8 space-y-3 text-sm sm:text-base text-slate-600">
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 text-wncdi-accent">
                            <span class="material-icons text-lg">check_circle</span>
                        </span>
                        <span>{{ about.bullet1 }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 text-wncdi-accent">
                            <span class="material-icons text-lg">check_circle</span>
                        </span>
                        <span>{{ about.bullet2 }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 text-wncdi-accent">
                            <span class="material-icons text-lg">check_circle</span>
                        </span>
                        <span>{{ about.bullet3 }}</span>
                    </li>
                </ul>

                <a
                    :href="about.cta_url || '/services'"
                    class="inline-flex items-center rounded-full bg-wncdi-accent px-6 py-3 text-sm font-semibold text-white shadow hover:bg-wncdi-dark"
                >
                    {{ about.cta_label }}
                    <span class="material-icons ml-2 text-base">arrow_forward</span>
                </a>
            </div>

            <!-- Right images -->
            <div class="relative w-full lg:w-1/2 flex justify-center gap-3">
                <div class="h-72 w-40 overflow-hidden rounded-2xl bg-slate-200 shadow-lg sm:h-80 sm:w-48">
                    <img
                        :src="about.left_image_url"
                        alt="WNCDi team meeting"
                        class="h-full w-full object-cover hover:scale-110 transition-transform duration-300"
                    />
                </div>
                <div class="mt-8 h-72 w-40 overflow-hidden rounded-2xl bg-slate-200 shadow-lg sm:mt-12 sm:h-80 sm:w-48">
                    <img
                        :src="about.right_image_url"
                        alt="WNCDi expert"
                        class="h-full w-full object-cover hover:scale-110 transition-transform duration-300"
                    />
                </div>

                <!-- Experience badge -->
                <div
                    class="absolute bottom-6 left-1/2 w-56 -translate-x-1/2 rounded-3xl bg-wncdi-primary px-5 py-4 text-left text-white shadow-xl"
                >
                    <p class="mb-1 text-xs uppercase tracking-wide opacity-80">{{ about.experience_label }}</p>
                    <p class="text-2xl font-extrabold">{{ about.experience_text }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
