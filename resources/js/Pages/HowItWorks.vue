<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <Header />
        <main>
            <!-- Hero -->
            <section class="relative bg-gradient-to-r from-emerald-700 via-emerald-600 to-sky-500 text-white py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('/images/DXB_3576-1536x1024.jpg')] bg-cover bg-center"></div>
                <div class="relative mx-auto max-w-5xl text-center">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight mb-4">How WNCDi Works</h1>
                    <p class="text-lg sm:text-xl text-emerald-50 max-w-3xl mx-auto">
                        From awareness to action &mdash; see how WNCDi empowers communities through health education and wellness initiatives.
                    </p>
                </div>
            </section>

            <!-- Steps -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
                <div class="mx-auto max-w-5xl">
                    <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Three Simple Steps</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-wncdi-accent">
                            <div class="text-sm font-semibold text-wncdi-accent mb-2">Step 1</div>
                            <h3 class="text-xl font-bold mb-3">Register Your Interest</h3>
                            <p class="text-gray-600 text-sm">
                                Choose the right category for you: Forum delegates, exhibitors, or diaspora participants. Fill in your contact and professional details so our team can support you.
                            </p>
                        </div>
                        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-sky-500">
                            <div class="text-sm font-semibold text-sky-500 mb-2">Step 2</div>
                            <h3 class="text-xl font-bold mb-3">Confirm &amp; Prepare</h3>
                            <p class="text-gray-600 text-sm">
                                Complete payment for your chosen package and receive confirmation, agenda highlights, and useful logistics information for Dubai.
                            </p>
                        </div>
                        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-rose-500">
                            <div class="text-sm font-semibold text-rose-500 mb-2">Step 3</div>
                            <h3 class="text-xl font-bold mb-3">Connect &amp; Grow</h3>
                            <p class="text-gray-600 text-sm">
                                Attend the forum, network with key players in trade and logistics, and build partnerships that drive Tanzania's growth.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to action -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white border-t border-gray-200">
                <div class="mx-auto max-w-4xl text-center">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Ready to get started?</h2>
                    <p class="text-gray-600 mb-8">
                        Choose the path that matches you best and complete your registration in just a few minutes.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a
                            href="/forumregster"
                            class="inline-flex justify-center items-center px-8 py-3 rounded-lg bg-wncdi-accent text-white font-semibold hover:bg-wncdi-dark transition"
                        >
                            Register for Forum
                        </a>
                        <a
                            href="/uaeresidents"
                            class="inline-flex justify-center items-center px-8 py-3 rounded-lg border border-wncdi-accent text-wncdi-dark font-semibold hover:bg-wncdi-light transition"
                        >
                            Diaspora in UAE / Middle East
                        </a>
                    </div>
                </div>
            </section>
        </main>
        <Footer />
    </div>
</template>
