<template>
<div>

    <Header></Header>

    <Slider :rooms="rooms"></Slider>

    <Rooms :rooms="rooms"></Rooms>

    <RecommandedRooms></RecommandedRooms>

    <!-- <Blogs :articles="articles"></Blogs> -->

    <LatestReviews></LatestReviews>

    <Footer></Footer>

</div>
</template>

<script>
import Header from '../partials/Header'
import Footer from '../partials/Footer'
import Slider from '../components/LandingPage/SliderShow'
import Rooms from '../components/LandingPage/Rooms'
import Blogs from '../components/LandingPage/Blogs'
import RecommandedRooms from '../components/LandingPage/RecommandedRooms'
import LatestReviews from '../components/LandingPage/LatestReviews'
export default {
    components: {
        Header,
        Footer,
        Slider,
        Rooms,
        Blogs,
        RecommandedRooms,
        LatestReviews,
    },
    data(){
        return{
            rooms: {},
            articles: {},
        }
    },
    methods:{
        async getRooms(){
            const result = await axios.get(`/api/rooms`)
            this.rooms = result.data.rooms
        },
        async getArticles(){
            const result = await axios.get(`/api/articles`)
            this.articles = result.data.articles
        }
    },
    mounted(){
        this.getRooms()
        this.getArticles()
    }
}
</script>

<style scoped>



</style>
