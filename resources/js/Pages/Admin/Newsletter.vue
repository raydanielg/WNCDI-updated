<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    subscriptions: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Newsletter" />
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Newsletter subscriptions</h1>
                    <p class="text-[11px] text-gray-500 mt-1">
                        List of email addresses that subscribed via the footer newsletter form.
                    </p>
                </div>
                <div class="text-[11px] text-gray-500">
                    <span class="font-semibold text-wncdi-dark">{{ props.subscriptions.length }}</span>
                    subscribers
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-xs">
                <table class="min-w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                            <th class="py-2 px-3 font-medium">Email</th>
                            <th class="py-2 px-3 font-medium">Name</th>
                            <th class="py-2 px-3 font-medium">Subscribed at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sub in props.subscriptions" :key="sub.id" class="border-b border-gray-50">
                            <td class="py-2 px-3 text-[11px] text-gray-900">{{ sub.email }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-600">{{ sub.name || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-500">{{ new Date(sub.created_at).toLocaleString() }}</td>
                        </tr>
                        <tr v-if="!props.subscriptions.length">
                            <td colspan="3" class="py-6 text-center text-[11px] text-gray-500">No subscriptions yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
