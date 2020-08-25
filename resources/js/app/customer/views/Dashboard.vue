<template>
<div class="container py-5">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card text-dark bg-white rounded-0">
                <div class="card-body">
                    <h4 class="card-title">Search Rooms:</h4>
                    <div class="card-body px-0">
                        <form action="/rooms/search" method="get">
                            <div>
                                <label>Check in</label>
                                <v-date-picker :min-date='new Date()' v-model="booking.checkin" :input-props='{name: "checkin", required: true}' :is-required="true" />
                            </div>

                            <div>
                                <label>Check out</label>
                                <v-date-picker :min-date='booking.checkin || new Date()' :input-props='{name: "checkout", required: true}' v-model="booking.checkout" :is-required="true" />
                            </div>

                            <div>
                                <label>Guests</label>
                                <input class="form-control" v-model="booking.guests" min="1" type="number" name="guests" required>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-warning rounded-0 text-white d-flex align-items-center mt-4">Search <i class="fas fa-search ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">

            <div class="row">

                    <div class="col-12 col-md-4">
                        <router-link to="/customer/profile">
                        <div class="card rounded-0 text-warning">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-user main-icons"></i>
                                    Edit Profile
                                </div>
                            </div>
                        </div>
                        </router-link>
                    </div>




                    <div class="col-12 col-md-4">
                        <router-link to="/customer/bookings">
                        <div class="card rounded-0 text-warning">
                            <div class="card-body">
                                <div class="d-flex flex-column  align-items-center">
                                    <i class="fas fa-clipboard main-icons"></i>
                                    Your bookings
                                </div>
                            </div>
                        </div>
                        </router-link>
                    </div>



                    <div class="col-12 col-md-4">
                        <router-link to="/customer/reviews">
                        <div class="card rounded-0 text-warning">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-star main-icons"></i>
                                    Your reviews
                                </div>
                            </div>
                        </div>
                        </router-link>
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
            booking: {
                checkin: null,
                checkout: null,
                guests: null
            },

        }
    },
    watch: {

        'booking.checkin': function (val) {
            this.booking.checkout = null
        }

    },
}
</script>

<style scoped>
.main-icons {
    font-size: 36px;
    margin-bottom: 10px;
}
</style>
