const { mix } = require('laravel-mix');


mix.scripts([
    // 'resources/assets/js/lib/jquery.min.js',
    // 'resources/assets/js/lib/bootstrap.min.js',
    'resources/assets/js/lib/sweetalert2.min.js',
    'resources/assets/js/lib/ladda.min.js',
    'resources/assets/js/lib/spin.min.js'
], 'public/js/lib.js');

mix.scripts([
    'resources/assets/js/app/home.js'
], 'public/js/app.js');

mix.styles([
    //'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/bulma.min.css',
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/css/ladda-themeless.min.css',
    'resources/assets/css/sweetalert2.min.css',
    'resources/assets/css/main.css'
], 'public/css/app.css');


//   .sass('resources/assets/sass/app.scss', 'public/css');
