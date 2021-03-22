<template>
    <b-card title="Edit Supplier">
        <supplier-form :id="supplierId" @completed="onSupplierAdded"></supplier-form>

        <b-link class="mt-5" :to="{name: 'suppliers'}">Cancel</b-link>
    </b-card>
</template>

<script>
import SupplierForm from "../components/SupplierForm";
export default {
    name: "EditSupplier",
    components: { SupplierForm },
    data(){
        return {
            supplierId: 0
        }
    },
    created(){
        this.supplierId = parseInt(this.$route.params.supplierId)
    },
    methods: {
        onSupplierAdded: function(){
            this.$swal("Success", "Successfully edited supplier", "success")
                .then(() => {
                    this.$router.push({name: 'suppliers'})
                });
        }
    }
}
</script>

<style scoped>

</style>
