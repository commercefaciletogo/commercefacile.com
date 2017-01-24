import _ from 'lodash';
import axios from 'axios';
import Vue from 'vue';

import Categories from '../components/ads/create/Categories.vue';
import CategoryItem from '../components/ads/create/CategoryMenuItem.vue';
import ImagePreview from '../components/ads/create/ImagePreview.vue';
import SubCategories from '../components/ads/create/SubCategories.vue';

new Vue({
    el: 'div#main',
    data: {
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
            photos: [],
            price: {
                amount: '',
                negotiable: true
            }
        },
        user: {
            name: '',
            location: {
                text: '',
                id: ''
            },
            email: '',
            phoneNumber: ''
        }
    },
    computed: {
        dropButtonName(){
            if(this.newAd.category.id){
                return 'Change';
            }
            return 'Choose';
        }
    },
    components: {
        'image-preview': ImagePreview,
        'categories': Categories,
        'sub-categories': SubCategories,
        'option-item' : CategoryItem
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
        },
        chooseCategory(e){
            console.log(e.target);
            $('.categories').modal('refresh').modal('show');
        },
        fetchSub(category){
            this.selectedCategory = category;
        },
        fetchCategories(){
            axios.get('/categories')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        fetchLocations(){
            axios.get('/locations')
                .then(response => {
                    this.locations = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        closeModal(subCategory){
            this.selectedSubCategory = subCategory;
            this.newAd.category.text = `${this.selectedCategory.name} > ${this.selectedSubCategory.name}`;
            this.newAd.category.subId = this.selectedSubCategory.id;
            $('.categories').modal('hide');
        },
        preview(){

        },
        submit(){}
    },
    created(){

    },
    mounted(){
        $('#selectCategory').dropdown({
            action: 'hide',
            onChange: function(value, text){
                this.newAd.category.text = text;
                this.newAd.category.id = value;
            }.bind(this)
        });

        $('#selectLocation').dropdown({
            action: 'hide',
            onChange: function(value, text){
                this.user.location.text = text;
                this.user.location.id = value;
            }.bind(this)
        });

        this.fetchCategories();
        this.fetchLocations();
    },
    events: {
    }
});