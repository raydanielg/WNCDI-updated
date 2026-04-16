<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    testimonials: {
        type: Array,
        default: () => [],
    },
});

const selectedTestimonial = ref(null);
const createModalOpen = ref(false);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

const testimonialForm = useForm({
    name: '',
    role: '',
    avatar_url: '',
    avatar: null,
    headline: '',
    body1: '',
    body2: '',
});

const openCreateModal = () => {
    selectedTestimonial.value = null;
    testimonialForm.reset();
    testimonialForm.avatar = null;
    createModalOpen.value = true;
};

const submitCreate = () => {
    testimonialForm.post(route('admin.testimonials.store'), {
        preserveScroll: true,
        onSuccess: () => {
            createModalOpen.value = false;
            testimonialForm.reset();
        },
    });
};

const openEditModal = (item) => {
    selectedTestimonial.value = item;
    testimonialForm.name = item.name;
    testimonialForm.role = item.role || '';
    testimonialForm.avatar_url = item.avatar_url || '';
    testimonialForm.avatar = null;
    testimonialForm.headline = item.headline || '';
    testimonialForm.body1 = item.body1 || '';
    testimonialForm.body2 = item.body2 || '';
    editModalOpen.value = true;
};

const submitEdit = () => {
    if (!selectedTestimonial.value) return;

    testimonialForm.put(route('admin.testimonials.update', selectedTestimonial.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            editModalOpen.value = false;
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (item) => {
    selectedTestimonial.value = item;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedTestimonial.value) return;

    deleteForm.delete(route('admin.testimonials.destroy', selectedTestimonial.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const testimonialCount = computed(() => props.testimonials.length);
</script>

<template>
    <Head title="Testimonials" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header summary -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Testimonials</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Manage quotes shown on the public site homepage.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">format_quote</span>
                        <span class="font-semibold">{{ testimonialCount }}</span>
                        <span class="text-wncdi-primary/80">testimonials</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New testimonial</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">All testimonials</h2>
                    <p class="text-[11px] text-gray-500">These appear in the Testimonials section on the homepage.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Person</th>
                                <th class="py-2 px-3 font-medium">Avatar</th>
                                <th class="py-2 px-3 font-medium">Role</th>
                                <th class="py-2 px-3 font-medium">Headline</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in testimonials"
                                :key="item.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-wncdi-light text-[11px] font-semibold text-wncdi-dark">
                                            {{ item.name.split(' ').map((n) => n[0]).join('').slice(0, 2).toUpperCase() }}
                                        </span>
                                        <span class="text-[12px] text-gray-900 font-medium">{{ item.name }}</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="h-9 w-9 rounded-full bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                                        <img
                                            v-if="item.avatar_url"
                                            :src="item.avatar_url"
                                            :alt="item.name"
                                            class="h-full w-full object-cover"
                                        />
                                        <span v-else class="text-[9px] text-gray-400">No image</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ item.role || '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-700 line-clamp-1">
                                    {{ item.headline || '-' }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ new Date(item.created_at).toLocaleDateString() }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openEditModal(item)"
                                        >
                                            <span class="material-icons text-[12px]">edit</span>
                                            <span>Edit</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1"
                                            @click="openDeleteModal(item)"
                                        >
                                            <span class="material-icons text-[12px]">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!testimonials.length">
                                <td colspan="5" class="py-6 text-center text-[11px] text-gray-500">
                                    No testimonials found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create / Edit modal -->
            <div
                v-if="(createModalOpen || editModalOpen)"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-5 max-h-[90vh] overflow-y-auto text-xs">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">
                        {{ createModalOpen ? 'Create testimonial' : 'Edit testimonial' }}
                    </h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Control the content that appears in the homepage Testimonials carousel.
                    </p>

                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Name</label>
                                <input
                                    v-model="testimonialForm.name"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                                <p v-if="testimonialForm.errors.name" class="mt-1 text-[10px] text-red-600">
                                    {{ testimonialForm.errors.name }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Role / Title</label>
                                <input
                                    v-model="testimonialForm.role"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Avatar image</label>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    testimonialForm.avatar = file;
                                }"
                            />
                            <p v-if="testimonialForm.errors.avatar" class="mt-1 text-[10px] text-red-600">
                                {{ testimonialForm.errors.avatar }}
                            </p>
                            <div class="mt-2 flex items-center gap-2" v-if="testimonialForm.avatar || testimonialForm.avatar_url">
                                <span class="text-[10px] text-gray-500">Preview:</span>
                                <div class="h-10 w-10 rounded-full overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center">
                                    <img
                                        v-if="testimonialForm.avatar"
                                        :src="URL.createObjectURL(testimonialForm.avatar)"
                                        alt="Preview"
                                        class="h-full w-full object-cover"
                                    />
                                    <img
                                        v-else-if="testimonialForm.avatar_url"
                                        :src="testimonialForm.avatar_url"
                                        alt="Current avatar"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Headline</label>
                            <input
                                v-model="testimonialForm.headline"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Body (intro)</label>
                            <textarea
                                v-model="testimonialForm.body1"
                                rows="3"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Body (extra)</label>
                            <textarea
                                v-model="testimonialForm.body2"
                                rows="3"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            ></textarea>
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
                            :disabled="testimonialForm.processing"
                            @click="createModalOpen ? submitCreate() : submitEdit()"
                        >
                            <span
                                v-if="testimonialForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>{{ createModalOpen ? 'Create testimonial' : 'Save changes' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete modal -->
            <div
                v-if="deleteModalOpen && selectedTestimonial"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete testimonial</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete
                        <span class="font-semibold">{{ selectedTestimonial.name }}</span>? This action cannot be undone.
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
