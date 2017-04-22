import Vue from 'vue';
import axios from 'axios';

const host = window.location.host;
const socket = io.connect('http://' + host + ':8443');

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
            if(this.currentPassword && this.newPassword && this.newPasswordConfirm){
                axios.post(window.changePasswordUrl)
                    .then(rep => {

                    })
                    .catch(error => {

                    })
            }
            window.setTimeout(() => {
                this.changing = false;
            }, 5000);
        },
        updatePending(){
            axios.get(window.adsStatusUrl).then(rep => {
            }).catch(er => {
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

        socket.on('Admin:AdsWereUpdated', e => {
            this.pending = !e.pending.empty;
        });

        this.updatePending();

        this.updateQuery();
    }
});