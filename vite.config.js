import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    build: {
        rollupOptions: {
            // Treat root-level image URLs (served from public/) as external static assets
            // so Rollup does not try to resolve them as JS imports.
            external: [/^\/.*\.(png|jpe?g|gif|webp|svg)$/i],
        },
    },
});
