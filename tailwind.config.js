import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'justify-end',
        'max-w-xl',
        'md:max-w-2xl',
        'transition',
        'ease-in-out',
        'duration-1000',
        'bg-neutral-100',
        'border-neutral-700',
        {
            pattern: /max-w-(sm|md|lg|xl|2xl)/,
            variants: ['sm', 'md']
        }
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
