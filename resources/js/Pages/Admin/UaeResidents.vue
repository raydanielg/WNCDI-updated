<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    residents: {
        type: Array,
        default: () => [],
    },
});

const updateStatus = (resident, status) => {
    if (!status || resident.status === status) return;

    router.post(
        route('admin.uae-residents.update-status', resident.id),
        { status },
        {
            preserveScroll: true,
            preserveState: true,
        },
    );
};

const selectedIds = ref([]);

const allSelected = computed(() => {
    if (!props.residents.length) return false;
    return selectedIds.value.length === props.residents.length;
});

const toggleSelectAll = () => {
    if (allSelected.value) {
        selectedIds.value = [];
    } else {
        selectedIds.value = props.residents.map((resident) => resident.id);
    }
};

const toggleRow = (id) => {
    if (selectedIds.value.includes(id)) {
        selectedIds.value = selectedIds.value.filter((x) => x !== id);
    } else {
        selectedIds.value.push(id);
    }
};

const exportSelected = (format) => {
    if (!selectedIds.value.length) return;

    const params = new URLSearchParams();
    selectedIds.value.forEach((id) => params.append('ids[]', id));
    params.append('format', format);

    const url = route('admin.uae-residents.export') + '?' + params.toString();
    window.location.href = url;
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="UAE Resident registrations" />
        <div class="space-y-6">
            <div
                class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
            >
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">UAE Residents</h1>
                    <p class="text-[11px] text-gray-500 mt-1">
                        Submissions from the UAE residents diaspora registration form.
                    </p>
                </div>
                <div class="text-[11px] text-gray-500">
                    <span class="font-semibold text-wncdi-dark">{{ props.residents.length }}</span>
                    registrations
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-xs overflow-x-auto">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[11px] text-gray-500">
                        Select residents then export as PDF or Excel.
                    </p>
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="inline-flex items-center gap-1 rounded-full border border-gray-200 px-3 py-1.5 text-[11px] font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-40 disabled:cursor-default"
                            :disabled="!selectedIds.length"
                            @click="exportSelected('excel')"
                        >
                            <span class="material-icons text-[14px] text-wncdi-accent">grid_on</span>
                            <span>Export Excel</span>
                        </button>
                        <button
                            type="button"
                            class="inline-flex items-center gap-1 rounded-full border border-gray-200 px-3 py-1.5 text-[11px] font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-40 disabled:cursor-default"
                            :disabled="!selectedIds.length"
                            @click="exportSelected('pdf')"
                        >
                            <span class="material-icons text-[14px] text-wncdi-primary">picture_as_pdf</span>
                            <span>Export PDF</span>
                        </button>
                    </div>
                </div>

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
                            <th class="py-2 px-3 font-medium">Name</th>
                            <th class="py-2 px-3 font-medium">Email</th>
                            <th class="py-2 px-3 font-medium">Phone</th>
                            <th class="py-2 px-3 font-medium">City</th>
                            <th class="py-2 px-3 font-medium">Country</th>
                            <th class="py-2 px-3 font-medium">Nationality</th>
                            <th class="py-2 px-3 font-medium">Job title</th>
                            <th class="py-2 px-3 font-medium">Website</th>
                            <th class="py-2 px-3 font-medium">Attendee type</th>
                            <th class="py-2 px-3 font-medium"># People</th>
                            <th class="py-2 px-3 font-medium">Package</th>
                            <th class="py-2 px-3 font-medium">Status</th>
                            <th class="py-2 px-3 font-medium">Created</th>
                            <th class="py-2 px-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="resident in props.residents"
                            :key="resident.id"
                            class="border-b border-gray-50 hover:bg-gray-50/60"
                        >
                            <td class="py-2 px-3 text-[11px] text-gray-700">
                                <input
                                    type="checkbox"
                                    class="h-3.5 w-3.5 rounded border-gray-300 text-wncdi-accent"
                                    :value="resident.id"
                                    :checked="selectedIds.includes(resident.id)"
                                    @change="toggleRow(resident.id)"
                                />
                            </td>
                            <td class="py-2 px-3 text-[11px] text-gray-900">{{ resident.name }}</td>
                            <td class="py-2 px-3 text-[11px] text-wncdi-dark">{{ resident.email }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.phone || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.city || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.country || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.nationality || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.job_title || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-wncdi-dark truncate max-w-[140px]">
                                <a v-if="resident.website" :href="resident.website" target="_blank" class="hover:underline">
                                    {{ resident.website }}
                                </a>
                                <span v-else>-</span>
                            </td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.attendee_type || '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.attendee_count ?? '-' }}</td>
                            <td class="py-2 px-3 text-[11px] text-gray-700">{{ resident.package || '-' }}</td>
                            <td class="py-2 px-3 text-[11px]">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium"
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': !resident.status || resident.status === 'pending',
                                        'bg-wncdi-light text-wncdi-primary': resident.status === 'approved',
                                        'bg-blue-100 text-blue-800': resident.status === 'rejected',
                                    }"
                                >
                                    {{ resident.status || 'pending' }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-[11px] text-gray-500">
                                {{ new Date(resident.created_at).toLocaleString() }}
                            </td>
                            <td class="py-2 px-3 text-[11px] text-right">
                                <div class="flex gap-1 justify-end">
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[10px] border border-wncdi-light text-wncdi-dark bg-wncdi-light hover:bg-wncdi-light disabled:opacity-60 disabled:cursor-default"
                                        :disabled="resident.status === 'approved'"
                                        @click="updateStatus(resident, 'approved')"
                                    >
                                        <span class="material-icons text-[13px]">check_circle</span>
                                        <span>Approve</span>
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[10px] border border-rose-200 text-rose-700 bg-blue-50 hover:bg-blue-100 disabled:opacity-60 disabled:cursor-default"
                                        :disabled="resident.status === 'rejected'"
                                        @click="updateStatus(resident, 'rejected')"
                                    >
                                        <span class="material-icons text-[13px]">cancel</span>
                                        <span>Reject</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!props.residents.length">
                            <td colspan="15" class="py-6 text-center text-[11px] text-gray-500">No registrations yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
