<template>
<div class="container">
    <div class="row">
        <div class="col-12 py-5">
            <div>
                <h1>Your bookings</h1>

            </div>

        </div>
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Room</th>
                        <th scope="col">Nights</th>
                        <th scope="col">Check in</th>
                        <th scope="col">Check out</th>
                        <th scope="col">Booked at</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="booking in bookings.data" :key="booking.id">
                        <td><img class="rounded-circle" style="width:80px;height:80px;object-fit:cover" :src="'/images/rooms/' + booking.room.images[0]" alt="room"></td>
                        <td>{{booking.room.title}}</td>
                        <td>{{calculateNights(booking.check_in, booking.check_out)}}</td>
                        <td>{{new Date(booking.check_in).toDateString()}}</td>
                        <td>{{new Date(booking.check_out).toDateString()}}</td>
                        <td>{{new Date(booking.created_at).toDateString()}}</td>
                        <td><a :href="'/customer/bookings/' + booking.id">View <i class="fas fa-eye"></i></a></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            bookings: []
        }
    },
    methods: {
        async getBookings() {
            try {
                const result = await axios.get(`/api/customer/bookings`)
                this.bookings = result.data.bookings
            } catch (error) {
                console.log(error)
            }
        },
        calculateNights(from, to) {
            return ((new Date(to).getTime() - new Date(from).getTime()) / (1000 * 3600 * 24)).toFixed()
        }
    },
    mounted() {

        // Default axios headers
        const token = localStorage.getItem('user-token')
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}` // for all requests

        this.getBookings()
    }
}
</script>

<style>
td {
    vertical-align: middle!important;
}
</style>
