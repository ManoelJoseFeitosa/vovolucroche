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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Cores baseadas na identidade visual da Vovó Lu Crochê
                'vovolu': {
                    'rosa': '#F4978E',   // Tom salmão/rosa da logo
                    'azul': '#55B4B0',   // Tom turquesa/teal da logo
                    'cinza': '#4A4A4A',  // Para textos
                    'fundo': '#F9F9F9',  // Off-white para fundo
                }
            }
        },
    },

    plugins: [forms],
};
