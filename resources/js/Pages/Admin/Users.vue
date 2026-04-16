<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
});

const selectedUser = ref(null);
const createModalOpen = ref(false);
const roleModalOpen = ref(false);
const passwordModalOpen = ref(false);
const banModalOpen = ref(false);
const deleteModalOpen = ref(false);

const createForm = useForm({
    name: '',
    email: '',
    password: '',
    role: 'user',
});

const roleForm = useForm({
    role: 'user',
});

const passwordForm = useForm({});
const banForm = useForm({});
const deleteForm = useForm({});

const openCreateModal = () => {
    createForm.reset();
    createForm.role = 'user';
    createModalOpen.value = true;
};

const submitCreate = () => {
    createForm.post(route('users.store'), {
        onSuccess: () => {
            createModalOpen.value = false;
            createForm.reset();
        },
    });
};

const openRoleModal = (user) => {
    selectedUser.value = user;
    roleForm.role = user.role;
    roleModalOpen.value = true;
};

const submitRole = () => {
    if (!selectedUser.value) return;
    roleForm.patch(route('users.update-role', selectedUser.value.id), {
        onSuccess: () => {
            roleModalOpen.value = false;
        },
    });
};

const openPasswordModal = (user) => {
    selectedUser.value = user;
    passwordModalOpen.value = true;
};

const submitPasswordReset = () => {
    if (!selectedUser.value) return;
    passwordForm.post(route('users.reset-password', selectedUser.value.id), {
        onSuccess: () => {
            passwordModalOpen.value = false;
        },
    });
};

const openBanModal = (user) => {
    selectedUser.value = user;
    banModalOpen.value = true;
};

const submitBan = () => {
    if (!selectedUser.value) return;
    banForm.post(route('users.ban', selectedUser.value.id), {
        onSuccess: () => {
            banModalOpen.value = false;
        },
    });
};

const openDeleteModal = (user) => {
    selectedUser.value = user;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedUser.value) return;
    deleteForm.delete(route('users.destroy', selectedUser.value.id), {
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const userCount = computed(() => props.users.length);
</script>

<template>
    <Head title="Users & Roles" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header summary -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Users &amp; Roles</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Manage access to the WNCDi admin panel.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">group</span>
                        <span class="font-semibold">{{ userCount }}</span>
                        <span class="text-wncdi-primary/80">users</span>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                        @click="openCreateModal"
                    >
                        <span class="material-icons text-[13px]">person_add</span>
                        <span>New user</span>
                    </button>
                </div>
            </div>

            <!-- Users table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">All users</h2>
                    <p class="text-[11px] text-gray-500">Edit roles, reset passwords, or disable accounts.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Name</th>
                                <th class="py-2 px-3 font-medium">Email</th>
                                <th class="py-2 px-3 font-medium">Role</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="user in users"
                                :key="user.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-wncdi-light text-[11px] font-semibold text-wncdi-dark">
                                            {{ user.name.split(' ').map((n) => n[0]).join('').slice(0, 2).toUpperCase() }}
                                        </span>
                                        <span class="text-[12px] text-gray-900 font-medium">{{ user.name }}</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ user.email }}
                                </td>
                                <td class="py-2.5 px-3">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold capitalize"
                                        :class="{
                                            'bg-wncdi-light text-wncdi-dark border border-emerald-100': user.role === 'admin',
                                            'bg-gray-50 text-gray-700 border border-gray-200': user.role === 'user',
                                            'bg-red-50 text-red-600 border border-red-100': user.role === 'banned',
                                        }"
                                    >
                                        <span class="material-icons text-[12px]" v-if="user.role === 'admin'">security</span>
                                        <span class="material-icons text-[12px]" v-else-if="user.role === 'banned'">block</span>
                                        <span class="material-icons text-[12px]" v-else>person</span>
                                        <span>{{ user.role }}</span>
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ new Date(user.created_at).toLocaleDateString() }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openRoleModal(user)"
                                        >
                                            <span class="material-icons text-[12px]">admin_panel_settings</span>
                                            <span>Edit role</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openPasswordModal(user)"
                                        >
                                            <span class="material-icons text-[12px]">lock_reset</span>
                                            <span>Reset</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1"
                                            @click="openBanModal(user)"
                                        >
                                            <span class="material-icons text-[12px]">block</span>
                                            <span>Ban</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 flex items-center gap-1"
                                            @click="openDeleteModal(user)"
                                        >
                                            <span class="material-icons text-[12px]">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!users.length">
                                <td colspan="5" class="py-6 text-center text-[11px] text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modals -->

            <!-- Create user modal -->
            <div
                v-if="createModalOpen"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Create user</h3>
                    <p class="text-[11px] text-gray-500 mb-3">
                        Add a new user and choose whether they are an <span class="font-semibold">admin</span> or regular <span class="font-semibold">user</span>.
                    </p>
                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block mb-1 text-gray-700">Name</label>
                            <input
                                v-model="createForm.name"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                            <p v-if="createForm.errors.name" class="mt-1 text-[10px] text-red-600">
                                {{ createForm.errors.name }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">Email</label>
                            <input
                                v-model="createForm.email"
                                type="email"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                            <p v-if="createForm.errors.email" class="mt-1 text-[10px] text-red-600">
                                {{ createForm.errors.email }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">Password</label>
                            <input
                                v-model="createForm.password"
                                type="password"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                placeholder="Min 8 characters"
                            />
                            <p v-if="createForm.errors.password" class="mt-1 text-[10px] text-red-600">
                                {{ createForm.errors.password }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700">Role</label>
                            <select
                                v-model="createForm.role"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            >
                                <option value="user">User</option>
                                <option value="admin">Admin (Full access)</option>
                                <option value="editor">Editor (CMS only)</option>
                                <option value="moderator">Moderator (Forms only)</option>
                            </select>
                            <p v-if="createForm.errors.role" class="mt-1 text-[10px] text-red-600">
                                {{ createForm.errors.role }}
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
                            :disabled="createForm.processing"
                            @click="submitCreate"
                        >
                            <span
                                v-if="createForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Create user</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Edit role modal -->
            <div
                v-if="roleModalOpen && selectedUser"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Update role</h3>
                    <p class="text-[11px] text-gray-500 mb-3">
                        Change the access level for <span class="font-semibold">{{ selectedUser.name }}</span>.
                    </p>
                    <div class="mb-4 text-xs">
                        <label class="block mb-1 text-gray-700">Role</label>
                        <select
                            v-model="roleForm.role"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                        >
                            <option value="user">User</option>
                            <option value="admin">Admin (Full access)</option>
                            <option value="editor">Editor (CMS only)</option>
                            <option value="moderator">Moderator (Forms only)</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 text-[11px]">
                        <button
                            class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100"
                            @click="roleModalOpen = false"
                            type="button"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-3 py-1.5 rounded-full bg-wncdi-accent text-white text-xs font-semibold hover:bg-wncdi-dark flex items-center gap-2"
                            :disabled="roleForm.processing"
                            type="button"
                            @click="submitRole"
                        >
                            <span
                                v-if="roleForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Save changes</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reset password modal -->
            <div
                v-if="passwordModalOpen && selectedUser"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Reset password</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        This will reset the password for <span class="font-semibold">{{ selectedUser.email }}</span> to <code>12345678</code>.
                    </p>
                    <div class="flex justify-end gap-2 text-[11px]">
                        <button
                            class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100"
                            @click="passwordModalOpen = false"
                            type="button"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-3 py-1.5 rounded-full bg-wncdi-accent text-white text-xs font-semibold hover:bg-wncdi-dark flex items-center gap-2"
                            :disabled="passwordForm.processing"
                            type="button"
                            @click="submitPasswordReset"
                        >
                            <span
                                v-if="passwordForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Confirm reset</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Ban modal -->
            <div
                v-if="banModalOpen && selectedUser"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Ban user</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        This will set the role of <span class="font-semibold">{{ selectedUser.name }}</span> to <strong>banned</strong> and prevent login.
                    </p>
                    <div class="flex justify-end gap-2 text-[11px]">
                        <button
                            class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100"
                            @click="banModalOpen = false"
                            type="button"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-3 py-1.5 rounded-full bg-red-600 text-white text-xs font-semibold hover:bg-red-700 flex items-center gap-2"
                            :disabled="banForm.processing"
                            type="button"
                            @click="submitBan"
                        >
                            <span
                                v-if="banForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>Ban user</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete modal -->
            <div
                v-if="deleteModalOpen && selectedUser"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete user</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete <span class="font-semibold">{{ selectedUser.name }}</span>? This action cannot be undone.
                    </p>
                    <div class="flex justify-end gap-2 text-[11px]">
                        <button
                            class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100"
                            @click="deleteModalOpen = false"
                            type="button"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-3 py-1.5 rounded-full bg-red-600 text-white text-xs font-semibold hover:bg-red-700 flex items-center gap-2"
                            :disabled="deleteForm.processing"
                            type="button"
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
