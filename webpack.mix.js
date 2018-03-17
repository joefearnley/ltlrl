const { mix } = require('laravel-mix');

mix.js([
  'resources/assets/js/lib/bulma.js',  
  'resources/assets/js/app.js'
], 'public/js/app.js');

mix.combine([
  'resources/assets/css/bulma.min.css',
  'resources/assets/css/bulma-tooltip.min.css',
  'resources/assets/css/fontawesome-all.min.css',
  'resources/assets/css/sweetalert2.min.css',
  'resources/assets/css/main.css'
], 'public/css/app.css');
