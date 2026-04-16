<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    settings: {
        type: Object,
        default: () => null,
    },
});

const form = useForm({
    default_meta_title: props.settings?.default_meta_title || '',
    default_meta_description: props.settings?.default_meta_description || '',
    default_meta_keywords: props.settings?.default_meta_keywords || '',
    og_image_url: props.settings?.og_image_url || '',
});

const submit = () => {
    form.post(route('admin.settings.seo.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="SEO settings" />

        <div class="space-y-6 max-w-3xl">
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h1 class="text-lg font-semibold text-gray-900">SEO</h1>
                <p class="text-[11px] text-gray-500 mt-1">Defaults for meta tags across the site.</p>
            </div>

            <form
                @submit.prevent="submit"
                class="bg-white rounded-2xl border border-gray-100 p-5 text-xs space-y-6"
            >
                <div>
                    <label class="block text-[11px] font-medium text-gray-700 mb-1">Default meta title</label>
                    <input
                        v-model="form.default_meta_title"
                        type="text"
                        class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        placeholder="WNCDi - Non-Communicable Diseases Initiative"
                    />
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-700 mb-1">Default meta description</label>
                    <textarea
                        v-model="form.default_meta_description"
                        rows="3"
                        class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        placeholder="Short description for search engines."
                    ></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-700 mb-1">Default meta keywords</label>
                    <textarea
                        v-model="form.default_meta_keywords"
                        rows="2"
                        class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        placeholder="logistics, trade, Tanzania, Dubai"
                    ></textarea>
                    <p class="mt-1 text-[10px] text-gray-400">Comma-separated list.</p>
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-700 mb-1">Default OG image URL</label>
                    <input
                        v-model="form.og_image_url"
                        type="text"
                        class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        placeholder="https://example.com/images/og-default.jpg"
                    />
                </div>

                <div class="border-t border-gray-100 pt-4 flex items-center justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-full bg-wncdi-accent px-4 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark disabled:bg-wncdi-gold disabled:cursor-not-allowed"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing" class="inline-flex h-4 w-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                        <span>Save changes</span>
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
