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
    allow_registration: props.settings?.allow_registration ?? true,
    password_min_length: props.settings?.password_min_length ?? 8,
    login_rate_limit: props.settings?.login_rate_limit ?? 5,
    two_factor_enabled: props.settings?.two_factor_enabled ?? false,
});

const submit = () => {
    form.post(route('admin.settings.security.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Security settings" />

        <div class="space-y-6 max-w-3xl">
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h1 class="text-lg font-semibold text-gray-900">Security</h1>
                <p class="text-[11px] text-gray-500 mt-1">Authentication and security-related options.</p>
            </div>

            <form
                @submit.prevent="submit"
                class="bg-white rounded-2xl border border-gray-100 p-5 text-xs space-y-6"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-[11px] font-semibold uppercase tracking-wide text-gray-500 mb-1">
                            User registration
                        </h2>
                        <p class="text-[11px] text-gray-500">Allow new users to create accounts.</p>
                    </div>
                    <label class="inline-flex items-center gap-2 text-[12px] text-gray-700">
                        <input
                            v-model="form.allow_registration"
                            type="checkbox"
                            class="rounded border-gray-300 text-wncdi-accent focus:ring-wncdi-accent"
                        />
                        <span>Allow registration</span>
                    </label>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">Password min length</label>
                        <input
                            v-model.number="form.password_min_length"
                            type="number"
                            min="6"
                            max="64"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        />
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">Login attempts limit</label>
                        <input
                            v-model.number="form.login_rate_limit"
                            type="number"
                            min="1"
                            max="100"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        />
                        <p class="mt-1 text-[10px] text-gray-400">Max failed attempts before temporary lockout.</p>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                    <div>
                        <h2 class="text-[11px] font-semibold uppercase tracking-wide text-gray-500 mb-1">Two-factor auth</h2>
                        <p class="text-[11px] text-gray-500">Enable 2FA enforcement (implementation can follow later).</p>
                    </div>
                    <label class="inline-flex items-center gap-2 text-[12px] text-gray-700">
                        <input
                            v-model="form.two_factor_enabled"
                            type="checkbox"
                            class="rounded border-gray-300 text-wncdi-accent focus:ring-wncdi-accent"
                        />
                        <span>Require 2FA</span>
                    </label>
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
