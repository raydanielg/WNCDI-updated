<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    settings: {
        type: Object,
        default: () => null,
    },
});

const form = useForm({
    mailer: props.settings?.mailer || 'smtp',
    host: props.settings?.host || '',
    port: props.settings?.port || 587,
    username: props.settings?.username || '',
    password: '',
    encryption: props.settings?.encryption || 'tls',
    from_address: props.settings?.from_address || '',
    from_name: props.settings?.from_name || '',
});

const testForm = useForm({
    test_email: '',
});

const submit = () => {
    form.post(route('admin.settings.mail.update'), {
        preserveScroll: true,
    });
};

const sendTestEmail = () => {
    testForm.post(route('admin.settings.mail.test'), {
        preserveScroll: true,
        onSuccess: () => {
            testForm.reset();
        },
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="SMTP &amp; email settings" />

        <div class="space-y-6 max-w-3xl">
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h1 class="text-lg font-semibold text-gray-900">SMTP &amp; email</h1>
                <p class="text-[11px] text-gray-500 mt-1">Configure how the application sends emails.</p>
            </div>

            <form
                @submit.prevent="submit"
                class="bg-white rounded-2xl border border-gray-100 p-5 text-xs space-y-6"
            >
                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-1">
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">Mailer</label>
                        <select
                            v-model="form.mailer"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        >
                            <option value="smtp">SMTP</option>
                            <option value="sendmail">Sendmail</option>
                            <option value="log">Log (development)</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2 grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Host</label>
                            <input
                                v-model="form.host"
                                type="text"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="smtp.mailtrap.io"
                            />
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Port</label>
                            <input
                                v-model.number="form.port"
                                type="number"
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="587"
                            />
                        </div>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">Username</label>
                        <input
                            v-model="form.username"
                            type="text"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        />
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">Password</label>
                        <input
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                            placeholder="••••••••"
                        />
                        <p class="mt-1 text-[10px] text-gray-400">Leave blank to keep existing password.</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">Encryption</label>
                        <select
                            v-model="form.encryption"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                        >
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                            <option value="none">None</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">From address</label>
                        <input
                            v-model="form.from_address"
                            type="email"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                            placeholder="no-reply@example.com"
                        />
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-700 mb-1">From name</label>
                        <input
                            v-model="form.from_name"
                            type="text"
                            class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                            placeholder="WNCDi"
                        />
                    </div>
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

            <!-- Test Email Section -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Test Email Configuration</h2>
                    <p class="text-[11px] text-gray-500 mt-1">Send a test email to verify your SMTP settings are working correctly.</p>
                </div>

                <form @submit.prevent="sendTestEmail" class="space-y-4">
                    <div class="flex gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-[11px] font-medium text-gray-700 mb-1">Recipient Email Address</label>
                            <input
                                v-model="testForm.test_email"
                                type="email"
                                required
                                class="w-full rounded-lg border-gray-300 text-[12px] focus:ring-wncdi-accent focus:border-wncdi-accent"
                                placeholder="your-email@example.com"
                            />
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-[11px] font-semibold text-white hover:bg-blue-700 disabled:bg-blue-400 disabled:cursor-not-allowed"
                            :disabled="testForm.processing"
                        >
                            <span v-if="testForm.processing" class="inline-flex h-4 w-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                            <span class="material-icons text-sm">send</span>
                            <span>Send Test Email</span>
                        </button>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex gap-2">
                            <span class="material-icons text-blue-600 text-base">info</span>
                            <div class="text-[11px] text-blue-800">
                                <p class="font-medium mb-1">How to test:</p>
                                <ol class="list-decimal list-inside space-y-1">
                                    <li>Enter your email address above</li>
                                    <li>Click "Send Test Email"</li>
                                    <li>Check your inbox for the test message</li>
                                    <li>If you don't receive it, check your spam folder or verify your SMTP settings</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
