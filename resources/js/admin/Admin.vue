<template>
<div v-if="$store.getters.isAdmin">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary shadow">
        <a class="navbar-brand" href="/">Hotelux</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" @click="toggleSidebar" href="#"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <router-link to="/admin/profile" class="dropdown-item">
                        Profile
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" @click.prevent="logout()">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav my-3">

                        <router-link to="/admin" class="nav-link">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt link-icons"></i></div>
                            Dashboard
                        </router-link>

                        <router-link to="/admin/bookings" class="nav-link">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard link-icons"></i></div>
                            Bookings
                        </router-link>

                        <router-link to="/admin/rooms" class="nav-link">
                            <div class="sb-nav-link-icon"><i class="fas fa-home link-icons"></i></div>
                            Rooms
                        </router-link>

                        <router-link to="/admin/reviews" class="nav-link">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-alt link-icons"></i></div>
                            Reviews
                        </router-link>

                        <router-link to="/admin/customers" class="nav-link">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-alt link-icons"></i></div>
                            Customers
                        </router-link>

                        <router-link to="/admin/settings" class="nav-link">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs link-icons"></i></div>
                            Settings
                        </router-link>

                        <a href="#" class="nav-link" @click.prevent="logout">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-left link-icons"></i></div>
                            Logout
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer bg-primary ">
                    <div class="small">Logged in as:</div>
                    {{$store.state.user.first_name + ' ' + $store.state.user.last_name}}
                </div>
            </nav>
        </div>

        <!-- Main content goes HERE -->

        <div id="layoutSidenav_content">

            <main>

                <router-view></router-view>

            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>


    <loading
    :active.sync="$store.state.isLoading"
    :is-full-page="true"
    :color="'#EAAE49'"
    :loader="'bars'" />

</div>
</template>

<script>
// Import VueLoading component
import Loading from 'vue-loading-overlay';
// Import VueLoading stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{
        Loading,
    },
    methods: {
        toggleSidebar() {
            $("body").toggleClass("sb-sidenav-toggled");
        },
        getUserProfile(){

            this.$store.dispatch('getUserProfile')

        },
        logout(){
            this.$store.dispatch('logout')
        }
    },
    created() {

        // Initiate the token for all axios requests
        const token = localStorage.getItem('user-token')
        axios.defaults.headers.common['Authorization'] =  `Bearer ${token}`// for all requests

        // Check if user is a logged in admin
        this.$store.dispatch('isUserLoggedIn')
        if(!this.$store.getters.isAdmin) window.location = '/login'

    }
}
</script>

<style scoped>
.sb-nav-link-icon {
    width: 20px;
    color: none;
}

.router-link-exact-active,
.router-link-exact-active .link-icons {
    color: #EAAE49 !important
}

.sb-topnav {
    background-color: #3A3F51
}

.nav-link:hover{
    color: #EAAE49 !important

}
</style>
