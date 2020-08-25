<template>
<div class="container-fluid">

    <div>
        <h1 class="my-4">Customers </h1>

    </div>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active rounded-0" id="pills-home-tab" data-toggle="pill" href="#active" role="tab" aria-controls="pills-home" aria-selected="true">Active</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link rounded-0" id="pills-profile-tab" data-toggle="pill" href="#deleted" role="tab" aria-controls="pills-profile" aria-selected="false">Deleted</a>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
        <!-- ACTIVE CUSTOMERS HERE -->
        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Bookings</th>
                                    <th>Register date</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="customer in customers.data" :key="customer.id">
                                    <td>{{customer.id}}</td>
                                    <td>{{customer.first_name + ' ' + customer.last_name}}</td>
                                    <td>{{customer.email}}</td>
                                    <td>{{customer.phone}}</td>
                                    <td>{{customer.bookings_count}}</td>
                                    <td>{{new Date(customer.created_at).toDateString()}}</td>
                                    <td><a href="#" @click.prevent="editCustomerModal(customer)"><i class="fas fa-pen-alt"></i></a></td>
                                    <td><a href="#" @click.prevent="deleteCustomer(customer.id)"><i class="fas fa-trash-alt"></i></a></td>
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
                            <li :class="['page-item', customers.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getCustomers(customers.current_page - 1)">Previous</a></li>
                            <li :class="['page-item', customers.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of customers.last_page" :key="index"><a class="page-link" @click.prevent="getCustomers(index + 1)" href="#">{{index + 1}}</a></li>
                            <li :class="['page-item', customers.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getCustomers(customers.current_page + 1)">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- DELETED CUSTOMERS HERE -->
        <div class="tab-pane fade" id="deleted" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Bookings</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="customer in deletedCustomers.data" :key="customer.id">
                                    <td>{{customer.id}}</td>
                                    <td>{{customer.first_name + ' ' + customer.last_name}}</td>
                                    <td>{{customer.email}}</td>
                                    <td>{{customer.phone}}</td>
                                    <td>{{customer.bookings_count}}</td>
                                    <td><a href="#" @click.prevent="restoreDeletedCustomer(customer.id)"><i class="fas fa-backward"></i></a></td>
                                    <td><a href="#" @click.prevent="permaDeleteCustomer(customer.id)"><i class="fas fa-trash-alt"></i></a></td>
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
                            <li :class="['page-item', deletedCustomers.prev_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getDeletedCustomers(deletedCustomers.current_page - 1)">Previous</a></li>
                            <li :class="['page-item', deletedCustomers.current_page === (index + 1) ? 'active' : '']" v-for="(page, index) of deletedCustomers.last_page" :key="index"><a class="page-link" @click.prevent="getDeletedCustomers(index + 1)" href="#">{{index + 1}}</a></li>
                            <li :class="['page-item', deletedCustomers.next_page_url ? '' : 'disabled']"><a class="page-link" href="#" @click.prevent="getDeletedCustomers(deletedCustomers.current_page + 1)">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <EditCustomer :customer="customer" @getCustomers="getCustomers"/>
</div>
</template>

<script>
import EditCustomer from '../components/customers/EditCustomer'
export default {
    components:{EditCustomer},
    data() {
        return {
            customers: {},
            deletedCustomers: {},
            customer: {}

        }
    },
    methods: {
        editCustomerModal(customer){
            this.customer = customer
            $('#editCustomer').modal('show')
        },
        async getCustomers(page = 1) {
            try {
                const result = await axios.get(`/api/admin/customers?page=${page}`)
                this.customers = result.data.customers
            } catch (error) {
                if(error.response.status === 401) this.$store.dispatch('logout')

                console.log(error)
            }

        },
        async getDeletedCustomers(page = 1) {
            try {
                const result = await axios.get(`/api/admin/customers?page=${page}`)
                this.deletedCustomers = result.data.deletedCustomers
            } catch (error) {
                console.log(error)
            }

        },

        async deleteCustomer(customerId) {
            if (confirm('Do you want to proceed and delete this customer?')) {
                try {
                    const deletedCustomer = await axios.delete(`/api/admin/customers/${customerId}`)
                    console.log(deletedCustomer)
                    this.getCustomers()
                    this.getDeletedCustomers()
                } catch (error) {
                    console.log(error)
                }
            }

        },




        async getDeletedCustomers(page = 1) {
            try {
                const result = await axios.get(`/api/admin/deleted/customers?page=${page}`)
                this.deletedCustomers = result.data.deletedCustomers
            } catch (error) {
                console.log(error)
            }

        },
        async restoreDeletedCustomer(customerId){
            try {
                const result = await axios.put(`/api/admin/customers/${customerId}/restore`)
                this.customer = result.data.customer
                this.getDeletedCustomers()
                this.getCustomers()
            } catch (error) {
                console.log(error)
            }

        },

        async permaDeleteCustomer(customerId){
            if(confirm('Do you want to proceed and permanently delete this record?'))
                try {
                    const result = await axios.delete(`/api/admin/customers/${customerId}/delete`)
                    this.getDeletedCustomers()
                } catch (error) {
                    console.log(error)
                }
        },
    },
    mounted() {
        this.getCustomers()
        this.getDeletedCustomers()

    }
}
</script>

<style scoped>
td {
    vertical-align: middle
}
</style>
