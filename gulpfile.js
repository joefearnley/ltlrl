var elixir = require('laravel-elixir');

elixir(function(mix) {

    mix.styles([
        'bootstrap.min.css',
        'font-awesome.min.css',
        'ladda-themeless.min.css',
        'main.css'
    ], 'public/css/app.css');

    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'jquery.validate.min.js',
        'mustache.min.js',
        'spin.min.js',
        'ladda.min.js'
    ], 'public/js/app.js');

    mix.phpUnit();
});
