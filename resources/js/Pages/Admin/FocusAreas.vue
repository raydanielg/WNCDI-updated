<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    areas: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

const globalFocusError = computed(() => {
    const errors = page.props.errors || {};
    return errors.focus || null;
});

const selectedArea = ref(null);
const createModalOpen = ref(false);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

const areaForm = useForm({
    title: '',
    description: '',
    icon: '',
    image: null,
    sort_order: 0,
});

const iconOptions = [
    { value: 'category', label: 'Category' },
    { value: 'insights', label: 'Insights' },
    { value: 'analytics', label: 'Analytics' },
    { value: 'local_shipping', label: 'Logistics & Shipping' },
    { value: 'public', label: 'Global / Trade' },
    { value: 'support_agent', label: 'Advisory / Support' },
    { value: 'hub', label: 'Network / Hub' },
    { value: 'verified', label: 'Quality / Assurance' },
    { value: 'travel_explore', label: 'Expansion / Markets' },
    { value: 'shield', label: 'Security / Compliance' },
];

const openCreateModal = () => {
    selectedArea.value = null;
    areaForm.reset();
    areaForm.image = null;
    areaForm.sort_order = 0;
    createModalOpen.value = true;
};

const submitCreate = () => {
    areaForm.post(route('admin.focus-areas.store'), {
        preserveScroll: true,
        onSuccess: () => {
            createModalOpen.value = false;
            areaForm.reset();
            areaForm.image = null;
        },
    });
};

const openEditModal = (area) => {
    selectedArea.value = area;
    areaForm.title = area.title;
    areaForm.description = area.description;
    areaForm.icon = area.icon || '';
    areaForm.image = null;
    areaForm.sort_order = area.sort_order || 0;
    editModalOpen.value = true;
};

const submitEdit = () => {
    if (!selectedArea.value) return;

    areaForm.post(route('admin.focus-areas.update', selectedArea.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            editModalOpen.value = false;
            areaForm.image = null;
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (area) => {
    selectedArea.value = area;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedArea.value) return;

    deleteForm.post(route('admin.focus-areas.destroy', selectedArea.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const areaCount = computed(() => props.areas.length);
</script>

<template>
    <Head title="Focus Areas" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Global error popup -->
            <div
                v-if="globalFocusError"
                class="fixed top-16 right-6 z-50 max-w-xs bg-red-50 border border-red-200 text-red-800 text-[11px] rounded-xl shadow-sm px-3 py-2 flex items-start gap-2"
            >
                <span class="material-icons text-[14px] mt-[1px]">error_outline</span>
                <div>
                    <p class="font-semibold mb-0.5">Action failed</p>
                    <p class="text-[10px] leading-snug">{{ globalFocusError }}</p>
                </div>
            </div>

            <!-- Header -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Our Focus Areas</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Manage the cards shown in the "Our Focus Areas" section on the homepage.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">category</span>
                        <span class="font-semibold">{{ areaCount }}</span>
                        <span class="text-wncdi-primary/80">areas</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New focus area</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">Focus Areas</h2>
                    <p class="text-[11px] text-gray-500">Titles, descriptions and icons for the homepage focus cards.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Order</th>
                                <th class="py-2 px-3 font-medium">Title</th>
                                <th class="py-2 px-3 font-medium">Description</th>
                                <th class="py-2 px-3 font-medium">Icon</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="area in areas"
                                :key="area.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ area.sort_order }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-900 font-medium">
                                    {{ area.title }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600 max-w-xs">
                                    <span class="line-clamp-2">{{ area.description }}</span>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    <span v-if="area.icon" class="inline-flex items-center gap-1">
                                        <span class="material-icons text-base">{{ area.icon }}</span>
                                        <span>{{ area.icon }}</span>
                                    </span>
                                    <span v-else class="text-[10px] text-gray-400">default icon</span>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openEditModal(area)"
                                        >
                                            <span class="material-icons text-[12px]">edit</span>
                                            <span>Edit</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1"
                                            @click="openDeleteModal(area)"
                                        >
                                            <span class="material-icons text-[12px]">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!areas.length">
                                <td colspan="5" class="py-6 text-center text-[11px] text-gray-500">
                                    No focus areas found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create / Edit modal -->
            <div
                v-if="createModalOpen || editModalOpen"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-5 max-h-[90vh] overflow-y-auto text-xs">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">
                        {{ createModalOpen ? 'Create focus area' : 'Edit focus area' }}
                    </h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Manage the title, description and icon for this focus area card.
                    </p>

                    <div class="space-y-3">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title</label>
                            <input
                                v-model="areaForm.title"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Description</label>
                            <textarea
                                v-model="areaForm.description"
                                rows="3"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Focus Area Image</label>
                            <div v-if="selectedArea?.image_url" class="mb-2">
                                <img :src="selectedArea.image_url" :alt="selectedArea.title" class="w-full h-32 object-cover rounded-lg border border-gray-200" />
                            </div>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    areaForm.image = file;
                                }"
                            />
                            <p v-if="areaForm.errors.image" class="mt-1 text-[10px] text-red-600">
                                {{ areaForm.errors.image }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Icon</label>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1">
                                        <select
                                            v-model="areaForm.icon"
                                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent bg-white"
                                        >
                                            <option value="">Default (category)</option>
                                            <option
                                                v-for="icon in iconOptions"
                                                :key="icon.value"
                                                :value="icon.value"
                                            >
                                                {{ icon.label }}
                                            </option>
                                        </select>
                                    </div>
                                    <div
                                        class="w-9 h-9 rounded-full bg-wncdi-light text-wncdi-dark flex items-center justify-center border border-emerald-100"
                                    >
                                        <span class="material-icons text-base">
                                            {{ areaForm.icon || 'category' }}
                                        </span>
                                    </div>
                                </div>
                                <p class="mt-1 text-[10px] text-gray-400">
                                    Choose a nice Material icon for this focus area.
                                </p>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Order</label>
                                <input
                                    v-model.number="areaForm.sort_order"
                                    type="number"
                                    min="0"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-5 text-[11px]">
                        <button
                            class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100"
                            type="button"
                            @click="createModalOpen ? (createModalOpen = false) : (editModalOpen = false)"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-3 py-1.5 rounded-full bg-wncdi-accent text-white text-xs font-semibold hover:bg-wncdi-dark flex items-center gap-2"
                            type="button"
                            :disabled="areaForm.processing"
                            @click="createModalOpen ? submitCreate() : submitEdit()"
                        >
                            <span
                                v-if="areaForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>{{ createModalOpen ? 'Create focus area' : 'Save changes' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete modal -->
            <div
                v-if="deleteModalOpen && selectedArea"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete focus area</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete
                        <span class="font-semibold">{{ selectedArea.title }}</span>? This action cannot be undone.
                    </p>
                    <div class="flex justify-end gap-2 text-[11px]">
                        <button
                            class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100"
                            type="button"
                            @click="deleteModalOpen = false"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-3 py-1.5 rounded-full bg-red-600 text-white text-xs font-semibold hover:bg-red-700 flex items-center gap-2"
                            type="button"
                            :disabled="deleteForm.processing"
                            @click="submitDelete"
                        >
                            <span
                                v-if="deleteForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
