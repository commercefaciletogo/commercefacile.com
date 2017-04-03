import Vue from 'vue';
import Echo from 'laravel-echo';
import axios from 'axios';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

new Vue({
    el: '#topMenu',
    data: {
        pending: false,
        changing: false,
        password: {
            currentPassword: '',
            newPassword: '',
            newPasswordConfirm: ''
        },
        updatingPassword: false
    },
    methods: {
        changePassword(){
            this.changing = true;
            window.setTimeout(() => {
                this.changing = false;
            }, 5000);
        },
        updatePending(){
            axios.get(window.adsStatusUrl).then(rep => {
            }).catch(er => {
                console.log(er);
            })
        },
        initSearch(){
            $('.ui.search')
                .search({
                    apiSettings: {
                        url: '//api.github.com/search/repositories?q={query}'
                    },
                    fields: {
                        results : 'items',
                        title   : 'name',
                        url     : 'html_url'
                    },
                    minCharacters : 3
                })
        }
    },
    mounted(){
        window.Echo.channel(`admin`)
            .listen('.AdsWereUpdated', e => {
                console.log(e);
                this.pending = !e.pending.empty;
            });

        this.updatePending();

        this.initSearch();
        console.log('top menu mounted');
    }
});