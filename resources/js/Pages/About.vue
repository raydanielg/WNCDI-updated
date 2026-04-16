<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';

const heroImage =
    typeof window !== 'undefined'
        ? `${window.location.origin}/img/wncdi/about-hero.jpeg`
        : '/img/wncdi/about-hero.jpeg';
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero section with breadcrumb overlay -->
            <section
                class="relative h-80 bg-cover bg-center flex flex-col items-center justify-center"
                :style="{ backgroundImage: `url(${heroImage})` }"
            >
                <div class="absolute inset-0 bg-gradient-to-b from-wncdi-dark/20 via-wncdi-primary/15 to-wncdi-primary/25 backdrop-blur-sm"></div>
                <div class="relative z-10 text-center text-white px-4 mb-8">
                    <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight">About Us</h1>
                </div>
                
                <!-- Breadcrumb inside hero -->
                <nav class="relative z-10 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg">
                    <div class="flex items-center gap-2 text-sm text-white">
                        <a href="/" class="hover:text-wncdi-light transition">Home</a>
                        <span class="text-white/60">›</span>
                        <span class="text-white/90 font-medium">About Us</span>
                    </div>
                </nav>
            </section>

            <!-- Main content section -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="mx-auto max-w-6xl">
                    <!-- Organization Overview -->
                    <div class="mb-20">
                        <h2 class="text-4xl sm:text-5xl font-extrabold mb-8 text-slate-900 leading-tight">
                            About WNCDi
                        </h2>
                        <div class="space-y-6 text-gray-700 leading-relaxed text-lg">
                            <p>
                                <strong>Without Non Communicable Diseases Initiative (WNCDi)</strong> is a youth-led Non-Governmental, non-profit, non-political, non-religious organization registered in December 2024 by Tanzania Ministry of Community Development, Gender, Elderly and Children (MCDGEC) with registration number <strong>00NGO/R/7809</strong> under NGO Act No. 24 of 2002.
                            </p>
                            <p>
                                WNCDi has the main objective of rising awareness to the community on various Non Communicable Diseases and emphasis on good approaches to get rid of Non Communicable Diseases (NCDs) burden which is currently accountable for more than 70% of life loss globally. Over 70% of all deaths globally are due to Non-Communicable Diseases (NCDs) where 41 - 44% of deaths in Tanzania are attributed to NCDs according to WHO estimates.
                            </p>
                            <div class="bg-wncdi-light border-l-4 border-wncdi-accent p-6">
                                <p class="text-wncdi-dark">
                                    This burden geared the introduction of WNCDi as a new platform in fighting against Non-Communicable Diseases with the motto: <strong>"Becoming Healthier Together"</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Vision and Mission -->
                    <div class="grid md:grid-cols-2 gap-12 mb-20">
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl p-8 border border-wncdi-light">
                            <h3 class="text-2xl font-bold text-wncdi-dark mb-4 flex items-center gap-3">
                                <span class="material-icons text-3xl">visibility</span>
                                Our Vision
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                To create the society that is free from preventable Non-Communicable diseases burden, aware of health determinants to Non-communicable Diseases with Younger Generation actively involved.
                            </p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 border border-blue-200">
                            <h3 class="text-2xl font-bold text-blue-700 mb-4 flex items-center gap-3">
                                <span class="material-icons text-3xl">public</span>
                                Our Mission
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                Provision of incessant advocacy, campaigns and education on Non communicable diseases with their risk factors proportionally to the need of early diagnosis and effective NCDs control.
                            </p>
                        </div>
                    </div>

                    <!-- Organization Aim -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 md:p-12 mb-20">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Organization Aim</h3>
                        <p className="text-gray-700 leading-relaxed mb-6">
                            The main aim of WNCDi is to aid the reduction of Non-Communicable Diseases burden in Tanzanian local and regional areas through actual ground activities in all levels:
                        </p>
                        <div class="grid sm:grid-cols-3 gap-6">
                            <div class="flex items-center gap-3 p-4 bg-wncdi-light rounded-lg">
                                <span class="material-icons text-wncdi-accent">school</span>
                                <span class="font-semibold text-gray-900">Lower Schools</span>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                                <span class="material-icons text-blue-600">domain</span>
                                <span class="font-semibold text-gray-900">Universities</span>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-wncdi-secondary rounded-lg">
                                <span class="material-icons text-wncdi-accent">groups</span>
                                <span class="font-semibold text-gray-900">General Community</span>
                            </div>
                        </div>
                        <p class="text-gray-700 leading-relaxed mt-6">
                            This initiative aligns with the World Health Organization (WHO) Sustainable Development Goal (SDG) 3.4 by the year 2030 - reducing by one-third premature mortality from Non-Communicable diseases.
                        </p>
                    </div>

                    <!-- Key Strengths -->
                    <div class="mb-20">
                        <h2 class="text-3xl font-bold mb-12 text-gray-900">Key Strengths of WNCDi</h2>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-wncdi-light rounded-xl p-6 border border-wncdi-light">
                                <h4 class="font-bold text-wncdi-dark mb-3 flex items-center gap-2">
                                    <span class="material-icons">youth_identity</span>
                                    Youth-Led Organization
                                </h4>
                                <p class="text-sm text-gray-700">
                                    The entire team is made up of energetic youths with high volunteerism attitude and leadership capabilities.
                                </p>
                            </div>

                            <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                <h4 class="font-bold text-blue-700 mb-3 flex items-center gap-2">
                                    <span class="material-icons">school</span>
                                    Health Education Background
                                </h4>
                                <p class="text-sm text-gray-700">
                                    Team members have NCDs and health education background from medical schools.
                                </p>
                            </div>

                            <div class="bg-wncdi-secondary rounded-xl p-6 border border-blue-200">
                                <h4 class="font-bold text-wncdi-primary mb-3 flex items-center gap-2">
                                    <span class="material-icons">mic</span>
                                    Public Addressing Skills
                                </h4>
                                <p class="text-sm text-gray-700">
                                    WNCDi members have high skills of public addressing for clear community delivery.
                                </p>
                            </div>

                            <div class="bg-wncdi-secondary rounded-xl p-6 border border-amber-200">
                                <h4 class="font-bold text-wncdi-gold mb-3 flex items-center gap-2">
                                    <span class="material-icons">people</span>
                                    Team Leadership
                                </h4>
                                <p class="text-sm text-gray-700">
                                    Team has high leadership capabilities from different health courses.
                                </p>
                            </div>

                            <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                                <h4 class="font-bold text-yellow-700 mb-3 flex items-center gap-2">
                                    <span class="material-icons">school</span>
                                    Experienced Advisors
                                </h4>
                                <p class="text-sm text-gray-700">
                                    Operates under mentors who are Professors and Health Specialists from major health institutions.
                                </p>
                            </div>

                            <div class="bg-cyan-50 rounded-xl p-6 border border-cyan-200">
                                <h4 class="font-bold text-cyan-700 mb-3 flex items-center gap-2">
                                    <span class="material-icons">trending_up</span>
                                    Continuous Training
                                </h4>
                                <p class="text-sm text-gray-700">
                                    Team knowledge capacity is continuously built through regular trainings.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Funding Mechanism -->
                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-2xl p-8 md:p-12 border border-wncdi-light">
                        <h3 class="text-2xl font-bold text-wncdi-dark mb-6">How We Are Funded</h3>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            WNCDi relies on support from donors, sponsors, and organizations that believe in our mission to fight against NCDs. Our funding comes from:
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start gap-3">
                                <span class="text-wncdi-accent font-bold">•</span>
                                <span class="text-gray-700">Contributions from supporting stakeholders</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-wncdi-accent font-bold">•</span>
                                <span class="text-gray-700">Direct support from team members</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-wncdi-accent font-bold">•</span>
                                <span class="text-wncdi-accent font-bold">•</span>
                                <span class="text-gray-700">Donations from individuals and organizations</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-wncdi-accent font-bold">•</span>
                                <span class="text-gray-700">Sponsors and public/private organizations</span>
                            </li>
                        </ul>
                        <div class="bg-white rounded-lg p-4 border border-wncdi-light">
                            <p class="text-sm text-wncdi-primary">
                                <strong>Interested in supporting WNCDi?</strong> You can donate via our official bank account. Visit our <a href="/donate" class="text-wncdi-accent font-semibold hover:underline">Donate page</a> to learn how to contribute.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

        <Footer />
        </main>
    </div>
</template>
