import Vue from 'vue';
import AdsTable from '../../components/admin/AdsTable.vue';
import VueEvents from 'vue-events';
const VueI18n = require('vue-i18n');

const host = window.location.host;
const socket = io.connect('http://' + host + ':8443');

Vue.use(VueI18n);
Vue.use(VueEvents);

const locales = {
    en: {
        fields: {
            author: 'Author',
            title: 'Title',
            date: 'Date',
            category: 'Category',
            status: 'Status'
        }
    },
    fr: {
        fields: {
            author: 'Auteur',
            title: 'Titre',
            date: 'Date',
            category: 'Categorie',
            status: 'Statue'
        }
    }
};

Vue.config.lang = window.locale;
Object.keys(locales).forEach(function (lang) {
    Vue.locale(lang, locales[lang])
});

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

new Vue({
    el: '#main',
    components: {
        'ads-table': AdsTable
    },
    data: {
        currentStatus: 'all'
    },
    methods: {
        changeStatus(type){
            this.currentStatus = type;
        }
    },
    mounted(){
        socket.on('Admin:AdsWereUpdated', () => this.$events.$emit('reload'));
    }
});