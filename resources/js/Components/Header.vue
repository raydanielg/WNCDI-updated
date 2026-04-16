<script setup>
import { ref } from 'vue';

const isDarkMode = ref(true);
const isMoreDropdownOpen = ref(false);
const isMobileMenuOpen = ref(false);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

const toggleMoreDropdown = () => {
    isMoreDropdownOpen.value = !isMoreDropdownOpen.value;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>

<template>
    <header class="w-full" :class="isDarkMode ? 'dark' : ''">
        <!-- Top bar (emerald) -->
        <div class="bg-wncdi-accent text-white text-[11px] sm:text-xs border-b border-wncdi-dark">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-3 py-2 sm:px-6 lg:px-8">
                <!-- Left: Email + Call -->
                <div class="flex items-center gap-3 sm:gap-6">
                    <div class="flex items-center gap-1">
                        <span class="material-icons text-sm">mail</span>
                        <span>Email: <a href="mailto:wncdinitiative@gmail.com" class="hover:text-wncdi-gold">wncdinitiative@gmail.com</a></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="material-icons text-sm">call</span>
                        <span>Call: <a href="tel:+255621068500" class="hover:text-wncdi-gold">+255 621 068 500</a></span>
                    </div>
                </div>

                <!-- Right: Dark Mode + Language + Sign In -->
                <div class="hidden sm:flex items-center gap-3 sm:gap-4">
                    <button @click="toggleDarkMode" class="hover:opacity-80 transition text-white">
                        <span class="material-icons text-sm">{{ isDarkMode ? 'light_mode' : 'dark_mode' }}</span>
                    </button>
                    <select class="bg-wncdi-dark text-white text-xs border-0 focus:ring-0 cursor-pointer">
                        <option>English</option>
                        <option>Swahili</option>
                    </select>
                    <a href="/login" class="text-white hover:text-sky-300">Sign In</a>
                </div>
            </div>
        </div>

        <!-- Main nav bar (white) -->
        <nav class="bg-white text-gray-900 shadow-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-3 py-3 sm:px-6 lg:px-8">
                <!-- Left: Logo -->
                <div class="flex items-center px-2 py-1">
                    <img
                        :src="'/img/wncdi/logo.png'"
                        alt="WNCDi Logo"
                        class="h-16 sm:h-24 w-auto drop-shadow-xl"
                    />
                </div>

                <!-- Center: Links (desktop / tablet) -->
                <div class="hidden lg:flex flex-1 items-center justify-center gap-8 px-6 text-sm font-medium">
                    <a href="/" class="hover:text-wncdi-accent transition">Home</a>
                    <a href="/blog" class="hover:text-wncdi-accent transition">Blog</a>
                    <a href="/about" class="hover:text-wncdi-accent transition">About</a>
                    <a href="/contact" class="hover:text-wncdi-accent transition">Contact</a>
                    <a href="/faq" class="hover:text-wncdi-accent transition">FAQ</a>
                    
                    <!-- Programs link -->
                    <a href="/programs" class="hover:text-wncdi-accent transition">Programs</a>
                    
                    <!-- Donate link -->
                    <a href="/donate" class="hover:text-wncdi-accent transition">Donate</a>
                    
                    <!-- More dropdown -->
                    <div class="relative">
                        <button
                            @click="toggleMoreDropdown"
                            class="flex items-center gap-1 hover:text-wncdi-accent transition"
                        >
                            More
                            <span class="material-icons text-sm" :class="isMoreDropdownOpen ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        
                        <!-- Dropdown menu - 3 columns -->
                        <div
                            v-if="isMoreDropdownOpen"
                            class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-[600px] bg-white border border-gray-200 rounded-lg shadow-xl z-50 p-8"
                        >
                            <!-- Column 1: Programs & Activities -->
                            <div class="grid grid-cols-3 gap-8">
                                <div>
                                    <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-600 mb-4">Programs</h3>
                                    <ul class="space-y-4">
                                        <li>
                                            <a href="/programs" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">campaign</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">NCDs Advocacy</p>
                                                    <p class="text-xs text-gray-500">Education & awareness</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/events" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">event</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">Events & Activities</p>
                                                    <p class="text-xs text-gray-500">Join our activities</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/resources" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">library_books</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">Health Resources</p>
                                                    <p class="text-xs text-gray-500">Learn & explore</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Column 2: Get Involved -->
                                <div>
                                    <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-600 mb-4">Get Involved</h3>
                                    <ul class="space-y-4">
                                        <li>
                                            <a href="/donate" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">favorite</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">Donate</p>
                                                    <p class="text-xs text-gray-500">Support our mission</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/partners" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">handshake</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">Partnerships</p>
                                                    <p class="text-xs text-gray-500">Collaborate with us</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/about" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">card_membership</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">Membership</p>
                                                    <p class="text-xs text-gray-500">Join our movement</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Column 3: Organization -->
                                <div>
                                    <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-600 mb-4">Organization</h3>
                                    <ul class="space-y-4">
                                        <li>
                                            <a href="/about" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">info</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">About WNCDi</p>
                                                    <p class="text-xs text-gray-500">Our mission & vision</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/blog" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">newspaper</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">Blog</p>
                                                    <p class="text-xs text-gray-500">Latest updates</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/contact" class="flex items-start gap-3 group">
                                                <span class="material-icons text-wncdi-accent text-lg flex-shrink-0 group-hover:text-wncdi-dark">support_agent</span>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-wncdi-accent">Contact</p>
                                                    <p class="text-xs text-gray-500">Get in touch</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Action buttons at bottom -->
                            <div class="mt-6 border-t border-gray-200 pt-6 flex gap-3">
                                <a
                                    href="#register-forum"
                                    class="flex-1 inline-flex items-center justify-center rounded-md bg-wncdi-primary px-4 py-2 text-xs font-semibold uppercase text-white hover:bg-wncdi-accent transition"
                                >
                                    Register for Forum
                                </a>
                                <a
                                    href="#register-member"
                                    class="flex-1 inline-flex items-center justify-center rounded-md bg-wncdi-accent px-4 py-2 text-xs font-semibold uppercase text-white hover:bg-wncdi-dark transition"
                                >
                                    Become a Member
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Search + CTA (desktop) -->
                <div class="hidden md:flex items-center gap-4">
                    <!-- Search -->
                    <div class="hidden md:flex items-center bg-gray-100 rounded px-3 py-1">
                        <input
                            type="text"
                            placeholder="Search..."
                            class="bg-transparent text-gray-900 text-xs placeholder-gray-500 border-0 focus:ring-0 w-32"
                        />
                        <span class="material-icons text-sm text-gray-500">search</span>
                    </div>

                    <!-- Get Started button -->
                    <a
                        href="/donate"
                        class="bg-wncdi-accent hover:bg-wncdi-dark text-white px-4 py-2 rounded text-xs font-semibold flex items-center gap-1 transition"
                    >
                        Donate Now
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 lg:hidden"
                    @click="toggleMobileMenu"
                >
                    <span class="material-icons text-2xl">{{ isMobileMenuOpen ? 'close' : 'menu' }}</span>
                </button>
            </div>

            <!-- Mobile menu panel -->
            <div v-if="isMobileMenuOpen" class="lg:hidden border-t border-gray-100 bg-white">
                <div class="space-y-1 px-4 py-4 text-sm font-medium">
                    <a href="/" class="block py-2 hover:text-wncdi-accent">Home</a>
                    <a href="/blog" class="block py-2 hover:text-wncdi-accent">Blog</a>
                    <a href="/about" class="block py-2 hover:text-wncdi-accent">About</a>
                    <a href="/programs" class="block py-2 hover:text-wncdi-accent">Programs</a>
                    <a href="/events" class="block py-2 hover:text-wncdi-accent">Events</a>
                    <a href="/contact" class="block py-2 hover:text-wncdi-accent">Contact</a>
                    <a href="/donate" class="block py-2 hover:text-wncdi-accent">Donate</a>
                    <a href="/partners" class="block py-2 hover:text-wncdi-accent">Partners</a>
                    <a href="/faq" class="block py-2 hover:text-wncdi-accent">FAQ</a>
                    <a href="/resources" class="block py-2 hover:text-wncdi-accent">Resources</a>

                    <div class="pt-3 mt-3 border-t border-gray-100 flex flex-col gap-2">
                        <a
                            href="/donate"
                            class="inline-flex justify-center items-center rounded-md bg-wncdi-accent px-4 py-2 text-xs font-semibold text-white hover:bg-wncdi-dark"
                        >
                            Support Our Mission
                        </a>
                        <a href="/login" class="text-xs text-gray-700 hover:text-wncdi-accent">Sign In</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>
