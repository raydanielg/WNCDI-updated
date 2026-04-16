<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    members: {
        type: Array,
        default: () => [],
    },
});

const updateStatus = (member, status) => {
    if (!status || member.status === status) return;

    router.post(
        route('admin.tanford-members.update-status', member.id),
        { status },
        {
            preserveScroll: true,
            preserveState: true,
        },
    );
};

const selectedIds = ref([]);

const allSelected = computed(() => {
    if (!props.members.length) return false;
    return selectedIds.value.length === props.members.length;
});

const toggleSelectAll = () => {
    if (allSelected.value) {
        selectedIds.value = [];
    } else {
        selectedIds.value = props.members.map((m) => m.id);
    }
};

const toggleRow = (id) => {
    if (selectedIds.value.includes(id)) {
        selectedIds.value = selectedIds.value.filter((x) => x !== id);
    } else {
        selectedIds.value.push(id);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="TANFORD members" />
        <div class="space-y-6">
            <div
                class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
            >
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">TANFORD Membership Applications</h1>
                    <p class="text-[11px] text-gray-500 mt-1">
                        Submissions from the TANFORD membership registration form.
                    </p>
                </div>
                <div class="text-[11px] text-gray-500">
                    <span class="font-semibold text-wncdi-dark">{{ props.members.length }}</span>
                    applications
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-xs overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                            <th class="py-2 px-3 font-medium w-8">
                                <input
                                    type="checkbox"
                                    class="h-3.5 w-3.5 rounded border-gray-300 text-wncdi-accent"
                                    :checked="allSelected"
                                    @change="toggleSelectAll"
                                />
                            </th>
                            <th class="py-2 px-3 font-medium">Full name</th>
                            <th class="py-2 px-3 font-medium">Email</th>
                            <th class="py-2 px-3 font-medium">WhatsApp</th>
                            <th class="py-2 px-3 font-medium">Company</th>
                            <th class="py-2 px-3 font-medium">Country of registration</th>
                            <th class="py-2 px-3 font-medium">Status</th>
                            <th class="py-2 px-3 font-medium">Created</th>
                            <th class="py-2 px-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="member in props.members"
                            :key="member.id"
                            class="border-b border-gray-50 hover:bg-gray-50/60"
                        >
                            <td class="py-2 px-3 text-[11px] text-gray-700">
                                <input
                                    type="checkbox"
                                    class="h-3.5 w-3.5 rounded border-gray-300 text-wncdi-accent"
                                    :value="member.id"
                                    :checked="selectedIds.includes(member.id)"
                                    @change="toggleRow(member.id)"
                                />
                            </td>
                            <td class="py-2 px-3 text-[11px] text-gray-900">{{ member.full_name }}</td>
                            <td class="py-2 px-3 text-[11px] text-wncdi-dark">{{ member.email || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ member.whatsapp || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ member.company_name || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ member.country_of_registration || '-' }}</td>
                            <td class="py-2 px-3 text-[11px]">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium"
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': !member.status || member.status === 'pending',
                                        'bg-wncdi-light text-wncdi-primary': member.status === 'approved',
                                        'bg-rose-100 text-rose-800': member.status === 'rejected',
                                    }"
                                >
                                    {{ member.status || 'pending' }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-[11px] text-gray-500">
                                {{ new Date(member.created_at).toLocaleString() }}
                            </td>
                            <td class="py-2 px-3 text-[11px] text-right">
                                <div class="flex gap-1 justify-end">
                                    <Link
                                        :href="route('admin.tanford-members.show', member.id)"
                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[10px] border border-gray-200 text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        <span class="material-icons text-[13px]">visibility</span>
                                        <span>View details</span>
                                    </Link>
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[10px] border border-wncdi-light text-wncdi-dark bg-wncdi-light hover:bg-wncdi-light disabled:opacity-60 disabled:cursor-default"
                                        :disabled="member.status === 'approved'"
                                        @click="updateStatus(member, 'approved')"
                                    >
                                        <span class="material-icons text-[13px]">check_circle</span>
                                        <span>Approve</span>
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[10px] border border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100 disabled:opacity-60 disabled:cursor-default"
                                        :disabled="member.status === 'rejected'"
                                        @click="updateStatus(member, 'rejected')"
                                    >
                                        <span class="material-icons text-[13px]">cancel</span>
                                        <span>Reject</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!props.members.length">
                            <td colspan="9" class="py-6 text-center text-[11px] text-gray-500">No members yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
