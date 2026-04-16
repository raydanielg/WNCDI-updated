<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const form = useForm({
    full_name: '',
    date: '',
    nationality: '',
    passport_or_id: '',
    whatsapp: '',
    email: '',
    company_name: '',
    country_of_registration: '',
    business_location: '',
    services: [],
    other_services: '',
    registration_number: '',
    tin: '',
    willing_to_join: null,
    reason: '',
    agree_terms: false,
    signature_name: '',
});

const successMessage = ref('');
const showCongrats = ref(false);
const submittedSnapshot = ref(null);

const page = usePage();
const memberId = computed(() => page.props.flash?.member_id || null);

const serviceOptions = [
    'Freight Forwarding',
    'Customs Clearance',
    'Warehousing',
    'Air Cargo',
    'Sea Cargo',
    'Other',
];

const handleSubmit = () => {
    if (form.processing) return;

    form.post(route('tanford-membership.store'), {
        preserveScroll: true,
        onSuccess: () => {
            submittedSnapshot.value = { ...form.data() };
            successMessage.value = 'Thank you for registering as a TANFORD member.';
            showCongrats.value = true;
            form.reset();
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 text-gray-900">
        <Header />
        <main>
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-10">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                            TANFORD MEMBERSHIP REGISTRATION FORM
                        </h1>
                        <p class="mt-2 text-lg font-semibold text-wncdi-dark">
                            FOMU YA USAJILI WA UANACHAMA WA TANFORD
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            TANZANIA FREIGHT FORWARDERS ASSOCIATION - DUBAI &amp; TANZANIA
                        </p>
                    </div>

                    <form @submit.prevent="handleSubmit" class="bg-white rounded-2xl shadow-lg p-8 space-y-10">
                        <!-- Personal Information -->
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-wncdi-accent">
                                PERSONAL INFORMATION / TAARIFA BINAFSI
                            </h2>

                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Full Name / Jina Kamili <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.full_name"
                                        type="text"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.full_name ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                        autocomplete="name"
                                    />
                                    <p v-if="form.errors.full_name" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.full_name }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Date / Tarehe
                                    </label>
                                    <input
                                        v-model="form.date"
                                        type="date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Nationality / Uraia <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.nationality"
                                        type="text"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.nationality ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                    />
                                    <p v-if="form.errors.nationality" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.nationality }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Passport or ID Number / Namba ya Kitambulisho au Pasipoti <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.passport_or_id"
                                        type="text"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.passport_or_id ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                    />
                                    <p v-if="form.errors.passport_or_id" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.passport_or_id }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        WhatsApp Number / Namba ya WhatsApp <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.whatsapp"
                                        type="tel"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.whatsapp ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                        autocomplete="tel"
                                    />
                                    <p v-if="form.errors.whatsapp" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.whatsapp }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Email Address / Barua Pepe <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.email ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                        autocomplete="email"
                                    />
                                    <p v-if="form.errors.email" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- Company Information -->
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-wncdi-accent">
                                COMPANY INFORMATION / TAARIFA ZA KAMPUNI
                            </h2>

                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Company Name / Jina la Kampuni <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.company_name"
                                        type="text"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.company_name ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                    />
                                    <p v-if="form.errors.company_name" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.company_name }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Country of Registration / Nchi iliyosajiliwa <span class="text-rose-600">*</span>
                                    </label>
                                    <select
                                        v-model="form.country_of_registration"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.country_of_registration ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                    >
                                        <option value="">Select / Chagua</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="UAE (Dubai)">UAE (Dubai)</option>
                                        <option value="Both">Both / Zote mbili</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Business Location / Mahali Biashara Ilipo <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.business_location"
                                        type="text"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.business_location ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                    />
                                    <p v-if="form.errors.business_location" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.business_location }}
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Nature of Services / Aina ya Huduma Zinazotolewa
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <label
                                            v-for="service in serviceOptions"
                                            :key="service"
                                            class="flex items-center gap-3 cursor-pointer"
                                        >
                                            <input
                                                v-model="form.services"
                                                type="checkbox"
                                                :value="service"
                                                class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent"
                                            />
                                            <span class="text-sm text-gray-800">{{ service }}</span>
                                        </label>
                                    </div>
                                    <div v-if="form.services.includes('Other')" class="mt-3">
                                        <input
                                            v-model="form.other_services"
                                            type="text"
                                            placeholder="If Other, specify / Kama nyingine, fafanua"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Registration No. / Namba ya Usajili <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.registration_number"
                                        type="text"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.registration_number ? 'border-rose-500' : 'border-gray-300'"
                                        required
                                    />
                                    <p v-if="form.errors.registration_number" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.registration_number }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        TIN (if any) / TIN (ikiwa ipo)
                                    </label>
                                    <input
                                        v-model="form.tin"
                                        type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                    />
                                </div>
                            </div>
                        </section>

                        <!-- Membership Terms -->
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-wncdi-accent">
                                MEMBERSHIP TERMS / MASHARTI YA UANACHAMA
                            </h2>
                            <div class="bg-wncdi-light border border-emerald-100 rounded-xl p-4 text-sm text-gray-800 space-y-1">
                                <p>
                                    <span class="font-semibold">Annual Registration Fee:</span> AED 1,000
                                    <span class="mx-2">|</span>
                                    <span class="font-semibold">Ada ya Usajili ya Mwaka:</span> Dirham 1,000
                                </p>
                                <p>
                                    <span class="font-semibold">Monthly Contribution:</span> AED 300
                                    <span class="mx-2">|</span>
                                    <span class="font-semibold">Michango ya Kila Mwezi:</span> Dirham 300
                                </p>
                                <p class="mt-2 text-gray-700">
                                    Itakayosaidia katika utekelezaji wa shughuli rasmi na maendeleo ya TANFORD.
                                </p>
                            </div>
                        </section>

                        <!-- Membership Request -->
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-wncdi-accent">
                                MEMBERSHIP REQUEST / MAOMBI YA UANACHAMA
                            </h2>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 mb-2">
                                        Are you willing to join TANFORD voluntarily and accept the above terms?
                                        Je, uko tayari kujiunga na TANFORD kwa hiari na kukubaliana na masharti haya?
                                        <span class="text-rose-600">*</span>
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input
                                                type="radio"
                                                class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent"
                                                :value="true"
                                                v-model="form.willing_to_join"
                                            />
                                            <span class="text-sm text-gray-800">Yes / Ndiyo</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input
                                                type="radio"
                                                class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent"
                                                :value="false"
                                                v-model="form.willing_to_join"
                                            />
                                            <span class="text-sm text-gray-800">No / Hapana</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Why do you want to join TANFORD? (optional)
                                        <span class="block text-xs font-normal text-gray-600">
                                            Kwa nini unataka kujiunga na TANFORD? (si lazima)
                                        </span>
                                    </label>
                                    <textarea
                                        v-model="form.reason"
                                        rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                    ></textarea>
                                </div>
                            </div>
                        </section>

                        <!-- Declaration -->
                        <section>
                            <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-wncdi-accent">
                                DECLARATION / UTHIBITISHO
                            </h2>

                            <div class="space-y-4 text-sm text-gray-800">
                                <p>
                                    I confirm that the information provided is true and I agree to pay the membership fees as stated above.
                                </p>
                                <p>
                                    Nathibitisha kuwa taarifa nilizotoa ni sahihi na ninakubali kulipa ada ya uanachama kama ilivyoelezwa hapo juu.
                                </p>

                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input
                                        v-model="form.agree_terms"
                                        type="checkbox"
                                        class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent mt-1"
                                        required
                                    />
                                    <span class="text-sm text-gray-800">
                                        I agree / Nakubaliana
                                    </span>
                                </label>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Signature / Sahihi (Name) <span class="text-rose-600">*</span>
                                    </label>
                                    <input
                                        v-model="form.signature_name"
                                        type="text"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent"
                                        :class="form.errors.signature_name ? 'border-rose-500' : 'border-gray-300'"
                                        placeholder="Type your full name / Andika jina kamili"
                                        required
                                    />
                                    <p v-if="form.errors.signature_name" class="mt-1 text-xs text-rose-600">
                                        {{ form.errors.signature_name }}
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- Submit -->
                        <div class="pt-4 space-y-3">
                            <button
                                type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-wncdi-accent text-white font-bold py-4 px-6 rounded-lg hover:bg-wncdi-dark disabled:bg-wncdi-gold disabled:cursor-not-allowed transition-colors duration-300 text-lg uppercase tracking-wide"
                                :disabled="form.processing"
                            >
                                <span
                                    v-if="form.processing"
                                    class="inline-flex h-5 w-5 border-2 border-white/40 border-t-white rounded-full animate-spin"
                                ></span>
                                <span>{{ form.processing ? 'Submitting...' : 'Submit Application / Tuma Maombi' }}</span>
                            </button>
                            <p v-if="successMessage" class="text-center text-sm text-wncdi-accent font-medium">
                                {{ successMessage }}
                            </p>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <Footer />

        <!-- Simple success popup -->
        <div
            v-if="showCongrats"
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
        >
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Thank you!</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Your TANFORD membership registration has been submitted successfully.
                        </p>
                    </div>
                    <button
                        type="button"
                        class="text-gray-400 hover:text-gray-600"
                        @click="showCongrats = false"
                    >
                        <span class="material-icons text-[18px]">close</span>
                    </button>
                </div>

                <div v-if="submittedSnapshot" class="space-y-1 text-sm text-gray-700">
                    <p class="font-semibold text-gray-900">
                        {{ submittedSnapshot.full_name }}
                    </p>
                    <p v-if="submittedSnapshot.company_name">
                        <span class="text-gray-500">Company:</span>
                        <span class="ml-1">{{ submittedSnapshot.company_name }}</span>
                    </p>
                </div>

                <div class="pt-2">
                    <button
                        type="button"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-transparent text-gray-600 hover:bg-gray-50 text-xs font-medium py-2 px-4"
                        @click="showCongrats = false"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
