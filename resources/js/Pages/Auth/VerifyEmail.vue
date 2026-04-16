<script setup>
import { computed, ref, watch, onMounted } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);

const showStatus = ref(false);

const triggerStatusAlert = () => {
    if (!verificationLinkSent.value) return;
    showStatus.value = true;
    window.setTimeout(() => {
        showStatus.value = false;
    }, 5000);
};

onMounted(() => {
    if (verificationLinkSent.value) {
        triggerStatusAlert();
    }
});

watch(
    () => verificationLinkSent.value,
    (newVal) => {
        if (newVal) {
            triggerStatusAlert();
        }
    }
);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <!-- Floating status alert -->
        <div
            v-if="verificationLinkSent"
            class="fixed top-4 right-4 z-50 max-w-sm"
        >
            <div class="bg-wncdi-light border border-wncdi-light text-wncdi-primary rounded-2xl shadow-lg px-4 py-3 text-xs flex items-start gap-2">
                <span class="mt-0.5 material-icons text-sm text-wncdi-accent">check_circle</span>
                <p class="leading-snug">
                    A new verification link has been sent to the email address you provided during registration.
                </p>
            </div>
        </div>

        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    class="inline-flex items-center justify-center gap-2"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    <span
                        v-if="form.processing"
                        class="w-4 h-4 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                    ></span>
                    <span>Resend Verification Email</span>
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >Log Out</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
