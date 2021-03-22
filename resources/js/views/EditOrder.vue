<template>
    <b-card title="Edit Order">
        <order-form :id="orderId"></order-form>
    </b-card>
</template>

<script>
import OrderForm from "../components/OrderForm";
export default {
    name: "EditOrder",
    components: { OrderForm },
    data(){
        return {
            orderId: 0
        }
    },
    created(){
        this.orderId = this.$route.params.orderId
    }
}
</script>

<style scoped>

</style>
