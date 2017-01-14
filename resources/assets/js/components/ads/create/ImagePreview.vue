<template>
    <div class="ui image">
        <a class="floating ui red label circular tiny" @click="remove">
            x
        </a>
        <img :src="image">
    </div>
</template>

<script>
    export default{
        data(){
            return{
            }
        },
        computed: {
            image(){
                return URL.createObjectURL(this.src);
            }
        },
        props: ['src'],
        methods: {
            remove(){
                this.$emit('remove', this.src.name);
            }
        },
        mounted(){
        }
    }
</script>
