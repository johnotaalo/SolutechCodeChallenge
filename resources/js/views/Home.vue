<template>
    <div>
        <b-row>
            <div class="col-md-3">
                <b-card>
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h6 class="text-uppercase text-muted mb-1">PRODUCTS</h6>
                            <!-- Heading -->
                            <span class="h2 mb-0">{{ products.length }}</span>
                        </div>
                        <div class="col-auto">
                            <b-icon-box class="h1 text-muted mb-0"></b-icon-box>
                        </div>
                    </div>
                </b-card>
            </div>
            <div class="col-md-3">
                <b-card>
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h6 class="text-uppercase text-muted mb-1">ORDERS</h6>
                            <!-- Heading -->
                            <span class="h2 mb-0">{{ orders.length }}</span>
                        </div>
                        <div class="col-auto">
                            <b-icon-bag class="h1 text-muted mb-0"></b-icon-bag>
                        </div>
                    </div>
                </b-card>
            </div>
            <div class="col-md-3">
                <b-card>
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h6 class="text-uppercase text-muted mb-1">SUPPLIERS</h6>
                            <!-- Heading -->
                            <span class="h2 mb-0">{{ suppliers.length }}</span>
                        </div>
                        <div class="col-auto">
                            <b-icon-people class="h1 text-muted mb-0"></b-icon-people>
                        </div>
                    </div>
                </b-card>
            </div>
            <div class="col-md-3">
                <b-card>
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h6 class="text-uppercase text-muted mb-1">USERS</h6>
                            <!-- Heading -->
                            <span class="h2 mb-0">{{ users.length }}</span>
                        </div>
                        <div class="col-auto">
                            <b-icon-person class="h1 text-muted mb-0"></b-icon-person>
                        </div>
                    </div>
                </b-card>
            </div>
        </b-row>
        <b-row>
            <div class="col-md">
                <b-card title="Orders Trend" >
                    <highcharts :options="ordersTrend" style="height: 400px;"></highcharts>
                </b-card>
            </div>
            <div class="col-md-6">
                <b-card title="Products">
                    <highcharts style="height: 400px;" :options="productQuantities"></highcharts>
                </b-card>
            </div>
        </b-row>
    </div>
</template>

<script>
export default {
    name: "Home",
    data(){
        return {
            products: [],
            orders: [],
            suppliers: [],
            users: []
        }
    },
    created(){
        axios.all([this.getProducts(), this.getOrders(), this.getSuppliers(), this.getUsers()])
        .then(axios.spread((...responses) => {
            this.products = responses[0].data
            this.orders = responses[1].data
            this.suppliers = responses[2].data
            this.users = responses[3].data
        }))
    },
    methods: {
        getProducts: function(){
            return axios.get("/api/products")
        },
        getOrders: function(){
            return axios.get("/api/orders");
        },
        getSuppliers: function(){
            return axios.get("/api/suppliers");
        },
        getUsers: function(){
            return axios.get("/api/users");
        }
    },
    computed: {
        productQuantities: function(){
            let data = _.map(this.products, (product) => {
                return {
                    name: product.name,
                    y: product.quantity
                }
            });

            return {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Product Quantities'
                },
                series: [{
                    name: "Quantities",
                    colorByPoint: true,
                    data: data
                }]
            }
        },
        ordersTrend: function(){
            let orders = this.orders

            var dates = _.uniq(_.map(orders, (order) => {
                return this.$moment(order.created_at).format("DD-MM-YYYY")
            }))

            let orderDateData = {};

            _.each(orders, (order) => {
                var orderDate = this.$moment(order.created_at).format("DD_MM_YYYY")
                if(typeof orderDateData["date_" + orderDate] === "undefined") {
                    orderDateData["date_" + orderDate] = []
                }
                orderDateData["date_" + orderDate].push(order)
            })

            let data = _.map(orderDateData, (orderDate) => {
                return orderDate.length
            })

            return {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Orders per Day'
                },
                xAxis: {
                    categories: dates
                },
                yAxis: {
                    title: {
                        text: 'Number of Orders'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                series: [{
                    name: 'Orders',
                    data: data
                }]
            };
        }
    }
}
</script>

<style scoped>

</style>
