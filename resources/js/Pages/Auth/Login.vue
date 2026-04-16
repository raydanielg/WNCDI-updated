<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    canResetPassword: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
    status: {
        type: String,
        default: null,
    },
});

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

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex bg-gray-100 relative">
        <Head title="Log in" />

        <!-- Floating status alert -->
        <div
            v-if="showStatus && status"
            class="fixed top-4 right-4 z-50 max-w-sm"
        >
            <div class="bg-wncdi-light border border-wncdi-light text-wncdi-primary rounded-2xl shadow-lg px-4 py-3 text-xs flex items-start gap-2">
                <span class="mt-0.5 material-icons text-sm text-wncdi-accent">check_circle</span>
                <p class="leading-snug">{{ status }}</p>
            </div>
        </div>

        <!-- Left: Login form card -->
        <div class="flex-1 flex justify-center items-start px-4 pt-10 pb-8 sm:px-6 lg:px-12 lg:pt-16">
            <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10">
                <!-- Logo top -->
                <div class="mb-4 flex justify-center">
                    <img :src="'/img/WNCDiLogo.png'" alt="WNCDI Logo" class="h-12 w-auto" />
                </div>

                <!-- Welcome copy -->
                <div class="mb-6 text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Welcome to WNCDI</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Sign in to access your WNCDI account.
                    </p>
                </div>

                <!-- Social buttons (optional, static for UI) -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <button
                        type="button"
                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        <span class="h-6 w-6 rounded-full bg-white flex items-center justify-center shadow-sm">
                            <svg class="h-4 w-4" viewBox="0 0 48 48" aria-hidden="true">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.7 1.22 9.19 3.6l6.85-6.85C35.9 2.7 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.3 13.05 17.68 9.5 24 9.5z" />
                                <path fill="#34A853" d="M46.1 24.5c0-1.63-.15-3.2-.43-4.71H24v9.02h12.4c-.54 2.9-2.17 5.36-4.64 7.01l7.51 5.82C43.78 37.22 46.1 31.37 46.1 24.5z" />
                                <path fill="#FBBC05" d="M10.54 28.41A14.5 14.5 0 019.5 24c0-1.53.26-3.01.74-4.39l-7.98-6.19C.8 16.33 0 20.06 0 24c0 3.86.8 7.59 2.26 10.58l8.28-6.17z" />
                                <path fill="#4285F4" d="M24 48c6.48 0 11.93-2.13 15.9-5.79l-7.51-5.82C30.48 37.97 27.53 39 24 39c-6.32 0-11.7-3.55-14.16-8.91l-8.28 6.17C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </span>
                        <span>Google</span>
                    </button>
                    <button
                        type="button"
                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        <span class="h-6 w-6 rounded-full bg-black flex items-center justify-center">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    fill="white"
                                    d="M17.57 12.09c-.01-1.6.72-2.81 2.2-3.7-.83-1.2-2.09-1.87-3.73-2-1.56-.12-3.28.91-3.9.91-.64 0-2.05-.87-3.17-.87C7.1 6.5 4.5 8.1 4.5 11.79c0 1.17.21 2.38.64 3.62.57 1.6 2.6 5.52 4.72 5.46 1.1-.03 1.87-.78 3.3-.78 1.4 0 2.12.78 3.36.78 2.14-.03 3.96-3.57 4.51-5.18-2.88-1.36-3.46-4-3.47-4.6zM15.5 5.2c1.2-1.46 1.09-2.8 1.06-3.2-1.06.06-2.29.73-3.01 1.57-.78.9-1.24 2.02-1.14 3.18 1.16.09 2.22-.51 3.09-1.55z"
                                />
                            </svg>
                        </span>
                        <span>Apple</span>
                    </button>
                </div>

                <div class="flex items-center gap-3 mb-6">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-[11px] uppercase tracking-wide text-gray-400">or sign in with email</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
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

                    <div>
                        <InputLabel for="password" value="Password" class="text-xs font-semibold text-gray-700" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-wncdi-accent focus:ring-wncdi-accent text-sm"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />

                        <InputError class="mt-1 text-xs" :message="form.errors.password" />
                    </div>

                    <!-- Role selector + remember / forgot -->
                    <div class="flex flex-col gap-3 mt-1 text-xs">
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="text-gray-600">Remember me</span>
                            </label>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-wncdi-accent hover:text-wncdi-dark font-semibold"
                            >
                                Forgot password?
                            </Link>
                        </div>
                    </div>

                    <div class="pt-2">
                        <PrimaryButton
                            class="w-full justify-center bg-wncdi-accent hover:bg-wncdi-dark border-0 py-3 text-sm font-semibold flex items-center justify-center gap-2"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            <span
                                v-if="form.processing"
                                class="w-4 h-4 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Sign in to your account</span>
                        </PrimaryButton>
                    </div>
                </form>

                <p v-if="props.canRegister" class="mt-6 text-[11px] text-center text-gray-500">
                    Don't have an account?
                    <Link :href="route('register')" class="text-wncdi-accent font-semibold hover:text-wncdi-dark">Sign up</Link>
                </p>
            </div>
        </div>

        <!-- Right: Marketing / branding panel (no logo, just text) -->
        <div class="hidden lg:flex flex-1 bg-gradient-to-br from-slate-900 via-wncdi-primary to-blue-600 text-white items-center justify-center px-12">
            <div class="max-w-md">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-sm font-semibold tracking-wide uppercase text-emerald-100">WNCDi Platform</span>
                </div>
                <h2 class="text-3xl font-extrabold mb-4 leading-tight">
                    Empowering Youth Health & Community Development.
                </h2>
                <p class="text-sm text-emerald-50 mb-6">
                    Join our comprehensive wellness and educational initiatives focused on diabetes awareness, health education,
                    and community empowerment. Discover programs, resources, and opportunities to make a real difference in people's lives.
                </p>
                <div class="flex items-center gap-4 text-xs text-emerald-50">
                    <div class="flex flex-col">
                        <span class="font-semibold">Global Network</span>
                        <span>Members across Tanzania & beyond.</span>
                    </div>
                    <div class="h-10 w-px bg-wncdi-gold/40"></div>
                    <div class="flex flex-col">
                        <span class="font-semibold">Trusted by industry</span>
                        <span>Secure, audited, and optimized for results.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
