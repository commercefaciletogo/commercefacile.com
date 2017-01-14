<template>
    <div class="ui segment" style="
        padding-top: 0;
        border: 0;
        box-shadow: none;
        border-radius: 0;
    ">
        <p style="font-size: 1.2em; color: #4a597d;">Electronics</p>
        <ad v-for="ad in ads" data="ad"></ad>
    </div>
</template>

<script type="text/babel">
    import Ad from 'Ad.vue';
    import axios from 'axios';

    export default{
        data(){
            return{
                ads: []
            }
        },
        props: ['category', 'category_id'],
        methods: {
            fetchLastestAds($category_id){}
        },
        components : {
            'ad' : Ad
        },
        mounted(){}
    }
</script>
