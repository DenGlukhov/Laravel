<template>
    <div>
        <div v-if="errors.length" class="alert alert-warning" role="alert">
            <span v-for="(error, idx) in errors" :key="idx">{{ error }}<br></span>
        </div>
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, idx) in products" :key="product.id">
                    <td class="text-center">{{ idx + 1 }}</td>
                    <td class="text-center">{{ product.name }}</td>
                    <td class="text-center">{{ product.price }} руб.</td>
                    <td class="product-buttons">
                        <button @click="cartAction('addTo', product.id)" class="btn btn-success">+</button>
                        {{ product.quantity }}
                        <button @click="cartAction('removeFrom', product.id)" class="btn btn-danger">-</button>
                    </td>
                    <td class="text-center">{{ Number(product.price * product.quantity).toFixed(2) }}</td>
                </tr>
                <tr v-if="!products.length">
                    <td class="text-center" colspan="5">Здесь пока ничего нет, но можно это <a href="/">исправить</a></td>
                </tr>
                <tr>
                    <td class="text-end" colspan="4">Итого:</td>
                    <td class="text-center"><strong>{{ Number(summ).toFixed(2) }} руб.</strong></td> <!-- toFixed(2) приводит значение после запятой к 2-м знакам -->
                </tr>
            </tbody>
        </table>
        <label>Ваше имя</label>
            <input class="form-control mb-2" name="name" v-model="userName">
        <label>Ваш email</label>
            <input class="form-control mb-2" name="email" v-model="userEmail">
        <label>Ваш адрес</label>
            <input class="form-control mb-2" name="address" v-model="userAddress">
        <template v-if="!userName">
            <input id="register_confirmation" name="register_confirmation" type="checkbox" >
            <label for="register_confirmation" class="mb-2">Вы будете автоматически зарегистрированы в системе</label>
            <br>
        </template>
            <button v-if="loading" class="btn btn-warning" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Оформляем заказ...
            </button>
            <button v-else @click="createOrder" type="submit" class="btn btn-warning">Оформить заказ</button>
    </div>
</template>

<script>
export default {
    props: ['prods', 'user', 'address'],
    
    data() {
        return {
            products: this.prods,
            errors: [],
            loading: false,
            userName: null,
            userEmail: null,
            userAddress: null
        }
    },

    computed: {
        summ() {
            return this.products.reduce((sum, product) => {
                return sum += product.price * product.quantity
            }, 0)
        }
    },
    methods: {
        cartAction(type, id) {
            const params = {
                id
            }
            axios.post(`/cart/${type}Cart`, params)
            .then((response) => {
                const index = this.products.findIndex((product) => {
                    return product.id == id
                })
                if (response.data > 0) {
                    this.products[index].quantity = response.data
                } else {
                    this.products.splice(index, 1)
                }
                
            })
            
        },
        createOrder() {
            this.loading = true
            this.errors = []
            const params = {
                name: this.userName,
                email: this.userEmail,
                address: this.userAddress
            }
            axios.post(`/cart/createOrder`, params)
            .then(() => {
                document.location.href = '/profile/orders'
            })
            .catch(error => {
                const errors = error.response.data.errors
                for (let err in errors ){
                    errors[err].forEach(e => {
                        this.errors.push(e)
                    })
                }
            })
            .finally(() => {
                this.loadnig = false
            })
        }
    },
     mounted () {
        if (this.user) {
            this.userName = this.user.name
            this.userEmail = this.user.email
        }
        if (this.address) {
            this.userAddress = this.address
        }
    }

}
</script>

<style scoped>

</style>