import Vue from 'vue';
import Notify from 'izitoast';
import axios from 'axios';

const VueI18n = require('vue-i18n');
Vue.use(VueI18n);

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
        ad: {}
    },
    methods: {
        reportAd(adId){
            axios.post(window.reportAdUrl).then(rep => {

            }).catch(err => {

            });
            console.log(`reporting ad ${adId}`);
        },
        favoriteAd(adId){
            axios.post(window.favoriteAdUrl).then(rep => {

            }).catch(err => {

            });
            console.log(`favorite ad ${adId}`);
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

        console.log('single ad page mounted');
        this.notify("single ad page mounted", "topCenter", "success");
    }
});