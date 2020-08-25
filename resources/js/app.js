/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// VUEX
import store from './store/store'

// Fontawesome free
import '@fortawesome/fontawesome-free'

// Use v-calendar & v-date-picker components
import VCalendar from 'v-calendar'
Vue.use(VCalendar)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const appViews = require.context('./app/views', true, /\.vue$/i)
appViews.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], appViews(key).default))

const authViews = require.context('./app/auth', true, /\.vue$/i)
authViews.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], authViews(key).default))

const customerViews = require.context('./app/customer', true, /\.vue$/i)
customerViews.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], customerViews(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue Router - Admin Routes
import VueRouter from 'vue-router'
import Axios from 'axios';

Vue.use(VueRouter)

const routes = [
  { path: '/customer', component: require('./app/customer/views/Dashboard.vue').default },
  { path: '/customer/bookings', component: require('./app/customer/views/BookingsList.vue').default },
  { path: '/customer/bookings/:id', component: require('./app/customer/views/Booking.vue').default },
  { path: '/customer/Profile', component: require('./app/customer/views/Profile.vue').default },
]

const router = new VueRouter({
    mode: 'history',
  routes
})

// Default axios headers
const token = localStorage.getItem('user-token') || null
axios.defaults.headers.common['Authorization'] =  `Bearer ${token}`// for all requests

const app = new Vue({
    el: '#app',
    router,
    store,
});
