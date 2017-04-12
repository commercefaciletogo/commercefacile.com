import axios from 'axios';
import Vue from 'vue';
import _ from 'lodash';
import Notify from 'izitoast';


import OptionItem from '../components/ads/create/OptionItem.vue';

const VueI18n = require('vue-i18n');
Vue.use(VueI18n);

const locales = {
    en: {
        general: {
            success: 'Update was successful.',
            failed: 'Update failed.',
        }
    },
    fr: {
        general: {
            success: 'La mise à jour a été réussie.',
            failed: 'Mise à jour a échoué.'
        },
    }
};

Vue.config.lang = window.locale;

new Vue({
    el: '#main',
    components: {
        'option-item': OptionItem
    },
    data: {
        locations: [],
        updatingProfile: false,
        updatingPassword: false,
        user: {
            fullName: window.loginUser.name.toUpperCase(),
            email: window.loginUser.email,
            location: {
                id: window.loginUser.location.id,
                text: window.loginUser.location.name
            },
            phoneNumber: window.loginUser.phone,
            errors: {
                name: false,
                email: false,
                phone: false
            }
        },
        password: {
            currentPassword: '',
            newPassword: '',
            newPasswordConfirm: '',
            error: false,
            updated: false
        }
    },
    methods: {
        notify(message, position, status){
            Notify[status]({message, position, progressBar: false});
        },
        updateInfo() {
            let { fullName, email, phoneNumber, location } = this.user;
            if(fullName && email && location.id && phoneNumber){
                this.updatingProfile = true;
                let data = new FormData;
                data.append('name', fullName);
                data.append('email', email);
                data.append('phone', phoneNumber);
                data.append('location_id', location.id);
                data.append('_token', window.csrf_token);
                console.log('updating information');
                axios.post(window.updateProfileUrl, data).then(res => {
                    this.updatingProfile = false;
                    if( !res.data.updated){
                        return this.notify(this.$t('general.failed'), 'topCenter', 'danger');
                    }
                    return this.notify(this.$t('general.success'), 'topCenter', 'success');
                }).catch(err => {
                    this.updatingProfile = false;
                    Object.keys(err.response.data.error).forEach(key => {
                        this.user.errors[key] = true;
                    });
                });
            }
        },
        changePassword() {
            let { currentPassword, newPassword, newPasswordConfirm } = this.password;
            if(currentPassword && newPassword && newPasswordConfirm && newPassword === newPasswordConfirm){
                this.updatingPassword = true;
                let data = new FormData;
                data.append('old_password', currentPassword);
                data.append('password', newPassword);
                data.append('password_confirmation', newPasswordConfirm);
                data.append('_token', window.csrf_token);

                _.forEach(_.keys(this.password), key => this.password[key] = '');
                axios.post(window.updatePasswordUrl, data).then(res => {
                    this.updatingPassword = false;
                    if( !res.data.updated){
                        return this.notify(this.$t('general.failed'), 'topCenter', 'danger');
                    }
                    return this.notify(this.$t('general.success'), 'topCenter', 'success');
                }).catch(err => {
                    this.updatingPassword = false;
                    this.password.error = true;
                    // kindly check your input and try again
                })
            }
        },
        closeLocationModal({id, name}) {
            this.user.location.id = id;
            this.user.location.text = name;
            $('#chooseLocation').remodal().close();
        },
        fetchLocations(){
            axios.get('/locations')
                .then(response => {
                    this.locations = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    beforeCreate(){
        Object.keys(locales).forEach(function (lang) {
            Vue.locale(lang, locales[lang])
        })
    },
    mounted() {
        $('#chooseLocation').accordion();
        this.fetchLocations();
        console.log('profile.settings mounted')
    }
});