<template>
<div>

    <Header></Header>

    <div class="container py-5 mt-5">

        <div class="row">
            <div class="col-12 col-md-6 m-auto">
                <div class="card rounded-0 shadow-sm bg-light">
                    <div class="card-body bg-white">
                        <h4 class="card-title mb-4">Forgot password?</h4>
                        <div>

                            <form class="form-container" @click.prevent="resetPassword">

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Enter email" v-model="user.email">

                                </div>

                                <div class="form-group row">
                                    <div class="col-12 col-md-6">

                                    <input type="password" name="password" class="form-control"  placeholder="Enter new password">
                                    </div>
                                    <div class="col-12 col-md-6">

                                    <input type="password" name="password_confirmation" class="form-control"  placeholder="Confirm new password">
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-warning text-white rounded-0">Change password</button>
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
    props: ['token'],
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            user: {
                email: "",
                password: "",
                password_confirmation: "",
                errors: {
                    email: "",
                    password: "",
                }
            }
        }
    },
    methods: {
        async resetPassword(){

            if(password !== password_confirmation) this.user.errors.password = "Passwords don't match"

            if(this.user.errors.password.length === 0 && this.user.errors.password.length === 0)
                try {
                    const result = await axios.post(`/api/password/reset`, this.user)
                    alert(result.data)
                } catch (error) {
                    alert(error.response.statusText)

                }

            this.user.errors.password = ""
            this.user.errors.email = ""
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
