<template>
<div>
    <Header></Header>

    <div class="container">
        <div class="row py-5">
            <div class="col-12 col-md-8">
                <div class="row mb-4" v-for="room in rooms.data" :key="room.id">
                    <div class="col">
                        <a :href="'/rooms/' + room.slug">
                            <div class="card mb-3">
                                <div class="row no-gutters">
                                    <div class="col-md-4 card-img">
                                        <img :src="'/images/rooms/' + room.images[0]" class="card-img" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title text-dark">{{room.title.length > 80 ? room.title.slice(0,80) + '..' : room.title}}</h5>
                                            <div class="text-secondary" v-html="room.description.length > 120 ? room.description.slice(0,120) + '..' : room.description"></div>
                                            <a :href="'/rooms/' + room.slug" class="btn btn-warning rounded-0 text-white">Book Now</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row" v-if="rooms.data.length < 1">
                    <div class="col">
                        <h2>No available rooms</h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card text-dark bg-white">
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
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-8">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li :class="['page-item', rooms.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getRooms(rooms.current_page - 1)">Previous</a></li>
                        <li :class="['page-item', rooms.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of rooms.last_page" :key="index"><a class="page-link" @click.prevent="getRooms(index + 1)" href="#">{{index + 1}}</a></li>
                        <li :class="['page-item', rooms.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getRooms(rooms.current_page + 1)">Next</a></li>
                    </ul>
                </nav>
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
    props: ['checkin', 'checkout', 'guests'],
    data() {
        return {
            booking: {
                checkin: null,
                checkout: null,
                guests: null
            },
            rooms: {}
        }
    },
    watch:{

        'booking.checkin': function(val) {
            this.booking.checkout = null
        }

    },
    methods: {
        async getRooms(page = 1) {
            if(this.checkin && this.checkout && this.guests){
                try {
                    const result = await axios.get(`/api/rooms/search${'?checkin=' + this.checkin + '&checkout=' + this.checkout + '&guests=' + this.guests + '&page=' + page}`)
                    this.rooms = result.data.rooms

                } catch (error) {
                    console.log(error)
                }
            }else{
                try {
                    const result = await axios.get(`/api/rooms/search${'?page=' + page}`)
                    this.rooms = result.data.rooms
                } catch (error) {
                    console.log(error)
                }
            }
        }
    },
    mounted() {
        this.getRooms()
    }
}
</script>

<style scoped>
.card-img{
    height: 180px;
    object-fit: cover;
}
</style>
