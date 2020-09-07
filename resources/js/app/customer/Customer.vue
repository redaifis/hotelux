<template>
<div v-if="$store.getters.isUserLoggedIn">
    <div v-if="!$store.state.user.email_verified_at" class="alert alert-warning m-0 text-center"><div class="container">Your email is not verified! <button class="btn btn-sm btn-secondary rounded-0 ml-4" @click="sendVerificationEmail">Resend Verification Email</button></div></div>
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

        },
        async sendVerificationEmail(){
            try {
                const result = await axios.get(`/api/auth/email/resend`)
                alert(result.data.message)
            } catch (error) {
                alert(error.response.statusText)
            }
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
