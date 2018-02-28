const { mix } = require('laravel-mix');

mix.scripts([
  'resources/assets/js/lib/sweetalert2.min.js'
], 'public/js/vendor.js');

mix.js([
  'resources/assets/js/app.js'
], 'public/js/app.js');

mix.combine([
  'resources/assets/sass/bulma.min.css',
  'resources/assets/sass/bulma-tooltip.min.css',
  'resources/assets/sass/fontawesome-all.min.css',
  'resources/assets/sass/sweetalert2.min.css',
  'resources/assets/sass/main.css'
], 'public/css/app.css');
