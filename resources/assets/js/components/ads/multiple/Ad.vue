<template>
    <a :href="link" class="ui segment" style="padding: 0; box-shadow: none; border-radius: 0; border-right: 0; border-left: 0;">
        <div style="width: 322px; color: #1d305d;">
            <div class="ui container" style="background-color: #fcfcfd;">
                <div class="ui grid" style="margin: 0;">
                    <div class="column" style="padding: 0; width: 100px !important;">
                        <img class="ui image" v-lazy="path" alt="">
                    </div>
                    <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                        <div class="row title" style="font-size: 1.5em;">
                            <span v-text="title"/>
                        </div>
                        <div class="row price" style="font-size: 1.2em;" v-text="price"></div>
                        <div class="row description" style="color: #77829d; font-size: .9em;">
                            <img style="width: 15px;" class="ui mini spaced image" src="/img/icons/user_outline.png"><span>{{ name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>

<style>

</style>

<script>
    export default{
        data(){
            return{

            }
        },
        props: ['ad'],
        computed: {
            title(){
                return this.ad.title;
            },
            price(){
                return `${this.ad.price} FCFA`;
            },
            path(){
                return this.ad.image;
            },
            name(){
                return this.ad.owner.name;
            },
            link(){
                return `${window.singleAdUrl}/${this.ad.uuid}`;
            }
        },
        methods: {
            view(){
                let url = `${window.singleAdUrl}/${this.ad.uuid}`;
                window.location = url;
            }
        },
        mounted(){
            console.log('~')
        }
    }
</script>
