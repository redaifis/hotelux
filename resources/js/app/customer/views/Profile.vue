<template>
<div class="container py-5">
    <div class="row">
        <div class="col-12 col-md-8 m-auto">
            <form @submit.prevent="updateUserProfile">

                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="first_name">First name</label>
                        <input v-model="user.first_name" type="text" minlength="3" class="form-control" name="first_name" id="first_name" placeholder="First name" required>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="last_name">Last name</label>
                        <input v-model="user.last_name" type="text" minlength="3" class="form-control" name="last_name" id="last_name" placeholder="Last name" required>
                    </div>

                </div>

                <div class="form-group ">
                    <label for="email">Email</label>
                    <input v-model="user.email" type="email" class="form-control" name="email" id="email" placeholder="email" required />
                </div>

                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input v-model="user.phone" type="tel" class="form-control" name="phone" id="phone" placeholder="phone number" required>
                </div>

                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="country">Country</label>
                        <input v-model="user.country" type="text" pattern="[a-zA-Z]+" class="form-control" name="country" id="country" placeholder="country" required>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="city">City</label>
                        <input v-model="user.city" type="text" pattern="[a-zA-Z]+" class="form-control" name="city" id="city" placeholder="city" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input v-model="user.address" type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                </div>

                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="postal_code">Postal code</label>
                        <input v-model="user.postal_code" type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Postal code" required>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="state">State</label>
                        <input v-model="user.state" type="text" class="form-control" name="state" id="state" placeholder="State" required>
                    </div>

                </div>
                <div class="alert alert-success" role="alert" v-show="success">
                    Profile has been successfuly updated!
                </div>
                <div class="alert alert-danger" role="alert" v-if="errors.user">
                    {{errors.user}}
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" :disabled="$store.state.isLoading" class="btn btn-primary rounded-0">Update profile</button>
                    <!-- Button trigger CHANGE PASSWORD -->
                    <button type="button" class="btn btn-warning text-white rounded-0" data-toggle="modal" data-target="#changePassword">
                        Change Password
                    </button>
                </div>
            </form>

        </div>

    </div>

    <!-- CHANGE PASSWORD MODAL -->

    <!-- Modal -->
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="#" @submit.prevent="updatePassword()">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordTitle">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="password">Password</label>
                                <input v-model="user.password" type="password" minlength="8" class="form-control" name="password" id="password" placeholder="Confirm password" required>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="password">Confirm password</label>
                                <input v-model="user.password_confirmation" type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required>
                            </div>
                        </div>

                        <div class="alert alert-success" role="alert" v-show="success">
                            Profile has been successfuly updated!
                        </div>
                        <div class="alert alert-danger" role="alert" v-if="errors.password">
                            {{errors.password}}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" :disabled="$store.state.isLoading">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            user: {...this.$store.state.user},
            success: false,
            errors: {password: null, user: null}
        }
    },
    methods: {
        async updateUserProfile() {
            this.$store.state.isLoading = true
            try {
                const result = await axios.put(`/api/customer/profile/${this.user.id}`, this.user)
                console.log(result)
                localStorage.setItem('user', JSON.stringify(result.data.profile))
                // this.$store.dispatch('getProfile')
                this.success = true
            } catch (error) {
                console.log(error)
            }
            this.$store.state.isLoading = false
        },
        async changePassword() {
            this.$store.state.isLoading =  true

            this.errors.password = null

            if(this.user.password !== this.user.password_confirmation){
                this.errors.password = 'Passwords don\'t match!'
            }

            try {
                const result = await axios.put(`/api/customer/password/${this.user.id}`, {password: this.user.password})
                console.log(result)
                this.success = true
            } catch (error) {
                console.log(error)
            }
            this.$store.state.isLoading = false
        }
    },
    mounted() {

    }
}
</script>

<style>

</style>
