<style scoped>
    .item.header, .ui.dividing.header{
        color: #1d305d;
        cursor: default !important;
    }
    .ui.dividing.header{
        cursor: pointer !important;
    }
</style>

<template>
    <div>
        <h5 class="ui dividing header" style="font-weight: normal; margin-bottom: 0" @click="goBack"><i class="mini angle left icon"></i> {{ parent.name }} </h5>
        <div class="ui link items" style="margin-top: .5em;">
            <div class="item" style="height: 20px;" v-for="item in subs" @click="handleClick(item)">
                <div class="ui mini image" style="width: 15px; height: 15px;"> <i class="right triangle icon"></i></div>
                <div class="middle aligned content" style="padding: 0 0 0 16px; margin-bottom: 5px;" v-text="item.name"></div>
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
        props: ['subs', 'parent', 'goBackLabel', 'type'],
        methods:{
            handleClick(item){
                this.$emit('selected', {item: item, type: this.type, parent: false});
            },
            goBack(){
                this.$emit('back', this.type);
            }
        }
    }
</script>
