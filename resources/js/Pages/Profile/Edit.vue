<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user ?? {});

const userInitials = computed(() => {
    if (!user.value.name) return '';
    return user.value.name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Profile summary -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-wncdi-accent text-white text-lg font-semibold">
                        {{ userInitials }}
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ user.name }}</h1>
                        <p class="text-xs text-gray-500">{{ user.email }}</p>
                        <p class="mt-1 inline-flex items-center gap-1 rounded-full bg-wncdi-light px-2 py-0.5 text-[11px] font-medium text-wncdi-dark capitalize">
                            <span class="material-icons text-[14px]">shield_person</span>
                            <span>{{ user.role }} account</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 text-[11px] text-gray-600">
                    <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-gray-50 border border-gray-100">
                        <span class="material-icons text-[14px] text-wncdi-accent">lock</span>
                        <span>Secure account</span>
                    </div>
                    <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-gray-50 border border-gray-100">
                        <span class="material-icons text-[14px] text-sky-500">alternate_email</span>
                        <span>Email notifications</span>
                    </div>
                </div>
            </div>

            <!-- Profile forms layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left column: profile + password -->
                <div class="space-y-6 lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h2 class="text-sm font-semibold text-gray-900 mb-1">Profile details</h2>
                        <p class="text-[11px] text-gray-500 mb-4">Update your basic account information.</p>
                        <UpdateProfileInformationForm
                            :must-verify-email="props.mustVerifyEmail"
                            :status="props.status"
                            class="max-w-xl"
                        />
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h2 class="text-sm font-semibold text-gray-900 mb-1">Password & security</h2>
                        <p class="text-[11px] text-gray-500 mb-4">Change your password to keep your account secure.</p>
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </div>

                <!-- Right column: danger zone -->
                <div>
                    <div class="bg-white rounded-2xl border border-red-100 p-6 flex flex-col gap-3">
                        <div class="flex items-center gap-2">
                            <span class="material-icons text-base text-red-500">warning</span>
                            <h2 class="text-sm font-semibold text-gray-900">Danger zone</h2>
                        </div>
                        <p class="text-[11px] text-gray-500">
                            Permanently delete your account and all associated data. This action cannot be undone.
                        </p>
                        <DeleteUserForm class="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
