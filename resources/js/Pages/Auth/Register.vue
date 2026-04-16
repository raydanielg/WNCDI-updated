<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="min-h-screen flex bg-gray-100">
        <Head title="Register" />

        <!-- Left: Register card -->
        <div class="flex-1 flex justify-center items-start px-4 pt-10 pb-8 sm:px-6 lg:px-12 lg:pt-16">
            <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10">
                <!-- Logo top -->
                <div class="mb-4 flex justify-center">
                    <img src="/tanford.logo.png" alt="Tanford Logo" class="h-12 w-auto" />
                </div>

                <!-- Title + description -->
                <div class="mb-6 text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Create your Tanford account</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Join the Tanford network to access forums, events, and logistics opportunities.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <InputLabel for="name" value="Full name" class="text-xs font-semibold text-gray-700" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-wncdi-accent focus:ring-wncdi-accent text-sm"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <InputError class="mt-1 text-xs" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" class="text-xs font-semibold text-gray-700" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-wncdi-accent focus:ring-wncdi-accent text-sm"
                            v-model="form.email"
                            required
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
                            autocomplete="new-password"
                        />

                        <InputError class="mt-1 text-xs" :message="form.errors.password" />
                    </div>

                    <div>
                        <InputLabel
                            for="password_confirmation"
                            value="Confirm Password"
                            class="text-xs font-semibold text-gray-700"
                        />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-wncdi-accent focus:ring-wncdi-accent text-sm"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />

                        <InputError
                            class="mt-1 text-xs"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <div class="pt-2 flex items-center justify-between text-xs">
                        <Link
                            :href="route('login')"
                            class="text-gray-500 hover:text-gray-700"
                        >
                            Already registered? Log in
                        </Link>

                        <PrimaryButton
                            class="inline-flex justify-center items-center gap-2 bg-wncdi-accent hover:bg-wncdi-dark border-0 py-2.5 px-4 text-sm font-semibold"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            <span
                                v-if="form.processing"
                                class="w-4 h-4 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Create account</span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Info panel -->
        <div class="hidden lg:flex flex-1 bg-gradient-to-br from-slate-900 via-wncdi-primary to-blue-600 text-white items-center justify-center px-12">
            <div class="max-w-md">
                <h2 class="text-3xl font-extrabold mb-4 leading-tight">Become part of the Tanford network.</h2>
                <p class="text-sm text-emerald-50 mb-6">
                    Register as a member to stay informed about forums, events, and logistics opportunities connecting
                    Tanzania with the global market.
                </p>
                <p class="text-xs text-emerald-100">
                    Your account gives you faster registration, personalized communication, and access to exclusive
                    partner content.
                </p>
            </div>
        </div>
    </div>
</template>
