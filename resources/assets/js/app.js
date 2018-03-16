
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueSweetalert2 from 'vue-sweetalert2';
import VueClipboards from 'vue-clipboards';

Vue.use(VueSweetalert2);
Vue.use(VueClipboards);

Vue.component('home-form', require('./components/HomeForm.vue'));
Vue.component('urls-list', require('./components/UrlsList.vue'));
Vue.component('make-url-little-button', require('./components/MakeUrlLittleButton.vue'));
Vue.component('update-personal-information-form', require('./components/UpdatePersonalInformationForm.vue'));
Vue.component('update-password-form', require('./components/UpdatePasswordForm.vue'));

const app = new Vue({
    el: '#app'
});
