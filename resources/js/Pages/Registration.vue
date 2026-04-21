<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { ref } from 'vue';

const formData = ref({
    attendeeType: '',
    name: '',
    email: '',
    phone: '',
    city: '',
    country: '',
    nationality: '',
    organization: '',
    contactPerson: '',
    jobTitle: '',
    website: '',
    contactPhone: '',
    attendeeCount: '',
    services: [],
    attendanceDays: [],
    booth: '',
    sponsorshipPackage: '',
    agreeTerms: false
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

const handleSubmit = () => {
    console.log('Form submitted:', formData.value);
};
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero section with image carousel -->
            <section class="relative h-96 bg-cover bg-center flex flex-col items-center justify-center overflow-hidden">
                <div class="absolute inset-0 flex">
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('/img/wncdi/img1.jpeg');"></div>
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('/img/wncdi/moments.jpeg');"></div>
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-wncdi-dark/50 via-wncdi-primary/40 to-wncdi-primary/60"></div>
                <div class="relative z-10 text-center text-white px-4">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Registration</h1>
                </div>
            </section>

            <!-- Registration form section -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
                <div class="mx-auto max-w-4xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-8">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <a href="/" class="hover:text-wncdi-accent transition">Home</a>
                            <span class="text-gray-400">›</span>
                            <span class="text-gray-900 font-medium">Tanzania Global Logistics Forum 2025 Registration Form</span>
                        </div>
                    </nav>

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
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Attendee Type <span class="text-rose-600">*</span></label>
                                <select v-model="formData.attendeeType" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent">
                                    <option value="">Select attendee type</option>
                                    <option value="individual">Individual</option>
                                    <option value="company">Company Representative</option>
                                    <option value="exhibitor">Exhibitor</option>
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Name <span class="text-rose-600">*</span></label>
                                <input v-model="formData.name" type="text" placeholder="E.g. John Doe" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Email Address <span class="text-rose-600">*</span></label>
                                <input v-model="formData.email" type="email" placeholder="E.g. john@doe.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Phone -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Phone <span class="text-rose-600">*</span></label>
                                <div class="flex gap-2">
                                    <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent">
                                        <option>United Arab Emirates +971</option>
                                        <option>Tanzania +255</option>
                                        <option>Other</option>
                                    </select>
                                    <input v-model="formData.phone" type="tel" placeholder="50 123 4567" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                                </div>
                            </div>

                            <!-- City -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">City <span class="text-rose-600">*</span></label>
                                <input v-model="formData.city" type="text" placeholder="E.g. Sydney" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Country of Residence -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Country of Residence <span class="text-rose-600">*</span></label>
                                <input v-model="formData.country" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Nationality -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Nationality <span class="text-rose-600">*</span></label>
                                <input v-model="formData.nationality" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>
                        </div>

                        <!-- Professional Information Section -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-wncdi-accent">Professional Information</h3>
                            
                            <!-- Organization -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Organization/Company <span class="text-rose-600">*</span></label>
                                <input v-model="formData.organization" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Contact Person -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Name of the Contact person/company representative for this event <span class="text-rose-600">*</span></label>
                                <input v-model="formData.contactPerson" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Job Title -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Job Title <span class="text-rose-600">*</span></label>
                                <input v-model="formData.jobTitle" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Website -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Professional Website</label>
                                <input v-model="formData.website" type="url" placeholder="E.g. www.example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" />
                            </div>

                            <!-- Contact Phone -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Mobile number for the Contact person/representative for this event <span class="text-rose-600">*</span></label>
                                <input v-model="formData.contactPhone" type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Attendee Count -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">How many people from your company will be coming to the forum? <span class="text-rose-600">*</span></label>
                                <input v-model="formData.attendeeCount" type="number" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wncdi-accent focus:border-transparent" required />
                            </div>

                            <!-- Services -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Services Rendered <span class="text-rose-600">*</span></label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label v-for="service in services" :key="service" class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="formData.services" type="checkbox" :value="service" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">{{ service }}</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Attendance Days -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Are you intending to attend for both days or one of the two days? <span class="text-rose-600">*</span></label>
                                <p class="text-xs text-gray-600 mb-4">Tick both if you will attend two days or tick one if you will be attending one of the two days</p>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="formData.attendanceDays" type="checkbox" value="day1" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Day 1 (13th February 2026)</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="formData.attendanceDays" type="checkbox" value="day2" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Day 2 (14th February 2026)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Booth -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Would you prefer to have a booth to showcase your products/services? <span class="text-rose-600">*</span></label>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="formData.booth" type="radio" value="yes" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Yes</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="formData.booth" type="radio" value="no" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">No</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input v-model="formData.booth" type="radio" value="maybe" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent" />
                                        <span class="text-gray-700">Maybe</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Sponsorship Package -->
                            <div class="mb-6" v-if="formData.booth === 'yes'">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Choose a package for sponsorship <span class="text-rose-600">*</span></label>
                                <p class="text-sm text-gray-600 mb-4">We sincerely look forward to your participation and partnership in this significant event promoting Tanzania's trade and logistics advancement.</p>
                                <div class="grid gap-4">
                                    <label v-for="pkg in packages" :key="pkg.name" class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-wncdi-accent transition">
                                        <input v-model="formData.sponsorshipPackage" type="radio" :value="pkg.name" class="w-4 h-4 text-wncdi-accent focus:ring-2 focus:ring-wncdi-accent mt-1 flex-shrink-0" />
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
                                <input v-model="formData.agreeTerms" type="checkbox" class="w-4 h-4 text-wncdi-accent rounded focus:ring-2 focus:ring-wncdi-accent mt-1 flex-shrink-0" required />
                                <span class="text-sm text-gray-700">Agree to the conference's terms and conditions and the processing of your data. <span class="text-rose-600">*</span></span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-8">
                            <button type="submit" class="w-full bg-wncdi-accent text-white font-bold py-4 px-6 rounded-lg hover:bg-wncdi-dark transition-colors duration-300 text-lg uppercase tracking-wide">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <Footer />
    </div>
</template>
