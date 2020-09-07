<template>
<div class="container-fluid">
    <h1 class="my-4">Dashboard</h1>

    <Counts />


    <!-- CHARTS -->
    <h2 class="mt-4">Statistics</h2>

    <div class="row">
        <div class="col-12 col-md-6">
            <bar-chart v-if="bookingsData.isLoaded" :chartdata="bookingsData.chartdata" :options="bookingsData.options" />
        </div>

        <div class="col-12 col-md-6">
            <line-chart v-if="revenueData.isLoaded" :chartdata="revenueData.chartdata" :options="revenueData.options" />
        </div>
    </div>
</div>
</template>

<script>
import BarChart from "../components/dashboard/BarChart";
import LineChart from "../components/dashboard/LineChart";
import Counts from "../components/dashboard/Counts";
export default {
    data: () => ({
        bookingsData: {
            chartdata: {
                labels: [],
                datasets: [{
                    label: 'Bookings',
                    backgroundColor: '#447695',
                    data: []
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            precision: 0
                        }
                    }]
                }
            },
            isLoaded: false
        },

        revenueData: {
            chartdata: {
                labels: [],
                datasets: [{
                    label: 'Revenue',
                    backgroundColor: '#ABC32F',
                    data: []
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 2,
                            callback: function(value, index, values) {
                                // Convert the number to a string and splite the string every 3 charaters from the end
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);

                                // Convert the array to a string and format the output
                                value = value.join(',');
                                return '$' + value;
                            }
                        }
                    }]
                }

            },
            isLoaded: false
        },

    }),

    components: {
        LineChart,
        BarChart,
        Counts,
    },

    methods: {
        async getBookings() {
            this.$store.state.isLoading = true;
            this.bookingsData.isLoaded = false;
            try {
                const bookingsList = await axios.get("/api/admin/total/bookings");
                console.log(bookingsList)
                const data = Object.entries(bookingsList.data.bookings).sort()
                console.log(data)
                data.forEach(el => {
                    // Push date
                    this.bookingsData.chartdata.labels.push(el[0])
                    this.revenueData.chartdata.labels.push(el[0])
                    if (el[1] !== null) {

                        // Push number of bookings
                        this.bookingsData.chartdata.datasets[0].data.push(el[1].length)

                        // Calculate and Push revenue
                        let totalRevenue = 0
                        el[1].forEach(booking => totalRevenue += booking.invoice.total)
                        this.revenueData.chartdata.datasets[0].data.push(totalRevenue)
                        totalRevenue = 0

                    } else {
                        this.bookingsData.chartdata.datasets[0].data.push(0)
                    }
                })
                this.bookingsData.isLoaded = true;
                this.revenueData.isLoaded = true;

            } catch (e) {
                console.error(e);
            }
            this.$store.state.isLoading = false

        }
    },
    mounted() {
        this.getBookings()
    },
}
</script>

<style scoped>

</style>
