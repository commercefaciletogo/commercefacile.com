import axios from 'axios';
import Vue from 'vue';

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
                        url: `${window.usersSearchUrl}?q={query}`
                    },
                    fields: {
                        results : 'items',
                        title: 'name',
                        price: 'ads'
                    },
                    minCharacters : 8
                })
        }
    },
    mounted(){
        this.initSearch();
        socket.on('Admin:AdsWereUpdated', ({ data }) => {
            this.pending = !data.pending.empty;
        });

        this.updatePending();

        this.updateQuery();
    }
});