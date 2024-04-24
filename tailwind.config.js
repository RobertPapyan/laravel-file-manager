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
            colors:{
                'custom-blue-light':'#E1E5EA',
                'custom-blue-main' :'#5C6CFF',
                'custom-blue-dark' : '#5663E0',
                'custom-gray-bg' :'#EDF0F2',
                'custom-gray-icons':'#404B5A',
                'custom-gray-icons-light':'#999FA6',
                'custom-gray-borders' : '#C3CED7',
                'custom-gray-text' : '#606E80',
                'custom-black-text' : '#181D25',
                'custom-red-main' :'#F32051'
            }
        },
    },

    plugins: [forms],
};
