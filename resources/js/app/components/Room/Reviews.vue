<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div
          class="tab-pane fade active show"
          id="pills-reviews"
          role="tabpanel"
          aria-labelledby="pills-reviews-tab"
        >
          <div class="bg-white rounded shadow-sm p-4 mb-4 restaurant-detailed-ratings-and-reviews">
            <h3 class="mb-1 text-center">Ratings and Reviews</h3>

            <!-- REVIEW ITEM -->
            <div
              class="reviews-members pt-4 pb-4"
              v-for="reviewElement in reviews.data"
              :key="reviewElement.id"
            >
              <div class="media">
                <a href="#">
                  <img
                    alt="Generic placeholder image"
                    src="/images/profiles/portrait_placeholder.jpg"
                    class="mr-3 rounded-pill"
                  />
                </a>
                <div class="media-body">
                  <div class="reviews-members-header">
                    <span class="star-rating float-right">
                      <a href="#">
                        <i
                          :class="['fas fa-star', reviewElement.rating > 0 ? 'active-rating' : '']"
                        ></i>
                      </a>
                      <a href="#">
                        <i
                          :class="['fas fa-star', reviewElement.rating > 1 ? 'active-rating' : '']"
                        ></i>
                      </a>
                      <a href="#">
                        <i
                          :class="['fas fa-star', reviewElement.rating > 2 ? 'active-rating' : '']"
                        ></i>
                      </a>
                      <a href="#">
                        <i
                          :class="['fas fa-star', reviewElement.rating > 3 ? 'active-rating' : '']"
                        ></i>
                      </a>
                      <a href="#">
                        <i
                          :class="['fas fa-star', reviewElement.rating > 4 ? 'active-rating' : '']"
                        ></i>
                      </a>
                    </span>
                    <h6 class="mb-1">
                      <a
                        class="text-black"
                        href="#"
                      >{{reviewElement.user.first_name + ' ' + reviewElement.user.last_name}}</a>
                    </h6>
                    <p class="text-gray">{{new Date(reviewElement.created_at).toDateString()}}</p>
                  </div>
                  <div class="reviews-members-body">
                    <p v-html="reviewElement.comment"></p>
                  </div>
                </div>
              </div>
              <hr />
            </div>
            <!-- <a class="text-center w-100 d-block mt-4 font-weight-bold" href="#">See All Reviews</a> -->

            <nav aria-label="Page navigation example text-center w-100 d-block mt-4">
              <ul class="pagination">

                <li :class="['page-item', reviews.current_page <= 1 ? 'disabled' : '']">
                  <a class="page-link" href="#" @click.prevent="getReviews(reviews.current_page - 1)" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>

                <li :class="['page-item', reviews.current_page === page ? 'active' : '']" v-for="(page,index) in reviews.last_page" :key="index">
                  <a class="page-link" href="#" @click.prevent="getReviews(page)">{{page}}</a>
                </li>

                <li :class="['page-item', reviews.current_page === reviews.last_page ? 'disabled' : '']">
                  <a class="page-link" href="#" @click.prevent="getReviews(reviews.current_page + 1)" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>

          <div class="bg-white rounded shadow-sm p-4 mb-5 rating-review-select-page">
            <h5 class="mb-4">Leave a review</h5>
            <p class="mb-2">Rate this room</p>
            <div class="mb-4">
              <span class="star-rating">
                <a href="#" @click.prevent="review.rating = 1">
                  <i :class="['fas fa-star', review.rating <= 5 ? 'active-rating' : '']"></i>
                </a>
                <a href="#" @click.prevent="review.rating = 2">
                  <i
                    :class="['fas fa-star', review.rating <= 5 && review.rating >= 2 ? 'active-rating' : '']"
                  ></i>
                </a>
                <a href="#" @click.prevent="review.rating = 3">
                  <i
                    :class="['fas fa-star', review.rating <= 5 && review.rating >= 3 ? 'active-rating' : '']"
                  ></i>
                </a>
                <a href="#" @click.prevent="review.rating = 4">
                  <i
                    :class="['fas fa-star', review.rating <= 5 && review.rating >= 4 ? 'active-rating' : '']"
                  ></i>
                </a>
                <a href="#" @click.prevent="review.rating = 5">
                  <i :class="['fas fa-star', review.rating === 5 ? 'active-rating' : '']"></i>
                </a>
              </span>
            </div>
            <form @submit.prevent="storeReview">
              <div class="form-group">
                <label>Your Comment</label>
                <textarea class="form-control" name="comment" v-model="review.comment" required></textarea>
              </div>
              <div class="form-group">
                  <div class="alert alert-success" role="alert" v-show="review.submited">
                      <span>Your review has been submited, and will be reviewed by moderators.</span>
                  </div>
                  <div class="alert alert-danger" role="alert" v-show="review.error.length > 0">
                      <span>{{review.error}}</span>
                  </div>
                <button
                  class="btn btn-primary rounded-0"
                  type="submit"
                  :disabled="!$store.getters.isUserLoggedIn || isLoading"
                >Submit Review</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["roomId"],
  data() {
    return {
      reviews: {},
      review: {
        rating: 5,
        comment: "",
        submited: false,
        error: ""
      },

      isLoading: false,
    };
  },
  // computed:{
  //     isUserLoggedIn(){
  //         return $store.getters.isUserLoggedIn
  //     }
  // },
  methods: {
    async getReviews(page = null) {
        if(page){
            try {
                const result = await axios.get(`/api/reviews/${roomId}/room/?page=${page}`);
                this.reviews = result.data.reviews;

            } catch (error) {
                console.log(error);
            }
        }else{
            try {
                const result = await axios.get(`/api/reviews/${roomId}/room`);
                this.reviews = result.data.reviews;
            } catch (error) {
                console.log(error);
            }

        }


    },
    async storeReview() {
      this.isLoading = true
      try {
        let data = { ...this.review, roomId }
        const result = await axios.post('/api/reviews', data)
        console.log(result)
        this.review.submited = true
        this.getReviews()
      } catch (err) {
        if (err.response) {
            this.review.error = err.response.data.message
        }
      }
      this.isLoading = false

      this.review.rating = 5
      this.review.comment = ""
    },
  },
  mounted() {
    this.getReviews()
  },
};
</script>

<style scoped>
body {
  background: #dcdcdc;
}
.total-like-user-main a {
  display: inline-block;
  margin: 0 -17px 0 0;
}
.total-like {
  border: 1px solid;
  border-radius: 50px;
  display: inline-block;
  font-weight: 500;
  height: 34px;
  line-height: 33px;
  padding: 0 13px;
  vertical-align: top;
}
.restaurant-detailed-ratings-and-reviews hr {
  margin: 0 -24px;
}
.graph-star-rating-header .star-rating {
  font-size: 17px;
}
.progress {
  background: #f2f4f8 none repeat scroll 0 0;
  border-radius: 0;
  height: 30px;
}
.rating-list {
  display: inline-flex;
  margin-bottom: 15px;
  width: 100%;
}
.rating-list-left {
  height: 16px;
  line-height: 29px;
  width: 10%;
}
.rating-list-center {
  width: 80%;
}
.rating-list-right {
  line-height: 29px;
  text-align: right;
  width: 10%;
}
.restaurant-slider-pics {
  bottom: 0;
  font-size: 12px;
  left: 0;
  z-index: 999;
  padding: 0 10px;
}
.restaurant-slider-view-all {
  bottom: 15px;
  right: 15px;
  z-index: 999;
}
.offer-dedicated-nav .nav-link.active,
.offer-dedicated-nav .nav-link:hover,
.offer-dedicated-nav .nav-link:focus {
  border-color: #3868fb;
  color: #3868fb;
}
.offer-dedicated-nav .nav-link {
  border-bottom: 2px solid #fff;
  color: #000000;
  padding: 16px 0;
  font-weight: 600;
}
.offer-dedicated-nav .nav-item {
  margin: 0 37px 0 0;
}
.restaurant-detailed-action-btn {
  margin-top: 12px;
}
.restaurant-detailed-header-right .btn-success {
  border-radius: 3px;
  height: 45px;
  margin: -18px 0 18px;
  min-width: 130px;
  padding: 7px;
}
.text-black {
  color: #000000;
}
.icon-overlap {
  bottom: -23px;
  font-size: 74px;
  opacity: 0.23;
  position: absolute;
  right: -32px;
}
.menu-list img {
  width: 41px;
  height: 41px;
  object-fit: cover;
}
.restaurant-detailed-header-left img {
  width: 88px;
  height: 88px;
  border-radius: 3px;
  object-fit: cover;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
.reviews-members .media .mr-3 {
  width: 56px;
  height: 56px;
  object-fit: cover;
}
.rounded-pill {
  border-radius: 50rem !important;
}
.total-like-user {
  border: 2px solid #fff;
  height: 34px;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
  width: 34px;
}
.total-like-user-main a {
  display: inline-block;
  margin: 0 -17px 0 0;
}
.total-like {
  border: 1px solid;
  border-radius: 50px;
  display: inline-block;
  font-weight: 500;
  height: 34px;
  line-height: 33px;
  padding: 0 13px;
  vertical-align: top;
}
.restaurant-detailed-ratings-and-reviews hr {
  margin: 0 -24px;
}
.graph-star-rating-header .star-rating {
  font-size: 17px;
}
.progress {
  background: #f2f4f8 none repeat scroll 0 0;
  border-radius: 0;
  height: 30px;
}
.rating-list {
  display: inline-flex;
  margin-bottom: 15px;
  width: 100%;
}
.rating-list-left {
  height: 16px;
  line-height: 29px;
  width: 10%;
}
.rating-list-center {
  width: 80%;
}
.rating-list-right {
  line-height: 29px;
  text-align: right;
  width: 10%;
}
.restaurant-slider-pics {
  bottom: 0;
  font-size: 12px;
  left: 0;
  z-index: 999;
  padding: 0 10px;
}
.restaurant-slider-view-all {
  bottom: 15px;
  right: 15px;
  z-index: 999;
}

.progress {
  background: #f2f4f8 none repeat scroll 0 0;
  border-radius: 0;
  height: 30px;
}

.star-rating i {
  color: #a5afb6;
  font-size: 24px;
}

.active-rating {
  color: #eaae49 !important;
}
</style>

