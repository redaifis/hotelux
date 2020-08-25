<template>
  <div class="slider mb-5">
    <div class="h-100">
      <carousel :per-page="1" :mouse-drag="false" :loop="true" :autoplay="true" :paginationEnabled="false" class="h-100">
        <slide v-for="room in rooms" :key="room.id">
          <img :src="'/images/rooms/' + room.images[0]" alt="room photo" class="w-100" style="object-fit:cover;height:700px!important"/>
        </slide>
      </carousel>
    </div>

    <div id="booking-search" class="p-5 rounded">
      <h1 class="mb-4 text-center text-white font-weight-bold">Compare room prices</h1>
      <div class="card">
        <div class="card-body my-3">
          <form action="/rooms/search" method="get">
            <div class="d-flex align-items-end booking_all_inputs">
              <div class="m-2 booking__input">
                <label>Check in</label>
                <v-date-picker
                  :min-date="new Date()"
                  v-model="booking.checkin"
                  :input-props="{name: 'checkin', required: true}"
                  :is-required="true"
                />
              </div>

              <div class="m-2 booking__input">
                <label>Check out</label>
                <v-date-picker
                  :min-date="booking.checkin || new Date()"
                  :input-props="{name: 'checkout', required: true}"
                  v-model="booking.checkout"
                  :is-required="true"
                />
              </div>

              <div class="m-2 booking__input">
                <label>Guests</label>
                <input
                  class="form-control"
                  v-model="booking.guests"
                  min="1"
                  type="number"
                  name="guests"
                  required
                />
              </div>

              <div class="m-2">
                <button
                  type="submit"
                  class="btn btn-warning rounded-0 text-white d-flex align-items-center"
                >
                  Search
                  <i class="fas fa-search ml-2"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Carousel, Slide } from "vue-carousel";

export default {
  props: ["rooms"],
  components: {
    Carousel,
    Slide,
  },
  data() {
    return {
      booking: {
        checkin: null,
        checkout: null,
        guests: 1,
      },
    };
  },
  computed:{
      calculWidth(){
          return window.innerWidth
      }
  },

  watch: {
    "booking.checkin": function (val) {
      this.booking.checkout = null;
    },
  },
  methods: {},
  mounted() {

  },
};
</script>

<style scoped lang="scss">


.slider {
  width: 100%;
  height: 700px;
  position: relative;
background-color:#447695;//   background: linear-gradient(
//     90deg,
//     rgba(68, 118, 149, 1) 26%,
//     rgba(85, 149, 189, 1) 61%,
//     rgba(102, 179, 227, 1) 89%
//   );
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

// .slider{
//     position: absolute;
//     bottom: 0;
// }

.card {
  display: block;
  margin-bottom: 20px;
  line-height: 1.42857143;
  background-color: #fff;
  border-radius: 2px;
  transition: 0.25s all;
  z-index: 9999;
}

.card:hover {
  box-shadow: 0 3px 9px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.15);
}

.booking_all_inputs {
  max-width: 700px;
  width: 100%;
}
.booking__input {
  width: 150px;
}

@media (max-width: 667px) {
  .booking_all_inputs {
    flex-wrap: wrap;
  }
}

// wavy background
</style>
