<template>
<div>

    <Header></Header>

    <div class="container py-5">

        <div class="row">
            <div class="col-12 col-md-6 m-auto">
                <div class="card rounded-0 shadow-sm bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Register</h4>
                        <div>

                            <form @submit.prevent="registerUser">

                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="first_name">First name</label>
                                        <input v-model="newUser.first_name" type="text" minlength="3" class="form-control" name="first_name" id="first_name" placeholder="First name" required>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="last_name">Last name</label>
                                        <input v-model="newUser.last_name" type="text" minlength="3" class="form-control" name="last_name" id="last_name" placeholder="Last name" required>
                                    </div>

                                </div>

                                <div class="form-group ">
                                    <label for="email">Email</label>
                                    <input v-model="newUser.email" type="email" class="form-control" name="email" id="email" placeholder="email" required />
                                </div>

                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="password">Password</label>
                                        <input v-model="newUser.password" type="password" class="form-control" name="password" id="password" placeholder="Confirm password" required>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="password">Confirm password</label>
                                        <input v-model="newUser.password_confirmation" type="password" class="form-control" name="password" id="password" placeholder="Confirm password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input v-model="newUser.phone" type="tel" class="form-control" name="phone" id="phone" placeholder="phone number" required>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="country">Country</label>
                                        <input v-model="newUser.country" type="text" pattern="[a-zA-Z]+" class="form-control" name="country" id="country" placeholder="country" required>
                                    </div>

                                    <div class="form-group col-12 col-md-6">
                                        <label for="city">City</label>
                                        <input v-model="newUser.city" type="text" pattern="[a-zA-Z]+" class="form-control" name="city" id="city" placeholder="city" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input v-model="newUser.address" type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="postal_code">Postal code</label>
                                        <input v-model="newUser.postal_code" type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Postal code" required>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="state">State</label>
                                        <input v-model="newUser.state" type="text" class="form-control" name="state" id="state" placeholder="State" required>
                                    </div>

                                </div>

                                <button type="submit" :disabled="$store.state.isLoading" class="btn btn-primary rounded-0">Sign up</button>
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
    data() {
        return {
            newUser: {
                first_name: "",
                last_name: "",
                email: "",
                email_confirmation: "",
                password: "",
                password_confirmation: "",
                phone: "",
                country: "",
                city: "",
                postal_code: "",
                address: "",
                state: "",
            },
        }
    },
    methods: {
        registerUser(){
            this.$store.dispatch('registerUser', this.newUser)

        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
