import _ from 'lodash';
import axios from 'axios';
import vSelect from "vue-select";
import Vue from 'vue';

import Child from '../components/ads/multiple/ChildrenList.vue';
import OptionItem from '../components/ads/create/OptionItem.vue';
import Parent from '../components/ads/multiple/ParentsList.vue';

new Vue({
    el: '#root',
    data: {
        filter: {
            sort: 'recentAds',
            category: '',
            location: ''
        },
        categories: [],
        locations: [],
        showCategories: true,
        showSubCategories: false,
        parentId: '',
        subCategories: [],
        cities: [],
        currentSelectionLocation: 'parent',
        currentSelectionCategory: 'parent',
        selectedCategory: '',
        selectedLocation: '',
        selectedSub: '',
        search: {
            category: {
                id: '',
                text: 'Categorie'
            },
            location: {
                id: '',
                text: 'Lieu'
            },
            q: ''
        },
        filteredCategory: '',
        filteredLocation: ''
    },
    components: {
        'parent': Parent,
        'child': Child,
        'option-item': OptionItem
    },
    computed: {},
    methods: {
        performFilter() {
            $('#performFilterModal').remodal().close();
        },
        closeCategoryFilter({id, name}) {
            this.filter.category = { id, name };
            $('.ui.accordion.field').accordion('close', 0);
        },
        closeLocationFilter({id, name}) {
            this.filter.location = { id, name };
            $('.ui.accordion.field').accordion('close', 1);
        },
        handleSelected({item, type, parent}) {
            if (parent) return this.handleParentSelection({ item: item, type: type });
            if (type === "category") {
                this.filter.category = item;
            } else {
                this.filter.location = item;
            }
            return console.log(`load ads for ${item.name}`);
        },
        handleParentSelection({item, type}) {
            if (type === "category") {
                this.selectedCategory = item;
            } else {
                this.selectedLocation = item;
            }

            if(_.isEmpty(item.children)){
                return console.log(`load ads for ${item.name} -> ${type}`);
            } else {
                if(type === 'category') {
                    this.subCategories = item.children;
                    this.currentSelectionCategory = 'child';
                } else {
                    this.cities = item.children;
                    this.currentSelectionLocation = 'child';
                }
            }
        },
        fetchSub(parent, type) {
            let path = null;
            if (type === "category") {
                path = "categories";
            } else {
                path = "locations";
            }
            axios.get(`/${path}/${parent}`)
                .then(response => {
                    if (type === "category") {
                        this.subCategories = response.data;
                    } else {
                        this.cities = response.data;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        goBack(type){
            if (type === "category") {
                this.currentSelectionCategory = 'parent';
                this.selectedCategory = '';
            } else {
                this.currentSelectionLocation = 'parent';
                this.selectedLocation = '';
            }
            
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
        closeCategoryModal({id, name}){
            this.search.category.text = `${name}`;
            this.search.category.id = id;
            $('#chooseCategory').remodal().close();
        },
        closeLocationModal({id, name}) {
            this.search.location.id = id;
            this.search.location.text = name;
            $('#chooseLocation').remodal().close();
        },
    },
    mounted(){
        $('#chooseCategory').accordion();
        $('#chooseLocation').accordion();
        $('#lgCategoryFilter').accordion();
        $('#lgLocationFilter').accordion();
        $('.ui.accordion.field').accordion();
        $('.ui.selection.dropdown').dropdown(
            {
                action: 'activate',
                onChange: function(value, text, $selectedItem) {
                    this.filter.sort = value;
                    console.log('performFilter....')
                }.bind(this)
            }
        );
        this.fetchCategories();
        this.fetchLocations();
    }
});