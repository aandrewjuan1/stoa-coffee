import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            keyframes: {
                pulse: {
                  '0%, 100%': { opacity: 1 },
                  '50%': { opacity: 0.5 },
                },
              },
              animation: {
                pulse: 'pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
              },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};