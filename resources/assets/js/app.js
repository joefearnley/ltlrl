require('./bootstrap');

import VueSweetAlert from 'vue-sweetalert';

window.Vue = require('vue');

Vue.use(VueSweetAlert);
Vue.component('home-form', require('./components/HomeForm.vue'));

const app = new Vue({ el: '#app' });