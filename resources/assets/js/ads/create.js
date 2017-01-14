import Vue from 'vue';
import _ from 'lodash';
import ImagePreview from '../components/ads/create/ImagePreview.vue';

const imageInput = document.querySelector('input[type="file"]');
const imagesPreview = document.querySelector('div.ui.tiny.images');

new Vue({
    el: 'div#main',
    data: {
        newAd: {
            title: '',
            category: '',
            description: '',
            photos: [],
            price: {
                amount: '',
                negotiable: true
            }
        },
        user: {
            name: '',
            location: '',
            email: '',
            phoneNumber: ''
        }
    },
    components: {
        'image-preview': ImagePreview
    },
    methods: {
        ReorderImages(event){
            this.newAd.photos.splice(event.newIndex, 0, this.newAd.photos.splice(event.oldIndex, 1)[0])
        },
        addImage(event){
            const input = event.target;

            if(input.files && input.files[0]){
                this.newAd.photos.push(input.files[0]);
                this.newAd.photos = _.uniqBy(this.newAd.photos, 'name');
            }
        },
        removeImage(name){
            this.newAd.photos = _.reject(this.newAd.photos, {'name': name});
        }
    },
    mounted(){
    },
    events: {
    }
});