<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    settings: {
        type: Object,
        default: () => null,
    },
});

const form = useForm({
    site_name: props.settings?.site_name || '',
    tagline: props.settings?.tagline || '',
    default_email: props.settings?.default_email || '',
    default_phone: props.settings?.default_phone || '',
    default_language: props.settings?.default_language || 'en',
    timezone: props.settings?.timezone || 'Africa/Nairobi',
    maintenance_mode: props.settings?.maintenance_mode || false,
});

const isDirty = computed(() => form.isDirty);

const submit = () => {
    form.post(route('admin.settings.general.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="General settings" />

        <div class="space-y-6">
            <div
                class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
            >
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">General settings</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Core branding and site-wide defaults.</p>
                </div>
                <div class="text-[11px] text-gray-500">
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium"
                        :class="isDirty ? 'bg-amber-100 text-amber-800' : 'bg-wncdi-light text-wncdi-dark'"
                    >
                        {{ isDirty ? 'Unsaved changes' : 'Up to date' }}
                    </span>
                </div>
            </div>

            <form
                @submit.prevent="submit"
                class="bg-white rounded-2xl border border-gray-100 p-5 text-xs space-y-6 max-w-3xl"
            >
                <div>
                    <h2 class="text-[11px] font-semibold uppercase tracking-wide text-gray-500 mb-3">Branding</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Site name</label>
                            <input
                                v-model="form.site_name"
                                type="text"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="WNCDi"
                            />
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Tagline</label>
                            <input
                                v-model="form.tagline"
                                type="text"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="Your logistics partner"
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-[11px] font-semibold uppercase tracking-wide text-gray-500 mb-3">Contact</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Default email</label>
                            <input
                                v-model="form.default_email"
                                type="email"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="info@example.com"
                            />
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Default phone</label>
                            <input
                                v-model="form.default_phone"
                                type="text"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="+255 ..."
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-[11px] font-semibold uppercase tracking-wide text-gray-500 mb-3">Locale &amp; time</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Default language</label>
                            <select
                                v-model="form.default_language"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                            >
                                <option value="en">English</option>
                                <option value="sw">Swahili</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Timezone</label>
                            <input
                                v-model="form.timezone"
                                type="text"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="Africa/Nairobi"
                            />
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-[12px] text-gray-700">
                        <input
                            v-model="form.maintenance_mode"
                            type="checkbox"
                            class="rounded border-gray-300 text-wncdi-accent focus:ring-wncdi-accent"
                        />
                        <span>Enable maintenance mode</span>
                    </label>

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-full bg-wncdi-accent px-4 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark disabled:bg-wncdi-gold disabled:cursor-not-allowed"
                        :disabled="form.processing || !isDirty"
                    >
                        <span v-if="form.processing" class="inline-flex h-4 w-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                        <span>Save changes</span>
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
