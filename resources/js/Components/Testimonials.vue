<template>
    <section class="bg-white" v-if="testimonials.length">
        <div class="py-16 px-4 mx-auto max-w-screen-xl lg:py-20 lg:px-6">
            <div class="grid gap-12 lg:grid-cols-[320px_minmax(0,1fr)] items-start">
                <!-- Left: people list -->
                <div class="space-y-4">
                    <button
                        v-for="(item, index) in testimonials"
                        :key="item.name"
                        type="button"
                        class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left transition-colors"
                        :class="
                            activeIndex === index
                                ? 'bg-gray-50 shadow-sm text-wncdi-dark'
                                : 'hover:bg-gray-50 text-gray-700 hover:text-sky-600'
                        "
                        @click="activeIndex = index"
                    >
                        <img
                            class="h-10 w-10 rounded-full object-cover"
                            :src="item.avatar_url"
                            :alt="item.name"
                        />
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ item.name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ item.role }}
                            </p>
                        </div>
                    </button>

                    <a
                        href="#"
                        class="inline-flex items-center text-xs font-semibold text-wncdi-accent hover:text-wncdi-dark"
                    >
                        View other 20 testimonials
                        <span class="material-icons ml-1 text-xs">arrow_forward</span>
                    </a>
                </div>

                <!-- Right: testimonial content -->
                <div class="max-w-2xl">
                    <span class="mb-4 inline-block text-5xl leading-none text-wncdi-accent">“</span>
                    <h3 class="mb-3 text-2xl font-bold text-gray-900">
                        {{ current.headline }}
                    </h3>
                    <p class="mb-4 text-sm sm:text-base text-gray-500">
                        {{ current.body1 }}
                    </p>
                    <p class="text-sm sm:text-base text-gray-500">
                        {{ current.body2 }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    testimonials: {
        type: Array,
        default: () => [],
    },
});

const activeIndex = ref(0);

const testimonials = computed(() => props.testimonials ?? []);

const current = computed(() => {
    if (!testimonials.value.length) {
        return {
            headline: '',
            body1: '',
            body2: '',
        };
    }

    const item = testimonials.value[activeIndex.value] ?? testimonials.value[0];

    return {
        headline: item.headline,
        body1: item.body1,
        body2: item.body2,
    };
});
</script>
