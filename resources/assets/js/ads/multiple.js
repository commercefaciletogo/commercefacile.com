import _ from 'lodash';
import axios from 'axios';
import Vue from 'vue';
import createHistory from 'history/createBrowserHistory';
const history = createHistory();
const queryString = require('query-string');
const VueI18n = require('vue-i18n');
Vue.use(VueI18n);
import vSelect from 'vue-select'
Vue.component('v-select', vSelect);

import VueLazyload from 'vue-lazyload';
Vue.use(VueLazyload, {
    loading: '/img/icons/loading.gif',
    error: '/img/icons/placeholder.png'
});

import Paginate from 'vuejs-paginate';
Vue.component('paginate', Paginate);

import Child from '../components/ads/multiple/ChildrenList.vue';
import OptionItem from '../components/ads/create/OptionItem.vue';
import Parent from '../components/ads/multiple/ParentsList.vue';
import Results from '../components/ads/multiple/Results.vue';
import NoResult from '../components/ads/multiple/NoResult.vue';

const locales = {
    en: {
        filter: {
            lowestPrice: "lowest-price",
            recentAds: "recent-ads",
            sort: 'sort',
            location: 'Location',
            category: 'Category'
        }
    },
    fr: {
        filter: {
            lowestPrice: "prix-le-plus-bas",
            recentAds: "annonces-recentes",
            sort: 'trier',
            location: 'Lieu',
            category: 'Categorie'
        }
    }
};

Vue.config.lang = window.locale;

new Vue({
    el: '#root',
    data: {
        currentView: '',
        busy: false,
        filter: {
            sort: 'r',
            category: {
                id: null,
                name: ''
            },
            location: {
                id: null,
                name: ''
            },
            q: ''
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
        filteredLocation: '',
        ads: {
            total: '',
            from: '',
            to: '',
            data: ''
        }
    },
    components: {
        'parent': Parent,
        'child': Child,
        'option-item': OptionItem,
        'results': Results,
        'no-result': NoResult
    },
    computed: {
        query(){
            let base = `&${this.$t('filter.sort')}=${this.filter.sort}`;
            if(this.filter.category.id !== null) base = `${base}&c=${this.filter.category.uuid}`;
            if(this.filter.location.id !== null) base = `${base}&l=${this.filter.location.uuid}`;
            if( !_.isEmpty(this.search.q) ) base = `${base}&q=${this.search.q}`;
            return base;
        },
        transCategory(){
            if(this.filter.category.id === null){
                return this.$t('filter.category')
            }else {
                return this.filter.category.name;
            }
        },
        transLocation(){
            if(this.filter.location.id === null){
                return this.$t('filter.location');
            }else{
                return this.filter.location.name;
            }
        },
        result(){
            return !_.isEmpty(this.ads.data);
        },
        paginate(){
            if(this.ads.last_page){
                return this.ads.last_page > 1;
            }
        }
    },
    watch: {
        query(query){
            _.delay(q => {
                this.updateUrl(q)
            }, 500, query);
        }
    },
    methods: {
        handlePaginate(currentPage){
            console.log(currentPage);
        },
        performFilter() {
            $('#performFilterModal').remodal().close();
        },
        closeCategoryFilter(category) {
            this.filter.category = category;
            $('.ui.accordion.field').accordion('close', 0);
        },
        closeLocationFilter(location) {
            this.filter.location = location;
            $('.ui.accordion.field').accordion('close', 1);
        },
        handleSelected({item, type, parent}) {
            if (parent) return this.handleParentSelection({ item: item, type: type });
            if (type === "category") {
                this.filter.category = item;
            } else {
                this.filter.location = item;
            }
        },
        handleParentSelection({item, type}) {
            if (type === "category") {
                this.selectedCategory = item;
            } else {
                this.selectedLocation = item;
            }

            if(_.isEmpty(item.children)){
                if (type === "category") {
                    this.filter.category = item;
                } else {
                    this.filter.location = item;
                }
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
        initData(){
            return Promise.all([this.fetchCategories(), this.fetchLocations()]);
        },
        fetchCategories(){
            return axios.get('/categories');
        },
        fetchLocations(){
            return axios.get('/locations');
        },
        closeCategoryModal(category){
            this.$set(this.filter, 'category', category);
            $('#chooseCategory').remodal().close();
        },
        closeLocationModal(location) {
            this.$set(this.filter, 'location', location);
            $('#chooseLocation').remodal().close();
        },
        initUrlListener(){
            const unlisten = history.listen((location, action) => {
                if(action === 'PUSH'){
                    return this.performSearch(location.search);
                }
            })
        },
        updateQuery(){
            let localSearch = this.query;
            let remoteSearch = history.location.search;
            let localParams = queryString.parse(localSearch);
            let remoteParams = queryString.parse(remoteSearch);
            let currentParams = Object.assign({}, localParams, remoteParams);

            this.initData().then(values => {
                this.categories = values[0].data;
                this.locations = values[1].data;

                let cat = _.find(this.categories, category => {
                    let uuid = _.get(currentParams, 'c');
                    return category.uuid === uuid;
                });
                if(cat === undefined){
                    let subCategories = _.flatMap(this.categories, category => {
                        return category.children;
                    });
                    cat = _.find(subCategories, category => {
                        let uuid = _.get(currentParams, 'c');
                        return category.uuid === uuid;
                    });
                }
                if(cat !== undefined) this.$set(this.filter, 'category', cat);

                let loc = _.find(this.locations[0].children, location => {
                    let uuid = _.get(currentParams, 'l');
                    return location.uuid === uuid;
                });
                if(loc !== undefined) this.$set(this.filter, 'location', loc);

                var sort = _.get(currentParams, this.$t('filter.sort'));
                if(sort !== undefined) this.$set(this.filter, 'sort', sort);

                let q = _.get(currentParams, 'q');
                if(q !== undefined) {this.$set(this.filter, 'q', q); this.$set(this.search, 'q', q);}

                if(cat === undefined && loc === undefined && q === undefined){
                    let queryParams = queryString.stringify(currentParams);
                    this.updateUrl(queryParams);
                }

            }).catch(error => {
            });
        },
        updateUrl(s){
            let params = queryString.parse(s);
            let search = `?${queryString.stringify(params)}`;
            history.push(search);
        },
        updateSearchQuery(){
            if(_.isEmpty(this.filter.q)) return ;
            this.$set(this.search, 'q', this.filter.q);
        },
        performSearch(queryParams){
            this.busy = true;
            let url = `${window.baseUrl}${queryParams}`;
            axios.get(url).then(rep => {
                this.ads = rep.data;
                if(_.isEmpty(this.ads.data)){
                    this.currentView = 'no-result'
                }

                if(!_.isEmpty(this.ads.data)){
                    this.currentView = 'results';
                }
                this.busy = false;
            }).catch(error => {
                this.busy = false;
            });
        }
    },
    beforeCreate(){
        Object.keys(locales).forEach(function (lang) {
            Vue.locale(lang, locales[lang])
        })
    },
    mounted(){
        this.initUrlListener();
        this.updateQuery();
    }
});