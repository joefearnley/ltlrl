const { mix } = require('laravel-mix');

mix.scripts([
    'resources/assets/js/lib/sweetalert2.min.js'
], 'public/js/vendor.js');

mix.scripts([
    'resources/assets/js/components/HomeForm.js'
], 'public/js/app.js');

mix.styles([
    'resources/assets/css/bulma.min.css',
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/css/sweetalert2.min.css',
    'resources/assets/css/main.css'
], 'public/css/app.css');
