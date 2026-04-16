<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white flex flex-col">
        <Head title="Temporarily unavailable" />

        <main class="flex-1 flex items-center justify-center px-4 py-10">
            <div class="max-w-lg w-full text-center space-y-6">
                <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-rose-500/10 border border-rose-500/40 mb-2">
                    <span class="material-icons text-rose-400">build</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold">System is temporarily turned off</h1>
                <p class="text-sm text-slate-300">
                    Our online system is currently disabled by the administrator for maintenance or updates.
                    You can still reach us directly on WhatsApp for any urgent assistance.
                </p>

                <div class="space-y-3">
                    <a
                        href="https://wa.me/255613976254"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-wncdi-accent px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-wncdi-accent/30 hover:bg-wncdi-accent"
                    >
                        <span class="material-icons text-[18px]">whatsapp</span>
                        <span>Contact us on WhatsApp +255 613 976 254</span>
                    </a>
                    <p class="text-[11px] text-slate-400">
                        We appreciate your patience. Please check back again later.
                    </p>
                </div>

                <div class="pt-4 text-[11px] text-slate-500">
                    <p>
                        If you are the superadmin, you can sign in using your special credentials on the
                        <Link :href="route('login')" class="text-wncdi-gold hover:text-emerald-300 font-semibold">
                            login page
                        </Link>
                        and re-enable the system.
                    </p>
                </div>
            </div>
        </main>
    </div>
</template>
