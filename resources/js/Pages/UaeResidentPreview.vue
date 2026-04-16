<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    resident: {
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
                            Your UAE resident registration
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
                                'bg-yellow-100 text-yellow-800': !resident.status || resident.status === 'pending',
                                'bg-wncdi-light text-wncdi-primary': resident.status === 'approved',
                                'bg-rose-100 text-rose-800': resident.status === 'rejected',
                            }"
                        >
                            {{ resident.status || 'pending' }}
                        </p>
                        <p class="mt-1 text-gray-500">
                            Submitted {{ new Date(resident.created_at).toLocaleString() }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
                        <h2 class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                            Attendee information
                        </h2>
                        <div class="text-sm space-y-2">
                            <p><span class="text-gray-500">Attendee type:</span> <span class="font-medium capitalize">{{ resident.attendee_type }}</span></p>
                            <p><span class="text-gray-500">Full name:</span> <span class="font-medium">{{ resident.name }}</span></p>
                            <p><span class="text-gray-500">Email:</span> <span class="font-medium">{{ resident.email }}</span></p>
                            <p><span class="text-gray-500">Phone:</span> <span class="font-medium">{{ resident.phone }}</span></p>
                            <p><span class="text-gray-500">City:</span> <span class="font-medium">{{ resident.city }}</span></p>
                            <p><span class="text-gray-500">Country of residence:</span> <span class="font-medium">{{ resident.country }}</span></p>
                            <p><span class="text-gray-500">Nationality:</span> <span class="font-medium">{{ resident.nationality }}</span></p>
                            <p><span class="text-gray-500">Passport number:</span> <span class="font-medium">{{ resident.passport_number }}</span></p>
                            <p><span class="text-gray-500">Emirates ID:</span> <span class="font-medium">{{ resident.emirates_id }}</span></p>
                        </div>
                    </section>

                    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
                        <h2 class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                            Professional information
                        </h2>
                        <div class="text-sm space-y-2">
                            <p><span class="text-gray-500">Job title / position:</span> <span class="font-medium">{{ resident.job_title }}</span></p>
                            <p><span class="text-gray-500">Organization / company:</span> <span class="font-medium">{{ resident.organization || '-' }}</span></p>
                            <p>
                                <span class="text-gray-500">Professional website:</span>
                                <span class="font-medium break-all">
                                    <a
                                        v-if="resident.website"
                                        :href="resident.website.startsWith('http') ? resident.website : `https://${resident.website}`"
                                        target="_blank"
                                        class="text-wncdi-dark hover:underline"
                                    >
                                        {{ resident.website }}
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
                            <span class="text-gray-500">Number of attendees with you:</span>
                            <span class="font-medium">{{ resident.attendee_count }}</span>
                        </p>
                        <p>
                            <span class="text-gray-500">Attendance days:</span>
                            <span class="font-medium">
                                {{ Array.isArray(resident.attendance_days) ? resident.attendance_days.join(', ') : resident.attendance_days }}
                            </span>
                        </p>
                        <p>
                            <span class="text-gray-500">Chosen package:</span>
                            <span class="font-medium">{{ resident.package }}</span>
                        </p>
                        <p>
                            <span class="text-gray-500">Terms &amp; conditions:</span>
                            <span class="font-medium">
                                {{ resident.agree_terms ? 'You agreed to the conference terms and data processing.' : 'Not accepted' }}
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
