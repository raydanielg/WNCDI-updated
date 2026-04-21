<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

const showStatus = ref(false);

const triggerStatusAlert = () => {
    if (!props.status) return;
    showStatus.value = true;
    window.setTimeout(() => {
        showStatus.value = false;
    }, 5000);
};

onMounted(() => {
    if (props.status) {
        triggerStatusAlert();
    }
});

watch(
    () => props.status,
    (newVal) => {
        if (newVal) {
            triggerStatusAlert();
        }
    }
);
</script>

<template>
    <div class="min-h-screen flex bg-gray-100 relative">
        <Head title="Forgot Password" />

        <!-- Floating status alert -->
        <div
            v-if="status"
            class="fixed top-4 right-4 z-50 max-w-sm"
        >
            <div class="bg-wncdi-light border border-wncdi-light text-wncdi-primary rounded-2xl shadow-lg px-4 py-3 text-xs flex items-start gap-2">
                <span class="mt-0.5 material-icons text-sm text-wncdi-accent">check_circle</span>
                <p class="leading-snug">{{ status }}</p>
            </div>
        </div>

        <!-- Left: Forgot password card -->
        <div class="flex-1 flex justify-center items-start px-4 pt-10 pb-8 sm:px-6 lg:px-12 lg:pt-16">
            <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10">
                <!-- Logo top -->
                <div class="mb-4 flex justify-center">
                    <img src="/wncdi-logo.png" alt="Logo" class="h-12 w-auto" />
                </div>

                <!-- Title + description -->
                <div class="mb-6 text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Reset your password</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Enter the email you use with us and we will send you a secure link to reset your password.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <InputLabel for="email" value="Email" class="text-xs font-semibold text-gray-700" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-wncdi-accent focus:ring-wncdi-accent text-sm"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-1 text-xs" :message="form.errors.email" />
                    </div>

                    <div class="pt-2 flex items-center justify-between text-xs">
                        <Link :href="route('login')" class="text-gray-500 hover:text-gray-700">Back to login</Link>
                        <PrimaryButton
                            class="inline-flex justify-center items-center gap-2 bg-wncdi-accent hover:bg-wncdi-dark border-0 py-2.5 px-4 text-sm font-semibold"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            <span
                                v-if="form.processing"
                                class="w-4 h-4 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Email Password Reset Link</span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Info panel -->
        <div class="hidden lg:flex flex-1 bg-gradient-to-br from-slate-900 via-wncdi-primary to-blue-600 text-white items-center justify-center px-12">
            <div class="max-w-md">
                <h2 class="text-3xl font-extrabold mb-4 leading-tight">Forgot your password?</h2>
                <p class="text-sm text-emerald-50 mb-6">
                    No worries. Use your email address to receive a secure reset link and get back to managing your
                    trade and logistics activities.
                </p>
                <p class="text-xs text-emerald-100">
                    For security reasons, reset links expire after a short period. If you need assistance, please
                    contact the support team.
                </p>
            </div>
        </div>
    </div>
</template>
