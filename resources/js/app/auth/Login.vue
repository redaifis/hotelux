<template>
<div>

    <Header></Header>

    <div class="container py-5 mt-5">

        <div class="row">
            <div class="col-12 col-md-6 m-auto">
                <div class="card rounded-0 shadow-sm bg-light">
                  <div class="card-body">
                    <h4 class="card-title">Login</h4>
                    <div>
                        <form @submit.prevent="loginUser">
                            <div class="form-group">
                                <label for="email">email</label>
                                <input v-model="userToLogin.email" type="email" class="form-control" name="email" id="email" placeholder="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input v-model="userToLogin.password" type="password" class="form-control" name="password" id="password" placeholder="Confirm password">
                            </div>

                            <button type="submit" :disabled="$store.state.isLoading" class="btn btn-primary rounded-0" >Login</button>
                        </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>

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
        Footer,
    },
    data(){
        return{

            userToLogin: {
                email: "",
                password: ""
            },

        }
    },
    methods: {
        loginUser(){
            this.$store.dispatch('loginUser', this.userToLogin)
        }
    },
    mounted() {
        console.log(this.$store.state.user.role)
    }
}
</script>

<style scoped>

</style>
