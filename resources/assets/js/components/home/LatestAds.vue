<template>
    <div>
        <p  style="font-size: 1.5em; color: #1d305d;">
            Latest Ads
        </p>
        <div class="ui segments" style="
                        border: 0;
                        box-shadow: none;
                        border-radius: 0;
                    ">
            <ad-row v-for="category in categories" category="category.name"></ad-row>
        </div>
    </div>
</template>

<style>

</style>

<script type="text/babel">
    import AdRow from 'AdRow.vue';
    import axios from 'axios';

    export default{
        data(){
            return{
                categories: []
            }
        },
        components : {
            'ad-row' : AdRow
        },
        methods: {
            fetchTopCategories(){

            }
        },
        mounted(){

        }
    }
</script>
