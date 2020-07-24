<template>
<div>

    <Header></Header>

    <Slider></Slider>

    <Rooms></Rooms>

    <Blogs></Blogs>

    <Footer></Footer>

</div>
</template>

<script>
import Header from '../partials/Header'
import Footer from '../partials/Footer'
import Slider from '../components/SliderShow'
import Rooms from '../components/Rooms'
import Blogs from '../components/Blogs'
export default {
    components: {
        Header,
        Footer,
        Slider,
        Rooms,
        Blogs,
    }
}
</script>

<style scoped>



</style>
