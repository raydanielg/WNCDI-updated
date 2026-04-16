<template>
    <section class="bg-white" v-if="teamMembers.length">
        <div class="py-16 px-4 mx-auto max-w-screen-xl lg:py-20 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center mb-10 lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">
                    Our Team
                </h2>
                <p class="font-light text-gray-500 sm:text-xl">
                    Meet the dedicated professionals behind WNCDi who are committed to health education,
                    community wellness, and making a positive impact on people's lives.
                </p>
            </div>
            <div class="grid gap-6 mb-6 lg:mb-16 grid-cols-1 sm:grid-cols-2 lg:gap-8">
                <div
                    v-for="member in teamMembers"
                    :key="member.id"
                    class="flex flex-col items-center bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6"
                >
                    <div class="mb-4">
                        <img
                            class="w-32 h-32 rounded-full object-cover border-4 border-wncdi-accent shadow-md"
                            :src="member.photo_url"
                            :alt="member.name"
                        />
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold tracking-tight mb-1">
                            <span class="text-gray-900">
                                {{ member.name }}
                            </span>
                        </h3>
                        <span class="text-wncdi-accent font-semibold text-sm uppercase tracking-wide">{{ member.title }}</span>
                        <p class="mt-3 mb-4 font-light text-gray-600 text-sm">
                            {{ member.bio }}
                        </p>
                        <ul
                            class="flex space-x-4 justify-center"
                            v-if="member.instagram_url || member.facebook_url || member.linkedin_url || member.twitter_url"
                        >
                            <li v-if="member.facebook_url">
                                <a :href="member.facebook_url" class="text-gray-400 hover:text-blue-600 transition-colors" target="_blank" rel="noopener" aria-label="Facebook">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            fill-rule="evenodd"
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                            </li>
                            <li v-if="member.twitter_url">
                                <a :href="member.twitter_url" class="text-gray-400 hover:text-sky-500 transition-colors" target="_blank" rel="noopener" aria-label="Twitter">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                                        />
                                    </svg>
                                </a>
                            </li>
                            <li v-if="member.linkedin_url">
                                <a :href="member.linkedin_url" class="text-gray-400 hover:text-blue-700 transition-colors" target="_blank" rel="noopener" aria-label="LinkedIn">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M4.983 3.5C4.983 4.88 3.88 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.483 1.12 2.483 2.5zM.25 8.25h4.5v13.5H.25zM8.75 8.25h4.31v1.84h.06c.6-1.14 2.07-2.34 4.26-2.34 4.55 0 5.39 2.99 5.39 6.88v7.09h-4.5v-6.28c0-1.5-.03-3.43-2.09-3.43-2.09 0-2.41 1.63-2.41 3.32v6.39h-4.5z"
                                        />
                                    </svg>
                                </a>
                            </li>
                            <li v-if="member.instagram_url">
                                <a :href="member.instagram_url" class="text-gray-400 hover:text-pink-600 transition-colors" target="_blank" rel="noopener" aria-label="Instagram">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h10zm-5 3.5A4.5 4.5 0 1 0 16.5 12 4.505 4.505 0 0 0 12 7.5zm0 2A2.5 2.5 0 1 1 9.5 12 2.503 2.503 0 0 1 12 9.5zm4.75-3.25a1.25 1.25 0 1 0 1.25 1.25 1.252 1.252 0 0 0-1.25-1.25z"
                                        />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    teamMembers: {
        type: Array,
        default: () => [],
    },
});

const teamMembers = props.teamMembers ?? [];
</script>
