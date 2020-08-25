/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 **/



require('./bootstrap');

window.Vue = require('vue');

// Vue Router - Admin Routes
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    { path: '/admin', component: require('./admin/views/Dashboard.vue').default },
    { path: '/admin/bookings', component: require('./admin/views/Bookings.vue').default },
    { path: '/admin/rooms', component: require('./admin/views/Rooms.vue').default },
    { path: '/admin/reviews', component: require('./admin/views/Reviews.vue').default },
    { path: '/admin/customers', component: require('./admin/views/Customers.vue').default },
    { path: '/admin/settings', component: require('./admin/views/Settings.vue').default },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

// Text editor CKEditor
import CKEditor from 'ckeditor4-vue';

Vue.use(CKEditor);

// VUEX
import store from './store/store'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('admin', require('./admin/Admin.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



const admin = new Vue({
    router,
    store
}).$mount('#admin')
