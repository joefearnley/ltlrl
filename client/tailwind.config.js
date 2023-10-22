const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: ['./src/**/*.js'],
    darkMode: 'false',
    theme: {
        colors: {
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            emerald: colors.emerald,
            indigo: colors.indigo,
            yellow: colors.yellow,
            red: colors.red,
            transparent: colors.transparent,
            'dark_slate_gray': {
                DEFAULT: '#283d3b',
                100: '#080c0c',
                200: '#101918',
                300: '#182524',
                400: '#203130',
                500: '#283d3b',
                600: '#496f6b',
                700: '#6b9e99',
                800: '#9cbfbb',
                900: '#cedfdd'
            },
            'caribbean_current': {
                DEFAULT: '#197278',
                100: '#051618',
                200: '#0a2d2f',
                300: '#0f4347',
                400: '#135a5f',
                500: '#197278',
                600: '#25aab3',
                700: '#48d0da',
                800: '#85e0e6',
                900: '#c2eff3'

            },
            'champagne_pink': {
                DEFAULT: '#edddd4',
                100: '#3f281a',
                200: '#7f5035',
                300: '#b87955',
                400: '#d2ab95',
                500: '#edddd4',
                600: '#f1e4dc',
                700: '#f4ebe5',
                800: '#f8f1ee',
                900: '#fbf8f6'
            },
            'persian_red': {
                DEFAULT: '#c44536',
                100: '#270e0b',
                200: '#4e1b15',
                300: '#762920',
                400: '#9d362b',
                500: '#c44536',
                600: '#d2685c',
                700: '#dd8d84',
                800: '#e9b3ad',
                900: '#f4d9d6'
            },
            'burnt_umber': {
                DEFAULT: '#772e25',
                100: '#180907',
                200: '#30130f',
                300: '#491c16',
                400: '#61261e',
                500: '#772e25',
                600: '#af4436',
                700: '#cd6b5d',
                800: '#de9c93',
                900: '#eecec9'
            },
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
