<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    systemEnabled: {
        type: Boolean,
        default: true,
    },
});

const form = useForm({
    system_enabled: props.systemEnabled,
});

const statusText = computed(() => (form.system_enabled ? 'System is currently ON' : 'System is currently OFF'));
const statusColor = computed(() => (form.system_enabled ? 'text-wncdi-accent bg-wncdi-light border-wncdi-light' : 'text-rose-600 bg-rose-50 border-rose-200'));

const submit = () => {
    form.post(route('superadmin.system.toggle'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Superadmin Control Panel" />

        <div class="max-w-3xl space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Superadmin Control Panel</h1>
                    <p class="mt-1 text-xs text-gray-500">
                        Use this panel to temporarily turn the public system on or off.
                    </p>
                </div>
                <div class="text-right text-[11px] text-gray-400">
                    <div class="font-mono">support@wncdi.local</div>
                    <div class="font-mono">**********</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5 text-xs">
                <div :class="['flex items-center justify-between rounded-xl border px-4 py-3', statusColor]">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-base" v-if="form.system_enabled">check_circle</span>
                        <span class="material-icons text-base" v-else>error_outline</span>
                        <span class="font-semibold">{{ statusText }}</span>
                    </div>
                    <span class="text-[11px] text-gray-500" v-if="!form.system_enabled">
                        Visitors will see the maintenance page with WhatsApp contact.
                    </span>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-[11px] font-semibold uppercase tracking-wide text-gray-500 mb-1">
                                System availability
                            </h2>
                            <p class="text-[11px] text-gray-500 max-w-sm">
                                Turn OFF the system when you want to perform maintenance or stop new access. Only
                                superadmin can toggle this.
                            </p>
                        </div>
                        <button
                            type="button"
                            class="relative inline-flex h-7 w-12 items-center rounded-full border transition-colors duration-200"
                            :class="form.system_enabled ? 'bg-wncdi-accent border-wncdi-accent' : 'bg-gray-200 border-gray-300'"
                            @click="form.system_enabled = !form.system_enabled"
                        >
                            <span
                                class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform duration-200"
                                :class="form.system_enabled ? 'translate-x-5' : 'translate-x-1'"
                            ></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                        <p class="text-[11px] text-gray-500 max-w-sm">
                            When the system is turned OFF, visitors will be redirected to a simple page with your
                            contact:
                            <span class="font-semibold">WhatsApp +255 613 976 254</span>.
                        </p>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-wncdi-accent px-4 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark disabled:bg-wncdi-gold disabled:cursor-not-allowed"
                            :disabled="form.processing"
                        >
                            <span
                                v-if="form.processing"
                                class="inline-flex h-4 w-4 border-2 border-white/40 border-t-white rounded-full animate-spin"
                            ></span>
                            <span>Save status</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
