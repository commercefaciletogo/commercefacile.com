import _ from 'lodash';
import axios from 'axios';
import Vue from 'vue';
import Echo from 'laravel-echo';
import Notify from 'izitoast';

import Categories from '../components/ads/create/Categories.vue';
import ImagePreview from '../components/ads/create/ImagePreview.vue';
import OptionItem from '../components/ads/create/OptionItem.vue';
import SubCategories from '../components/ads/create/SubCategories.vue';

let csrf = document.querySelector("meta[name=csrf-token]").content;
// let authorUuid = document.querySelector("meta[name=author-uuid]").content;
console.log(`require location -> ${!!window.requireLocation}`);
console.log(`author id -> ${window.authorId}`);

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

new Vue({
    el: 'div#main',
    data: {
        submitting: false,
        categories: [],
        locations: [],
        selectedCategory: {},
        selectedSubCategory: {},
        newAd: {
            title: '',
            category: {
                id: '',
                text: ''
            },
            description: '',
            condition: 1,
            photos: [],
            price: {
                amount: '',
                negotiable: true
            }
        },
        errors: {
            title: false,
            category: false,
            description: false,
            images: false,
            price: false,
            location: false
        },
        user: {
            location: {
                text: '',
                id: ''
            },
        },
        moreImageDefaultStyle: 'ui tiny compact button inp act'
    },
    computed: {
        moreImage() {
            if (this.newAd.photos.length === 4) return false;
            return true;
        }
    },
    components: {
        'image-preview': ImagePreview,
        'categories': Categories,
        'sub-categories': SubCategories,
        'option-item' : OptionItem
    },
    methods: {
        submit(){
            this.submitting = true;
            this.errors.title = _.trim(this.newAd.title).length < 5;
            this.errors.category = !_.isNumber(this.newAd.category.id);
            this.errors.description = _.trim(this.newAd.description).length < 20;
            let imagesSize = _.reduce(this.newAd.photos, (totalSize, photo) => {
                return totalSize + photo.size;
            }, 0);
            console.log(`total size -> ${imagesSize} && ${this.newAd.photos.length < 1 || imagesSize > 5000000}`);
            this.errors.images = this.newAd.photos.length < 1 || imagesSize > 5000000;
            this.errors.price = !_.isNumber(this.newAd.price.amount);

            if(window.requireLocation){
                this.errors.location = !_.isNumber(this.user.location.id);
            }

            if(_.includes(_.values(this.errors), true)) return this.submitting = false;

            let data = new FormData;
            data.append('title', this.newAd.title);
            data.append('category_id', this.newAd.category.id);
            data.append('condition', this.newAd.condition);
            data.append('description', this.newAd.description);
            data.append('price', this.newAd.price.amount);
            data.append('negotiable', this.newAd.price.negotiable);
            if(window.requireLocation){
                data.append('location_id', this.user.location.id);
            }
            data.append('_token', csrf);
            data.append('image_length', this.newAd.photos.length);
            _.forEach(this.newAd.photos, (photo, i) => data.append(`image_${i + 1}`, photo.file));

            axios.post(window.postAdUrl, data).then(res => {
                if(res.data.done){
                    window.location = window.profileUrl;
                }
            }).catch(error => {
                this.submitting = false;
                console.log(error.response);
            });

            console.log(data);
        },
        ReorderImages(event){
            this.newAd.photos.splice(event.newIndex, 0, this.newAd.photos.splice(event.oldIndex, 1)[0])
        },
        addImage(event){
            const input = event.target;

            if(input.files && input.files[0]){
                this.newAd.photos.push({
                    id: input.files[0].name,
                    file: input.files[0]
                });
                this.newAd.photos = _.uniqBy(this.newAd.photos, 'id');
            }
        },
        removeImage(id){
            this.newAd.photos = _.reject(this.newAd.photos, {'id': id});
        },
        chooseCategory(e){

        },
        fetchSub(category){
            this.selectedCategory = category;
        },
        fetchCategories(){
            axios.get(window.categoriesUrl)
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        fetchLocations(){
            axios.get(window.locationsUrl)
                .then(response => {
                    this.locations = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        closeCategoryModal({id, name}){
            this.selectedSubCategory = {id, name};
            this.newAd.category.text = `${name}`;
            this.newAd.category.id = id;
            $('#chooseCategory').remodal().close();
        },
        closeLocationModal({id, name}) {
            this.user.location.id = id;
            this.user.location.text = name;
            $('#chooseLocation').remodal().close();
        }
    },
    mounted(){

        window.Echo.channel(`author.${window.authorId}`)
            .listen('.AdWasSubmitted', e => {
                console.log(e);
                this.submitting = false;
                window.location = window.profileUrl;
            });

        $('#chooseCategory').accordion();

        $('#chooseLocation').accordion();

        this.fetchCategories();
        this.fetchLocations();
    }
});