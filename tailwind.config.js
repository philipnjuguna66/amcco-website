const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                poppins: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    950 :  "#58b047",
                    900 :  "#58b047",
                    800 :  "#58b047",
                    700 :  "#58b047",
                    600 :  "#58b047",
                    500 :  "#58b047",
                    400 :  "#58b047",
                },
                secondary: {
                    900 :  "#292974",
                    800 :  "#292974",
                    700 :  "#292974",
                    600 :  "#292974",
                    500 :  "#292974",
                    400 :  "#292974",
                },
                danger: colors.rose,
                warning: colors.yellow
            }
        },
    },

    plugins: [
        require('flowbite/plugin') ,
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
};
