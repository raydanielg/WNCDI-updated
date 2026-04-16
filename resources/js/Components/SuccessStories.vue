<template>
    <section class="bg-white py-20" v-if="stories.length">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="mb-10 text-3xl font-extrabold leading-snug text-slate-900 sm:text-4xl lg:text-5xl">
                Read and explore Our latest news
            </h2>
        </div>

        <!-- Grid cards from DB-backed stories -->
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                <article
                    v-for="story in stories"
                    :key="story.id || story.title"
                    class="w-full"
                >
                    <div class="overflow-hidden rounded-3xl bg-white shadow-[0_18px_45px_rgba(15,23,42,0.06)]">
                        <!-- Image with Read More button overlay -->
                        <div class="relative h-52 w-full bg-slate-200">
                            <img :src="story.image_url" :alt="story.title" class="h-full w-full object-cover" />
                            <a
                                :href="route('blog.show', story.slug)"
                                class="absolute bottom-3 left-3 inline-flex items-center rounded-full bg-wncdi-accent px-4 py-1.5 text-[11px] font-semibold text-white shadow hover:bg-wncdi-dark"
                            >
                                Read More
                                <span class="material-icons ml-1 text-[13px]">arrow_forward</span>
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="px-5 py-5 text-left">
                            <p class="mb-2 text-xs font-medium text-slate-500 flex items-center gap-2">
                                <span class="text-wncdi-accent">{{ story.category || 'News' }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <span>{{ story.published_at ? new Date(story.published_at).toLocaleDateString() : '' }}</span>
                            </p>
                            <h3 class="mb-3 text-sm font-semibold text-slate-900 line-clamp-2">
                                {{ story.title }}
                            </h3>
                            <a
                                :href="route('blog.show', story.slug)"
                                class="inline-flex items-center text-xs font-semibold text-wncdi-accent hover:text-wncdi-dark"
                            >
                                Read More
                                <span class="material-icons ml-1 text-xs">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    stories: {
        type: Array,
        default: () => [],
    },
});

const stories = props.stories ?? [];
</script>
