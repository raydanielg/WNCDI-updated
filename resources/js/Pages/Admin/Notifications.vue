<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    notifications: {
        type: Array,
        default: () => [],
    },
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);

const activeNotification = ref(null);

const createForm = useForm({
    title: '',
    url: '',
    is_published: true,
    sort_order: 0,
});

const editForm = useForm({
    id: null,
    title: '',
    url: '',
    is_published: true,
    sort_order: 0,
});

const openCreate = () => {
    createForm.reset();
    createForm.is_published = true;
    createForm.sort_order = props.notifications.length;
    showCreateModal.value = true;
};

const openEdit = (notification) => {
    activeNotification.value = notification;
    editForm.id = notification.id;
    editForm.title = notification.title;
    editForm.url = notification.url;
    editForm.is_published = !!notification.is_published;
    editForm.sort_order = notification.sort_order ?? 0;
    showEditModal.value = true;
};

const openDelete = (notification) => {
    activeNotification.value = notification;
    showDeleteModal.value = true;
};

const submitCreate = () => {
    createForm.post(route('admin.notifications.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showCreateModal.value = false;
        },
    });
};

const submitEdit = () => {
    if (!activeNotification.value) return;

    editForm.post(route('admin.notifications.update', activeNotification.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
        },
    });
};

const submitDelete = () => {
    if (!activeNotification.value) return;

    const form = useForm({});
    form.post(route('admin.notifications.destroy', activeNotification.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
        },
    });
};

const publishedCount = computed(() => props.notifications.filter((n) => n.is_published).length);
</script>

<template>
    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Hero Notifications</h1>
                    <p class="text-sm text-gray-500">
                        Manage small notification badges that appear in the hero section on the home page.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center rounded-full bg-wncdi-light px-3 py-1 text-xs font-medium text-wncdi-dark border border-emerald-100">
                        <span class="material-icons text-xs mr-1">notifications</span>
                        {{ publishedCount }} published
                    </span>
                    <button
                        type="button"
                        class="inline-flex items-center rounded-lg bg-wncdi-accent px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-wncdi-dark"
                        @click="openCreate"
                    >
                        <span class="material-icons text-xs mr-1">add</span>
                        New notification
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Order</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Title</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">URL</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Published</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" v-if="props.notifications.length">
                        <tr v-for="notification in props.notifications" :key="notification.id">
                            <td class="px-4 py-2 text-xs text-gray-600">
                                {{ notification.sort_order }}
                            </td>
                            <td class="px-4 py-2 text-sm font-medium text-gray-900">
                                {{ notification.title }}
                            </td>
                            <td class="px-4 py-2 text-xs text-wncdi-dark truncate max-w-xs">
                                <a :href="notification.url" target="_blank" rel="noopener" class="hover:underline">
                                    {{ notification.url }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                <span
                                    class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium"
                                    :class="notification.is_published ? 'bg-wncdi-light text-wncdi-dark' : 'bg-gray-50 text-gray-500'"
                                >
                                    <span class="material-icons text-[14px] mr-1">
                                        {{ notification.is_published ? 'visibility' : 'visibility_off' }}
                                    </span>
                                    {{ notification.is_published ? 'Published' : 'Hidden' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right text-xs">
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-full border border-gray-200 px-2 py-1 mr-1 text-xs text-gray-700 hover:bg-gray-50"
                                    @click="openEdit(notification)"
                                >
                                    <span class="material-icons text-[14px] mr-1">edit</span>
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-full border border-red-100 px-2 py-1 text-xs text-red-600 hover:bg-red-50"
                                    @click="openDelete(notification)"
                                >
                                    <span class="material-icons text-[14px] mr-1">delete</span>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-xs text-gray-500">
                                No notifications yet. Click "New notification" to create one.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreateModal" class="fixed inset-0 z-30 flex items-center justify-center bg-black/40">
                <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-gray-900">New notification</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600" @click="showCreateModal = false">
                            <span class="material-icons text-base">close</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitCreate" class="space-y-4 text-sm">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Title</label>
                            <input
                                v-model="createForm.title"
                                type="text"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:border-wncdi-accent focus:ring-wncdi-accent"
                                placeholder="Notification text"
                            />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">URL</label>
                            <input
                                v-model="createForm.url"
                                type="text"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:border-wncdi-accent focus:ring-wncdi-accent"
                                placeholder="https://example.com"
                            />
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-xs text-gray-700">
                                <input
                                    v-model="createForm.is_published"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-wncdi-accent shadow-sm focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                                <span>Published</span>
                            </label>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span>Order</span>
                                <input
                                    v-model.number="createForm.sort_order"
                                    type="number"
                                    min="0"
                                    class="block w-20 rounded-lg border-gray-300 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end gap-2">
                            <button
                                type="button"
                                class="inline-flex justify-center rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                                @click="showCreateModal = false"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="inline-flex justify-center rounded-lg bg-wncdi-accent px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-wncdi-dark"
                            >
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Modal -->
            <div v-if="showEditModal" class="fixed inset-0 z-30 flex items-center justify-center bg-black/40">
                <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-gray-900">Edit notification</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600" @click="showEditModal = false">
                            <span class="material-icons text-base">close</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitEdit" class="space-y-4 text-sm">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Title</label>
                            <input
                                v-model="editForm.title"
                                type="text"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">URL</label>
                            <input
                                v-model="editForm.url"
                                type="text"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-xs text-gray-700">
                                <input
                                    v-model="editForm.is_published"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-wncdi-accent shadow-sm focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                                <span>Published</span>
                            </label>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span>Order</span>
                                <input
                                    v-model.number="editForm.sort_order"
                                    type="number"
                                    min="0"
                                    class="block w-20 rounded-lg border-gray-300 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end gap-2">
                            <button
                                type="button"
                                class="inline-flex justify-center rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                                @click="showEditModal = false"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="inline-flex justify-center rounded-lg bg-wncdi-accent px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-wncdi-dark"
                            >
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div v-if="showDeleteModal" class="fixed inset-0 z-30 flex items-center justify-center bg-black/40">
                <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="material-icons text-red-500">warning</span>
                        <h2 class="text-sm font-semibold text-gray-900">Delete notification</h2>
                    </div>
                    <p class="text-xs text-gray-600 mb-4">
                        Are you sure you want to delete this notification? This action cannot be undone.
                    </p>
                    <div class="mt-2 flex justify-end gap-2">
                        <button
                            type="button"
                            class="inline-flex justify-center rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                            @click="showDeleteModal = false"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            class="inline-flex justify-center rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-red-700"
                            @click="submitDelete"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
