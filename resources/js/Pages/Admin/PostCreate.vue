<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const form = useForm({
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

const submit = () => {
    form.post(route('admin.posts.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create Post" />

    <AuthenticatedLayout>
        <div class="space-y-6 relative">
            <!-- Global loading overlay for slow uploads/submits -->
            <div
                v-if="form.processing"
                class="fixed inset-0 z-50 flex items-center justify-center bg-white/70"
            >
                <div class="flex flex-col items-center gap-2 text-xs text-gray-700">
                    <div class="w-6 h-6 border-2 border-wncdi-accent border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-[11px]">Uploading / saving post, please wait...</p>
                </div>
            </div>
            <!-- Header -->
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <Link
                        :href="route('admin.posts.index')"
                        class="inline-flex items-center gap-1 rounded-full bg-gray-50 px-3 py-1.5 text-[11px] font-medium text-gray-700 border border-gray-200 hover:bg-gray-100"
                    >
                        <span class="material-icons text-[14px]">arrow_back</span>
                        <span>Back to posts</span>
                    </Link>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Create new post</h1>
                        <p class="text-[11px] text-gray-500 mt-0.5">
                            Write a new article for the public blog.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Create form (similar to edit) -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-xs">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="space-y-3 lg:col-span-2">
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            />
                            <p v-if="form.errors.title" class="mt-1 text-[10px] text-red-600">
                                {{ form.errors.title }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Category</label>
                                <input
                                    v-model="form.category"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Author</label>
                                <input
                                    v-model="form.author_name"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Excerpt</label>
                            <textarea
                                v-model="form.excerpt"
                                rows="3"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:border-wncdi-accent focus:ring-wncdi-accent"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block mb-1 text-gray-700 text-[11px]">Body (rich text)</label>
                            <QuillEditor
                                v-model:content="form.body"
                                content-type="html"
                                theme="snow"
                                class="bg-white border border-gray-300 rounded-lg min-h-[260px] text-xs"
                            />
                            <p class="mt-1 text-[10px] text-gray-400">
                                Format text, add lists, headings, links and more. Content is saved as HTML.
                            </p>
                            <p v-if="form.errors.body" class="mt-1 text-[10px] text-red-600">
                                {{ form.errors.body }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="border border-gray-100 rounded-xl p-3 bg-gray-50/60">
                            <h3 class="text-[11px] font-semibold text-gray-800 mb-2">Featured image</h3>
                            <input
                                type="file"
                                accept="image/*"
                                class="w-full text-[11px] text-gray-600"
                                @change="(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    form.image = file;
                                }"
                            />
                            <p v-if="form.errors.image" class="mt-1 text-[10px] text-red-600">
                                {{ form.errors.image }}
                            </p>
                        </div>

                        <div class="border border-gray-100 rounded-xl p-3 bg-gray-50/60 space-y-3">
                            <h3 class="text-[11px] font-semibold text-gray-800">Body media</h3>
                            <div>
                                <label class="block mb-1 text-gray-700 text-[11px]">Body image (optional)</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    class="w-full text-[11px] text-gray-600"
                                    @change="(e) => {
                                        const file = e.target.files?.[0] ?? null;
                                        form.body_image = file;
                                    }"
                                />
                                <p v-if="form.errors.body_image" class="mt-1 text-[10px] text-red-600">
                                    {{ form.errors.body_image }}
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
                                        form.body_audio = file;
                                    }"
                                />
                                <p v-if="form.errors.body_audio" class="mt-1 text-[10px] text-red-600">
                                    {{ form.errors.body_audio }}
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
                                        form.body_video = file;
                                    }"
                                />
                                <p v-if="form.errors.body_video" class="mt-1 text-[10px] text-red-600">
                                    {{ form.errors.body_video }}
                                </p>
                            </div>
                        </div>

                        <div class="border border-gray-100 rounded-xl p-3 bg-gray-50/60 flex items-center justify-between">
                            <label class="flex items-center gap-2 text-[11px] text-gray-700">
                                <input
                                    v-model="form.published"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-wncdi-accent focus:ring-wncdi-accent"
                                />
                                <span>Mark as published (visible on site)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-5 text-[11px]">
                    <Link
                        :href="route('admin.posts.index')"
                        class="px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100 inline-flex items-center gap-1"
                    >
                        <span class="material-icons text-[13px]">close</span>
                        <span>Cancel</span>
                    </Link>
                    <button
                        class="px-3 py-1.5 rounded-full bg-wncdi-accent text-white text-xs font-semibold hover:bg-wncdi-dark flex items-center gap-2"
                        type="button"
                        :disabled="form.processing"
                        @click="submit"
                    >
                        <span
                            v-if="form.processing"
                            class="w-3 h-3 border-2 border-white/70 border-t-transparent rounded-full animate-spin"
                        ></span>
                        <span>Create post</span>
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
