import Vue from 'vue';
import axios from 'axios';
import _ from 'lodash';


new Vue({
    el: '#main',
    data: {
        review: {
            title: null,
            category: null,
            condition: null,
            description: null,
            price: null,
            images: null
        }
    },
    computed: {
        disabled(){
            return _.includes(_.values(this.review), null);
        }
    },
    methods: {
        toggle(item, pass){
            this.review[item] = pass
        },
        commit(){
            let data = new FormData;
            data.append('title', this.review.title);
            data.append('category', this.review.category);
            data.append('condition', this.review.condition);
            data.append('price', this.review.price);
            data.append('images', this.review.images);

            axios.post(window.reviewAdApiUrl, data).then(rep => {
                if(rep.data.success){
                    window.location = window.adsUrl;
                }
            }).catch(error => {
                console.log(error.response);
            })
        }
    },
    mounted(){
        console.log('review ad mounted');
    }
});