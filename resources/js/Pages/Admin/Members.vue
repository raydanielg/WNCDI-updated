<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    members: {
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
    logo: null,
});

const logoPreview = ref('');

const openCreateModal = () => {
    selectedMember.value = null;
    memberForm.reset();
    logoPreview.value = '';
    createModalOpen.value = true;
};

const submitCreate = () => {
    memberForm.post(route('admin.members.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            createModalOpen.value = false;
            memberForm.reset();
            logoPreview.value = '';
        },
    });
};

const openEditModal = (member) => {
    selectedMember.value = member;
    memberForm.name = member.name;
    memberForm.logo = null;
    logoPreview.value = member.logo_url || '';
    editModalOpen.value = true;
};

const submitEdit = () => {
    if (!selectedMember.value) return;

    memberForm.put(route('admin.members.update', selectedMember.value.id), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            editModalOpen.value = false;
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (member) => {
    selectedMember.value = member;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedMember.value) return;

    deleteForm.delete(route('admin.members.destroy', selectedMember.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const memberCount = computed(() => props.members.length);

const onLogoChange = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    memberForm.logo = file;
    const reader = new FileReader();
    reader.onload = (ev) => {
        logoPreview.value = ev.target.result;
    };
    reader.readAsDataURL(file);
};
</script>

<template>
    <Head title="Members" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header summary -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Member Organizations</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Manage logos and names shown in the OUR MEMBERS section on the homepage.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">groups</span>
                        <span class="font-semibold">{{ memberCount }}</span>
                        <span class="text-wncdi-primary/80">members</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New member</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">All members</h2>
                    <p class="text-[11px] text-gray-500">These logos appear in the OUR MEMBERS section on the homepage.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Name</th>
                                <th class="py-2 px-3 font-medium">Logo</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="member in members"
                                :key="member.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3 text-[12px] text-gray-900 font-medium">
                                    {{ member.name }}
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="h-10 w-28 bg-white border border-gray-100 rounded flex items-center justify-center overflow-hidden">
                                        <img
                                            v-if="member.logo_url"
                                            :src="member.logo_url"
                                            :alt="member.name"
                                            class="max-h-8 max-w-full object-contain"
                                        />
                                        <span v-else class="text-[10px] text-gray-400">No logo</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ new Date(member.created_at).toLocaleDateString() }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openEditModal(member)"
                                        >
                                            <span class="material-icons text-[12px]">edit</span>
                                            <span>Edit</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1"
                                            @click="openDeleteModal(member)"
                                        >
                                            <span class="material-icons text-[12px]">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!members.length">
                                <td colspan="4" class="py-6 text-center text-[11px] text-gray-500">
                                    No members found.
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
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-5 max-h-[90vh] overflow-y-auto text-xs">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">
                        {{ createModalOpen ? 'Create member' : 'Edit member' }}
                    </h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Control the organizations that appear in the homepage members grid.
                    </p>

                    <div class="space-y-3">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Name</label>
                            <input
                                v-model="memberForm.name"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Logo image</label>
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-28 bg-white border border-gray-200 rounded flex items-center justify-center overflow-hidden">
                                    <img
                                        v-if="logoPreview"
                                        :src="logoPreview"
                                        :alt="memberForm.name || 'Logo preview'"
                                        class="max-h-8 max-w-full object-contain"
                                    />
                                    <span v-else class="text-[10px] text-gray-400">No logo selected</span>
                                </div>
                                <label class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1.5 text-[11px] font-medium text-gray-700 border border-gray-200 cursor-pointer hover:bg-gray-50">
                                    <span class="material-icons text-[14px]">upload</span>
                                    <span>Upload logo</span>
                                    <input type="file" accept="image/*" class="hidden" @change="onLogoChange" />
                                </label>
                            </div>
                            <p class="mt-1 text-[10px] text-gray-400">Recommended: small horizontal logo, PNG/JPG.</p>
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
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete member</h3>
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
