<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    teamMembers: {
        type: Array,
        default: () => [],
    },
});

const selectedMember = ref(null);
const createModalOpen = ref(false);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

const memberForm = useForm({
    name: '',
    title: '',
    bio: '',
    photo: null,
    photo_url: '',
    facebook_url: '',
    twitter_url: '',
    instagram_url: '',
    linkedin_url: '',
});

const photoPreview = ref('');

const openCreateModal = () => {
    selectedMember.value = null;
    memberForm.reset();
    memberForm.photo = null;
    photoPreview.value = '';
    createModalOpen.value = true;
};

const submitCreate = () => {
    memberForm.post(route('admin.team-members.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            createModalOpen.value = false;
            memberForm.reset();
            memberForm.photo = null;
            photoPreview.value = '';
        },
    });
};

const openEditModal = (item) => {
    selectedMember.value = item;
    memberForm.name = item.name;
    memberForm.title = item.title || '';
    memberForm.bio = item.bio || '';
    memberForm.photo = null;
    memberForm.photo_url = item.photo_url || '';
    memberForm.facebook_url = item.facebook_url || '';
    memberForm.twitter_url = item.twitter_url || '';
    memberForm.instagram_url = item.instagram_url || '';
    memberForm.linkedin_url = item.linkedin_url || '';
    photoPreview.value = item.photo_url || '';
    editModalOpen.value = true;
};

const submitEdit = () => {
    if (!selectedMember.value) return;

    memberForm.post(route('admin.team-members.update', selectedMember.value.id), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            editModalOpen.value = false;
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (item) => {
    selectedMember.value = item;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedMember.value) return;

    deleteForm.delete(route('admin.team-members.destroy', selectedMember.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const onPhotoChange = (e) => {
    const file = e.target.files?.[0] ?? null;
    if (!file) return;
    memberForm.photo = file;
    const reader = new FileReader();
    reader.onload = (ev) => {
        photoPreview.value = ev.target?.result ?? '';
    };
    reader.readAsDataURL(file);
};

const memberCount = computed(() => props.teamMembers.length);
</script>

<template>
    <Head title="Team Members" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header summary -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Team Members</h1>
                    <p class="text-[11px] text-gray-500 mt-1">
                        Manage the leadership and core team shown in the Our Team section on the homepage.
                    </p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">groups</span>
                        <span class="font-semibold">{{ memberCount }}</span>
                        <span class="text-wncdi-primary/80">people</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New team member</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">All team members</h2>
                    <p class="text-[11px] text-gray-500">
                        These people appear in the Our Team section on the homepage.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Person</th>
                                <th class="py-2 px-3 font-medium">Photo</th>
                                <th class="py-2 px-3 font-medium">Title</th>
                                <th class="py-2 px-3 font-medium">Bio</th>
                                <th class="py-2 px-3 font-medium">Social</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in teamMembers"
                                :key="item.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-wncdi-light text-[11px] font-semibold text-wncdi-dark">
                                            {{ item.name.split(' ').map((n) => n[0]).join('').slice(0, 2).toUpperCase() }}
                                        </span>
                                        <div class="flex flex-col">
                                            <span class="text-[12px] text-gray-900 font-medium">{{ item.name }}</span>
                                            <span class="text-[11px] text-gray-500">
                                                {{ item.title || '—' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="h-12 w-12 rounded-full bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                                        <img
                                            v-if="item.photo_url"
                                            :src="item.photo_url"
                                            :alt="item.name"
                                            class="h-full w-full object-cover"
                                        />
                                        <span v-else class="text-[10px] text-gray-400">No photo</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ item.title || '—' }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-700 max-w-xs">
                                    <p class="line-clamp-2">
                                        {{ item.bio || '—' }}
                                    </p>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span
                                            v-if="item.instagram_url"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-pink-50 text-[10px] text-pink-700 border border-pink-100"
                                        >
                                            <span class="material-icons text-[13px]">photo_camera</span>
                                            <span>Instagram</span>
                                        </span>
                                        <span
                                            v-if="item.facebook_url"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-50 text-[10px] text-blue-700 border border-blue-100"
                                        >
                                            <span class="material-icons text-[13px]">facebook</span>
                                            <span>Facebook</span>
                                        </span>
                                        <span
                                            v-if="item.linkedin_url"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-sky-50 text-[10px] text-sky-700 border border-sky-100"
                                        >
                                            <span class="material-icons text-[13px]">business_center</span>
                                            <span>LinkedIn</span>
                                        </span>
                                        <span
                                            v-if="item.twitter_url"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-50 text-[10px] text-slate-700 border border-slate-100"
                                        >
                                            <span class="material-icons text-[13px]">alternate_email</span>
                                            <span>Twitter</span>
                                        </span>
                                        <span
                                            v-if="!item.instagram_url && !item.facebook_url && !item.linkedin_url && !item.twitter_url"
                                            class="text-[10px] text-gray-400"
                                        >
                                            None
                                        </span>
                                    </div>
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

                            <tr v-if="!teamMembers.length">
                                <td colspan="7" class="py-6 text-center text-[11px] text-gray-500">
                                    No team members found.
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
                        {{ createModalOpen ? 'Create team member' : 'Edit team member' }}
                    </h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Control who appears in the homepage Our Team grid.
                    </p>

                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Name</label>
                                <input
                                    v-model="memberForm.name"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                                <p v-if="memberForm.errors.name" class="mt-1 text-[10px] text-red-600">
                                    {{ memberForm.errors.name }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Title / Role</label>
                                <input
                                    v-model="memberForm.title"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Short bio</label>
                            <textarea
                                v-model="memberForm.bio"
                                rows="3"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            ></textarea>
                        </div>

                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Profile photo</label>
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 rounded-full bg-gray-50 border border-gray-200 overflow-hidden flex items-center justify-center">
                                    <img
                                        v-if="photoPreview || memberForm.photo_url"
                                        :src="photoPreview || memberForm.photo_url"
                                        alt="Preview"
                                        class="h-full w-full object-cover"
                                    />
                                    <span v-else class="text-[10px] text-gray-400">No photo</span>
                                </div>
                                <label class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1.5 text-[11px] font-medium text-gray-700 border border-gray-200 cursor-pointer hover:bg-gray-50">
                                    <span class="material-icons text-[14px]">upload</span>
                                    <span>Upload photo</span>
                                    <input type="file" accept="image/*" class="hidden" @change="onPhotoChange" />
                                </label>
                            </div>
                            <p class="mt-1 text-[10px] text-gray-400">Square image works best. Max 4MB.</p>
                            <p v-if="memberForm.errors.photo" class="mt-1 text-[10px] text-red-600">
                                {{ memberForm.errors.photo }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Instagram URL</label>
                                <input
                                    v-model="memberForm.instagram_url"
                                    type="url"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                    placeholder="https://instagram.com/..."
                                />
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Facebook URL</label>
                                <input
                                    v-model="memberForm.facebook_url"
                                    type="url"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                    placeholder="https://facebook.com/..."
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">LinkedIn URL</label>
                                <input
                                    v-model="memberForm.linkedin_url"
                                    type="url"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                    placeholder="https://linkedin.com/in/..."
                                />
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Twitter URL</label>
                                <input
                                    v-model="memberForm.twitter_url"
                                    type="url"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                    placeholder="https://twitter.com/..."
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
                            :disabled="memberForm.processing"
                            @click="createModalOpen ? submitCreate() : submitEdit()"
                        >
                            <span
                                v-if="memberForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>{{ createModalOpen ? 'Create member' : 'Save changes' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete modal -->
            <div
                v-if="deleteModalOpen && selectedMember"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete team member</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete
                        <span class="font-semibold">{{ selectedMember.name }}</span>? This action cannot be undone.
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
