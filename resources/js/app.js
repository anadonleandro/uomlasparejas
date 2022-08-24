//import './bootstrap';
require('./bootstrap');

import Vue from 'vue'

import vSelect from 'vue-select'

import VueSwal from 'vue-swal'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vue-select/dist/vue-select.css';

import moment from 'moment'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(VueSwal)
Vue.component('v-select',vSelect)
Vue.prototype.moment = moment


Vue.component('mov-multiple-component', require('./components/movimiento_multiple.vue').default);



const app = new Vue({
    el: '#app',
});