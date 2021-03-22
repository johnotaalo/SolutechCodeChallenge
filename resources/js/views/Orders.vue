<template>
    <b-card>
        <template #header>
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-header-title"><b-icon-bag></b-icon-bag>&nbsp;Orders</h4>
                </div>
                <div class="col-auto">
                    <router-link :to="{name: 'add-order'}" class="btn btn-sm btn-primary">Add Order</router-link>
                </div>
            </div>
        </template>

        <b-table bordered striped hover :items="items" :fields="fields">
            <template #cell(#)="data">
                {{ data.index + 1 }}
            </template>
            <template #cell(products)="data">
                <b-link @click="showProductsModal(data.item.products)">({{ data.item.products.length }}) Products</b-link>
            </template>
            <template #cell(created)="data">
                {{ data.item.created | moment("DD-MM-YYYY") }}
            </template>
            <template #cell(actions)="data">
                <router-link :to="{name: 'edit-order', params: {orderId: data.item.id}}">Edit</router-link> | <b-link @click="deleteOrder(data.item.id)">Delete</b-link>
            </template>
        </b-table>

        <b-modal ref="products-modal" id="products-modal" title="Products">
            <ol>
                <li v-for="product in selectedProducts" :key="product.id">{{ product.name }}</li>
            </ol>
        </b-modal>
    </b-card>
</template>

<script>
export default {
    name: "Orders",
    data(){
        return {
            items: [],
            fields: ["#", "order_number", "products", "created", "actions"],
            selectedProducts: []
        }
    },
    created(){
        this.getOrders()
    },
    methods: {
        getOrders: function(){
            axios.get("/api/orders")
            .then(res => {
                this.items = _.map(res.data, (order) => {
                    return {
                        id: order.id,
                        order_number: order.order_number,
                        products: order.products,
                        created: order.created_at
                    }
                })
            });
        },
        deleteOrder: function(orderId){
            this.$swal({
                title: "Continue?",
                text: "The order will be deleted and cannot be undone",
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm: ()=>{
                    return axios.delete(`api/orders/${orderId}`)
                        .then(res => {
                            return res.data
                        })
                        .catch(error => {
                            _this.submitting = false
                            throw new Error(error.message)
                        })
                }
            })
                .then(result => {
                    if (result.isConfirmed){
                        this.$swal("Success", "Successfully deleted order", "success")
                        this.getOrders()
                    }else{
                        this.$swal("Cancelled", "The request has been cancelled", "info")
                    }
                })
                .catch(error => {
                    this.$swal("Error", error.message, "error")
                })
        },
        showProductsModal: function(products){
            this.selectedProducts = products
            this.$refs['products-modal'].show()
        }
    }
}
</script>

<style scoped>

</style>
