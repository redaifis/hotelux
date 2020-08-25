<template>
<div v-if="$store.getters.isUserLoggedIn">
    <Header></Header>
    <div>
        <router-view></router-view>
    </div>
    <Footer></Footer>
</div>
</template>

<script>
import Header from '../partials/Header'
import Footer from '../partials/Footer'

export default {
    components: {
        Header,
        Footer
    },
    data() {
        return {

        }
    },
    methods: {
        checkUser() {

        }
    },
    mounted() {

        // Default axios headers
        const token = localStorage.getItem('user-token')
        axios.defaults.headers.common['Authorization'] =  `Bearer ${token}`// for all requests

        // check if user is logged in
        this.$store.dispatch('isUserLoggedIn')
        if (!this.$store.getters.isUserLoggedIn) window.location = '/login'
    }
}
</script>

<style>

</style>
