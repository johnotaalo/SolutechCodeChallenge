<template>
    <b-card header="Edit Product">
        <product-form type="edit" :id="id"></product-form>
    </b-card>
</template>

<script>
import ProductForm from "../components/ProductForm";
export default {
    name: "EditProduct",
    components: { ProductForm },
    data(){
        return {
            id: 0
        }
    },
    created(){
        this.id = parseInt(this.$route.params.productId)
    }
}
</script>

<style scoped>

</style>
