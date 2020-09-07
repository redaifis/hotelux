<template>
<div>

    <!-- Modal -->
    <div class="modal fade" id="showReview" tabindex="-1" aria-labelledby="showReviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="showReviewLabel">Review #{{review.id}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12 mb-3">
                            <p><strong>Rating:</strong> {{review.rating}} <i class="fas fa-star text-warning"></i></p>
                            <p><strong>Comment:</strong></p>
                            <div v-html="review.comment" class="border py-3 mb-4 px-3"></div>
                            <a class="btn btn-warning text-white rounded-0 btn-sm" target="_blank" :href="'/rooms/' + review.room.slug">View Room</a>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['review'],
    methods: {

    }
}
</script>

<style>

</style>
