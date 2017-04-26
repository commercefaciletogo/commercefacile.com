<template>
    <div class="ui link items">
        <div class="item" style="height: 20px;" v-for="item in items" @click="handleClick(item)">
            <div class="ui mini image" style="width: 20px; height: 20px;">
                <img :src="item.icon">
            </div>
            <div class="middle aligned content" style="padding: 0 0 0 16px; margin-bottom: 5px;" v-text="item.name"></div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                
            }
        },
        props: ['items', 'type'],
        methods: {
            handleClick(item){
                this.$emit('selected', {item: item, type: this.type, parent: true});
            }
        },
        mounted(){
        }
    }
</script>
