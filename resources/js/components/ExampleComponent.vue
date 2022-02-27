<template>
    <div>
        Example Text 
        <br>
        {{ name }}
        <br>
        <button v-on:click="counterPlus" class="btn btn-info">Click {{ counter }}</button>
        <br>
        <span v-if="counter < 10">Значение счетчика меньше 10</span>
        <span v-else>Значение счетчика больше или равно 10</span>     
        <br>
        <button @click="showPicture = !showPicture" class="btn btn-warning">Переключатель</button>   
        <img v-if="showPicture" style="width: 200px" src="https://www.sbras.info/system/files/image/photo_pubrec/7036/2016-05-05/22-kosmos-oboi-kartinki-foto-1920x1080.jpg">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Категория</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(category, index) in categories" :key="category.id">
                    <td>{{ index +1 }}</td>
                    <td>
                        <a :href="`/category/${category.id}`">{{ category.name }}</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <button @click="addCategory" class="btn btn-primary">Добавить категорию</button>
        <br>
        {{ fullName }}
        <br>
        <input v-model="inputText" @input="listenInput" class="form-control">
        <br>
        <input v-model="text" class="form-control">
        <br>
        {{ reversedText }}
        <br>
        <select v-model="selected" @change="selectChanged" class="form-control mb-2">
            <option :value="null" selected disabled>-Выберите значение-</option>
            <option v-for="(option, idx) in options" :value="option" :key="idx">
                {{ option }}
            </option>
        </select>
        <button :disabled="!selected" class="btn mt-5" :class="buttonClass">Save</button>
        <br>
        <button @click="getData" class="btn btn-primary">Получить данные</button>
        <br>
        <table class="table table-bordered">
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                </tr>
                <tr v-if="!users.length">
                    <td class='text-center' colspan="3">
                        <em>
                            Данные пока не получены
                        </em>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                options: [1, 2, 3],
                selected: null,
                inputText: '',
                text: '',
                name: "Den",
                lastName: "Glukhov",
                counter: 0,
                showPicture: true,
                categories: [
                    {
                        id: 3,
                        name: 'Видеокарты'
                    },
                    {
                        id: 4,
                        name: 'Процессоры'
                    },
                    {
                        id: 10,
                        name: 'Оперативная память'
                    }
                ]
            }
        },
        watch: {
            selected: function(newValue, oldValue) {
                console.log(`Новое значение: ${newValue}, Старое значение: ${oldValue}`)
            }
        },
        computed: {
            buttonClass() {
                return this.selected ? 'btn-primary' : 'btn-danger'
            },
            fullName() {
                return this.name + " " + this.lastName
            },
            reversedText() {
                return this.text.split('').reverse().join('')
            }
        },
        methods: {
            getData() {
                const params = {
                    id: 1
                }
                axios.get('/api/test', {params})
                    .then(responce => {
                        this.users = responce.data
                    })
            },
            selectChanged() {
                console.log(this.selected)
            },
            listenInput() {
                console.log(this.inputText)
            },
            addCategory() {
                this.categories.push({
                    id: 9,
                    name: 'Жесткие диски'
                })
            },
            counterPlus () {
                this.counter += 1
            }
        },
        mounted() {
            console.log('Example component mounted.')
        }
    }
</script>

<style scoped>

</style>