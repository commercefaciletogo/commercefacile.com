import Vue from 'vue';
import Notify from 'izitoast';
import axios from 'axios';

const VueI18n = require('vue-i18n');
Vue.use(VueI18n);

import VueLazyload from 'vue-lazyload';
Vue.use(VueLazyload);

const locales = {
    en: {
        general: {
            copied: 'Phone number copied.'
        }
    },
    fr: {
        general: {
            copied: 'Numéro de téléphone copié.'
        },
    }
};

Vue.config.lang = window.locale;


new Vue({
    el: '#main',
    data: {
        shown: false,
        ad: window.ad,
        paths: window.ad.images
    },
    methods: {
        reportAd(){
            let url = window.reportAdUrl;
            if(this.ad.reported){
                url = window.dereportAdUrl;
            }
            axios.post(url).then(rep => {
                if(rep.data.done){
                    this.ad = rep.data.ad;
                    console.log('done reporting');
                }
            }).catch(err => {
                console.log(err.response);
            });
        },
        favoriteAd(){
            let url = window.favoriteAdUrl;
            if(this.ad.favorited){
                url = window.unfavoriteAdUrl;
            }
            axios.post(url).then(rep => {
                if(rep.data.done){
                    this.ad = rep.data.ad;
                    console.log('done favoriting');
                }
            }).catch(err => {
                console.log(err.response);
            });
        },
        showPhone(){
            this.shown = true;
        },
        initClipboard(){
            var clipboard = new Clipboard('.copy');

            clipboard.on('success', function(e) {
                console.info('Action:', e.action);
                console.info('Text:', e.text);
                console.info('Trigger:', e.trigger);
                this.notify(this.$t('general.copied'), "topCenter", "success");

                e.clearSelection();
            }.bind(this));

            clipboard.on('error', function(e) {
                console.error('Action:', e.action);
                console.error('Trigger:', e.trigger);
            }.bind(this));
        },
        notify(message, position, status){
            Notify[status]({message, position, progressBar: false});
        },
        startAdImagesSlider(){
            const mySiema = new Siema();
            const prev = document.querySelector('.prev');
            const mobPrev = document.querySelector('.mob-prev');
            const next = document.querySelector('.next');
            const mobNext = document.querySelector('.mob-next');
            prev.addEventListener('click', () => mySiema.prev());
            mobPrev.addEventListener('click', () => mySiema.prev());
            next.addEventListener('click', () => mySiema.next());
            mobNext.addEventListener('click', () => mySiema.next());
        }
    },
    beforeCreate(){
        Object.keys(locales).forEach(function (lang) {
            Vue.locale(lang, locales[lang])
        })
    },
    mounted(){
        this.startAdImagesSlider();
        $('.ads-slide').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            variableWidth: true,
            autoplay: true,
            autoplaySpeed: 5000
        });

        this.initClipboard();

        console.log(window.ad);
    }
});