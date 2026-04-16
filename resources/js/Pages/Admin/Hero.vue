<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    slides: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

const globalError = computed(() => {
    const errors = page.props.errors || {};
    return errors.slide || null;
});

const selectedSlide = ref(null);
const createModalOpen = ref(false);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

const slideForm = useForm({
    title: '',
    badge: '',
    description: '',
    image: null,
    sort_order: 1,
    is_active: true,
});

const openCreateModal = () => {
    selectedSlide.value = null;
    slideForm.reset();
    slideForm.image = null;
    slideForm.sort_order = (props.slides?.length || 0) + 1;
    slideForm.is_active = true;
    createModalOpen.value = true;
};

const submitCreate = () => {
    slideForm.post(route('admin.hero.store'), {
        preserveScroll: true,
        onSuccess: () => {
            createModalOpen.value = false;
            slideForm.reset();
            slideForm.image = null;
        },
    });
};

const openEditModal = (slide) => {
    selectedSlide.value = slide;
    slideForm.title = slide.title;
    slideForm.badge = slide.badge || '';
    slideForm.description = slide.description || '';
    slideForm.image = null;
    slideForm.sort_order = slide.sort_order || 1;
    slideForm.is_active = !!slide.is_active;
    editModalOpen.value = true;
};

const submitEdit = () => {
    if (!selectedSlide.value) return;

    slideForm.post(route('admin.hero.update', selectedSlide.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            editModalOpen.value = false;
            slideForm.image = null;
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (slide) => {
    selectedSlide.value = slide;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedSlide.value) return;

    deleteForm.post(route('admin.hero.destroy', selectedSlide.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const slideCount = computed(() => props.slides.length);
</script>

<template>
    <Head title="Hero Management" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div
                v-if="globalError"
                class="fixed top-16 right-6 z-50 max-w-xs bg-red-50 border border-red-200 text-red-800 text-[11px] rounded-xl shadow-sm px-3 py-2 flex items-start gap-2"
            >
                <span class="material-icons text-[14px] mt-[1px]">error_outline</span>
                <div>
                    <p class="font-semibold mb-0.5">Action failed</p>
                    <p class="text-[10px] leading-snug">{{ globalError }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Hero Management</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Manage the slides and text shown in the homepage hero section.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">view_carousel</span>
                        <span class="font-semibold">{{ slideCount }}</span>
                        <span class="text-wncdi-primary/80">slides</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New slide</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">Hero slides</h2>
                    <p class="text-[11px] text-gray-500">Control the main text and order of hero slides on the homepage.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Title</th>
                                <th class="py-2 px-3 font-medium">Badge</th>
                                <th class="py-2 px-3 font-medium">Active</th>
                                <th class="py-2 px-3 font-medium">Order</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="slide in slides"
                                :key="slide.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3 text-[11px] text-gray-900 font-medium">
                                    {{ slide.title }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600 max-w-xs">
                                    <span class="line-clamp-1">{{ slide.badge }}</span>
                                </td>
                                <td class="py-2.5 px-3 text-[11px]">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px]"
                                        :class="slide.is_active ? 'bg-wncdi-light text-wncdi-dark border border-emerald-100' : 'bg-gray-50 text-gray-500 border border-gray-200'"
                                    >
                                        <span class="material-icons text-[12px]">
                                            {{ slide.is_active ? 'check_circle' : 'radio_button_unchecked' }}
                                        </span>
                                        <span>{{ slide.is_active ? 'Active' : 'Inactive' }}</span>
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ slide.sort_order }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ new Date(slide.created_at).toLocaleDateString() }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openEditModal(slide)"
                                        >
                                            <span class="material-icons text-[12px]">edit</span>
                                            <span>Edit</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1"
                                            @click="openDeleteModal(slide)"
                                        >
                                            <span class="material-icons text-[12px]">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!slides.length">
                                <td colspan="6" class="py-6 text-center text-[11px] text-gray-500">
                                    No hero slides found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div
                v-if="createModalOpen || editModalOpen"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-5 max-h-[90vh] overflow-y-auto text-xs">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">
                        {{ createModalOpen ? 'Create hero slide' : 'Edit hero slide' }}
                    </h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Manage the title, badge, description and status for this hero slide.
                    </p>

                    <div class="space-y-3">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title</label>
                            <input
                                v-model="slideForm.title"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Badge (small text above)</label>
                            <input
                                v-model="slideForm.badge"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Description</label>
                            <textarea
                                v-model="slideForm.description"
                                rows="4"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                placeholder="Short paragraph describing this slide."
                            ></textarea>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Hero Image</label>
                            <div v-if="selectedSlide?.image_url" class="mb-2">
                                <img :src="selectedSlide.image_url" :alt="selectedSlide.title" class="w-full h-24 object-cover rounded-lg border border-gray-200" />
                            </div>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    slideForm.image = file;
                                }"
                            />
                            <p v-if="slideForm.errors.image" class="mt-1 text-[10px] text-red-600">
                                {{ slideForm.errors.image }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Order</label>
                                <input
                                    v-model.number="slideForm.sort_order"
                                    type="number"
                                    min="1"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                            <div class="flex items-center gap-2 mt-5">
                                <input
                                    id="is_active"
                                    type="checkbox"
                                    v-model="slideForm.is_active"
                                    class="h-3.5 w-3.5 text-wncdi-accent border-gray-300 rounded"
                                />
                                <label for="is_active" class="text-[11px] text-gray-700">Active (visible on site)</label>
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
                            :disabled="slideForm.processing"
                            @click="createModalOpen ? submitCreate() : submitEdit()"
                        >
                            <span
                                v-if="slideForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>{{ createModalOpen ? 'Create slide' : 'Save changes' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div
                v-if="deleteModalOpen && selectedSlide"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete hero slide</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete
                        <span class="font-semibold">{{ selectedSlide.title }}</span>? This action cannot be undone.
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
