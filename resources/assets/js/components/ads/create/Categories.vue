<template>
    <div class="ui middle aligned animated relaxed divided list link">
        <div v-for="category in categories" :key="cateory.id" class="item" @click="select(category)">
            <img class="ui avatar image" src="/img/placeholder.png">
            <div class="content">
                <a class="header" v-text="category.name"></a>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import axios from 'axios';

    export default{
        data(){
            return{
                categories: [],
                selectedCategory: {}
            }
        },
        methods: {
            fetchCategories(){
                axios.get('/categories')
                        .then(response => {
                            this.categories = response.data;
                            this.selectedCategory = this.categories[0];
                            this.$emit('selected', this.selectedCategory);
                        })
                        .catch(error => {
                        });
            },
            select(category){
                this.selectedCategory = category;
                this.$emit('selected', category);
            }
        },
        mounted(){
            this.fetchCategories();
        }
    }
</script>
