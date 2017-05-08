import Notify from 'izitoast';
import Vue from 'vue';
const VueI18n = require('vue-i18n');
const queryString = require('query-string');

Vue.use(VueI18n);

const host = window.location.host;
const socket = io.connect('http://' + host + ':8443');

const locales = {
    en: {
        loading: 'Loading...',
        error: 'Kindly try again later!',
        copied: 'Link copied.'
    },
    fr: {
        loading: 'Chargement...',
        error: 'Veuillez réessayer plus tard!',
        copied: 'Lien copié.'
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
            status: '',
            percent: 5
        },
        showProgress: false
    },
    methods: {

        initClipboard(){
            var clipboard = new Clipboard('.public');
            console.log('init clipboard')

            clipboard.on('success', function (e) {
                console.log('copied');
                this.notify(this.$t('copied'), "topCenter", "success");

                e.clearSelection();
            }.bind(this));

            clipboard.on('error', function(e) {
            }.bind(this));
        },
        notify(message, position, status){
            Notify[status]({message, position, progressBar: false});
        },
    },
    mounted() {
        this.initClipboard();
        const channel = `Author.${window.authorId}`;
        socket.on(`${channel}:ProcessingAdImages`, ({data}) => {
            console.log(channel);
            this.showProgress = true;
            $('#process').progress('set percent', data.percent);
            this.process.status = data.status;
        });

        socket.on(`${channel}:AdWasSubmitted`, ({data}) => {
            if(data.submitted){
                window.location = window.location.pathname;
            }else {
                $('#process').progress('set error');
                this.process.status = "";
            }
        });
        console.log('meta mounted')
    }
});