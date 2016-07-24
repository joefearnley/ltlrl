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
        'jquery.min.js',
        'bootstrap.min.js',
        'mustache.min.js',
        'spin.min.js',
        'ladda.min.js',
        'clipboard.min.js',
        'notify.js',
        'chart.min.js',
        'validator.min.js',
        'sweetalert2.min.js',
        'main.js'
    ], 'public/js/app.js');

    //mix.phpUnit();
});
