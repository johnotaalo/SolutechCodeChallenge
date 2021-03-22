<template>
    <div>
        <b-card>
            <template #header>
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-header-title"><b-icon-box></b-icon-box>&nbsp;Products</h4>
                    </div>
                    <div class="col-auto">
                        <router-link :to="{name: 'add-product'}" class="btn btn-sm btn-primary">Add Product</router-link>
                    </div>
                </div>
            </template>
            <b-table bordered striped hover :items="items" :fields="fields">
                <template #cell(#)="data">
                    {{ data.index + 1 }}
                </template>

                <template #cell(actions)="data">
                    <router-link :to="{name: 'edit-product', params: {productId: data.item.id}}">Edit</router-link> | <b-link @click="deleteProduct(data.item.id)">Delete</b-link>
                </template>
            </b-table>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "Products",
    data(){
        return {
            items: [],
            fields: ['#', 'name', 'description', 'quantity', 'actions']
        }
    },
    created(){
        this.getProducts()
    },
    methods: {
        getProducts: function(){
            axios.get("/api/products")
            .then(res => {
                let products = res.data
                this.items = _.map(products, (product) => {
                    return {
                        id: product.id,
                        name: product.name,
                        description: product.description,
                        quantity: product.quantity
                    }
                })
            })
            .catch(error => {
                alert("There is an error: " + error.message)
            });
        },
        deleteProduct: function(productId){
            this.$swal({
                title: "Continue?",
                text: "The product will be deleted and cannot be undone",
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm: ()=>{
                    return axios.delete(`api/products/${productId}`)
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
                    this.$swal("Success", "Successfully deleted product", "success")
                    this.getProducts()
                }else{
                    this.$swal("Cancelled", "The request has been cancelled", "info")
                }
            })
            .catch(error => {
                this.$swal("Error", error, "error")
            })
        }
    }
}
</script>

<style scoped>

</style>
