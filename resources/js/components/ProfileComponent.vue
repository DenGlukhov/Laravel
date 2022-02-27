<template>
    <div>
        <div v-if="errors" class="alert alert-warning" role="alert">
            <div v-for="error in errors" :key="error.id">
                {{ $error }} 
            </div>
        </div>
        <input type="hidden" :value="currentUser.id" name="userId">
        <div class="mb-3">
            <label class="form-label">Изображение</label>
                <div class="image-block mb-2">
                    <img class='user-picture mb-2' ref="file" v-on:change="changeImage" :src="`/storage/${currentUser.picture}`">
                </div>        
            <input type="file" name="picture" class="form-control">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почта</label>
            <input v-model="userEmail" type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <!-- <div id="emailHelp" class="form-text">Мы не палим Вашу почту, честно :)</div> -->
        </div>
        <div class="mb-3"> 
            <label class="form-label">Имя</label>
            <input v-model="userName" name="name" class="form-control">
        </div>
        <div>
            <label class="form-label">Изменить пароль:</label>
            <input v-model="currentPassword" type="password" autocomplete="off" placeholder="Введите текущий пароль" name="current_password" class="form-control mb-2">
        </div>
        <div>
            <input v-model="newPassword" type="password" placeholder="Введите новый пароль" name="password" class="form-control mb-2">
        </div>
        <div>
            <input v-model="passwordConfirmation" type="password" placeholder="Повторите новый пароль" name="password_confirmation" class="form-control mb-2">
        </div>
        <div class="mb-3">
            <label class="form-label">Список адресов:</label>
            <ul v-if="!addresses.length">                
                <li>
                    <em>Адреса не указаны</em>
                </li>
            </ul>
            <ul v-else v-for="address in addresses" :key="address.id">
                <li>
                    <input v-model="picked" class="form-check-input" :id="address.id" name="address" type="radio" :value="address.id">
                    <label v-if="address.main" :for="`${address.id}`">
                        <font color="blue">
                            <b><i>{{address.address}}</i></b>
                        </font>
                    </label>
                    <label v-else :for="`${address.id}`">{{address.address}}</label>
                </li>
            </ul>
        </div>
        <div class="mb-3">
            <label class="form-label">Новый адрес</label>
            <input v-model="newAddress" name="new_address" class="form-control" placeholder="Введите новый адрес">
                <div class="form-check mt-1">
                    <input v-model="setMainAddress" name="set_main_address" class="form-check-input" type="checkbox" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Сделать адресом по-умолчанию
                    </label>
                </div>
        </div>
            <button @click="saveChanges" type="submit" class="btn btn-warning"><strong>Сохранить</strong></button>
            <br>
            <a class="btn btn-danger next_button mt-2" aria-current="page" :href="`${routeOrders}`">
                <strong>Мои заказы</strong>
            </a>
    </div>
</template>

<script>
export default {
    props: ['pageTitle', 'user', 'routeProfile', 'addresses', 'routeOrders', 'errors'],
    data () {
        return {
            file: '',
            currentUser: this.user,
            userName: this.user.name,
            userEmail: this.user.email,
            newPassword: '',
            currentPassword: this.user.password,
            passwordConfirmation: '',
            newAddress: '',
            setMainAddress: false,    
            picked: null,
        }
    },

    methods: {
       saveChanges() {
            const params = {
                name: this.userName,
                userId: this.user.id,
                email: this.userEmail,
                password: this.newPassword,
                current_password: this.currentPassword,
                password_confirmation: this.passwordConfirmation,
                new_address: this.newAddress,
                main_address: this.picked,
                set_main_address: this.setMainAddress,
            }
            axios.post(`/profile/save`, params)
            // .then(response => {
            //     this.currentUser = response.data
            // })
        },

    }
}
</script>

<style scoped>

</style>