import _ from 'lodash';
import axios from 'axios';
import base64toblob from 'base64toblob';
import Notify from 'izitoast';
import Vue from 'vue';

import Categories from '../components/ads/create/Categories.vue';
import ImagePreview from '../components/ads/create/ImagePreview.vue';
import OptionItem from '../components/ads/create/OptionItem.vue';
import SubCategories from '../components/ads/create/SubCategories.vue';

let csrf = document.querySelector("meta[name=csrf-token]").content;

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
            compressedImages: [],
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
        moreImageDefaultStyle: 'ui tiny compact button inp act',
        currentUploadedFile: {},
        scale: 100,
        quality: 50,
        result: {},
        reader: {}
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
            this.errors.images = this.newAd.photos.length < 1 || imagesSize > 5000000;
            this.errors.price = _.isNaN(Number.parseInt(this.newAd.price.amount));

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
            data.append('image_length', this.newAd.compressedImages.length);
            _.forEach(this.newAd.compressedImages, (photo, i) => data.append(`image_${i + 1}`, photo.file));

            axios.post(window.postAdUrl, data).then(res => {
                if(res.data.done){
                    window.location = window.profileUrl;
                }
            }).catch(error => {
                this.submitting = false;
            });

        },
        ReorderImages(event){
            this.newAd.photos.splice(event.newIndex, 0, this.newAd.photos.splice(event.oldIndex, 1)[0])
        },
        addImage(event){
            const input = event.target;

            if (input.files && input.files[0]) {
                let file = input.files[0];
                this.newAd.photos.push({
                    id: file.name,
                    file
                });
                this.currentUploadedFile = file;
                this.newAd.photos = _.uniqBy(this.newAd.photos, 'id');

                 // Make new FileReader
                this.reader = new FileReader();

                // on reader load somthing...
                this.reader.onload = this.fileOnLoad;

                // Convert the file to base64 text
                this.reader.readAsDataURL(file);
            }
        },

        fileOnLoad() {
            // The File
            let { currentUploadedFile } = this

            // Make a fileInfo Object
            let fileInfo = {
                name: currentUploadedFile.name,
                type: currentUploadedFile.type,
                size: Math.round(currentUploadedFile.size / 1000)+' kB',
                base64: this.reader.result,
                file: currentUploadedFile
            }

            // Push it to the state
            this.result = fileInfo

            // DrawImage
            this.drawImage(this.result.base64)
        },

        drawImage(imgUrl) {
            // Create New Image
            let img = new Image()
            img.onload = event => { 
                // Recreate Canvas Element
                let canvas = document.createElement('canvas')
                // this.canvas = canvas

                // Set Canvas Context
                let ctx = canvas.getContext('2d')

                // Image Size After Scaling
                let scale = this.scale / 100
                let width = img.width * scale
                let height = img.height * scale

                // Set Canvas Height And Width According to Image Size And Scale
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);

                ctx.drawImage(img, 0, 0, width, height);

                // Quality Of Image
                let quality = this.quality ? (this.quality / 100) : 1

                // If all files have been proceed
                let base64 = canvas.toDataURL('image/jpeg', quality);

                let fileName = this.result.file.name;
                let lastDot = fileName.lastIndexOf(".");
                fileName = fileName.substr(0, lastDot) + '.jpeg';

                let objToPass = {
                canvas: canvas,
                original: this.result,
                compressed: {
                        blob: this.toBlob(base64),
                        base64: base64,
                        name: fileName,
                        file: this.buildFile(base64, fileName)
                    },
                }

                objToPass.compressed.size = Math.round(objToPass.compressed.file.size / 1000)+' kB'
                objToPass.compressed.type = "image/jpeg"

                this.doneCompressing(objToPass)

            };
            img.src = imgUrl
        },

        toBlob (imgUrl) {
            let blob = base64toblob(imgUrl.split(',')[1], "image/jpeg")
            let url = window.URL.createObjectURL(blob)
            return url
        },

        // Convert Blob To File
        buildFile (blob, name) {
            return new File([blob], name)
        },   

        doneCompressing({ compressed }) {
            console.log(compressed);
            this.newAd.compressedImages.push({
                id: compressed.file.name,
                file: compressed.file
            });
            this.newAd.compressedImages = _.uniqBy(this.newAd.compressedImages, 'id');
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
                });
        },
        fetchLocations(){
            axios.get(window.locationsUrl)
                .then(response => {
                    this.locations = response.data;
                })
                .catch(error => {
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

        $('#chooseCategory').accordion();

        $('#chooseLocation').accordion();

        this.fetchCategories();
        this.fetchLocations();
    }
});