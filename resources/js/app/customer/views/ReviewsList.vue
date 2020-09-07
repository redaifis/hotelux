<template>
<div class="container">
    <div class="row">

        <div class="col-12 pt-5 mb-3">
            <div class="d-flex justify-content-between">
                <h1>Your reviews</h1>
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
                                <th scope="col">Comment</th>
                                <th scope="col">Rating</th>

                                <th scope="col" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="review in reviews.data" :key="review.id">
                                <td><img class="rounded-circle" style="width:80px;height:80px;object-fit:cover" :src="'/images/rooms/' + review.room.images[0]" alt="room"></td>
                                <td>{{review.room.title}}</td>
                                <td>{{review.comment}}</td>
                                <td>{{review.rating}} <i class="fas fa-star text-warning"></i></td>

                                <td><a href="#" class="btn btn-default rounded-0" @click.prevent="showReview(review)">Show <i class="fas fa-eye"></i></a></td>
                                <td><a href="#" class="btn btn-default rounded-0" @click.prevent="deleteReview(review.id)">Delete <i class="fas fa-trash"></i></a></td>
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
                    <li :class="['page-item', reviews.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getReviews(reviews.current_page - 1)">Previous</a></li>
                    <li :class="['page-item', reviews.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of reviews.last_page" :key="index"><a class="page-link" @click.prevent="getReviews(index + 1)" href="#">{{index + 1}}</a></li>
                    <li :class="['page-item', reviews.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getReviews(reviews.current_page + 1)">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <ShowReview :review="reviewToShow" />
</div>
</template>

<script>
import ShowReview from '../components/ShowReview'
export default {
    components: {
        ShowReview
    },
    data() {
        return {
            reviews: [],
            reviewToShow: {}
        }
    },
    methods: {
        async getReviews(page = 1) {
            try {
                const result = await axios.get(`/api/customer/reviews?page=${page}`)
                this.reviews = result.data.reviews
            } catch (error) {
                console.log(error)
            }
        },
        async deleteReview(id) {
            if (confirm('Do you want to delete this review?'))
                try {
                    const result = await axios.delete(`/api/customer/reviews/${id}`)
                    console.log(result)
                } catch (err) {
                    console.log(err)
                }
            this.getReviews()
        },
        async showReview(review, callback) {
            const setReview = new Promise((resolve, reject) => {
                this.reviewToShow = review
                resolve('Success!');
            })

            setReview.then(() => {
                $('#showReview').modal('toggle')
            })
        }
    },
    mounted() {

        // Default axios headers
        const token = localStorage.getItem('user-token')
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}` // for all requests

        this.getReviews()
    }
}
</script>

<style>
td {
    vertical-align: middle !important;
}
</style>
