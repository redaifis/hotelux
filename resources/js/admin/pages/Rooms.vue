<template>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-4">Rooms </h1>
        <div>
            <button class="btn btn-warning text-white rounded-0" @click.prevent="toggleNewRoom">New Room</button>
        </div>
    </div>

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
                        <tr v-for="room in rooms" :key="room.id">
                            <td><img class="rounded-circle" style="width:80px;height:80px;object-fit:cover" :src="'/images/rooms/' + room.images[0]" alt="room"></td>
                            <td>{{room.id}}</td>
                            <td>{{room.title}}</td>
                            <td>{{room.capacity}}</td>
                            <td>{{room.price}}$</td>
                            <td><a href="#"><i class="fas fa-eye"></i></a></td>
                            <td><a href="#" @click.prevent="toggleNewRoom(room)"><i class="fas fa-pen-alt"></i></a></td>
                            <td><a href="#" @click.prevent="deleteRoom(room.id)"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="new-room" tabindex="-1" role="dialog">
        <div class="mmodal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="#" method="post" @submit.prevent="storeRoom(newRoom.id)">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add new room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" v-model="newRoom.title" name="title" id="title" class="form-control" placeholder="Room title" minlength="3" maxlength="100" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Description</label>
                            <ckeditor v-model="newRoom.description" required></ckeditor>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12 col-sm-6">
                                <label for="price">Price</label>
                                <input type="number" v-model="newRoom.price" min="1" name="price" id="price" class="form-control" placeholder="Price" required>
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="price">Capacity</label>
                                <input type="number" v-model="newRoom.capacity" min="1" name="price" id="capacity" class="form-control" placeholder="capacity" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price">Images (max 5)</label>
                            <input type="file" ref="file" multiple="multiple" id="images" class="form-control-file" required>
                            <small class="text-danger" v-if="newRoom.errors.images.length > 0">{{newRoom.errors.images}}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-white rounded-0">Save changes</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            rooms: {},
            newRoom: {
                id: null,
                title: "",
                description: "",
                price: "",
                capacity: null,
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
            if (room) {
                this.newRoom.id = room.id
                this.newRoom.title = room.title
                this.newRoom.description = room.description
                this.newRoom.price = room.price
                this.newRoom.capacity = room.capacity
            } else {
                this.newRoom.title = ''
                this.newRoom.description = ''
                this.newRoom.price = ''
                this.newRoom.capacity = null
            }

        },
        async storeRoom(id = null) {
            let dataToSubmit = new FormData

            // Initiate errors for new submition
            this.newRoom.errors = {
                title: "",
                description: "",
                price: "",
                capacity: null,
                images: ""
            }

            // Check images
            for (let i = 0; i < this.$refs.file.files.length; i++) {

                let file = this.$refs.file.files[i]

                console.log(file.type)

                if (file.type !== 'image/png' && file.type !== 'image/jpeg') {
                    this.newRoom.errors.images = "Invalid image type!"
                    return false
                }

                dataToSubmit.append('images[' + i + ']', file)

            }

            dataToSubmit.append('title', this.newRoom.title)
            dataToSubmit.append('description', this.newRoom.description)
            dataToSubmit.append('price', this.newRoom.price)
            dataToSubmit.append('capacity', this.newRoom.capacity)
            dataToSubmit.append('_method', 'put')

            if (id !== null) {

                try {
                    const result = await axios.post(`/api/rooms/${id}/update`,
                        dataToSubmit, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            },
                        }
                    )
                    this.getRooms()
                    console.log(result)
                } catch (error) {
                    console.log(error)
                }
                return true

            } else {

                try {
                    const result = await axios.post(`/api/rooms/new`,
                        dataToSubmit, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            },
                        }
                    )
                    this.getRooms()
                    console.log(result)
                } catch (error) {
                    console.log(error)
                }

                return true
            }

        },
        async deleteRoom(roomId) {
            if (confirm('Do you want to proceed and delete this room?')) {
                try {
                    const deletedRoom = await axios.delete(`/api/rooms/${roomId}/delete`)
                    console.log(deletedRoom)
                    this.getRooms()
                } catch (error) {
                    console.log(error)
                }
            }

        },
        async getRooms() {
            try {
                const rooms = await axios.get(`/api/rooms/all`)
                this.rooms = rooms.data.rooms
            } catch (error) {
                console.log(error)
            }

        },
    },
    mounted() {
        this.getRooms()

    }
}
</script>

<style scoped>
td {
    vertical-align: middle
}
</style>
