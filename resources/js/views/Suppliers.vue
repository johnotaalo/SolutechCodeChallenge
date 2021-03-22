<template>
    <b-card>
        <template #header>
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-header-title"><b-icon-people></b-icon-people>&nbsp;Suppliers</h4>
                </div>
                <div class="col-auto">
                    <router-link :to="{name: 'add-supplier'}" class="btn btn-sm btn-primary">Add Supplier</router-link>
                </div>
            </div>
        </template>

        <b-table bordered striped hover :items="items" :fields="fields">
            <template #cell(#)="data">
                {{ data.index + 1 }}
            </template>
            <template #cell(created)="data">
                {{ data.item.created | moment("DD-MM-YYYY") }}
            </template>

            <template #cell(products)="data">
                <b-link @click="showProductsModal(data.item.products)">({{ data.item.products.length }}) Products</b-link>
            </template>
            <template #cell(actions)="data">
                <router-link :to="{name: 'edit-supplier', params: {supplierId: data.item.id}}">Edit</router-link> | <b-link @click="deleteSupplier(data.item.id)">Delete</b-link>
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
    name: "Suppliers",
    data(){
        return {
            items: [],
            fields: ["#", "name", "products", "created", "actions"],
            selectedProducts: []
        }
    },
    created(){
        this.getSuppliers()
    },
    methods: {
        getSuppliers: function(){
            axios.get("/api/suppliers")
            .then(res => {
                this.items = _.map(res.data, (item) => {
                    return {
                        id: item.id,
                        name: item.name,
                        created: item.created_at,
                        products: item.products
                    }
                })
            });
        },
        deleteSupplier: function(supplierId){
            this.$swal({
                title: "Continue?",
                text: "The supplier will be deleted and cannot be undone",
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm: ()=>{
                    return axios.delete(`api/suppliers/${supplierId}`)
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
                        this.$swal("Success", "Successfully deleted supplier", "success")
                        this.getSuppliers()
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
            if(products.length > 0) {
                this.$refs['products-modal'].show()
            }else{
                this.$swal("", "There are no products to view", "info");
            }
        }
    }
}
</script>

<style scoped>

</style>
