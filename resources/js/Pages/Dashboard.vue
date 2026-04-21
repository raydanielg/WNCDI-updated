<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    dashboard: {
        type: Object,
        default: () => ({ stats: {}, recentActivity: {} }),
    },
});

const stats = computed(() => props.dashboard.stats || {});
const recentActivity = computed(() => props.dashboard.recentActivity || {});

const refresh = () => {
    router.get(route('dashboard'), {}, {
        only: ['dashboard'],
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header with refresh -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Site overview</h1>
                    <p class="text-xs text-gray-500">High-level summary of site activity and key forms.</p>
                </div>
                <button
                    type="button"
                    class="inline-flex items-center gap-1 rounded-full border border-gray-200 px-3 py-1.5 text-[11px] font-medium text-gray-700 hover:bg-gray-50"
                    @click="refresh"
                >
                    <span class="material-icons text-[14px]">refresh</span>
                    <span>Refresh data</span>
                </button>
            </div>

            <!-- Top stats cards -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-col gap-2">
                    <p class="text-[11px] font-medium text-gray-500">Users</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-gray-900">{{ stats.users ?? 0 }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-wncdi-light text-wncdi-accent">
                            <span class="material-icons text-xl">group</span>
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-400">Total registered users</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-col gap-2">
                    <p class="text-[11px] font-medium text-gray-500">Content (blog & media)</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-gray-900">{{ (stats.posts ?? 0) + (stats.media ?? 0) }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 text-sky-500">
                            <span class="material-icons text-xl">library_books</span>
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-400">
                        {{ stats.posts ?? 0 }} blog posts · {{ stats.media ?? 0 }} media items
                    </p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-col gap-2">
                    <p class="text-[11px] font-medium text-gray-500">Forum registrations</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-gray-900">{{ stats.forum?.total ?? 0 }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                            <span class="material-icons text-xl">event</span>
                        </span>
                    </div>
                    <p class="text-[11px] text-amber-600">{{ stats.forum?.pending ?? 0 }} pending review</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Recent activity list -->
                <div class="bg-white rounded-2xl border border-gray-100 p-5 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Recent activity</h3>
                            <p class="text-[11px] text-gray-500">Latest submissions from key forms.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="item in recentActivity.forum || []"
                            :key="`forum-${item.id}`"
                            class="flex items-center justify-between rounded-xl border border-gray-100 px-4 py-3 hover:bg-gray-50"
                        >
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-wncdi-light text-wncdi-accent">
                                    <span class="material-icons text-xl">description</span>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        Forum: {{ item.forum_name || 'Tanzania Global Logistics Forum' }}
                                    </p>
                                    <p class="text-[11px] text-gray-500">
                                        {{ item.name }} · {{ item.email }} ·
                                        <span class="capitalize">{{ item.status || 'pending' }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right text-[11px] text-gray-500">
                                {{ new Date(item.created_at).toLocaleString() }}
                            </div>
                        </div>

                        <p
                            v-if="!(recentActivity.forum && recentActivity.forum.length)"
                            class="text-[11px] text-gray-500 text-center py-4"
                        >
                            No recent activity yet.
                        </p>
                    </div>
                </div>

                <!-- Quick actions -->
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl border border-gray-100 p-5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Quick actions</h3>
                        <div class="space-y-3 text-xs">
                            <Link
                                :href="route('admin.forum-registrations.index')"
                                class="w-full inline-flex items-center justify-between rounded-xl bg-wncdi-accent hover:bg-wncdi-dark text-white px-4 py-2.5 font-semibold"
                            >
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-base">event</span>
                                    <span>View forum registrations</span>
                                </span>
                                <span class="material-icons text-sm">chevron_right</span>
                            </Link>

                            <Link
                                :href="route('admin.forum-registrations.index')"
                                class="w-full inline-flex items-center justify-between rounded-xl bg-wncdi-accent hover:bg-wncdi-dark text-white px-4 py-2.5 font-semibold"
                            >
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-base">event</span>
                                    <span>View forum registrations</span>
                                </span>
                                <span class="material-icons text-sm">chevron_right</span>
                            </Link>

                            <Link
                                :href="route('users.index')"
                                class="w-full inline-flex items-center justify-between rounded-xl border border-gray-200 px-4 py-2.5 font-semibold text-gray-700 hover:bg-gray-50"
                            >
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-base">group</span>
                                    <span>Manage users & roles</span>
                                </span>
                                <span class="material-icons text-sm">chevron_right</span>
                            </Link>

                            <Link
                                :href="route('admin.posts.index')"
                                class="w-full inline-flex items-center justify-between rounded-xl border border-gray-200 px-4 py-2.5 font-semibold text-gray-700 hover:bg-gray-50"
                            >
                                <span class="flex items-center gap-2">
                                    <span class="material-icons text-base">article</span>
                                    <span>Manage blog posts</span>
                                </span>
                                <span class="material-icons text-sm">chevron_right</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
