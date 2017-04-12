<template>
    <div>
        <ad-item v-for="ad in ads" :ad="ad"></ad-item>
    </div>
</template>
<style>
    body{
        background-color:#ff0000;
    }
</style>
<script type="text/babel">
    import Ad from './Ad.vue';

    export default{
        data(){
            return{

            }
        },
        props: ['ads'],
        components:{
            'ad-item': Ad
        }
    }
</script>
