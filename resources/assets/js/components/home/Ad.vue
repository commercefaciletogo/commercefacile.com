<template>
    <div style="width: 400px; color: #1d305d; display: inline-block; margin-right: .5em;">
        <div class="ui container" style="background-color: #e8eaee;">
            <div class="ui grid">
                <div class="column" style="padding: 0; width: 150px !important;">
                    <!--<img class="ui small image" src="" alt="">-->
                    <vue-img-loader src=""
                                    width="150"
                                    height="150"
                                    center-type="contain"
                                    background-color="#e8eaee"></vue-img-loader>
                </div>
                <div class="column"  style="
                                    width: 222px !important;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;
                                ">
                    <div class="row title" style="font-size: 1.5em;">
                        <span>USB light</span>
                    </div>
                    <div class="row description">
                        <span>usb light description</span>
                    </div>
                    <div class="row price" style="font-size: 2em; font-weight: bold;">
                        350 ghc
                    </div>
                    <div class="row action">
                        <button class="ui button mini">buy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import axios from 'axios';
    import { VueImgLoader } from 'vue-img-loader';

    export default{
        data(){
            return{

            }
        },
        components: {
            'vue-img-loader': VueImgLoader
        },
        props: ['data'],
        methods: {
            viewAd(){

            }
        },
        mounted(){}
    }
</script>
