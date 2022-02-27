<template>
    <div class="col-3 mb-4 mt-4">
        <div  class="category-card card text-center" style="width: 18rem; height: 430px;">
            <div class="text-center" style="height: 280px; width: 280px; overflow: hidden; vertical-align: middle; display: block; margin-left: auto; margin-right: auto;">
                <img :src="`/storage/${category.picture}`" style="height: 270px; margin-top: 7px; border-radius: 5px;" :alt="category.name">
            </div>
                <div class="mt-2" style="height: 70px">
                    <h5 class="card-title" :title="category.name">
                        {{ category.name }}
                    </h5>
                    <p class="card-text clip" :title="category.description">
                        {{ category.description }}
                    </p>
                </div>
                    <div class="text-center">
                        <a :href="`${routeCategory}/${category.id}`" class="btn btn-primary" style="width: 260px">Перейти</a>
                        <button @click="buttonClicked" class="btn btn-link">Click</button>
                    </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['category', 'routeCategory'],
        methods: {
            buttonClicked() {
                this.$emit('buttonClicked', this.category.id)
            }
        }
    }
</script>
<style scoped>
.clip {
        overflow: hidden;
        text-overflow: ellipsis; 
        white-space: nowrap; 
        padding: 10px; 
    }
</style>
