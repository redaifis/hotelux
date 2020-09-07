<template>
<div class="container py-5">
        <div class="row">
            <div class="col-12 mb-4 d-flex align-items-center">
                <h2>Recommanded</h2>
            </div>
            <div class="col-12 col-md-4" v-for="room in recommandedRooms" :key="room.id">
                <div :class="['card rounded-0 border-0 mb-4', { 'shadow': isHovering === room.id}]" @mouseover="isHovering = room.id" @mouseout="isHovering = false" >
                    <a class="img-card" :href="'/rooms/' + room.slug">
                        <img :src="'/images/rooms/' + room.images[0]" class="w-100"/>
                    </a>
                    <div class="card-content">
                        <h4 class="card-title">
                            <a :href="'/rooms/' + room.slug">{{room.title}}</a>
                        </h4>
                        <span>{{room.price + '$ / Night'}}</span>
                    </div>
                    <div class="card-read-more">
                        <a :href="'/rooms/' + room.slug" class="btn btn-link btn-block text-warning">
                            Read More
                        </a>
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
} from 'vue-carousel';

export default {
    components: {
        Carousel,
        Slide,
    },
    data(){
        return{
            recommandedRooms: {},
            isHovering: false

        }
    },
    methods:{
        async getRecommandedRooms(){
            try {
                const result = await axios.get('/api/rooms/recommanded')
                this.recommandedRooms = result.data.rooms
            } catch (error) {
                console.log(error)
            }
        }
    },
    mounted(){
        this.getRecommandedRooms()
    }

}
</script>

<style scoped>
/* Cards */
.card {
    display: block;
    /* margin-bottom: 20px; */
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    transition: .25s all;
}

.img-card {
    width: 100%;
    height: 200px;
    border-top-left-radius: 2px;
    border-top-right-radius: 2px;
    display: block;
    overflow: hidden;
}

.img-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: all .25s ease;
}

.card-content {
    padding: 15px;
    text-align: left;
}

.card-title {
    margin-top: 0px;
    min-height: 50px!important;
}

.card-title a {
    color: #000;
    text-decoration: none !important;
}


.card-read-more a {
    text-decoration: none !important;
    padding: 10px;
    font-weight: 600;
    text-transform: uppercase
}

</style>
