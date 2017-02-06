<template>
    <div>
        <h5 class="ui dividing header" style="font-weight: normal; margin-bottom: 0" @click="goBack"><i class="mini angle left icon"></i> All Categories</h5>
        <div class="ui link items" style="margin-top: .5em;">
            <div class="item" style="height: 20px;" @click="handleClick(parent)">
                <div class="ui mini image" style="width: 20px; height: 20px;">
                    <img :src="parent.icon">
                </div>
                <div class="middle aligned content" style="padding: 0 0 0 1em;" v-text="parent.name"></div>
            </div>
            <div class="item" style="height: 20px;" v-for="category in subs" @click="handleClick(category)">
                <div class="ui mini image" style="width: 20px; height: 20px;"></div>
                <div class="middle aligned content" style="padding: 0 0 0 1em;" v-text="category.name"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{

            }
        },
        props: ['subs', 'parent'],
        methods:{
            handleClick(category){
                this.$emit('selected', category);
            },
            goBack(){
                this.$emit('back');
            }
        },
        mounted(){

        }
    }
</script>
