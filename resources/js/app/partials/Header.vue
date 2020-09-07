<template>
<div class="bg-white">
    <div class="text-primary py-3 border-bottom">
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

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm main-nav">
        <div class="container">
            <a class="navbar-brand text-warning font-weight-bold mr-5" href="/">HOTELUX</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav links">
                    <li class="nav-item link-effect-9">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item link-effect-9">
                        <a class="nav-link" href="/rooms/search">Rooms</a>
                    </li>
                    <li class="nav-item link-effect-9">
                        <a class="nav-link" href="/about-us">About us</a>
                    </li>
                    <li class="nav-item link-effect-9">
                        <a class="nav-link" href="/contact-us">Contact us</a>
                    </li>

                </ul>

                <ul class="navbar-nav links ml-auto" v-if="!$store.state.userToken">
                    <li class="nav-item link-effect-9">
                        <a class="nav-link" href="#" @click="registerOrLogin(1)">Login</a>
                    </li>
                    <li class="nav-item link-effect-9">
                        <a class="nav-link" href="#" @click="registerOrLogin(0)">Signup</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto" v-if="$store.getters.isUserLoggedIn">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle rounded-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{`${$store.state.user.first_name} ${$store.state.user.last_name}`}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" :href="[$store.getters.isAdmin ? '/admin' : '/customer']">Dashboard</a>
                            <a class="dropdown-item" href="/customer/bookings" v-show="!$store.getters.isAdmin">Bookings</a>
                            <a class="dropdown-item" href="/customer/profile" v-show="!$store.getters.isAdmin">profile</a>
                            <a href="#" class="dropdown-item" @click.prevent="logout">
                                <i class="fas fa-arrow-left link-icons"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </ul>

                <!-- <ul class="navbar-nav ml-auto" v-if="$store.state.userToken">
                    <li class="nav-item">
                        <a class="nav-link" :href="[$store.state.user.role === 'admin' ? '/admin' : '/customer']">Dashboard</a>
                    </li>
                </ul> -->
            </div>

        </div>
    </nav>

    <!-- REGISTRATION MODAL -->
    <div class="modal" tabindex="-1" role="dialog" id="register">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title">Sign up</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                <label for="email">Email address</label>
                                <input v-model="newUser.email" type="email" class="form-control" name="email" id="email" placeholder="email" required />
                            </div>

                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="password">Password</label>
                                    <input v-model="newUser.password" type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="password">Confirm password</label>
                                    <input v-model="newUser.password_confirmation" type="password" class="form-control" name="password" id="password" placeholder="Confirm password" required>
                                </div>
                            </div>

                            <!-- <div class="form-group">
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

                            </div> -->

                            <div class="lds-ring d-block m-auto" v-if="isLoading"><div></div><div></div><div></div><div></div></div>
                            <button type="submit" :disabled="isLoading" class="btn btn-primary rounded-0">Sign up </button>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- LOGIN MODAL -->
    <div class="modal" tabindex="-1" role="dialog" id="login">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title d-flex">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <form @submit.prevent="loginUser">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input v-model="userToLogin.email" type="email" class="form-control" name="email" id="email" placeholder="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input v-model="userToLogin.password" type="password" class="form-control" name="password" id="password" placeholder="Confirm password">
                            </div>

                            <div class="alert alert-error" role="alert" v-show="userToLogin.error.length > 0">
                                <span>{{userToLogin.error}}</span>
                            </div>

                            <p>Forgot password? <a href="/reset_password">Click here</a></p>

                            <div class="lds-ring d-block m-auto" v-if="isLoading"><div></div><div></div><div></div><div></div></div>
                            <button type="submit" :disabled="isLoading" class="btn btn-primary d-flex rounded-0">Login</button>
                        </form>
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
                first_name: "",
                last_name: "",
                email: "",
                email_confirmation: "",
                password: "",
                password_confirmation: "",
                // phone: "",
                // country: "",
                // city: "",
                // postal_code: "",
                // address: "",
                // state: "",
                error: "",
            },
            userToLogin: {
                email: "",
                password: "",
                error: "",
            },
        }
    },
    computed: {
        isLoading(){
            return this.$store.state.isLoading
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
        registerUser() {

            this.$store.dispatch('registerUser', this.newUser)

        },
        loginUser() {

            this.$store.dispatch('loginUser', this.userToLogin)

        },
        logout(){
            this.$store.dispatch('logout')
        }
    }
}
</script>

<style scoped>
.navbar-toggler{
    outline: none!important;
    border:none!important;
}

.links {
  *zoom: 1;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  text-align: center;
}
.links:before, .links:after {
  content: "";
  display: table;
}
.links:after {
  clear: both;
}


.link-effect-9 a {
  color: #797878;
  padding: 10px 0;
  margin: 0 5px;
  position: relative;
  -moz-transition: ease-out 0.3s 0.1s;
  -o-transition: ease-out 0.3s 0.1s;
  -webkit-transition: ease-out 0.3s;
  -webkit-transition-delay: 0.1s;
  transition: ease-out 0.3s 0.1s;
}
.link-effect-9 a::after {
  height: 2px;
  width: 100%;
  background: #EAAE49;
  content: "";
  position: absolute;
  left: 0px;
  bottom: 0;
  -moz-transform: scaleX(0);
  -ms-transform: scaleX(0);
  -webkit-transform: scaleX(0);
  transform: scaleX(0);
  -moz-transition: 0.3s;
  -o-transition: 0.3s;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}
.link-effect-9 a:hover::after {
  -moz-transform: scaleX(1);
  -ms-transform: scaleX(1);
  -webkit-transform: scaleX(1);
  transform: scaleX(1);
}

.icons {
    font-size: 18px
}

</style>
