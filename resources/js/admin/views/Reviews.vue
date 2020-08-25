<template>
    <div class="container-fluid">

        <h1 class="my-4">Reviews</h1>


        <div class="row">
        <div class="col-12">
            <div class="table-responsive-md">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Post by</th>
                            <th>Comment</th>
                            <th>Rating</th>
                            <th>Posted at</th>
                            <th>Status</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="review in reviews.data" :key="review.id">
                            <th>{{review.id}}</th>
                            <td>{{review.user.first_name + ' ' + review.user.last_name}}</td>
                            <td>{{review.comment}}</td>
                            <td>{{review.rating}} <i class="fas fa-star text-warning"></i></td>
                            <td>{{new Date(review.created_at).toDateString()}}</td>
                            <td>
                                <span class="badge badge-success" v-show="review.is_approved">Approved</span>
                                <span class="badge badge-secondary" v-show="!review.is_approved">Pending</span>
                            </td>

                            <td><a class="btn btn-default rounded-0 btn-sm" href="#" @click.prevent="showReview(review)"><i class="fas fa-eye"></i></a></td>
                            <td v-show="!review.is_approved"><a class="btn btn-default rounded-0 btn-sm" href="#" @click.prevent="approveReview(review.id)" ><i class="fas fa-check"></i></a></td>
                            <td v-show="review.is_approved"><a class="btn btn-default rounded-0 btn-sm" href="#" @click.prevent="rejectReview(review.id)" ><i class="fas fa-times"></i></a></td>
                            <td><a class="btn btn-default rounded-0 btn-sm" href="#" @click.prevent="deleteReview(review.id)"><i class="fas fa-trash"></i></a></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li :class="['page-item', reviews.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getReviews(reviews.current_page - 1)">Previous</a></li>
                    <li :class="['page-item', reviews.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of reviews.last_page" :key="index"><a class="page-link" @click.prevent="getReviews(index + 1)" href="#">{{index + 1}}</a></li>
                    <li :class="['page-item', reviews.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getReviews(reviews.current_page + 1)">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <ShowReview :review='review' @approve='approveReview' @reject='rejectReview' @delete='deleteReview'/>

    </div>
</template>

<script>
import ShowReview from '../components/reviews/ShowReview'
export default {
    components: {ShowReview},
    data: () => ({
        reviews: {},
        review: {}
    }),
    methods:{
        async getReviews(page = 1){
            try {
                const reviews = await axios.get(`/api/admin/reviews?page=${page}`)
                this.reviews = reviews.data.reviews
            } catch (error) {
                if(error.response.status === 401) this.$store.dispatch('logout')
            }
        },
        async approveReview(review_id){
            if(confirm('Approve this review?'))
                try {
                    const review = await axios.put(`/api/admin/reviews/${review_id}`, { approval: 1 })
                    this.getReviews()
                    $('#showReview').modal('hide')
                } catch (error) {
                    if(error.response.status === 401) this.$store.dispatch('logout')
                }
        },
        async rejectReview(review_id){
            if(confirm('Reject this review?'))
                try {
                    const review = await axios.put(`/api/admin/reviews/${review_id}`, { approval: 0 })
                    this.getReviews()
                    $('#showReview').modal('hide')
                } catch (error) {
                    if(error.response.status === 401) this.$store.dispatch('logout')
                }
        },
        async deleteReview(review_id){
            if(confirm('Delete this review?'))
                try {
                    const review = await axios.delete(`/api/admin/reviews/${review_id}`)
                    this.getReviews()
                    $('#showReview').modal('hide')
                } catch (error) {
                    if(error.response.status === 401) this.$store.dispatch('logout')
                }
        },
        showReview(review){
            if(this.review = review) $('#showReview').modal('show')
        },

    },
    mounted(){
        this.getReviews()
    }
}
</script>

<style>

</style>
