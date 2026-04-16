<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

const globalPostError = computed(() => {
    const errors = page.props.errors || {};
    return errors.post || null;
});

const selectedPost = ref(null);
const createModalOpen = ref(false);
const editModalOpen = ref(false);
const deleteModalOpen = ref(false);

const postForm = useForm({
    title: '',
    category: '',
    author_name: '',
    image_url: '',
    image: null,
    body_image: null,
    body_audio: null,
    body_video: null,
    excerpt: '',
    body: '',
    published: false,
});

const openCreateModal = () => {
    selectedPost.value = null;
    postForm.reset();
    postForm.image = null;
    postForm.body_image = null;
    postForm.body_audio = null;
    postForm.body_video = null;
    postForm.published = false;
    createModalOpen.value = true;
};

const submitCreate = () => {
    postForm.post(route('admin.posts.store'), {
        preserveScroll: true,
        onSuccess: () => {
            createModalOpen.value = false;
            postForm.reset();
        },
    });
};

const openEditModal = (post) => {
    selectedPost.value = post;
    postForm.title = post.title;
    postForm.category = post.category || '';
    postForm.author_name = post.author_name || '';
    postForm.image_url = post.image_url || '';
    postForm.image = null;
    postForm.body_image = null;
    postForm.body_audio = null;
    postForm.body_video = null;
    postForm.excerpt = post.excerpt || '';
    postForm.body = post.body || '';
    postForm.published = !!post.published_at;
    editModalOpen.value = true;
};

const submitEdit = () => {
    if (!selectedPost.value) return;

    // Use POST route for update to avoid HTTP verb issues
    postForm.post(route('admin.posts.update', selectedPost.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            editModalOpen.value = false;
        },
    });
};

const deleteForm = useForm({});

const openDeleteModal = (post) => {
    selectedPost.value = post;
    deleteModalOpen.value = true;
};

const submitDelete = () => {
    if (!selectedPost.value) return;

    // Use POST route for delete to avoid HTTP verb issues
    deleteForm.post(route('admin.posts.destroy', selectedPost.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteModalOpen.value = false;
        },
    });
};

const postCount = computed(() => props.posts.length);
</script>

<template>
    <Head title="Blog Management" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Global error popup for post operations -->
            <div
                v-if="globalPostError"
                class="fixed top-16 right-6 z-50 max-w-xs bg-red-50 border border-red-200 text-red-800 text-[11px] rounded-xl shadow-sm px-3 py-2 flex items-start gap-2"
            >
                <span class="material-icons text-[14px] mt-[1px]">error_outline</span>
                <div>
                    <p class="font-semibold mb-0.5">Action failed</p>
                    <p class="text-[10px] leading-snug">{{ globalPostError }}</p>
                </div>
            </div>
            <!-- Header summary -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Blog Management</h1>
                    <p class="text-[11px] text-gray-500 mt-1">Create, edit and publish posts for the public blog.</p>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <div class="px-3 py-2 rounded-2xl bg-wncdi-light text-wncdi-dark border border-emerald-100 flex items-center gap-2">
                        <span class="material-icons text-sm">article</span>
                        <span class="font-semibold">{{ postCount }}</span>
                        <span class="text-wncdi-primary/80">posts</span>
                    </div>
                    <Link
                        :href="route('admin.posts.create')"
                        class="inline-flex items-center gap-1 rounded-full bg-wncdi-accent px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-wncdi-dark"
                    >
                        <span class="material-icons text-[13px]">add</span>
                        <span>New post</span>
                    </Link>
                </div>
            </div>

            <!-- Posts table -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">All posts</h2>
                    <p class="text-[11px] text-gray-500">Manage titles, status and visibility.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] text-gray-500">
                                <th class="py-2 px-3 font-medium">Title</th>
                                <th class="py-2 px-3 font-medium">Image</th>
                                <th class="py-2 px-3 font-medium">Category</th>
                                <th class="py-2 px-3 font-medium">Author</th>
                                <th class="py-2 px-3 font-medium">Status</th>
                                <th class="py-2 px-3 font-medium">Created</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="post in posts"
                                :key="post.id"
                                class="border-b border-gray-50 hover:bg-gray-50/60"
                            >
                                <td class="py-2.5 px-3">
                                    <div class="flex flex-col">
                                        <span class="text-[12px] text-gray-900 font-medium line-clamp-1">{{ post.title }}</span>
                                        <span class="text-[10px] text-gray-400">/{{ post.slug }}</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="h-10 w-16 bg-gray-50 border border-gray-100 rounded overflow-hidden flex items-center justify-center">
                                        <img
                                            v-if="post.image_url"
                                            :src="post.image_url"
                                            :alt="post.title"
                                            class="h-full w-full object-cover"
                                        />
                                        <span v-else class="text-[9px] text-gray-400">No image</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ post.category || 'General' }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-600">
                                    {{ post.author_name || 'Admin' }}
                                </td>
                                <td class="py-2.5 px-3">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold"
                                        :class="post.published_at ? 'bg-wncdi-light text-wncdi-dark border border-emerald-100' : 'bg-gray-50 text-gray-600 border border-gray-200'"
                                    >
                                        <span class="material-icons text-[12px]" v-if="post.published_at">visibility</span>
                                        <span class="material-icons text-[12px]" v-else>draft</span>
                                        <span>{{ post.published_at ? 'Published' : 'Draft' }}</span>
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ new Date(post.created_at).toLocaleDateString() }}
                                </td>
                                <td class="py-2.5 px-3 text-[11px] text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button
                                            class="px-2 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 flex items-center gap-1"
                                            @click="openEditModal(post)"
                                        >
                                            <span class="material-icons text-[12px]">edit</span>
                                            <span>Edit</span>
                                        </button>
                                        <button
                                            class="px-2 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 hover:bg-red-100 flex items-center gap-1"
                                            @click="openDeleteModal(post)"
                                        >
                                            <span class="material-icons text-[12px]">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!posts.length">
                                <td colspan="6" class="py-6 text-center text-[11px] text-gray-500">
                                    No posts found.
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
                        {{ createModalOpen ? 'Create post' : 'Edit post' }}
                    </h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Manage the title, content and visibility of this blog post.
                    </p>

                    <div class="space-y-3">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title</label>
                            <input
                                v-model="postForm.title"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Category</label>
                                <input
                                    v-model="postForm.category"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Author</label>
                                <input
                                    v-model="postForm.author_name"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Featured image</label>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    postForm.image = file;
                                }"
                            />
                            <p v-if="postForm.errors.image" class="mt-1 text-[10px] text-red-600">
                                {{ postForm.errors.image }}
                            </p>
                            <div class="mt-2 flex items-center gap-2" v-if="postForm.image || postForm.image_url">
                                <span class="text-[10px] text-gray-500">Preview:</span>
                                <div class="h-12 w-20 rounded border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center">
                                    <img
                                        v-if="postForm.image"
                                        :src="URL.createObjectURL(postForm.image)"
                                        alt="Preview"
                                        class="h-full w-full object-cover"
                                    />
                                    <img
                                        v-else-if="postForm.image_url"
                                        :src="postForm.image_url"
                                        alt="Current image"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Excerpt</label>
                            <textarea
                                v-model="postForm.excerpt"
                                rows="2"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Body (HTML supported)</label>
                            <textarea
                                v-model="postForm.body"
                                rows="6"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent font-mono"
                                placeholder="You can use basic HTML tags (p, strong, em, ul, img, audio, video, etc.)"
                            ></textarea>
                            <p v-if="postForm.errors.body" class="mt-1 text-[10px] text-red-600">
                                {{ postForm.errors.body }}
                            </p>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Body image (optional)</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    class="w-full text-[11px] text-gray-600"
                                    @change="(e) => {
                                        const file = e.target.files?.[0] ?? null;
                                        postForm.body_image = file;
                                    }"
                                />
                                <p v-if="postForm.errors.body_image" class="mt-1 text-[10px] text-red-600">
                                    {{ postForm.errors.body_image }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Body audio (mp3/wav)</label>
                                <input
                                    type="file"
                                    accept="audio/*"
                                    class="w-full text-[11px] text-gray-600"
                                    @change="(e) => {
                                        const file = e.target.files?.[0] ?? null;
                                        postForm.body_audio = file;
                                    }"
                                />
                                <p v-if="postForm.errors.body_audio" class="mt-1 text-[10px] text-red-600">
                                    {{ postForm.errors.body_audio }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Body video (mp4/webm)</label>
                                <input
                                    type="file"
                                    accept="video/*"
                                    class="w-full text-[11px] text-gray-600"
                                    @change="(e) => {
                                        const file = e.target.files?.[0] ?? null;
                                        postForm.body_video = file;
                                    }"
                                />
                                <p v-if="postForm.errors.body_video" class="mt-1 text-[10px] text-red-600">
                                    {{ postForm.errors.body_video }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2 text-[11px] text-gray-700">
                                <input
                                    v-model="postForm.published"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-wncdi-accent focus:ring-wncdi-accent"
                                />
                                <span>Mark as published (visible on site)</span>
                            </label>
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
                            :disabled="postForm.processing"
                            @click="createModalOpen ? submitCreate() : submitEdit()"
                        >
                            <span
                                v-if="postForm.processing"
                                class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                            ></span>
                            <span>{{ createModalOpen ? 'Create post' : 'Save changes' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete modal -->
            <div
                v-if="deleteModalOpen && selectedPost"
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/40"
            >
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Delete post</h3>
                    <p class="text-[11px] text-gray-500 mb-4">
                        Are you sure you want to permanently delete
                        <span class="font-semibold">{{ selectedPost.title }}</span>? This action cannot be undone.
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
