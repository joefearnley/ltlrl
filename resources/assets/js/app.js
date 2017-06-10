require('./bootstrap');

// window.HomeForm = require('./components/HomeForm.js');
// const homeForm = new HomeForm();

window.Vue = require('vue');
Vue.component('home', require('./components/HomeForm.vue'));
const app = new Vue({ el: '#app' });


