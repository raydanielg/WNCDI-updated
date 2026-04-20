import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Custom vibrant palette for WNCDi
                'wncdi-primary': '#640048',      // Deep purple - primary actions & brand color
                'wncdi-accent': '#f89107',       // Orange - hover effects & highlights
                'wncdi-gold': '#f89107',         // Orange - badges & special highlights
                'wncdi-dark': '#3d0028',         // Dark purple - contrast & text
                'wncdi-light': '#fff5f0',        // Light cream - backgrounds
                'wncdi-secondary': '#f89107',    // Orange for secondary actions
            },
        },
    },

    plugins: [forms],
};
