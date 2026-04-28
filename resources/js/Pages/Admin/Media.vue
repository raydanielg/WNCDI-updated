<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

const globalMediaError = computed(() => {
    const errors = page.props.errors || {};
    return errors.media || null;
});

const createModalOpen = ref(false);
const selectedItem = ref(null);
const deleteModalOpen = ref(false);

const mediaForm = useForm({
    title: '',
    description: '',
    file: null,
});

const openCreateModal = () => {
    mediaForm.reset();
    mediaForm.file = null;
    createModalOpen.value = true;
};

const submitCreate = () => {
    mediaForm.post(route('admin.media.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            createModalOpen.value = false;
            mediaForm.reset();
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (item) => {
    selectedItem.value = item;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedItem.value) return;

    deleteForm.post(route('admin.media.destroy', selectedItem.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const itemCount = computed(() => props.items.length);
</script>

<template>
    <Head title="Media Gallery" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Global error popup -->
            <div
                v-if="globalMediaError"
                class="fixed top-16 right-6 z-50 max-w-xs bg-red-50 border border-red-200 text-red-800 text-[11px] rounded-xl shadow-sm px-3 py-2 flex items-start gap-2"
            >
                <span class="material-icons text-[14px] mt-[1px]">error_outline</span>
                <div>
                    <p class="font-semibold mb-0.5">Action failed</p>
                    <p class="text-[10px] leading-snug">{{ globalMediaError }}</p>
                </div>
            </div>

            <!-- Header -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Media Gallery</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Upload images and videos for the public gallery.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">collections</span>
                        <span class="font-semibold">{{ itemCount }}</span>
                        <span class="text-wncdi-primary/80">items</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New media</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">Gallery items</h2>
                    <p class="text-[11px] text-gray-500">Manage images and videos shown on the gallery page.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Preview</th>
                                <th class="py-2 px-3 font-medium">Title</th>
                                <th class="py-2 px-3 font-medium">Type</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in items"
                                :key="item.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3">
                                    <div class="h-12 w-20 bg-gray-50 border border-gray-100 rounded overflow-hidden flex items-center justify-center">
                                        <img
                                            v-if="item.type === 'image'"
                                            :src="item.file_url"
                                            :alt="item.title"
                                            class="h-full w-full object-cover"
                                        />
                                        <div
                                            v-else-if="item.type === 'video'"
                                            class="flex items-center justify-center text-[9px] text-gray-500 flex-col"
                                        >
                                            <span class="material-icons text-base mb-0.5">videocam</span>
                                            <span>Video</span>
                                        </div>
                                        <span v-else class="text-[9px] text-gray-400">File</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-900">
                                    {{ item.title }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ item.type }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ new Date(item.created_at).toLocaleDateString() }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <button
                                        class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1 ml-auto"
                                        @click="openDeleteModal(item)"
                                    >
                                        <span class="material-icons text-[12px]">delete</span>
                                        <span>Delete</span>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!items.length">
                                <td colspan="5" class="py-6 text-center text-[11px] text-gray-500">
                                    No media items found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create modal -->
            <div
                v-if="createModalOpen"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-5 max-h-[90vh] overflow-y-auto text-xs">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Upload media</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Upload an image or video file for the public gallery.
                    </p>

                    <div class="space-y-3">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title</label>
                            <input
                                v-model="mediaForm.title"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                            <p v-if="mediaForm.errors.title" class="mt-1 text-[10px] text-red-600">
                                {{ mediaForm.errors.title }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">File (image or video)</label>
                            <input
                                type="file"
                                accept="image/*,video/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    mediaForm.file = file;
                                }"
                            />
                            <p v-if="mediaForm.errors.file" class="mt-1 text-[10px] text-red-600">
                                {{ mediaForm.errors.file }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-5 text-[11px]">
                        <button
                            class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100"
                            type="button"
                            @click="createModalOpen = false"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-3 py-1.5 rounded-full bg-wncdi-accent text-white text-xs font-semibold hover:bg-wncdi-dark flex items-center gap-2"
                            type="button"
                            :disabled="mediaForm.processing"
                            @click="submitCreate"
                        >
                            <span
                                v-if="mediaForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Upload</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete modal -->
            <div
                v-if="deleteModalOpen && selectedItem"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete media</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete
                        <span class="font-semibold">{{ selectedItem.title }}</span>? This action cannot be undone.
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
