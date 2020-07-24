<template>
<div class="slider mb-5">

<svg id="svg" xmlns="http://www.w3.org/2000/svg" viewBox="-300 0 950 270" >
        <path d="M-314,267 C105,364 200,100 1200,500" fill="#447695" stroke="#F8FAFC" stroke-width="120" stroke-linecap="round"/>
    </svg>
    <div id="booking-search" class="p-5 rounded">
    <h1 class="mb-4 text-center text-white">Compare room prices</h1>
        <div class="card">
            <div class="card-body my-3">
                <form>
                    <div class="d-flex align-items-end booking_all_inputs">

                        <div class="m-2 booking__input">
                            <label>Check in</label>
                            <datepicker :bootstrap-styling="true" v-model="booking.checkin" name="checkin"></datepicker>
                        </div>

                        <div class="m-2 booking__input">
                            <label>Check out</label>
                            <datepicker :bootstrap-styling="true" v-model="booking.checkout" name="checkout"></datepicker>
                        </div>

                        <div class="m-2 booking__input">
                            <label>Guests</label>
                            <input class="form-control" v-model="booking.guests" min="1" type="number" name="guests">
                        </div>

                        <div class="m-2">
                            <button type="submit" class="btn btn-warning rounded-0 text-white d-flex align-items-center">Search <i class="fas fa-search ml-2"></i></button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>





</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';

import {
    Carousel,
    Slide
} from 'vue-carousel';

export default {
    components: {
        Carousel,
        Slide,
        Datepicker
    },
    data() {
        return {
            booking: {
                checkin: null,
                checkout: null,
                guests: 1
            }
        }
    }
}
</script>

<style scoped lang="scss">
.slider {
    width: 100%;
    height: 700px;
    position: relative;
background: rgb(68,118,149);
background: linear-gradient(90deg, rgba(68,118,149,1) 26%, rgba(85,149,189,1) 61%, rgba(102,179,227,1) 89%);
}

.VueCarousel-slide {
    width: 100%;
    height: 100%;
}

img {
    max-width: 100%;
  height: auto;
    object-fit: cover;
}

#booking-search {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

svg{
    position: absolute;
    bottom: 0;
}

.card {
    display: block;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    transition: .25s all;
    z-index: 9999;
}

.card:hover {
box-shadow: 0 3px 9px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.15);
}

.booking_all_inputs{
    max-width: 700px;
    width: 100%;

}
.booking__input{
    width:150px
}

@media (max-width: 667px) {
    .booking_all_inputs{
        flex-wrap: wrap;
    }
}

// wavy background

</style>
