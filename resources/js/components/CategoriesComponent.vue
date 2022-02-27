<template>
    <div class="row">
        <category-component
            v-for="category in categories" 
            :key="category.id"
            :category="category"
            :route-category="routeCategory"
            @buttonClicked="buttonClicked"
        >
        </category-component>
    </div>
</template>

<script>
    import categoryComponent from './CategoryComponent.vue'
    export default {
        props: ['test', 'pageTitle', 'categories', 'routeCategory'],
        components: {categoryComponent},
        methods: {
            buttonClicked(data) {
                console.log(`Click из дочернего компонента (${data})`)
            }
        },
        mounted() {
            console.log(this.categories)
        }

    }
</script>

<style scoped>

</style>