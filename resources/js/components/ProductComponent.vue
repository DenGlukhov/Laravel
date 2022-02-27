<template>
    <div class="col-3">
        <div class="card mb-4" style="width: 18rem">
            <img :src="`/storage/${product.picture}`" class="card-img-top" :alt="product.name">
            <div class="card-body">
                <h5 class="card-title clip" :title="product.name">
                    {{ product.name }}
                </h5>
                <p class="card-text clip" :title="product.description">
                    {{ product.description }}
                </p>
                <div class="product-price">
                    {{ product.price }} руб.
                </div>
                <div class="product-buttons">
                    <button @click="cartAction('addTo')" class="btn btn-success">+</button>
                        {{ cartQuantity }}
                    <button v-if="cartQuantity" @click="cartAction('removeFrom')" class="btn btn-danger">-</button>
                    <button v-else disabled class="btn btn-danger">-</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['product'],
    data() {
        return {
            cartQuantity: this.product.quantity
        }
    },
    methods: {
        cartAction(type) {
            const params = {
                id: this.product.id
            }
            axios.post(`/cart/${type}Cart`, params)
            .then(response => {
                this.cartQuantity = response.data
            })
        }
    },
}
</script>

<style scoped>
    .product-price {
        font-size: 23px;
        text-align: center;
        margin-bottom: 10px;
    }
    .card-text {
        height: 46px;
    }
    .card-title {
        height: 22px;
    }
    .card-image {
        overflow: hidden; /* Обрезаем все, что не помещается в область */
        padding: 3px; /* Поля вокруг текста */
    }
    .clip {
        overflow: hidden; /* Обрезаем все, что не помещается в область */
        text-overflow: ellipsis; /* Добавляем многоточие */
        white-space: nowrap; /* Запрещаем перенос строк */
        padding: 3px; /* Поля вокруг текста */
    }
    .product-buttons {
        display: flex;
        justify-content: space-between;
        line-height: 37px;
    }
</style>