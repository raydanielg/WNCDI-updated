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
                'wncdi-primary': '#0204f9',      // Deep blue - primary actions & brand color
                'wncdi-accent': '#ff06bc',       // Magenta/Pink - hover effects & highlights
                'wncdi-gold': '#fdd011',         // Bright yellow - badges & special highlights
                'wncdi-dark': '#010057',         // Very dark blue - contrast & text
                'wncdi-light': '#f5f3ff',        // Very light lavender - backgrounds
                'wncdi-secondary': '#fdd011',    // Yellow for secondary actions
            },
        },
    },

    plugins: [forms],
};
