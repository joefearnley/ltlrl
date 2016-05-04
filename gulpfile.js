var elixir = require('laravel-elixir');

elixir(function(mix) {

    mix.styles([
        'bootstrap.min.css',
        'font-awesome.min.css',
        'main.css'
    ], 'public/css/app.css');

    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js'
    ], 'public/js/app.js');

    mix.phpUnit();
});
