<template>
<div class="">

  <div class="container  py-5">
    <div class="row">
      <div class="col-12">
        <h3 class="pb-4 text-center">Customers Reviews</h3>
      </div>
      <div class="col-12 col-md-7 mx-auto">
        <carousel class="shadow-sm "
          :autoplay="true"
          :nav="false"
          :loop="true"
          :paginationEnabled="false"
          :navigationEnabled="false"
          :perPage="1"
        >
          <slide v-for="review in reviews" :key="review.id" class="card border-0 px-4">
            <div class="row card-body">
              <div class="col-12">
                <div class="row">
                  <div class="col-12 text-center d-flex flex-column">
                      <span class="font-weight-bold">{{review.user.first_name + " " + review.user.last_name}}</span>
                      <span class="star-rating">
                        <a href="#">
                          <i :class="['fas fa-star', review.rating > 0 ? 'active-rating' : '']"></i>
                        </a>
                        <a href="#">
                          <i :class="['fas fa-star', review.rating > 1 ? 'active-rating' : '']"></i>
                        </a>
                        <a href="#">
                          <i :class="['fas fa-star', review.rating > 2 ? 'active-rating' : '']"></i>
                        </a>
                        <a href="#">
                          <i :class="['fas fa-star', review.rating > 3 ? 'active-rating' : '']"></i>
                        </a>
                        <a href="#">
                          <i :class="['fas fa-star', review.rating > 4 ? 'active-rating' : '']"></i>
                        </a>
                      </span>
                  </div>
                  <div class="col-12 d-flex flex-column">
                      <span class="font-weight-bold text-lg"><i class="fas fa-quote-left quotes"></i></span>
                    <p
                      class="my-2 text-center"
                    >{{review.comment.length > 100 ? review.comment.slice(0,100) + '...' : review.comment}}</p>
                    <span class="text-right"><i class="fas fa-quote-right quotes"></i></span>
                    <small>{{new Date(review.created_at).toDateString()}}</small>
                  </div>
                </div>
              </div>
            </div>
          </slide>
        </carousel>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { Carousel, Slide } from "vue-carousel";

export default {
  components: {
    Carousel,
    Slide,
  },
  data() {
    return {
      reviews: {},
    };
  },
  methods: {
    async getReviews() {
      try {
        const result = await axios.get("/api/reviews");
        this.reviews = result.data.reviews;
      } catch (error) {
        console.log(error);
      }
    },
  },
  mounted() {
    this.getReviews();
  },
};
</script>

<style scoped>
.star-rating i {
  color: #a5afb6;
  font-size: 11px;
}

.active-rating {
  color: #eaae49 !important;
}

.quotes{
  font-size: 11px;

}
</style>
