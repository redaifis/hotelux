<template>
<div class="container py-5">
    <div class="row">
        <div class="card shadow-sm rounded-0 border-0">
            <div class="card-body">
                <div class="row py-4">
                    <div class="col-12">
                        <article>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <carousel :per-page="1" :paginationColor="'#A0AEC0'" :paginationActiveColor="'#447695'" :paginationPadding='8' :centerMode='true'>
                                        <slide v-for="(img,index) in room.images" :key="index">
                                            <img height="400" :src="'/images/rooms/' + img" alt />
                                        </slide>
                                    </carousel>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h1 class="h2 mb-4">{{room.title}}</h1>
                                    <hr />
                                    <span class="font-weight-bold mb-2">Description:</span>
                                    <div v-html="room.description"></div>
                                    <div class="d-flex flex-wrap mb-3">
                                        <div><span class="font-weight-bold">Price per night: </span>{{room.price}}$</div>
                                        <div class="ml-4"><span class="font-weight-bold">Capacity: </span>{{room.capacity}}</div>
                                    </div>
                                    <form action @submit.prevent="() => $emit('book-now')">
                                        <div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Nights:</label>
                                                <v-date-picker mode="range" v-model="datesRange" :disabled-dates="disabledDates" :input-props="{name: 'nights', required:true}" :is-required="true" />
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Guests:</label>
                                                <input type="number" v-model="bookingDetails.guests" min="1" class="form-control" :max="room.capacity" name="guests" id="guests" required />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning text-white rounded-0">Book Now</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    Carousel,
    Slide
} from "vue-carousel";

export default {
    props: ['room', 'bookingDetails', 'disabledDates', 'datesRange'],
    components: {
        Carousel,
        Slide,
    }
}
</script>

<style>

</style>
