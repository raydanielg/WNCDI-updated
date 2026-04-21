<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { ref, computed } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';

const form = useForm({
    forum_name: 'Tanzania Global Logistics Forum 2026',
    attendee_type: '',
    name: '',
    email: '',
    phone: '',
    city: '',
    country: '',
    nationality: '',
    organization: '',
    contact_person: '',
    job_title: '',
    website: '',
    contact_phone: '',
    attendee_count: '',
    services: [],
    other_services: '',
    attendance_days: [],
    booth: '',
    sponsorship_package: '',
    agree_terms: false,
});

const services = [
    'Logistics',
    'Clearing and Forwarding',
    'Shipping line',
    'Airline',
    'Port Operators',
    'Warehouse Services',
    'Other'
];

const packages = [
    {
        name: 'BUSINESS NETWORK',
        price: '$800',
        details: 'Includes: 1 Delegate Passes, 2 Days for business forum, Access to Business Networking, Meals'
    },
    {
        name: 'STANDARD PACKAGE',
        price: '$1,500',
        details: 'Includes: 1 Exhibition Stall, 2 Delegate Passes, Promotional Video, Wall Banner Display, Business Networking Access, Certificate of Participation'
    },
    {
        name: 'PARTICIPANTS PACKAGE',
        price: '$3,500',
        details: 'Includes: Hotel 3 Nights, Visa, Ticket DAR - DXB – DAR, Meals, 2 Days Pass for business forum, Access to Business Networking, Pickup & Dropoff Airport & Hotel, Certificate of Participation'
    },
    {
        name: 'EXHIBITOR PACKAGE',
        price: '$4,500',
        details: 'Includes: Hotel 3 Nights, Visa, Ticket DAR - DXB – DAR, Meals, 2 Days Pass for business forum, Access to Business Networking, Stall, Promotional Video, Wall Banner Display at the venue, Pickup & Dropoff Airport & Hotel, Certificate of Participation'
    }
];

const successMessage = ref('');
const showCongrats = ref(false);
const submittedSnapshot = ref(null);

const page = usePage();
const registrationId = computed(() => page.props.flash?.registration_id || null);

const whatsappMessage = computed(() => {
    if (!submittedSnapshot.value) return '';

    const data = submittedSnapshot.value;
    const parts = [
        `I have just registered for the ${data.forum_name} as a ${data.attendee_type || 'participant'}.`,
    ];

    if (data.organization) {
        parts.push(`Organization: ${data.organization}`);
    }

    if (data.country) {
        parts.push(`Country: ${data.country}`);
    }

    parts.push('Join me at the forum and be part of this opportunity.');

    const baseUrl = typeof window !== 'undefined' ? window.location.origin : '';
    parts.push(`${baseUrl}/forumregster`);

    return parts.join(' ');
});

const scrollToForm = () => {
    const formSection = document.getElementById('registration-form');
    if (formSection) {
        formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};

const handleSubmit = () => {
    form.post(route('forum.register.store'), {
        preserveScroll: true,
        onSuccess: () => {
            submittedSnapshot.value = { ...form.data() };
            successMessage.value = 'Thank you for registering. We will contact you soon.';
            showCongrats.value = true;
            form.reset();
            form.forum_name = 'Tanzania Global Logistics Forum 2026';
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero section with image carousel -->
            <section class="relative min-h-screen bg-cover bg-center flex flex-col items-center justify-center overflow-hidden">
                <div class="absolute inset-0 flex">
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('/img/wncdi/about-hero.jpeg');"></div>
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('/img/wncdi/moments.jpeg');"></div>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-wncdi-dark/20 via-wncdi-primary/15 to-wncdi-primary/25"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight mb-6">Tanzania Global Logistics Forum 2025</h1>
                    <p class="text-xl sm:text-2xl font-light mb-12 max-w-2xl mx-auto">Register Now to Join Us for an Exceptional Networking and Business Opportunity</p>
                    <a @click.prevent="scrollToForm" href="#registration-form" class="inline-flex justify-center items-center py-4 px-8 text-lg font-bold text-center text-white rounded-lg bg-wncdi-primary hover:bg-wncdi-dark focus:ring-4 focus:ring-blue-200 transition-all duration-300 uppercase tracking-wide cursor-pointer">
                        Register for Forum
                    </a>
                </div>
            </section>

            <!-- Registration form section -->
            <section id="registration-form" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
                <div class="mx-auto max-w-4xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-8">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <a href="/" class="hover:text-wncdi-accent transition">Home</a>
                            <span class="text-gray-400">›</span>
                            <span class="text-gray-900 font-medium">Tanzania Global Logistics Forum 2025 Registration Form</span>
                        </div>
                    </nav>

                    <!-- Featured registration info card -->
                    <section class="mb-12">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <div class="grid md:grid-cols-2 gap-0">
                                <!-- Text content -->
                                <div class="p-8 sm:p-10 flex flex-col justify-between">
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-6 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                            <div class="flex items-center gap-2">
                                                <span class="material-icons text-base text-gray-400">event</span>
                                                <span>October 15, 2025</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="material-icons text-base text-gray-400">label</span>
                                                <span>Uncategorized</span>
                                            </div>
                                        </div>

                                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-gray-900">
                                            ONLINE REGISTRATION NOW OPEN FOR TANZANIA GLOBAL TRADE & LOGISTICS FORUM 2025 IN DUBAI
                                        </h2>

                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            <span class="font-semibold">Dubai, UAE</span>
                                            <span class="mx-1">&mdash;</span>
                                            Online registration is now open for participants and exhibitors ahead of the highly anticipated Tanzania Global Trade & Logistics Forum 2025, scheduled to take place on 13th–14th February 2026, at the iconic Shangri-La Hotel in Dubai...
                                        </p>
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="relative h-72 md:h-full bg-gray-100">
                                    <img
                                        :src="'/images/DXB_3576-1536x1024.jpg'"
                                        alt="Tanzania Global Trade & Logistics Forum venue"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Form title -->
                    <div class="mb-12">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Tanzania Global Logistics Forum 2025 Registration Form</h2>
                        <p class="text-gray-600 text-lg">This form should be filled out by companies/individuals intending to participate to this forum.</p>
                    </div>

                    <!-- Registration form -->
                    <form @submit.prevent="handleSubmit" class="bg-white rounded-lg shadow-lg p-8 space-y-8">
                        <!-- Attendant Information Section -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-wncdi-accent">Attendant Information</h3>
                            
                            <!-- Attendee Type -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Attendee Type <span class="text-wncdi-primary">*</span></label>
                                <select v-model="form.attendee_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required>
                                    <option value="">Select attendee type</option>
                                    <option value="individual">Individual</option>
                                    <option value="company">Company Representative</option>
                                    <option value="exhibitor">Exhibitor</option>
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Name <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.name" type="text" placeholder="E.g. John Doe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Email Address <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.email" type="email" placeholder="E.g. john@doe.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Phone -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Phone <span class="text-wncdi-primary">*</span></label>
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
                                <label class="block text-sm font-semibold text-gray-900 mb-3">City <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.city" type="text" placeholder="E.g. Sydney" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Country of Residence -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Country of Residence <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.country" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Nationality -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Nationality <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.nationality" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>
                        </div>

                        <!-- Professional Information Section -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-wncdi-accent">Professional Information</h3>
                            
                            <!-- Organization -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Organization/Company <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.organization" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Contact Person -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Name of the Contact person/company representative for this event <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.contact_person" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Job Title -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Job Title <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.job_title" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Website -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Professional Website (optional)</label>
                                <input v-model="form.website" type="url" placeholder="E.g. www.example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" />
                            </div>

                            <!-- Contact Phone -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Mobile number for the Contact person/representative for this event <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.contact_phone" type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Attendee Count -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">How many people from your company will be coming to the forum? <span class="text-wncdi-primary">*</span></label>
                                <input v-model="form.attendee_count" type="number" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Services -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Services Rendered <span class="text-wncdi-primary">*</span></label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label v-for="service in services" :key="service" class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="form.services" type="checkbox" :value="service" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">{{ service }}</span>
                                    </label>
                                </div>
                                <div v-if="form.services.includes('Other')" class="mt-4">
                                    <input v-model="form.other_services" type="text" placeholder="If you checked 'Other' above, specify the services" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" />
                                </div>
                            </div>

                            <!-- Attendance Days -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Are you intending to attend for both days or one of the two days? <span class="text-wncdi-primary">*</span></label>
                                <p class="text-xs text-gray-600 mb-4">Tick both if you will attend two days or tick one if you will be attending one of the two days</p>
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

                            <!-- Booth -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Would you prefer to have a booth to showcase your products/services? <span class="text-wncdi-primary">*</span></label>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="form.booth" type="radio" value="yes" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Yes</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="form.booth" type="radio" value="no" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">No</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="form.booth" type="radio" value="maybe" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Maybe</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Sponsorship Package -->
                            <div class="mb-6" v-if="form.booth === 'yes'">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Choose a package for sponsorship <span class="text-wncdi-primary">*</span></label>
                                <p class="text-sm text-gray-600 mb-4">We sincerely look forward to your participation and partnership in this significant event promoting Tanzania's trade and logistics advancement.</p>
                                <div class="grid gap-4">
                                    <label v-for="pkg in packages" :key="pkg.name" class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-wncdi-accent transition">
                                        <input v-model="form.sponsorship_package" type="radio" :value="pkg.name" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent mt-1 flex-shrink-0" />
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ pkg.name }} - {{ pkg.price }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ pkg.details }}</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Declaration -->
                        <div class="border-t-2 border-gray-200 pt-8">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input v-model="form.agree_terms" type="checkbox" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent mt-1 flex-shrink-0" required />
                                <span class="text-sm text-gray-700">Agree to the conference's terms and conditions and the processing of your data. <span class="text-wncdi-primary">*</span></span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-8 space-y-3">
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
                            Your forum registration has been submitted successfully. You will receive a confirmation
                            email shortly.
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
                    <p v-if="submittedSnapshot.organization">
                        <span class="text-gray-500">Organization:</span>
                        <span class="ml-1">{{ submittedSnapshot.organization }}</span>
                    </p>
                    <p v-if="submittedSnapshot.attendee_type">
                        <span class="text-gray-500">Attendee type:</span>
                        <span class="ml-1 capitalize">{{ submittedSnapshot.attendee_type }}</span>
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
                        v-if="registrationId"
                        :href="route('forum.register.preview', registrationId)"
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
