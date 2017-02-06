import Vue from 'vue';
import axios from 'axios';
import _ from 'lodash';
import Categories from '../components/ads/multiple/ParentsList.vue';
import SubCategories from '../components/ads/multiple/ChildrenList.vue';


new Vue({
    el: '#root',
    data: {
        showCategories: true,
        showSubCategories: false,
        parentId: null,
        subCategories: [],
        currentSelection: 'categories',
        selectedCategory: null,
        selectedSub: null
    },
    components: {
        'categories': Categories,
        'sub-categories': SubCategories
    },
    computed: {},
    methods: {
        handleSelected(category){
            this.selectedCategory = category;
            if(_.isEmpty(category.children)){
                return console.log(`load ads for ${category.name}`);
            }
            console.log(`selected is --> ${category.name}`);
            this.fetchSub(category.id);
            this.currentSelection = 'sub-categories';
        },
        fetchSub(parent){
            axios.get(`/categories/${parent}`)
                .then(response => {
                    this.subCategories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        goBack(){
            this.currentSelection = 'categories';
            this.selectedCategory = null;
        }
    },
    mounted(){
        $('.ui.styled.accordion').accordion();
        $('.ui.fluid.dropdown').dropdown();
    }
});