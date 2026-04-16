<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const days = ref('00');
const hours = ref('00');
const minutes = ref('00');
const seconds = ref('00');

let timerId = null;

const form = useForm({
    attendee_type: '',
    name: '',
    email: '',
    phone: '',
    city: '',
    country: '',
    nationality: '',
    passport_number: '',
    emirates_id: '',
    job_title: '',
    organization: '',
    website: '',
    attendee_count: '',
    attendance_days: [],
    package: '',
    agree_terms: false,
});

const successMessage = ref('');
const showCongrats = ref(false);
const submittedSnapshot = ref(null);

const page = usePage();
const residentId = computed(() => page.props.flash?.resident_id || null);

const whatsappMessage = computed(() => {
    if (!submittedSnapshot.value) return '';

    const data = submittedSnapshot.value;
    const parts = [
        `I have just registered as a UAE resident attendee for the Tanzania Trade & Logistics Forum.`,
    ];

    if (data.city || data.country) {
        parts.push(`Location: ${[data.city, data.country].filter(Boolean).join(', ')}`);
    }

    if (data.package) {
        parts.push(`Package: ${data.package}`);
    }

    parts.push('Join me and be part of this opportunity.');

    const baseUrl = typeof window !== 'undefined' ? window.location.origin : '';
    parts.push(`${baseUrl}/uaeresidents`);

    return parts.join(' ');
});

const targetDate = new Date('2026-02-13T09:00:00+04:00');

const updateCountdown = () => {
    const now = new Date().getTime();
    const distance = targetDate.getTime() - now;

    if (distance <= 0) {
        days.value = '00';
        hours.value = '00';
        minutes.value = '00';
        seconds.value = '00';
        if (timerId) window.clearInterval(timerId);
        return;
    }

    const d = Math.floor(distance / (1000 * 60 * 60 * 24));
    const h = Math.floor((distance / (1000 * 60 * 60)) % 24);
    const m = Math.floor((distance / (1000 * 60)) % 60);
    const s = Math.floor((distance / 1000) % 60);

    days.value = String(d).padStart(2, '0');
    hours.value = String(h).padStart(2, '0');
    minutes.value = String(m).padStart(2, '0');
    seconds.value = String(s).padStart(2, '0');
};

onMounted(() => {
    updateCountdown();
    timerId = window.setInterval(updateCountdown, 1000);
});

onBeforeUnmount(() => {
    if (timerId) window.clearInterval(timerId);
});

const submitDiasporaForm = () => {
    form.post(route('uaeresidents.store'), {
        preserveScroll: true,
        onSuccess: () => {
            submittedSnapshot.value = { ...form.data() };
            successMessage.value = 'Thank you for registering as a UAE resident attendee. We will contact you soon.';
            showCongrats.value = true;
            form.reset();
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero only (no breadcrumb) -->
            <section
                class="relative min-h-screen flex flex-col items-center justify-center text-white overflow-hidden"
            >
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('/img/wncdi/moments.jpeg'); filter: brightness(0.6);"
                ></div>
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"></div>

                <div class="relative z-10 max-w-4xl px-4 text-center">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">
                        TANZANIA TRADE AND LOGISTICS FORUM
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl font-medium mb-8">
                        13 to 14 February 2026, Shangri-La Hotel, Dubai
                    </p>

                    <!-- Countdown -->
                    <div class="mt-4 mb-10 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto">
                        <div class="bg-white/10 backdrop-blur-md rounded-lg py-4 px-3 flex flex-col items-center shadow-lg">
                            <div class="text-3xl sm:text-4xl font-extrabold">{{ days }}</div>
                            <div class="text-xs uppercase tracking-wide text-gray-200 mt-1">Days</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-lg py-4 px-3 flex flex-col items-center shadow-lg">
                            <div class="text-3xl sm:text-4xl font-extrabold">{{ hours }}</div>
                            <div class="text-xs uppercase tracking-wide text-gray-200 mt-1">Hours</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-lg py-4 px-3 flex flex-col items-center shadow-lg">
                            <div class="text-3xl sm:text-4xl font-extrabold">{{ minutes }}</div>
                            <div class="text-xs uppercase tracking-wide text-gray-200 mt-1">Minutes</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-lg py-4 px-3 flex flex-col items-center shadow-lg">
                            <div class="text-3xl sm:text-4xl font-extrabold">{{ seconds }}</div>
                            <div class="text-xs uppercase tracking-wide text-gray-200 mt-1">Seconds</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-4">
                        <a
                            href="/forumregster"
                            class="inline-flex justify-center items-center py-3 px-8 text-base font-bold text-center text-white rounded-lg bg-wncdi-accent hover:bg-wncdi-dark focus:ring-4 focus:ring-wncdi-light transition-all duration-300 uppercase tracking-wide"
                        >
                            Proceed to Forum Registration
                        </a>
                        <a
                            href="/"
                            class="inline-flex justify-center items-center py-3 px-8 text-base font-medium text-center text-white/80 rounded-lg border border-white/50 hover:bg-white/10 transition-all duration-300"
                        >
                            Back to Home
                        </a>
                    </div>
                </div>
            </section>

            <!-- Diaspora Registration Form Section -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
                <div class="mx-auto max-w-4xl">
                    <div class="mb-10 text-center">
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Your Home Advantage Starts Here</h2>
                        <p class="text-lg text-wncdi-dark font-semibold mb-2">Exclusive Diaspora Rate to the Tanzania Trade &amp; Logistics Business Forum</p>
                        <p class="text-gray-700 mb-2">
                            This category is open to attendees from all countries worldwide who wish to join the Tanzania Trade &amp; Logistics Forum 2026.
                        </p>
                        <p class="text-gray-600">
                            The Diaspora rate is a special discounted package designed to encourage participation, learning, networking, and contribution to national development for Tanzanians and friends of Tanzania across the globe.
                        </p>
                    </div>

                    <form @submit.prevent="submitDiasporaForm" class="bg-white rounded-2xl shadow-lg p-8 space-y-8">
                        <!-- Attendant Information -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-wncdi-accent">Attendant Information</h3>

                            <!-- Attendee Type -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Attendee Type <span class="text-rose-600">*</span></label>
                                <select v-model="form.attendee_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required>
                                    <option value="">Select attendee type</option>
                                    <option value="individual">Individual</option>
                                    <option value="company">Company Representative</option>
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Name <span class="text-rose-600">*</span></label>
                                <input v-model="form.name" type="text" placeholder="E.g. John Doe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Email Address <span class="text-rose-600">*</span></label>
                                <input v-model="form.email" type="email" placeholder="E.g. john@doe.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Phone -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Phone <span class="text-rose-600">*</span></label>
                                <div class="flex gap-2">
                                    <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent">
                                        <option>United Arab Emirates +971</option>
                                        <option>Tanzania +255</option>
                                        <option>Other</option>
                                    </select>
                                    <input v-model="form.phone" type="tel" placeholder="50 123 4567" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                                </div>
                            </div>

                            <!-- City -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">City <span class="text-rose-600">*</span></label>
                                <input v-model="form.city" type="text" placeholder="E.g. Sydney" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Country of Residence -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Country of Residence <span class="text-rose-600">*</span></label>
                                <input v-model="form.country" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Nationality -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Nationality <span class="text-rose-600">*</span></label>
                                <input v-model="form.nationality" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Passport Number -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Passport Number <span class="text-rose-600">*</span></label>
                                <input v-model="form.passport_number" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Emirates ID Number -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Emirates ID Number <span class="text-rose-600">*</span></label>
                                <input v-model="form.emirates_id" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-wncdi-accent">Professional Information</h3>

                            <!-- Job Title -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Job Title <span class="text-rose-600">*</span></label>
                                <input v-model="form.job_title" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Organization/Company -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Organization/Company</label>
                                <input v-model="form.organization" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" />
                            </div>

                            <!-- Professional Website -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Professional Website <span class="text-rose-600">*</span></label>
                                <input v-model="form.website" type="url" placeholder="E.g. www.example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Number of People Attending -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">How many people will be coming to the forum with you? <span class="text-rose-600">*</span></label>
                                <input v-model="form.attendee_count" type="number" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Attendance Days -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Are you intending to attend for both days or one of the two days? <span class="text-rose-600">*</span></label>
                                <p class="text-xs text-gray-600 mb-3">Tick both if you will attend two days or tick one if you will be attending one of the two days.</p>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="form.attendance_days" type="checkbox" value="day1" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Day 1 (13th February 2026)</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="form.attendance_days" type="checkbox" value="day2" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Day 2 (14th February 2026)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Package -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Choose a package <span class="text-rose-600">*</span></label>
                                <p class="text-xs text-gray-600 mb-3">Payment must be completed to secure your delegate pass. Limited slots available.</p>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="form.package" type="radio" value="diaspora_rate" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700 font-semibold">Diaspora Rate: AED 1,000</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Declaration -->
                        <div class="border-t border-gray-200 pt-6">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input v-model="form.agree_terms" type="checkbox" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent mt-1" required />
                                <span class="text-sm text-gray-700">Agree to the conference's terms and conditions and the processing of your data. <span class="text-rose-600">*</span></span>
                            </label>
                        </div>

                        <!-- Submit Button -->
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
                                <span>{{ form.processing ? 'Submitting...' : 'Register' }}</span>
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

        <!-- Congratulations popup -->
        <div
            v-if="showCongrats"
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
        >
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Congratulations!</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Your UAE resident registration has been submitted successfully. You will receive a
                            confirmation email shortly.
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

                <div class="space-y-3 text-sm text-gray-700" v-if="submittedSnapshot">
                    <p class="font-semibold text-gray-900">
                        {{ submittedSnapshot.name }}
                        <span v-if="submittedSnapshot.job_title" class="text-gray-500 font-normal">
                            · {{ submittedSnapshot.job_title }}
                        </span>
                    </p>
                    <p v-if="submittedSnapshot.city || submittedSnapshot.country">
                        <span class="text-gray-500">Location:</span>
                        <span class="ml-1">
                            {{ [submittedSnapshot.city, submittedSnapshot.country].filter(Boolean).join(', ') }}
                        </span>
                    </p>
                    <p v-if="submittedSnapshot.package">
                        <span class="text-gray-500">Package:</span>
                        <span class="ml-1">{{ submittedSnapshot.package }}</span>
                    </p>
                </div>

                <div class="space-y-3 pt-2">
                    <a
                        :href="`https://wa.me/?text=${encodeURIComponent(whatsappMessage)}`"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-wncdi-accent hover:bg-wncdi-dark text-white text-sm font-semibold py-2.5 px-4"
                    >
                        <span class="material-icons text-[16px]">share</span>
                        <span>Share via WhatsApp</span>
                    </a>

                    <a
                        v-if="residentId"
                        :href="route('uaeresidents.preview', residentId)"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-gray-200 text-gray-700 hover:bg-gray-50 text-sm font-semibold py-2.5 px-4"
                    >
                        <span class="material-icons text-[16px]">visibility</span>
                        <span>View your registration</span>
                    </a>

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
