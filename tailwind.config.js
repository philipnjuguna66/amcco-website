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
                    950 :  "#145359",
                    900 :  "#145359",
                    800 :  "#145359",
                    700 :  "#145359",
                    600 :  "#145359",
                    500 :  "#145359",
                    400 :  "#145359",
                },
                secondary: {
                    900 :  "#fe0000",
                    800 :  "#fe0000",
                    700 :  "#fe0000",
                    600 :  "#fe0000",
                    500 :  "#fe0000",
                    400 :  "#fe0000",
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
