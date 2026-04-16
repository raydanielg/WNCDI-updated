<template>
    <section class="bg-white py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 text-center">
            <!-- Top heading -->
            <button
                type="button"
                class="mb-4 inline-flex items-center rounded-full border border-emerald-100 bg-wncdi-light px-4 py-1 text-xs font-semibold uppercase tracking-wide text-wncdi-dark"
            >
                Our Focus Areas
            </button>

            <h2 class="mb-4 text-3xl font-extrabold leading-snug text-slate-900 sm:text-4xl lg:text-5xl">
                Our Focus Areas
            </h2>

            <p class="mx-auto max-w-3xl text-sm sm:text-base text-slate-500">
                WNCDi is dedicated to advancing public health and wellness through comprehensive education,
                community engagement, and evidence-based health initiatives.
            </p>
        </div>

        <div class="mx-auto flex max-w-6xl flex-col gap-10 px-4 sm:px-6 lg:flex-row lg:px-8">
            <!-- Left: service list -->
            <div class="w-full space-y-4 lg:w-5/12">
                <button
                    v-for="(service, index) in services"
                    :key="service.title"
                    @click="activeIndex = index"
                    class="group flex w-full items-center justify-between rounded-full border px-5 py-3 text-left text-sm font-medium transition-colors duration-200"
                    :class="
                        activeIndex === index
                            ? 'border-wncdi-accent bg-white shadow-[0_18px_45px_rgba(15,23,42,0.06)] text-wncdi-dark'
                            : 'border-wncdi-light bg-white text-slate-700 hover:border-sky-400 hover:text-sky-600'
                    "
                >
                    <span class="flex items-center gap-3">
                        <span
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full border transition-colors duration-200"
                            :class="
                                activeIndex === index
                                    ? 'border-wncdi-accent text-wncdi-accent'
                                    : 'border-wncdi-light text-wncdi-accent group-hover:border-sky-400 group-hover:text-sky-600'
                            "
                        >
                            <span class="material-icons text-base">{{ service.icon }}</span>
                        </span>
                        <span>{{ service.title }}</span>
                    </span>
                    <span
                        class="material-icons text-base"
                        :class="
                            activeIndex === index
                                ? 'text-wncdi-accent'
                                : 'text-gray-400 group-hover:text-sky-500'
                        "
                    >
                        chevron_right
                    </span>
                </button>
            </div>

            <!-- Right: details card -->
            <div
                class="relative w-full overflow-hidden rounded-3xl bg-white p-8 shadow-[0_18px_45px_rgba(15,23,42,0.06)] lg:w-7/12 text-left"
            >
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-wncdi-primary">
                    <span class="material-icons text-xl">{{ current.icon }}</span>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-slate-900">
                    {{ current.heading }}
                </h3>
                <p class="mb-6 text-sm sm:text-base text-slate-500">
                    {{ current.description }}
                </p>

                <div class="mt-4 h-40 w-full overflow-hidden rounded-2xl bg-slate-200 sm:h-52">
                    <img
                        :src="current.image"
                        :alt="current.title"
                        class="h-full w-full object-cover"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';

const services = [
    {
        title: 'Youth Champions Program',
        heading: 'Empowering Young Generation as NCDs Advocates',
        icon: 'favorite',
        description:
            'We provide health mentorship and NCDs education through established health clubs in primary and secondary schools to create younger ambassadors.',
        image:
            '/img/wncdi/moments.jpeg'
    },
    {
        title: 'Health Campaigns',
        heading: 'Community Responsibility for NCDs Prevention',
        icon: 'public',
        description:
            'We organize and participate in health determinants campaigns that emphasize community responsibility to protect themselves from preventable NCDs.',
        image:
            '/img/wncdi/health-awareness.jpeg'
    },
    {
        title: 'Screening Camps',
        heading: 'Community Health Assessment & Early Detection',
        icon: 'health_and_safety',
        description:
            'We organize collaborative screening camps with professional doctors providing blood glucose, blood pressure, BMI and cancer marker tests to communities.',
        image:
            '/img/wncdi/img2.jpeg'
    },
    {
        title: 'International Commemorations',
        heading: 'Participate in Global NCDs Awareness Days',
        icon: 'celebration',
        description:
            'We join world NCDs commemorations implementing activities with education about Cardiovascular Diseases, Diabetes, Cancer, Respiratory Diseases and Mental Health.',
        image:
            '/img/wncdi/ncd-prevention.jpeg'
    },
    {
        title: 'Partnerships',
        heading: 'Collaborate in the Fight Against NCDs',
        icon: 'handshake',
        description:
            'We partner with health institutions, organizations and companies that share our mission of reducing NCDs burden through collaborative initiatives.',
        image:
            '/img/wncdi/about-hero.jpeg'
    }
];

const activeIndex = ref(0);

const current = computed(() => services[activeIndex.value]);
</script>
