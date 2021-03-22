<template>
    <b-form @submit.stop.prevent="onSubmit">
        <b-form-group label="Order Number">
            <b-form-input
                id="order_number"
                name="order_number"
                v-model="$v.form.order_number.$model"
                :state="validateState('order_number')"
                aria-describedby="order_number-live-feedback"></b-form-input>
            <b-form-invalid-feedback id="order_number-live-feedback">This is a required field.</b-form-invalid-feedback>
        </b-form-group>

        <b-form-group label="Product(s)">
            <v-select
                :options="products"
                v-model="$v.form.products.$model"
                multiple></v-select>
            <span class="text-danger text-sm" v-if="$v.form.products.$error" id="input-live-help">This is a required field.</span>
        </b-form-group>

        <b-button variant="primary" type="submit" :state="!submitting">Submit</b-button>
        <router-link :to="{name: 'orders'}">Cancel</router-link>
    </b-form>
</template>

<script>
import { required } from "vuelidate/lib/validators";
export default {
    name: "OrderForm",
    props: {
        "value" : { type: null, default: null },
        id : { type: Number, default: 0 }
    },
    data(){
        return {
            submitting: false,
            products: [],
            form: {
                order_number: "",
                products: []
            }
        }
    },
    created(){
        this.getProducts()
        if(this.id !== 0){
            this.getOrderDetails(this.id)
        }
    },
    validations: {
        form: {
            order_number: { required },
            products: { required }
        }
    },
    methods: {
        onSubmit: function(){
            this.$v.form.$touch();

            if (!this.$v.form.$anyError) {
                this.submitting = true
                let _this = this
                let message = (this.id === 0) ? "This will add the order to the database" : "This will update the order in the database"
                this.$swal({
                    title: "Continue?",
                    text: message,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        if(_this.id === 0) {
                            return axios.post("/api/orders", _this.form)
                                .then(res => {
                                    _this.submitting = false
                                    return res.data
                                })
                                .catch(error => {
                                    _this.submitting = false
                                    throw new Error(error.message)
                                });
                        }else{
                            return axios.put(`/api/orders/${_this.id}`, _this.form)
                                .then(res => {
                                    _this.submitting = false
                                    return res.data
                                })
                                .catch(error => {
                                    _this.submitting = false
                                    throw new Error(error.message)
                                });
                        }
                    }
                })
                    .then(result => {
                        if (result.isConfirmed){
                            var statement = (_this.id === 0) ? "Successfully added your order" : "Successfully updated your order"
                            this.$swal("Success", statement, "success")
                                .then(()=> {
                                    _this.$router.push({name: 'orders'})
                                })
                        }else{
                            this.$swal("Oops... Something went wrong", "There was an error with your request", "error")
                        }
                    })
            }
        },
        getProducts(){
            axios.get("/api/products")
            .then(res => {
                this.products = _.map(res.data, (product) => {
                    return {
                        label: product.name,
                        value: product.id
                    }
                })
            });
        },
        getOrderDetails: function (orderId){
            axios.get(`/api/orders/${orderId}`)
            .then(res => {
                this.form.order_number = res.data.order_number
                this.form.products = _.map(res.data.products, (product) => {
                    return {
                        label: product.name,
                        value: product.id
                    }
                })
            });
        },
        validateState(name) {
            const { $dirty, $error } = this.$v.form[name];
            return $dirty ? !$error : null;
        }
    }
}
</script>

<style scoped>

</style>
