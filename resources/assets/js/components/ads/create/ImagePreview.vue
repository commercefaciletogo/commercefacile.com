<template>
    <div class="ui image">
        <a class="floating ui red label circular tiny" @click="remove">
            x
        </a>
        <img :src="image" :id="src.id">
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
                return URL.createObjectURL(this.src.file);
            }
        },
        props: ['src'],
        methods: {
            remove(){
                this.$emit('remove', this.src.id);
            }
        },
        mounted(){
        }
    }
</script>
