<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const showingSidebar = ref(true);
const showCmsMenu = ref(false);
const showSettingsMenu = ref(false);
const showFormsMenu = ref(false);

const searchQuery = ref('');
const showSearchResults = ref(false);

const mockSearchResults = computed(() => {
    if (!searchQuery.value.trim()) return [];

    const base = [
        'Forum registrations',
        'Blog posts',
        'Hero sections',
        'Team members',
    ];

    return base.filter((item) =>
        item.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );
});

const page = usePage();
const user = computed(() => page.props.auth.user ?? {});
const adminNotifications = computed(() => page.props.adminNotifications ?? { items: [], unreadCount: 0 });
const isAdmin = computed(() => user.value.role === 'admin');
const isEditor = computed(() => user.value.role === 'editor');
const isModerator = computed(() => user.value.role === 'moderator');
const canManageCms = computed(() => ['admin', 'editor'].includes(user.value.role));
const canModerate = computed(() => ['admin', 'moderator'].includes(user.value.role));
const canManageUsers = computed(() => user.value.role === 'admin');
const canManageSettings = computed(() => user.value.role === 'admin');

const userInitials = computed(() => {
    if (!user.value.name) return '';
    return user.value.name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
});

const markAllNotificationsRead = () => {
    if (!adminNotifications.value.unreadCount) return;

    router.post(route('admin.header-notifications.read-all'), {}, {
        preserveScroll: true,
        preserveState: true,
        only: ['adminNotifications'],
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <aside
            class="hidden md:flex flex-col w-64 bg-wncdi-primary text-white shadow-xl"
        >
            <div class="h-20 flex items-center justify-center px-6 border-b border-wncdi-dark">
                <Link :href="route('dashboard')" class="flex flex-col items-center gap-1">
                    <ApplicationLogo class="h-9 w-auto fill-current text-white" />
                    <span class="text-xs font-semibold tracking-wide text-wncdi-light">WNCDi Admin</span>
                </Link>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 text-sm space-y-6">
                <div>
                    <p class="px-3 mb-2 text-[11px] uppercase tracking-wider text-wncdi-light/70">Navigation</p>
                    <ul class="space-y-1">
                        <!-- Dashboard (common) -->
                        <li>
                            <Link
                                :href="route('dashboard')"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium"
                                :class="route().current('dashboard') ? 'bg-wncdi-accent text-white' : 'text-white/80 hover:bg-wncdi-dark hover:text-white'"
                            >
                                <span class="material-icons text-base">space_dashboard</span>
                                <span>Dashboard</span>
                            </Link>
                        </li>

                        <!-- Admin-specific navigation -->
                        <template v-if="isAdmin">
                            <li>
                                <Link
                                    :href="route('users.index')"
                                    class="w-full flex items-center justify-between rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark"
                                    :class="route().current('users.index') ? 'bg-wncdi-accent text-white' : ''"
                                >
                                    <span class="flex items-center gap-3 text-sm">
                                        <span class="material-icons text-base">group</span>
                                        <span>Users & Roles</span>
                                    </span>
                                </Link>
                            </li>
                        </template>

                        <!-- Forms menu (Admin & Moderator only) -->
                        <li v-if="canModerate">
                            <button
                                type="button"
                                class="w-full flex items-center justify-between rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark text-left"
                                @click="showFormsMenu = !showFormsMenu"
                            >
                                <span class="flex items-center gap-3 text-sm">
                                    <span class="material-icons text-base">description</span>
                                    <span>Forms</span>
                                </span>
                                <span class="material-icons text-sm text-white/80">
                                    {{ showFormsMenu ? 'expand_less' : 'expand_more' }}
                                </span>
                            </button>

                            <transition name="fade-slide">
                                <ul
                                    v-if="showFormsMenu"
                                    class="mt-1 space-y-0.5 pl-10 text-[12px] text-white/80/90"
                                >
                                    <li>
                                        <Link
                                            :href="route('admin.forum-registrations.index')"
                                            class="block w-full text-left py-1 hover:text-white"
                                            :class="route().current('admin.forum-registrations.*') ? 'text-white font-semibold' : ''"
                                        >
                                            Forum
                                        </Link>
                                    </li>
                                </ul>
                            </transition>
                        </li>

                        <!-- CMS Management menu (Admin & Editor only) -->
                        <li v-if="canManageCms">
                            <button
                                type="button"
                                class="w-full flex items-center justify-between rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark text-left"
                                @click="showCmsMenu = !showCmsMenu"
                            >
                                <span class="flex items-center gap-3 text-sm">
                                    <span class="material-icons text-base">web</span>
                                    <span>CMS Management</span>
                                </span>
                                <span class="material-icons text-sm text-white/80">
                                    {{ showCmsMenu ? 'expand_less' : 'expand_more' }}
                                </span>
                            </button>

                            <transition name="fade-slide">
                                <ul
                                    v-if="showCmsMenu"
                                    class="mt-1 space-y-0.5 pl-10 text-[12px] text-white/80/90"
                                >
                                        <li>
                                            <Link
                                                :href="route('admin.hero.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.hero.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Hero section
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.footer.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.footer.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Footer
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.notifications.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.notifications.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Notifications
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.newsletter.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.newsletter.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Newsletter
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.team-members.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.team-members.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Team
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.focus-areas.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.focus-areas.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Our Focus Areas
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.about.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.about.*') ? 'text-white font-semibold' : ''"
                                            >
                                                About Company
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.services.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.services.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Services
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.testimonials.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.testimonials.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Testimonials
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.members.index')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.members.*') ? 'text-white font-semibold' : ''"
                                            >
                                                Our Members
                                            </Link>
                                        </li>
                                    </ul>
                                </transition>
                            </li>

                        <!-- Blog Management (Admin & Editor only) -->
                        <li v-if="canManageCms">
                                <Link
                                    :href="route('admin.posts.index')"
                                    class="w-full flex items-center justify-between rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark"
                                    :class="route().current('admin.posts.*') ? 'bg-wncdi-accent text-white' : ''"
                                >
                                    <span class="flex items-center gap-3 text-sm">
                                        <span class="material-icons text-base">article</span>
                                        <span>Blog Management</span>
                                    </span>
                                </Link>
                            </li>

                        <!-- Media Gallery (Admin & Editor only) -->
                        <li v-if="canManageCms">
                                <Link
                                    :href="route('admin.media.index')"
                                    class="w-full flex items-center justify-between rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark"
                                    :class="route().current('admin.media.*') ? 'bg-wncdi-accent text-white' : ''"
                                >
                                    <span class="flex items-center gap-3 text-sm">
                                        <span class="material-icons text-base">collections</span>
                                        <span>Media Gallery</span>
                                    </span>
                                </Link>
                            </li>

                        <!-- Settings (Admin only) -->
                        <li v-if="canManageSettings">
                                <button
                                    type="button"
                                    class="w-full flex items-start justify-between rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark text-left"
                                    @click="showSettingsMenu = !showSettingsMenu"
                                >
                                    <span class="flex items-center gap-3 text-sm">
                                        <span class="material-icons text-base">settings</span>
                                        <span>Settings</span>
                                    </span>
                                    <span class="material-icons text-sm text-white/80">
                                        {{ showSettingsMenu ? 'expand_less' : 'expand_more' }}
                                    </span>
                                </button>

                                <transition name="fade-slide">
                                    <ul
                                        v-if="showSettingsMenu"
                                        class="mt-1 space-y-0.5 pl-10 text-[12px] text-white/80/90"
                                    >
                                        <li>
                                            <Link
                                                :href="route('admin.settings.general')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.settings.general*') ? 'text-white font-semibold' : ''"
                                            >
                                                General settings
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.settings.mail')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.settings.mail*') ? 'text-white font-semibold' : ''"
                                            >
                                                SMTP & email
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.settings.seo')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.settings.seo*') ? 'text-white font-semibold' : ''"
                                            >
                                                SEO
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('admin.settings.security')"
                                                class="block w-full text-left py-1 hover:text-white"
                                                :class="route().current('admin.settings.security*') ? 'text-white font-semibold' : ''"
                                            >
                                                Security
                                            </Link>
                                        </li>
                                    </ul>
                                </transition>
                            </li>
                    </ul>
                </div>

                <div>
                    <p class="px-3 mb-2 text-[11px] uppercase tracking-wider text-wncdi-light/70">Account</p>
                    <ul class="space-y-1">
                        <li>
                            <Link
                                :href="route('profile.edit')"
                                class="flex items-center gap-3 rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark"
                            >
                                <span class="material-icons text-base">person</span>
                                <span>Profile</span>
                            </Link>
                        </li>
                        <li>
                            <form @submit.prevent="$inertia.post(route('logout'))">
                                <button
                                    type="submit"
                                    class="w-full flex items-center gap-3 rounded-xl px-3 py-2 text-white/80 hover:bg-wncdi-dark"
                                >
                                    <span class="material-icons text-base">logout</span>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main content area -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top bar -->
            <header class="h-16 flex items-center justify-between px-4 md:px-8 bg-white border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100"
                        @click="showingSidebar = !showingSidebar"
                    >
                        <span class="material-icons text-xl">menu</span>
                    </button>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
                        <p class="text-xs text-gray-500">Welcome back, {{ user.name }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Search with suggestion dropdown (AJAX-style UI) -->
                    <div class="hidden sm:block relative w-64 text-xs">
                        <div class="flex items-center bg-gray-50 rounded-full px-3 py-1.5 text-gray-500">
                            <span class="material-icons text-base me-1">search</span>
                            <input
                                type="text"
                                v-model="searchQuery"
                                placeholder="Search forms, pages, users..."
                                class="bg-transparent border-0 focus:ring-0 text-xs flex-1 placeholder:text-gray-400"
                                @focus="showSearchResults = true"
                                @blur="setTimeout(() => (showSearchResults = false), 150)"
                            />
                        </div>

                        <div
                            v-if="showSearchResults && mockSearchResults.length"
                            class="absolute mt-1 w-full bg-white rounded-xl shadow-lg border border-gray-100 z-20 overflow-hidden"
                        >
                            <ul class="py-1 max-h-52 overflow-y-auto">
                                <li
                                    v-for="item in mockSearchResults"
                                    :key="item"
                                    class="px-3 py-1.5 hover:bg-gray-50 cursor-pointer flex items-center gap-2 text-[11px] text-gray-700"
                                >
                                    <span class="material-icons text-xs text-gray-400">search</span>
                                    <span>{{ item }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Notifications dropdown -->
                    <Dropdown align="right" width="64">
                        <template #trigger>
                            <button type="button" class="relative inline-flex items-center justify-center rounded-full h-9 w-9 bg-gray-50 text-gray-500 hover:bg-gray-100">
                                <span class="material-icons text-base">notifications</span>
                                <span
                                    v-if="adminNotifications.unreadCount > 0"
                                    class="absolute -top-0.5 -right-0.5 flex h-4 min-w-4 px-0.5 items-center justify-center rounded-full bg-red-500 text-[10px] text-white"
                                >
                                    {{ adminNotifications.unreadCount }}
                                </span>
                            </button>
                        </template>

                        <template #content>
                            <div class="px-3 py-2 border-b border-gray-100 flex items-center justify-between">
                                <p class="text-[11px] font-semibold text-gray-700">Notifications</p>
                                <button
                                    type="button"
                                    class="text-[10px] text-wncdi-accent font-medium cursor-pointer disabled:opacity-40"
                                    :disabled="!adminNotifications.unreadCount"
                                    @click="markAllNotificationsRead"
                                >
                                    Mark all read
                                </button>
                            </div>
                            <ul class="max-h-64 overflow-y-auto text-[11px]">
                                <li
                                    v-for="item in adminNotifications.items"
                                    :key="item.id"
                                    class="px-3 py-2 flex items-start gap-2 hover:bg-gray-50"
                                >
                                    <span class="mt-0.5 material-icons text-sm"
                                        :class="{
                                            'text-wncdi-accent': item.type === 'forum_registration',
                                            'text-sky-500': item.type === 'uae_resident',
                                            'text-wncdi-accent': item.type === 'user_signup',
                                        }"
                                    >
                                        {{ item.type === 'forum_registration' ? 'event' : item.type === 'uae_resident' ? 'flight_takeoff' : 'person_add' }}
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-800 truncate">{{ item.title }}</p>
                                        <p class="text-gray-500 truncate">{{ item.message }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">
                                            {{ new Date(item.created_at).toLocaleString() }}
                                        </p>
                                    </div>
                                </li>
                                <li
                                    v-if="!adminNotifications.items.length"
                                    class="px-3 py-3 text-[11px] text-gray-500 text-center"
                                >
                                    No new notifications.
                                </li>
                            </ul>
                        </template>
                    </Dropdown>

                    <!-- Account dropdown -->
                    <Dropdown align="right" width="56">
                        <template #trigger>
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-full bg-wncdi-light px-2 py-1 text-xs text-wncdi-dark border border-wncdi-light"
                            >
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-wncdi-accent text-white text-xs font-semibold">
                                    {{ userInitials }}
                                </span>
                                <span class="hidden sm:flex flex-col items-start leading-tight">
                                    <span class="text-xs font-semibold">{{ user.name }}</span>
                                    <span class="text-[11px] text-gray-500 capitalize">{{ user.role }}</span>
                                </span>
                                <span class="material-icons text-sm text-gray-400">expand_more</span>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                <div class="flex items-center gap-2 text-[12px]">
                                    <span class="material-icons text-sm text-gray-400">person</span>
                                    <span>Profile</span>
                                </div>
                            </DropdownLink>
                            <DropdownLink href="/">
                                <div class="flex items-center gap-2 text-[12px]">
                                    <span class="material-icons text-sm text-gray-400">public</span>
                                    <span>View site</span>
                                </div>
                            </DropdownLink>
                            <DropdownLink :href="route('profile.edit')">
                                <div class="flex items-center gap-2 text-[12px]">
                                    <span class="material-icons text-sm text-gray-400">settings</span>
                                    <span>Settings</span>
                                </div>
                            </DropdownLink>
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                <div class="flex items-center gap-2 text-[12px] text-red-600">
                                    <span class="material-icons text-sm">logout</span>
                                    <span>Log Out</span>
                                </div>
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
