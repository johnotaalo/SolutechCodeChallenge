<template>
    <b-card title="Add Supplier">
        <supplier-form @completed="onSupplierAdded"></supplier-form>

        <b-link class="mt-5" :to="{name: 'suppliers'}">Cancel</b-link>
    </b-card>
</template>

<script>
import SupplierForm from "../components/SupplierForm";
export default {
    name: "AddSupplier",
    components: { SupplierForm },
    data(){
        return {

        }
    },
    created(){

    },
    methods: {
        onSupplierAdded: function(){
            this.$swal("Success", "Successfully added supplier", "success")
            .then(() => {
                this.$router.push({name: 'suppliers'})
            });
        }
    }
}
</script>

<style scoped>

</style>
