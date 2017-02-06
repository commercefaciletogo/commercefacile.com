<template>
    <div class="ui link items">
        <div class="item" style="height: 20px;" v-for="category in categories" @click="handleClick(category)">
            <div class="ui mini image" style="width: 20px; height: 20px;">
                <img :src="category.icon">
            </div>
            <div class="middle aligned content" style="padding: 0 0 0 1em;" v-text="category.name"></div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default{
        data(){
            return{
                categories: []
            }
        },
        computed: {

        },
        methods: {
            fetchCategories(){
                axios.get('/categories')
                        .then(response => {
                            this.categories = response.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
            },
            handleClick(category){
                console.log('clicking');
                this.$emit('selected', category);
            }
        },
        components:{},
        mounted(){
            this.fetchCategories();
        }
    }
</script>
