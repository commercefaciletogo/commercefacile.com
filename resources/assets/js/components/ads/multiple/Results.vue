<template>
    <div>
        <ad-item v-for="ad in ads" :ad="ad" :key="ad.id"></ad-item>
    </div>
</template>
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
