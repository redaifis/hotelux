<template>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-4">Rooms </h1>
        <div>
            <button class="btn btn-warning text-white rounded-0" @click.prevent="toggleNewRoom">New Room</button>
        </div>
    </div>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active rounded-0" id="pills-home-tab" data-toggle="pill" href="#published" role="tab" aria-controls="pills-home" aria-selected="true">Published</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link rounded-0" id="pills-profile-tab" data-toggle="pill" href="#deleted" role="tab" aria-controls="pills-profile" aria-selected="false">Deleted</a>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
        <!-- PUBLISHED ROOMS HERE -->
        <div class="tab-pane fade show active" id="published" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Capacity</th>
                                    <th>Rent</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="room in rooms.data" :key="room.id">
                                    <td><img class="rounded-circle" style="width:80px;height:80px;object-fit:cover" :src="'/images/rooms/' + room.images[0]" alt="room"></td>
                                    <td>{{room.id}}</td>
                                    <td>{{room.title}}</td>
                                    <td>{{room.capacity}}</td>
                                    <td>{{room.price}}$</td>
                                    <td><a :href="'/rooms/' + room.slug" target="_blank"><i class="fas fa-eye"></i></a></td>
                                    <td><a href="#" @click.prevent="toggleNewRoom(room)"><i class="fas fa-pen-alt"></i></a></td>
                                    <td><a href="#" @click.prevent="deleteRoom(room.id)"><i class="fas fa-trash-alt"></i></a></td>
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
                            <li :class="['page-item', rooms.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getRooms(rooms.current_page - 1)">Previous</a></li>
                            <li :class="['page-item', rooms.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of rooms.last_page" :key="index"><a class="page-link" @click.prevent="getRooms(index + 1)" href="#">{{index + 1}}</a></li>
                            <li :class="['page-item', rooms.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getRooms(rooms.current_page + 1)">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- DELETED ROOMS HERE -->
        <div class="tab-pane fade" id="deleted" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Capacity</th>
                                    <th>Rent</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="room in deletedRooms.data" :key="room.id">
                                    <td><img class="rounded-circle" style="width:80px;height:80px;object-fit:cover" :src="'/images/rooms/' + room.images[0]" alt="room"></td>
                                    <td>{{room.id}}</td>
                                    <td>{{room.title}}</td>
                                    <td>{{room.capacity}}</td>
                                    <td>{{room.price}}$</td>
                                    <td><a href="#" @click.prevent="restoreDeletedRoom(room.id)"><i class="fas fa-backward"></i></a></td>
                                    <td><a href="#" @click.prevent="permaDeleteRoom(room.id)"><i class="fas fa-trash-alt"></i></a></td>
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
                            <li :class="['page-item', deletedRooms.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getDeletedRooms(deletedRooms.current_page - 1)">Previous</a></li>
                            <li :class="['page-item', deletedRooms.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of deletedRooms.last_page" :key="index"><a class="page-link" @click.prevent="getDeletedRooms(index + 1)" href="#">{{index + 1}}</a></li>
                            <li :class="['page-item', deletedRooms.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getDeletedRooms(deletedRooms.current_page + 1)">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <StoreRoom :newRoom="newRoom" @getRooms="getRooms" @resetInput="resetInputs" />

</div>
</template>

<script>
import StoreRoom from '../components/rooms/StoreRoom'
export default {
    components: {
        StoreRoom
    },
    data() {
        return {
            rooms: {},
            deletedRooms: {},
            newRoom: {
                id: null,
                title: "",
                description: "",
                price: "",
                capacity: null,
                images: null,
                errors: {
                    title: "",
                    description: "",
                    price: "",
                    capacity: "",
                    images: ""
                }
            }
        }
    },
    methods: {
        toggleNewRoom(room = null) {
            $('#new-room').modal('toggle')
            this.newRoom.id = room.id || null
            this.newRoom.title = room.title || ""
            this.newRoom.description = room.description || ""
            this.newRoom.price = room.price || null
            this.newRoom.capacity = room.capacity || null
            this.newRoom.images = room.images || null
            console.log(room.images)

        },

        async deleteRoom(roomId) {
            if (confirm('Do you want to proceed and delete this room?')) {
                try {
                    const deletedRoom = await axios.delete(`/api/admin/rooms/${roomId}`)
                    console.log(deletedRoom)
                    this.getRooms()
                    this.getDeletedRooms()
                } catch (error) {
                    console.log(error)
                }
            }

        },
        async getRooms(page = 1) {
            try {
                const result = await axios.get(`/api/admin/rooms?page=${page}`)
                this.rooms = result.data.rooms
            } catch (error) {
                console.log(error)
                if(error.response.status === 401) this.$store.dispatch('logout')

            }

        },

        async getDeletedRooms(page = 1) {
            try {
                const result = await axios.get(`/api/admin/deleted/rooms?page=${page}`)
                this.deletedRooms = result.data.deletedRooms
            } catch (error) {
                console.log(error)
            }

        },
        async restoreDeletedRoom(roomId){
            if(confirm('Restore this room?'))
                try {
                    const result = await axios.put(`/api/admin/rooms/${roomId}/restore`)
                    this.room = result.data.room
                    this.getDeletedRooms()
                    this.getRooms()
                } catch (error) {
                    console.log(error)
                }

        },

        async permaDeleteRoom(roomId){
            if(confirm('Do you want to proceed and permanently delete this room?'))
                try {
                    const result = await axios.delete(`/api/admin/rooms/${roomId}/delete`)
                    this.getDeletedRooms()
                } catch (error) {
                    console.log(error)
                }
        },
        resetInputs() {
            // reseting the inputs
            this.newRoom = {
                id: null,
                title: "",
                description: "",
                price: "",
                images: null,
                capacity: null,
                errors: {
                    title: "",
                    description: "",
                    price: "",
                    capacity: "",
                    images: ""
                }
            }
        },
        resetErrors() {
            this.newRoom.errors = {
                title: "",
                description: "",
                price: null,
                capacity: null,
                images: ""
            }
        },
    },
    mounted() {
        this.getRooms()
        this.getDeletedRooms()

    }
}
</script>

<style scoped>
td {
    vertical-align: middle
}
</style>
