<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    registration: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 text-gray-900">
        <Header />

        <main class="py-16 px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl space-y-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                            Your forum registration
                        </h1>
                        <p class="mt-2 text-sm text-gray-600">
                            This is a read-only preview of the information you submitted. If anything is incorrect,
                            please contact the organizers.
                        </p>
                    </div>
                    <div class="text-right text-xs">
                        <p
                            class="inline-flex items-center px-2 py-0.5 rounded-full font-medium text-[11px]"
                            :class="{
                                'bg-yellow-100 text-yellow-800': !registration.status || registration.status === 'pending',
                                'bg-wncdi-light text-wncdi-primary': registration.status === 'approved',
                                'bg-blue-100 text-blue-800': registration.status === 'rejected',
                            }"
                        >
                            {{ registration.status || 'pending' }}
                        </p>
                        <p class="mt-1 text-gray-500">
                            Submitted {{ new Date(registration.created_at).toLocaleString() }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
                        <h2 class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                            Attendee information
                        </h2>
                        <div class="text-sm space-y-2">
                            <p><span class="text-gray-500">Forum:</span> <span class="font-medium">{{ registration.forum_name }}</span></p>
                            <p><span class="text-gray-500">Attendee type:</span> <span class="font-medium capitalize">{{ registration.attendee_type }}</span></p>
                            <p><span class="text-gray-500">Full name:</span> <span class="font-medium">{{ registration.name }}</span></p>
                            <p><span class="text-gray-500">Email:</span> <span class="font-medium">{{ registration.email }}</span></p>
                            <p><span class="text-gray-500">Phone:</span> <span class="font-medium">{{ registration.phone }}</span></p>
                            <p><span class="text-gray-500">City:</span> <span class="font-medium">{{ registration.city }}</span></p>
                            <p><span class="text-gray-500">Country of residence:</span> <span class="font-medium">{{ registration.country }}</span></p>
                            <p><span class="text-gray-500">Nationality:</span> <span class="font-medium">{{ registration.nationality }}</span></p>
                        </div>
                    </section>

                    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
                        <h2 class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                            Professional information
                        </h2>
                        <div class="text-sm space-y-2">
                            <p><span class="text-gray-500">Organization / company:</span> <span class="font-medium">{{ registration.organization }}</span></p>
                            <p><span class="text-gray-500">Contact person:</span> <span class="font-medium">{{ registration.contact_person }}</span></p>
                            <p><span class="text-gray-500">Job title / position:</span> <span class="font-medium">{{ registration.job_title }}</span></p>
                            <p><span class="text-gray-500">Contact mobile:</span> <span class="font-medium">{{ registration.contact_phone }}</span></p>
                            <p>
                                <span class="text-gray-500">Company website:</span>
                                <span class="font-medium break-all">
                                    <a
                                        v-if="registration.website"
                                        :href="registration.website.startsWith('http') ? registration.website : `https://${registration.website}`"
                                        target="_blank"
                                        class="text-wncdi-dark hover:underline"
                                    >
                                        {{ registration.website }}
                                    </a>
                                    <span v-else>-</span>
                                </span>
                            </p>
                        </div>
                    </section>
                </div>

                <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
                    <h2 class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                        Forum participation
                    </h2>
                    <div class="text-sm space-y-2">
                        <p>
                            <span class="text-gray-500">Number of attendees from your company:</span>
                            <span class="font-medium">{{ registration.attendee_count }}</span>
                        </p>
                        <p>
                            <span class="text-gray-500">Booth preference:</span>
                            <span class="font-medium capitalize">{{ registration.booth }}</span>
                        </p>
                        <p>
                            <span class="text-gray-500">Selected sponsorship package:</span>
                            <span class="font-medium">{{ registration.sponsorship_package || '-' }}</span>
                        </p>
                        <p>
                            <span class="text-gray-500">Attendance days:</span>
                            <span class="font-medium">
                                {{ Array.isArray(registration.attendance_days) ? registration.attendance_days.join(', ') : registration.attendance_days }}
                            </span>
                        </p>
                        <p>
                            <span class="text-gray-500">Services rendered:</span>
                            <span class="font-medium">
                                {{ Array.isArray(registration.services) ? registration.services.join(', ') : registration.services }}
                            </span>
                        </p>
                        <p v-if="registration.other_services">
                            <span class="text-gray-500">Other services:</span>
                            <span class="font-medium">{{ registration.other_services }}</span>
                        </p>
                        <p>
                            <span class="text-gray-500">Terms &amp; conditions:</span>
                            <span class="font-medium">
                                {{ registration.agree_terms ? 'You agreed to the conference terms and data processing.' : 'Not accepted' }}
                            </span>
                        </p>
                    </div>
                </section>

                <div class="text-xs text-gray-500">
                    <p>
                        If your status changes to <span class="font-semibold text-wncdi-dark">approved</span>, you will receive
                        a separate confirmation email.
                    </p>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
