<template>
<div>
    <div class="bg-light text-primary py-3 border-bottom">
        <div class="container">
            <div class="d-flex">
                <div class="mr-4 d-flex align-items-center">
                    <i class="fas fa-phone icons"></i> <span class="ml-2">06 52 23 82 56</span>
                </div>
                <div class=" d-flex align-items-center">
                    <i class="fas fa-envelope icons"></i> <span class="ml-2">contact@hotelux.com</span>
                </div>

            </div>
        </div>

    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm main-nav">
        <div class="container">
            <a class="navbar-brand text-warning font-weight-bold" href="#">HOTELUX</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>

                </ul>

                <ul class="navbar-nav ml-auto" v-if="!$store.state.currentUser">
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click="registerOrLogin(1)">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click="registerOrLogin(0)">Signup</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto" v-if="$store.state.currentUser">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Dashboard</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- TODO: This is for server side, there is another version for browser defaults -->
    <div class="modal" tabindex="-1" role="dialog" id="register">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign up</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>

                            <div class="form-group">
                                <label for="full_name">Full name</label>
                                <input v-model="newUser.name" type="text" class="form-control" name="full_name" id="full_name" placeholder="full name">
                                <small class="text-danger" id="name-error" v-show="newUser.errors.name">{{newUser.errors.name}}</small>
                            </div>

                            <div class="form-group">
                                <label for="email">email</label>
                                <input v-model="newUser.email" type="email" class="form-control" name="email" id="email" placeholder="email">
                                <small class="text-danger" id="email-error" v-show="newUser.errors.email">{{newUser.errors.email}}</small>
                            </div>

                            <div class="form-group">
                                <label for="email_confirmation">Confirm email</label>
                                <input v-model="newUser.email_confirmation" type="email" class="form-control" name="email_confirmation" id="email_confirmation" placeholder="email_confirmation">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input v-model="newUser.password" type="password" minlength="8" class="form-control" name="password" id="password" placeholder="password">
                                <small class="text-danger" id="password-error" v-show="newUser.errors.password">{{newUser.errors.password}}</small>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input v-model="newUser.password_confirmation" type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
                            </div>

                            <div class="mb-2" v-show="newUser.errors.other">
                                <small class="text-danger" id="other-error" v-for="(error,index) in newUser.errors.other" :key="index">{{error[0]}}</small>
                            </div>

                            <button type="submit" :disabled="loading" class="btn btn-primary" @click.prevent="registerNewUser">Sign up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="login">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                            <div class="form-group">
                                <label for="email">email</label>
                                <input v-model="existingUser.email" type="email" class="form-control" name="email" id="email" placeholder="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input v-model="existingUser.password" type="password" class="form-control" name="password" id="password" placeholder="Confirm password">
                            </div>

                            <small class="text-danger d-block mb-3" id="other-error" v-show="existingUser.error">{{existingUser.error}}</small>
                            <small class="text-success d-block mb-3" id="other-error" v-if="existingUser.success">You are logged in! Loading...</small>

                            <button type="submit" :disabled="loading" class="btn btn-primary" @click.prevent="loginUser">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            newUser: {
                name: "",
                email: "",
                email_confirmation: "",
                password: "",
                password_confirmation: "",
                errors: {
                    email: null,
                    password: null,
                    other: null
                },

            },
            existingUser: {
                email: "",
                password: "",
                error: null,
                success: false
            },
            loading: false
        }
    },
    methods: {
        registerOrLogin(login) {
            if (login) {
                $('#register').modal('hide')
                $('#login').modal('show')
            } else {
                $('#login').modal('hide')
                $('#register').modal('show')
            }
        },
        async registerNewUser() {

            this.newUser.errors = {}

            if(/[^a-zA-Z\s]/.test(this.newUser.name) || this.newUser.name.length < 3){
                this.newUser.errors.name = "Please verify your name!"
                return false
            }

            if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.newUser.email) && this.newUser.email === this.newUser.email_confirmation)) {
                this.newUser.errors.email = "Please verify your email address!"
                return false
            }

            if(this.newUser.password !== this.newUser.password_confirmation || this.newUser.password.length < 8) {
                this.newUser.errors.password = "Please verify your password!"
                return false
            }

            this.loading = true

            try{
                let registerResult = await axios.post(`/api/auth/register`, this.newUser)

            }catch(error){
                console.log(error)
                this.newUser.errors.other = error.response.data.errors
            }

            this.loading = false

            this.registerOrLogin(1)

        },
        async loginUser(){

            this.existingUser.error = null

            this.loading = true

            try {
                let loginResult = await axios.post(`/api/auth/login`, {
                    email: this.existingUser.email,
                    password: this.existingUser.password
                })
                console.log(loginResult)
                localStorage.setItem('user-token', loginResult.data.access_token);
                this.existingUser.success = true
                window.location.replace('/admin');
            } catch (error) {
                console.log(error)
                this.existingUser.error = "Invalid credentials! Please verify your email and password!"

            }

            this.loading = false


        }
    }
}
</script>

<style scoped>
.icons {
    font-size: 18px
}
</style>
