<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

const globalServiceError = computed(() => {
    const errors = page.props.errors || {};
    return errors.service || null;
});

const selectedService = ref(null);
const createModalOpen = ref(false);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

const serviceForm = useForm({
    title: '',
    short_description: '',
    body: '',
    image_url: '',
    image: null,
});

const openCreateModal = () => {
    selectedService.value = null;
    serviceForm.reset();
    serviceForm.image = null;
    createModalOpen.value = true;
};

const submitCreate = () => {
    serviceForm.post(route('admin.services.store'), {
        preserveScroll: true,
        onSuccess: () => {
            createModalOpen.value = false;
            serviceForm.reset();
        },
    });
};

const openEditModal = (service) => {
    selectedService.value = service;
    serviceForm.title = service.title;
    serviceForm.short_description = service.short_description;
    serviceForm.body = service.body;
    serviceForm.image_url = service.image_url || '';
    serviceForm.image = null;
    editModalOpen.value = true;
};

const submitEdit = () => {
    if (!selectedService.value) return;

    serviceForm.post(route('admin.services.update', selectedService.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            editModalOpen.value = false;
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (service) => {
    selectedService.value = service;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedService.value) return;

    deleteForm.post(route('admin.services.destroy', selectedService.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const serviceCount = computed(() => props.services.length);
</script>

<template>
    <Head title="Services Management" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Global error popup -->
            <div
                v-if="globalServiceError"
                class="fixed top-16 right-6 z-50 max-w-xs bg-red-50 border border-red-200 text-red-800 text-[11px] rounded-xl shadow-sm px-3 py-2 flex items-start gap-2"
            >
                <span class="material-icons text-[14px] mt-[1px]">error_outline</span>
                <div>
                    <p class="font-semibold mb-0.5">Action failed</p>
                    <p class="text-[10px] leading-snug">{{ globalServiceError }}</p>
                </div>
            </div>

            <!-- Header -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Services Management</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Create and edit the services shown on the Services page.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">design_services</span>
                        <span class="font-semibold">{{ serviceCount }}</span>
                        <span class="text-wncdi-primary/80">services</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New service</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">Services</h2>
                    <p class="text-[11px] text-gray-500">Manage titles, summaries and content for each service.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Title</th>
                                <th class="py-2 px-3 font-medium">Summary</th>
                                <th class="py-2 px-3 font-medium">Image</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="service in services"
                                :key="service.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3 text-[11px] text-gray-900 font-medium">
                                    {{ service.title }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600 max-w-xs">
                                    <span class="line-clamp-2">{{ service.short_description }}</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="h-10 w-16 bg-gray-50 border border-gray-100 rounded overflow-hidden flex items-center justify-center">
                                        <img
                                            v-if="service.image_url"
                                            :src="service.image_url"
                                            :alt="service.title"
                                            class="h-full w-full object-cover"
                                        />
                                        <span v-else class="text-[9px] text-gray-400">No image</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ new Date(service.created_at).toLocaleDateString() }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openEditModal(service)"
                                        >
                                            <span class="material-icons text-[12px]">edit</span>
                                            <span>Edit</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1"
                                            @click="openDeleteModal(service)"
                                        >
                                            <span class="material-icons text-[12px]">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!services.length">
                                <td colspan="5" class="py-6 text-center text-[11px] text-gray-500">
                                    No services found.
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
                        {{ createModalOpen ? 'Create service' : 'Edit service' }}
                    </h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Manage the title, summary, content and image for this service.
                    </p>

                    <div class="space-y-3">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title</label>
                            <input
                                v-model="serviceForm.title"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Short description</label>
                            <input
                                v-model="serviceForm.short_description"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Detailed description</label>
                            <textarea
                                v-model="serviceForm.body"
                                rows="6"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                placeholder="Explain this service in detail so readers can understand what you offer."
                            ></textarea>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Image</label>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    serviceForm.image = file;
                                }"
                            />
                            <p v-if="serviceForm.errors.image" class="mt-1 text-[10px] text-red-600">
                                {{ serviceForm.errors.image }}
                            </p>
                            <div class="mt-2 flex items-center gap-2" v-if="serviceForm.image || serviceForm.image_url">
                                <span class="text-[10px] text-gray-500">Preview:</span>
                                <div class="h-12 w-20 rounded border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center">
                                    <img
                                        v-if="serviceForm.image"
                                        :src="URL.createObjectURL(serviceForm.image)"
                                        alt="Preview"
                                        class="h-full w-full object-cover"
                                    />
                                    <img
                                        v-else-if="serviceForm.image_url"
                                        :src="serviceForm.image_url"
                                        alt="Current image"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
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
                            :disabled="serviceForm.processing"
                            @click="createModalOpen ? submitCreate() : submitEdit()"
                        >
                            <span
                                v-if="serviceForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>{{ createModalOpen ? 'Create service' : 'Save changes' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete modal -->
            <div
                v-if="deleteModalOpen && selectedService"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete service</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete
                        <span class="font-semibold">{{ selectedService.title }}</span>? This action cannot be undone.
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
