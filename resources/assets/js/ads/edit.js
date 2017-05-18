import _ from 'lodash';
import axios from 'axios';
import blodUtil from 'blob-util';
import Vue from 'vue';

import Categories from '../components/ads/create/Categories.vue';
import ImageCompressor from '../helpers/compressor';
import ImagePreview from '../components/ads/create/ImagePreview.vue';
import OptionItem from '../components/ads/create/OptionItem.vue';
import SubCategories from '../components/ads/create/SubCategories.vue';

const host = window.location.host;
const socket = io.connect('http://' + host + ':8443');

let csrf = document.querySelector("meta[name=csrf-token]").content;
let oldAd = window.oldAd;

new Vue({
    el: 'div#main',
    data: {
        submitting: false,
        busy: false,
        categories: [],
        locations: [],
        selectedCategory: {},
        selectedSubCategory: {},
        newAdBuffer: {},
        newAd: {
            title: oldAd.title,
            category: {
                id: oldAd.category.id,
                text: oldAd.category.name
            },
            description: oldAd.description,
            condition: oldAd.condition,
            photos: [],
            compressedImages: [],
            price: {
                amount: oldAd.price.amount,
                negotiable: oldAd.price.negotiable
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
        scale: 100,
        quality: 50,
        process: {
            status: '',
            percent: 5,
            modal: {}
        },
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
                return totalSize + photo.file.size;
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
            data.append('negotiable', this.newAd.price.negotiable ? 1 : 0);
            if(window.requireLocation){
                data.append('location_id', this.user.location.id);
            }
            data.append('_token', csrf);
            data.append('image_length', this.newAd.photos.length);
            _.forEach(this.newAd.photos, (photo, i) => data.append(`image_${i + 1}`, photo.file));

            axios({url: window.updateAdUrl,
                method: 'POST',
                data: data}).then(res => {
                if(res.data.done){
                    this.process.modal.open();
                }
            }).catch(error => {
                this.submitting = false;
            });

        },
        cancel(){
            axios.post(window.cancelUpdateAdUrl).then(rep => {
            }).catch(e => {
            });
            window.history.back();
        },
        ReorderImages(event){
            this.newAd.photos.splice(event.newIndex, 0, this.newAd.photos.splice(event.oldIndex, 1)[0])
        },
        addImage(event){
            const input = event.target;

            if (input.files && input.files[0]) {
                let file = input.files[0];
                let compressor = new ImageCompressor(file,
                    document.createElement('canvas'),
                    this.scale,
                    this.quality,
                    this.doneCompressing);
                
                compressor.run();
            }
        },
         doneCompressing({ compressed }) {
            console.log(compressed);
            this.newAd.photos.push({
                id: compressed.file.name,
                file: compressed.file,
                base: compressed.base64
            });
            this.newAd.photos = _.uniqBy(this.newAd.photos, 'id');
        },
         removeImage(id) {
             this.$set(this.newAd, 'photos', _.reject(this.newAd.photos, {'id': id}));
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
        },
        convertImages(bases){
            console.log('start downloading...');
            _.each(bases, base => {
                blodUtil.base64StringToBlob(base)
                .then(blob => {this.newAd.photos.push({
                        id: + new Date(),
                        file: blob,
                        base: `data:image/jpeg;base64,${base}`
                    });
                    this.newAdBuffer = _.cloneDeep(this.newAd);
                }).catch(error => {

                });
            })
        }
    },
    mounted() {
        
        this.process.modal = $('[data-remodal-id=process-loading]').remodal({ closeOnOutsideClick: false, hashTracking: false });
        
        const channel = `Author.${window.authorId}`;
        socket.on(`${channel}:ProcessingAdImages`, ({data}) => {
            console.log(channel);
            this.showProgress = true;
            $('#process').progress('set percent', data.percent);
            this.process.status = data.status;
        });

        socket.on(`${channel}:AdWasSubmitted`, ({data}) => {
            if(data.submitted){
                window.location = window.profileUrl;
            }else {
                $('#process').progress('set error');
                this.process.status = "";
                this.process.modal.close();
            }
        });

        this.convertImages(oldAd.images);

        console.log('edit mounted');

        console.log(oldAd.images);

        $('#chooseCategory').accordion();

        $('#chooseLocation').accordion();

        this.fetchCategories();
        this.fetchLocations();
    }
});