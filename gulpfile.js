var elixir = require('laravel-elixir');

elixir(function(mix) {

    mix.styles([
        'bootstrap.min.css',
        'font-awesome.min.css',
        'ladda-themeless.min.css',
        'sweetalert2.min.css',
        'main.css'
    ], 'public/css/app.css');

    mix.scripts([
        'lib/jquery.min.js',
        'lib/bootstrap.min.js',
        'lib/angular.min.js',
        'lib/angular-clipboard.js',
        'lib/mustache.min.js',
        'lib/spin.min.js',
        'lib/ladda.min.js',
        'lib/angular-ladda.min.js',
        'lib/clipboard.min.js',
        'lib/chart.min.js',
        'lib/validator.min.js',
        'lib/sweetalert2.min.js'
    ], 'public/js/lib.js');

    mix.scripts([
        'main.js'
    ], 'public/js/app.js');

    mix.phpUnit();
});
