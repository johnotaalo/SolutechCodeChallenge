<template>
    <div>
        <b-form-group label="Supplier Name">
            <b-input-group size="sm">
                <b-form-input v-model="supplierName"></b-form-input>
                <b-input-group-append>
                    <b-button variant="outline-success" @click="submitSupplier"><b-icon-plus v-if="id === 0"></b-icon-plus><b-icon-pen v-else></b-icon-pen>&nbsp;{{ buttonText }}</b-button>
                </b-input-group-append>
            </b-input-group>
        </b-form-group>
    </div>
</template>

<script>
export default {
    name: "SupplierForm",
    props: {
        'value': { type: null, default: null },
        id: { type: Number, default: 0 }
    },
    data(){
      return {
          loading: false,
          supplierName: "",
          buttonText: "Add Supplier"
      }
    },
    created(){
        if(this.id !== 0){
            this.buttonText = "Edit Supplier"
            this.getSupplier(this.id)
        }
    },
    methods: {
        submitSupplier: function(){
            if (this.supplierName){
                this.loading = true
                if(this.id === 0) {
                    axios.post("/api/suppliers", {name: this.supplierName})
                        .then(res => {
                            this.loading = false
                            this.$emit("completed", res.data)
                        })
                        .catch(error => {
                            this.loading = false
                            this.$swal("Error", error.message, "error")
                        })
                }else{
                    axios.put(`/api/suppliers/${this.id}`, {name: this.supplierName})
                        .then(res => {
                            this.loading = false
                            this.$emit("completed", res.data)
                        })
                        .catch(error => {
                            this.loading = false
                            this.$swal("Error", error.message, "error")
                        })
                }
            }else{
                alert("Please input a supplier name");
            }
        },
        getSupplier: function (supplierId) {
            axios.get(`/api/suppliers/${supplierId}`)
            .then(res => {
                this.supplierName = res.data.name
            })
            .catch(error => {
                this.$swal("Error", error.message, "error")
            })
        }
    }
}
</script>

<style scoped>

</style>
