<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    about: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    badge_label: props.about.badge_label || 'About Company',
    title_line1: props.about.title_line1 || '',
    title_line2: props.about.title_line2 || '',
    intro_text: props.about.intro_text || '',
    bullet1: props.about.bullet1 || '',
    bullet2: props.about.bullet2 || '',
    bullet3: props.about.bullet3 || '',
    cta_label: props.about.cta_label || 'Explore Service',
    cta_url: props.about.cta_url || '/services',
    experience_label: props.about.experience_label || 'We have',
    experience_text: props.about.experience_text || '25+ Years of Experience',
    left_image: null,
    right_image: null,
});

const hasImages = computed(() => props.about.left_image_url || props.about.right_image_url);

const submit = () => {
    form.post(route('admin.about.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="About Company" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">About Company Section</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Manage the content and images for the About Company block on the homepage.</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-xs">
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Badge label</label>
                            <input
                                v-model="form.badge_label"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">CTA label</label>
                            <input
                                v-model="form.cta_label"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title line 1</label>
                            <input
                                v-model="form.title_line1"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title line 2</label>
                            <input
                                v-model="form.title_line2"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 text-[11px]">Intro text</label>
                        <textarea
                            v-model="form.intro_text"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                        ></textarea>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Bullet 1</label>
                            <input
                                v-model="form.bullet1"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Bullet 2</label>
                            <input
                                v-model="form.bullet2"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Bullet 3</label>
                            <input
                                v-model="form.bullet3"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Experience label</label>
                            <input
                                v-model="form.experience_label"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Experience text</label>
                            <input
                                v-model="form.experience_text"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Left image (team meeting)</label>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    form.left_image = file;
                                }"
                            />
                            <div v-if="props.about.left_image_url" class="mt-2 h-24 w-32 rounded border border-gray-200 overflow-hidden">
                                <img :src="props.about.left_image_url" alt="Current left" class="w-full h-full object-cover" />
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Right image (expert)</label>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    form.right_image = file;
                                }"
                            />
                            <div v-if="props.about.right_image_url" class="mt-2 h-24 w-32 rounded border border-gray-200 overflow-hidden">
                                <img :src="props.about.right_image_url" alt="Current right" class="w-full h-full object-cover" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4 text-[11px]">
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-full bg-wncdi-accent text-white font-semibold hover:bg-wncdi-dark flex items-center gap-2"
                            :disabled="form.processing"
                        >
                            <span
                                v-if="form.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Save changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
