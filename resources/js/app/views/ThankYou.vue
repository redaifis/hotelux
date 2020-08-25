<template>
<div class="thank-you d-flex align-items-between flex-column">

    <Header></Header>
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 text-center flex-column d-flex align-items-center justify-content-center">
                    <h1 class="display-1 text-warning">Thank You!</h1>
                    <p>You booking has been saved.</p>
                </div>

            </div>
        </div>


    <Footer></Footer>

</div>
</template>

<script>
import Header from '../partials/Header'
import Footer from '../partials/Footer'

export default {
    components: {
        Header,
        Footer,
    },
    data() {
        return {

        }
    },
    methods: {

    },
    mounted() {

    }
}
</script>

<style scoped>
.thank-you {
    height: 100vh;
}
</style>
