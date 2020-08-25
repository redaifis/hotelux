<template>
<div class="container py-5">
    <div class="row">
        <div class="col">
            <div class="py-3 d-flex flex-wrap justify-content-between">
                <h1>Booking <span>#{{booking.id}}</span></h1>
                <div><button type="button" class="btn btn-secondary rounded-0 d-flex align-items-center" @click.prevent="() => $router.replace('/customer/bookings')"><i class="fas fa-angle-left mr-2"></i> Go back</button></div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <img :src="'/images/rooms/' + booking.room.images[0]" :alt="booking.room.title" class="w-100">
                                    </div>
                                    <div class="col-12">
                                        <h4 class="mb-3">Room information:</h4>
                                        <p>Room: {{booking.room.title}}</p>
                                        <p>Description:</p>
                                        <div v-html="booking.room.description"></div>
                                        <p>Price: {{booking.room.price}}</p>
                                        <a :href="'/rooms/' + booking.room.id" class="btn btn-primary rounded-0">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <h4 class="mb-3">Booking Details:</h4>
                                    <p>Check in date: {{booking.check_in}}</p>
                                    <p>Check out date: {{booking.check_out}}</p>
                                    <p>Number of guests: {{booking.guests}}</p>
                                    <p v-if="booking.invoice">Status: {{booking.invoice.status ? 'Paid' : 'Unpaid'}}</p>
                                </div>
                                <hr>
                                <div>
                                    <h4 class="mb-3">Invoice details:</h4>
                                    <p>Payment method: {{booking.invoice.payment_type}}</p>
                                    <p>Total: {{booking.invoice.total}}$</p>
                                </div>
                            </div>
                        </div>

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
            booking: {}
        }
    },
    methods: {
        async getBooking() {
            try {
                const result = await axios.get(`/api/customer/bookings/${this.$route.params.id}`)
                this.booking = result.data.booking
            } catch (error) {
                console.log(error)
            }
        }
    },
    mounted() {
        this.getBooking()
    }
}
</script>

<style scoped>
i{
    font-size: 20px;
}
</style>
