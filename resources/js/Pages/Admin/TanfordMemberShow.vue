<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    member: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="TANFORD Member details" />

        <div class="space-y-6">
            <!-- Header / breadcrumb -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <nav class="text-[11px] text-gray-400 mb-1 flex items-center gap-1">
                        <Link :href="route('admin.tanford-members.index')" class="hover:text-wncdi-accent">TANFORD Members</Link>
                        <span>/</span>
                        <span class="text-gray-500">Details</span>
                    </nav>
                    <h1 class="text-lg font-semibold text-gray-900">Member details</h1>
                    <p class="text-[11px] text-gray-500 mt-1">
                        Full submission from TANFORD membership registration form.
                    </p>
                </div>
                <div class="flex items-center gap-2 text-[11px]">
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium"
                        :class="{
                            'bg-yellow-100 text-yellow-800': !member.status || member.status === 'pending',
                            'bg-wncdi-light text-wncdi-primary': member.status === 'approved',
                            'bg-blue-100 text-blue-800': member.status === 'rejected',
                        }"
                    >
                        {{ member.status || 'pending' }}
                    </span>
                    <span class="text-gray-400">·</span>
                    <span class="text-gray-500">ID #{{ member.id }}</span>
                </div>
            </div>

            <!-- Main content -->
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Left: personal & company info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-2xl border border-gray-100 p-5">
                        <h2 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <span class="material-icons text-[16px] text-wncdi-accent">person</span>
                            Personal information
                        </h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-[12px]">
                            <div>
                                <dt class="text-gray-500">Full name</dt>
                                <dd class="text-gray-900 font-medium">{{ member.full_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Date</dt>
                                <dd class="text-gray-900">{{ member.date || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Nationality</dt>
                                <dd class="text-gray-900">{{ member.nationality || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Passport / ID</dt>
                                <dd class="text-gray-900">{{ member.passport_or_id || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">WhatsApp</dt>
                                <dd class="text-gray-900">{{ member.whatsapp || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Email</dt>
                                <dd class="text-wncdi-dark break-words">{{ member.email || '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-5">
                        <h2 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <span class="material-icons text-[16px] text-wncdi-accent">business</span>
                            Company information
                        </h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-[12px]">
                            <div>
                                <dt class="text-gray-500">Company name</dt>
                                <dd class="text-gray-900 font-medium">{{ member.company_name || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Country of registration</dt>
                                <dd class="text-gray-900">{{ member.country_of_registration || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Business location</dt>
                                <dd class="text-gray-900">{{ member.business_location || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Registration number</dt>
                                <dd class="text-gray-900">{{ member.registration_number || '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">TIN</dt>
                                <dd class="text-gray-900">{{ member.tin || '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-5">
                        <h2 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <span class="material-icons text-[16px] text-wncdi-accent">handshake</span>
                            Membership & services
                        </h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-[12px]">
                            <div>
                                <dt class="text-gray-500">Willing to join TANFORD?</dt>
                                <dd class="text-gray-900">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px]"
                                        :class="member.willing_to_join ? 'bg-wncdi-light text-wncdi-dark' : 'bg-gray-50 text-gray-600'"
                                    >
                                        <span class="material-icons text-[14px]">
                                            {{ member.willing_to_join ? 'check_circle' : 'cancel' }}
                                        </span>
                                        <span>{{ member.willing_to_join ? 'Yes' : 'No' }}</span>
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Agreed to terms?</dt>
                                <dd class="text-gray-900">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px]"
                                        :class="member.agree_terms ? 'bg-wncdi-light text-wncdi-dark' : 'bg-gray-50 text-gray-600'"
                                    >
                                        <span class="material-icons text-[14px]">
                                            {{ member.agree_terms ? 'check_circle' : 'cancel' }}
                                        </span>
                                        <span>{{ member.agree_terms ? 'Yes' : 'No' }}</span>
                                    </span>
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-500 mb-1">Services</dt>
                                <dd>
                                    <div v-if="member.services && member.services.length" class="flex flex-wrap gap-1.5">
                                        <span
                                            v-for="service in member.services"
                                            :key="service"
                                            class="inline-flex items-center px-2 py-0.5 rounded-full bg-wncdi-light text-wncdi-dark text-[11px]"
                                        >
                                            {{ service }}
                                        </span>
                                    </div>
                                    <p v-else class="text-gray-400 text-[12px]">No services selected.</p>
                                </dd>
                            </div>
                            <div class="sm:col-span-2" v-if="member.other_services">
                                <dt class="text-gray-500 mb-1">Other services (description)</dt>
                                <dd class="text-gray-900 whitespace-pre-line text-[12px]">
                                    {{ member.other_services }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-5">
                        <h2 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <span class="material-icons text-[16px] text-wncdi-accent">description</span>
                            Motivation & consent
                        </h2>
                        <dl class="space-y-3 text-[12px]">
                            <div v-if="member.reason">
                                <dt class="text-gray-500 mb-1">Reason for joining (Maelezo)</dt>
                                <dd class="text-gray-900 whitespace-pre-line">
                                    {{ member.reason }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 mb-1">Signature</dt>
                                <dd class="text-gray-900 font-medium">
                                    {{ member.signature_name || '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Right: meta info -->
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-[12px]">
                        <h2 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <span class="material-icons text-[16px] text-wncdi-accent">info</span>
                            Meta
                        </h2>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-gray-500">Member ID</dt>
                                <dd class="text-gray-900 font-medium">#{{ member.id }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Status</dt>
                                <dd>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium"
                                        :class="{
                                            'bg-yellow-100 text-yellow-800': !member.status || member.status === 'pending',
                                            'bg-wncdi-light text-wncdi-primary': member.status === 'approved',
                                            'bg-blue-100 text-blue-800': member.status === 'rejected',
                                        }"
                                    >
                                        {{ member.status || 'pending' }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Created at</dt>
                                <dd class="text-gray-900">{{ new Date(member.created_at).toLocaleString() }}</dd>
                            </div>
                            <div v-if="member.updated_at">
                                <dt class="text-gray-500">Last updated</dt>
                                <dd class="text-gray-900">{{ new Date(member.updated_at).toLocaleString() }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
