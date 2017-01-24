<template>
    <div class="ui middle aligned animated relaxed divided list link" style="padding: .4em;">
        <div v-for="category in categories" class="item" @click="select(category)" style="padding: .5em;">
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
                selectedSubCategory: {}
            }
        },
        props: ['categories'],
        methods: {
            select(category){
                this.selectedSubCategory = category;
                this.$emit('selected', category);
            }
        },
        mounted(){
        }
    }
</script>
