<template>
    <b-form @submit.stop.prevent="onSubmit">
        <b-form-group label="Product Name">
            <b-form-input
                id="name"
                name="name"
                v-model="$v.form.name.$model"
                :state="validateState('name')"
                aria-describedby="name-live-feedback"></b-form-input>
            <b-form-invalid-feedback id="name-live-feedback">This is a required field.</b-form-invalid-feedback>
        </b-form-group>

        <b-form-group label="Product Description">
            <b-form-textarea
                id="description"
                name="description"
                rows="4"
                v-model="$v.form.description.$model"
                :state="validateState('description')"
                aria-describedby="description-live-feedback"></b-form-textarea>
            <b-form-invalid-feedback id="description-live-feedback">This is a required field.</b-form-invalid-feedback>
        </b-form-group>

        <b-form-group label="Quantity">
            <b-form-input
                id="quantity"
                name="quantity"
                type="number"
                v-model="$v.form.quantity.$model"
                :state="validateState('quantity')"
                aria-describedby="quantity-live-feedback"></b-form-input>
            <b-form-invalid-feedback id="quantity-live-feedback">This is a required field, has to be an integer and must be greater than 0.</b-form-invalid-feedback>
        </b-form-group>

        <b-form-group>
            <label>Supplier&nbsp;&nbsp;<b-link @click="toggleAddSupplier()"><b-icon-person-plus>Add Supplier</b-icon-person-plus>&nbsp;<span v-if="!showSupplierForm">Add New Supplier</span><span v-else>Close Form</span></b-link></label>
            <supplier-form v-if="showSupplierForm" @completed="onSupplierAdded"></supplier-form>
            <v-select
                :options="suppliers"
                label="name"
                v-model="$v.form.supplier.$model" multiple></v-select>
            <span class="text-danger text-sm" v-if="$v.form.supplier.$error" id="input-live-help">This is a required field.</span>
        </b-form-group>

        <b-button type="submit" :state="!submitting">Submit</b-button>
        <router-link :to="{name: 'products'}">Cancel</router-link>
    </b-form>
</template>

<script>
import SupplierForm from "./SupplierForm";
import { required, numeric } from "vuelidate/lib/validators";
export default {
    name: "ProductForm",
    props: {
        'value': { type: null, default: null },
        type: { type: String, default: "new" },
        id: { type: Number, default: 0 }
    },
    components: { SupplierForm },
    data(){
        return {
            suppliers: [],
            submitting: false,
            showSupplierForm: false,
            form: {
                name: "",
                description: "",
                quantity: "",
                supplier: ""
            }
        }
    },
    validations: {
        form: {
            name: { required },
            description: { required },
            quantity: {
                required,
                numeric
            },
            supplier: {
                required
            }
        }
    },
    created(){
        this.getSuppliers()
        if (this.id !== 0){
            this.getProductDetails(this.id)
        }
    },
    methods: {
        getSuppliers: function(){
            axios.get("/api/suppliers")
                .then(res => {
                    this.suppliers = res.data
                });
        },
        getProductDetails(id){
            axios.get(`/api/products/${id}`)
            .then(res => {
                this.form.name = res.data.name
                this.form.quantity = res.data.quantity
                this.form.description = res.data.description
                this.form.supplier = _.map(res.data.suppliers, (supplier) => {
                    return {
                        id: supplier.id,
                        name: supplier.name
                    }
                })
            })
        },
        toggleAddSupplier: function(){
            return this.showSupplierForm = !this.showSupplierForm
        },
        onSupplierAdded: function(supplier){
            this.suppliers.push(supplier)
            this.form.supplier = supplier
            this.toggleAddSupplier()
        },
        validateState(name) {
            const { $dirty, $error } = this.$v.form[name];
            return $dirty ? !$error : null;
        },
        onSubmit: function(){
            //    Validate data
            this.$v.form.$touch();
            if (!this.$v.form.$anyError) {
                this.submitting = true
                let _this = this
                this.$swal({
                    title: "Continue?",
                    message: "This will add the product to the database",
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        if(_this.id === 0) {
                            return axios.post("/api/products", _this.form)
                                .then(res => {
                                    _this.submitting = false
                                    return res.data
                                    // this.$swal("Success", "Successfully added the product")
                                })
                                .catch(error => {
                                    _this.submitting = false
                                    throw new Error(error.message)
                                    // this.$swal("Oops... Something went wrong", error.message, "error")
                                });
                        }else{
                            return axios.put(`/api/products/${_this.id}`, _this.form)
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
                            var statement = (_this.id === 0) ? "Successfully added the product" : "Successfully edited the product"
                            this.$swal("Success", statement, "success")
                                .then(()=> {
                                    _this.$router.push({name: 'products'})
                                })
                        }else{
                            this.$swal("Oops... Something went wrong", "There was an error with your request", "error")
                        }
                    })
            }
            else{
                return;
            }
        }
    }
}
</script>

<style scoped>

</style>
