import Vue from 'vue';

// components
// import LatestAds from '../components/home/LatestAds.vue';

new Vue({
    el: "#main",
    components: {
        // 'latest-ads' : LatestAds
    },
    data: {
        search: {
            category: {
                value: '',
                text: ''
            },
            city: {
                value: '',
                text: ''
            },
            query: ''
        }
    },
    computed: {},
    methods: {
        performSearch(){
            console.log(`search details -> ${this.search}`);
        }
    },
    mounted(){
        $('.ads-slide').slick({
            // infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            variableWidth: true,
            autoplay: true,
            autoplaySpeed: 5000
        });

        $('#citySelect').dropdown({
            action: 'activate',
            onChange: function(value, text){
                this.search.city.text = text;
                this.search.city.value = value;
            }.bind(this)
        }); 

        $('#categorySelect').dropdown({
            action: 'activate',
            onChange: function(value, text){
                this.search.category.text = text;
                this.search.category.value = value;
            }.bind(this)
        }); 

        $('.city-select').dropdown({
            action: 'hide',
            onChange: function(value, text){
                console.log(value);
            }
        }); 

        $('.category-select').dropdown({
            action: 'hide',
            onChange: function(value, text){
                console.log(value);
            }
        });

        console.log(locationsUrl, categoriesUrl);
    }
});