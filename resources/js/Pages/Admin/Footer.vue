<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    footer: {
        type: Object,
        default: () => null,
    },
});

const existing = computed(() => props.footer || {});

const form = useForm({
    description: existing.value.description || '',
    services_list: existing.value.services_list || 'Logistics Forums & Events\nTrade & Investment Networking\nDigital Registration Platforms\nTraining & Knowledge Sessions',
    facebook_url: existing.value.facebook_url || '',
    twitter_url: existing.value.twitter_url || '',
    linkedin_url: existing.value.linkedin_url || '',
    instagram_url: existing.value.instagram_url || '',
    quick_link1_label: existing.value.quick_link1_label || 'About Us',
    quick_link1_url: existing.value.quick_link1_url || '/about',
    quick_link2_label: existing.value.quick_link2_label || 'Contact Us',
    quick_link2_url: existing.value.quick_link2_url || '/contact',
    quick_link3_label: existing.value.quick_link3_label || 'More Resources',
    quick_link3_url: existing.value.quick_link3_url || '#',
    newsletter_text:
        existing.value.newsletter_text ||
        'Subscribe to get updates about forums, registrations and logistics news.',
    newsletter_button_label: existing.value.newsletter_button_label || 'Subscribe',
    privacy_url: existing.value.privacy_url || '#',
    terms_url: existing.value.terms_url || '#',
    copyright_text:
        existing.value.copyright_text ||
        'Copyright © 2026 WNCDi (Without Non-Communicable Diseases Initiative). All Rights Reserved.',
    logo: null,
});

const logoPreview = ref(existing.value.logo_url || '/img/WNCDiLogo.png');

const onLogoChange = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    form.logo = file;
    const reader = new FileReader();
    reader.onload = (ev) => {
        logoPreview.value = ev.target.result;
    };
    reader.readAsDataURL(file);
};

const submit = () => {
    form.post(route('admin.footer.update'), {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Footer" />
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Footer</h1>
                    <p class="text-[11px] text-gray-500 mt-1">
                        Manage the content and links that appear in the footer across the site.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-xs space-y-6">
                <!-- Logo + description -->
                <div class="grid md:grid-cols-[220px,1fr] gap-4">
                    <div>
                        <p class="text-[11px] font-semibold text-gray-800 mb-2">Brand logo</p>
                        <div class="border border-dashed border-gray-300 rounded-xl p-3 flex flex-col items-center gap-3 bg-gray-50/60">
                            <div class="h-14 w-40 bg-white rounded-md flex items-center justify-center overflow-hidden border border-gray-200">
                                <img :src="logoPreview" alt="Footer logo" class="max-h-12 w-auto object-contain" />
                            </div>
                            <label class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1.5 text-[11px] font-medium text-gray-700 border border-gray-200 cursor-pointer hover:bg-gray-50">
                                <span class="material-icons text-[14px]">upload</span>
                                <span>Change logo</span>
                                <input type="file" accept="image/*" class="hidden" @change="onLogoChange" />
                            </label>
                            <p class="text-[10px] text-gray-400 text-center">
                                Recommended: transparent PNG, at least 160x48px.
                            </p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 text-[11px]">Short description</label>
                        <textarea
                            v-model="form.description"
                            rows="4"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                        ></textarea>
                        <p class="mt-1 text-[10px] text-gray-400">
                            This text appears below the logo in the footer.
                        </p>
                    </div>
                </div>

                <!-- Services list -->
                <div>
                    <label class="block mb-1 text-gray-700 text-[11px]">Services list</label>
                    <textarea
                        v-model="form.services_list"
                        rows="3"
                        class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                    ></textarea>
                    <p class="mt-1 text-[10px] text-gray-400">
                        One service per line (these appear under the "Services" column).
                    </p>
                </div>

                <!-- Quick links -->
                <div class="grid md:grid-cols-3 gap-4">
                    <div v-for="n in [1, 2, 3]" :key="n">
                        <p class="text-[11px] font-semibold text-gray-800 mb-1">Quick link {{ n }}</p>
                        <input
                            v-model="form[`quick_link${n}_label`]"
                            type="text"
                            placeholder="Label"
                            class="mb-1 w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                        />
                        <input
                            v-model="form[`quick_link${n}_url`]"
                            type="text"
                            placeholder="URL"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                        />
                    </div>
                </div>

                <!-- Social links -->
                <div>
                    <p class="text-[11px] font-semibold text-gray-800 mb-2">Social links</p>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Facebook URL</label>
                            <input
                                v-model="form.facebook_url"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">X (Twitter) URL</label>
                            <input
                                v-model="form.twitter_url"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">LinkedIn URL</label>
                            <input
                                v-model="form.linkedin_url"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Instagram URL</label>
                            <input
                                v-model="form.instagram_url"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                    </div>
                </div>

                <!-- Newsletter + legal -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-[11px] font-semibold text-gray-800 mb-1">Newsletter</p>
                        <label class="block mb-1 text-gray-700 text-[11px]">Text</label>
                        <textarea
                            v-model="form.newsletter_text"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent mb-2"
                        ></textarea>
                        <label class="block mb-1 text-gray-700 text-[11px]">Button label</label>
                        <input
                            v-model="form.newsletter_button_label"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                        />
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-gray-800 mb-1">Legal & bottom bar</p>
                        <label class="block mb-1 text-gray-700 text-[11px]">Privacy Policy URL</label>
                        <input
                            v-model="form.privacy_url"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent mb-2"
                        />
                        <label class="block mb-1 text-gray-700 text-[11px]">Terms & Conditions URL</label>
                        <input
                            v-model="form.terms_url"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent mb-2"
                        />
                        <label class="block mb-1 text-gray-700 text-[11px]">Copyright text</label>
                        <input
                            v-model="form.copyright_text"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                        />
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 mt-4">
                    <button
                        type="button"
                        class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100 text-[11px]"
                        @click="form.reset()"
                    >
                        Reset
                    </button>
                    <button
                        type="button"
                        class="px-3 py-1.5 rounded-full bg-wncdi-accent text-white text-[11px] font-semibold hover:bg-wncdi-dark flex items-center gap-2"
                        :disabled="form.processing"
                        @click="submit"
                    >
                        <span
                            v-if="form.processing"
                            class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                        ></span>
                        <span>Save footer</span>
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
