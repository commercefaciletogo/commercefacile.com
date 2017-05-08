import _ from 'lodash';
import Vue from 'vue';
import VueEvents from 'vue-events';

import AdsTable from '../../components/admin/AdsTable.vue';

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

new Vue({
    el: '#main',
    components: {
        'ads-table': AdsTable
    },
    data: {
        currentStatus: 'all',
        query: '',
        loading: false
    },
    computed: {
        showReset() {
            return !this.loading;
        }
    },
    methods: {
        changeStatus(type){
            this.currentStatus = type;
        },
        search() {
            if (_.isEmpty(this.query)) return;
            this.$events.$emit('search', { query: this.query });
        },
        resetSearch() {
            if (_.isEmpty(this.query)) return;
            this.query = '';
            this.$events.$emit('search:reset');
        }
    },
    mounted() {
        this.$events.$on('table:loaded', () => {
            this.loading = true;
        });
        this.$events.$on('table:loaded', () => {
            this.loading = false;
        });
        
        socket.on('Admin:AdsWereUpdated', () => this.$events.$emit('reload'));
    }
});