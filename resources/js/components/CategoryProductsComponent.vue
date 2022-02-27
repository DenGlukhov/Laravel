<template>
    <div class="row" :class="{'spinner-centered' : !products.length}">
        <div v-if="!products.length" class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <product-component 
            v-else
            v-for="product in products"
            :key="product.id"
            :product="product">
        </product-component>
    </div>
</template>

<script>
import ProductComponent from './ProductComponent.vue'

export default {
    props: ['category'],
    components: {ProductComponent},
    data() {
        return {
            products: []
        }
    },
    mounted() {
        axios.get(`/category/${this.category}/getProducts`)
        .then(responce => {
            this.products = responce.data
        })
    }
}
</script>

<style scoped>
    .spinner-centered {
        justify-content: space-around;
    }
</style>