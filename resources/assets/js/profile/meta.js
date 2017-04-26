import Vue from 'vue';
const VueI18n = require('vue-i18n');
const queryString = require('query-string');

Vue.use(VueI18n);

const host = window.location.host;
const socket = io.connect('http://' + host + ':6001');

const locales = {
    en: {
        loading: 'Loading...'
    },
    fr: {
        loading: 'Chargement...'
    }
};

Vue.config.lang = window.locale;
Object.keys(locales).forEach(function (lang) {
    Vue.locale(lang, locales[lang])
});

new Vue({
    el: '#profileMeta',
    data: {
        process: {
            status: `Loading...`,
            percent: 5
        },
        showProgress: false
    },
    mounted(){
        const channel = `Author.${window.authorId}`;
        socket.on(`${channel}:ProcessingAdImages`, ({data}) => {
            console.log(channel);
            this.showProgress = true;
            $('.ui.indicating.progress').progress('set percent', data.percent);
            this.process.status = data.status;
        });

        socket.on(`${channel}:AdWasSubmitted`, ({data}) => {
            if(data.submitted){
                window.location = window.location.pathname;
            }else {
                $('.ui.indicating.progress').progress('set error');
                this.process.status = "Kindly try again later!";
            }
        });
        console.log('meta mounted')
    }
});