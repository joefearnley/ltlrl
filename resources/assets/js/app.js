
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueSweetAlert from 'vue-sweetalert';
import VueClipboards from 'vue-clipboards';

Vue.use(VueSweetAlert);
Vue.use(VueClipboards);

Vue.component('home-form', require('./components/HomeForm.vue'));
Vue.component('urls-list', require('./components/UrlsList.vue'));
Vue.component('make-url-little-button', require('./components/MakeUrlLittleButton.vue'));

const app = new Vue({
    el: '#app'
});
