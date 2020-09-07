<template>
<div class="container">
    <div class="row">
        <div class="col-12 pt-5 mb-3">
            <div class="d-flex justify-content-between">
                <h1>Bookings</h1>
                <div>

                <button class="btn btn-secondary rounded-0" @click.prevent="() => $router.replace('/customer')">Go back</button>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li :class="['page-item', bookings.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getBookings(bookings.current_page - 1)">Previous</a></li>
                    <li :class="['page-item', bookings.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of bookings.last_page" :key="index"><a class="page-link" @click.prevent="getBookings(index + 1)" href="#">{{index + 1}}</a></li>
                    <li :class="['page-item', bookings.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getBookings(bookings.current_page + 1)">Next</a></li>
                </ul>
            </nav>
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
        async getBookings(page = 1) {
            try {
                const result = await axios.get(`/api/customer/bookings?page=${page}`)
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
    vertical-align: middle !important;
}
</style>
