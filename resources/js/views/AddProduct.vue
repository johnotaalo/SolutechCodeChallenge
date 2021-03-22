<template>
    <div>
        <b-card header="Add Product">
            <product-form type="new"></product-form>
        </b-card>
    </div>
</template>

<script>
import ProductForm from "../components/ProductForm"
export default {
    name: "AddProduct",
    components: { ProductForm }
}
</script>

<style scoped>

</style>
