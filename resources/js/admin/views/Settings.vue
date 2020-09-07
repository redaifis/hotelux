<template>
<div class="container-fluid">

    <h1 class="my-4">Settings</h1>

    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">General</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Payment</a>
                </li>
            </ul>
            <div class="tab-content my-3" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form action="#" @submit.prevent="storeHotelInfo">
                        <h3 class="text-center mb-0">Insert hotel information:</h3>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" v-model="hotel.name" name="name" id="name" class="form-control" placeholder="Hotel name"  required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea v-model="hotel.description" rows="5" name="description" id="description" class="form-control" placeholder="Hotel description" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <label for="country">Country</label>
                                <input type="text" v-model="hotel.country" name="country" id="country" class="form-control" placeholder="Hotel country" required>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="address">Address</label>
                                <input type="text" v-model="hotel.address" name="address" id="address" class="form-control" placeholder="Hotel address" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <label for="state">State</label>
                                <input type="text" v-model="hotel.state" name="state" id="state" class="form-control" placeholder="Hotel state" required>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="postal_code">Postal code</label>
                                <input type="text" v-model="hotel.postal_code" name="postal_code" id="postal_code" class="form-control" placeholder="Hotel postal code" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input type="tel" v-model="hotel.phone" name="phone" id="phone" class="form-control" placeholder="Hotel phone number" required>
                        </div>

                        <button type="submit" class="btn btn-warning text-white rounded-0">Save changes</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur debitis aut numquam sit velit vero nemo eaque inventore exercitationem.
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
export default {
    data(){
        return{
            hotel: {
                name: '',
                description: '',
                country: '',
                address: '',
                city: '',
                postal_code: '',
                phone: '',
            }
        }
    },
    methods:{
        async getHotelInfo(){
            this.$store.state.isLoading = true

            try {
                const hotel = await axios.get(`/api/admin/hotel`, this.hotel)
                this.hotel = hotel.data.hotel
                console.log(hotel)
            } catch (error) {
                console.log(error)
            }
            this.$store.state.isLoading = false

        },
        async storeHotelInfo(){
            this.$store.state.isLoading = true

            try {
                const hotel = await axios.post(`/api/admin/hotel`, this.hotel)
                console.log(hotel)
            } catch (error) {
                console.log(error)
            }
            this.$store.state.isLoading = false

        }
    },
    mounted(){
        this.getHotelInfo()
    }
}
</script>

<style>
a {
    color: #252525;
    font-weight: 700;
}
</style>
