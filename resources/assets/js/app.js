require('./bootstrap');

window.Vue = require('vue');
Vue.component('home-form', require('./components/HomeForm.vue'));

const app = new Vue({ el: '#app' });