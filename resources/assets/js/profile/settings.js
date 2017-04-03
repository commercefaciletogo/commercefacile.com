import axios from 'axios';
import Vue from 'vue';
import _ from 'lodash';

import OptionItem from '../components/ads/create/OptionItem.vue';

console.log(window.loginUser);
console.log(window.updateProfileUrl);
console.log(window.updatePasswordUrl);

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
                        // info could not be updated
                        return console.log(res.data.updated)
                    }
                    console.log('updated')
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
                        // info could not be updated
                        return this.password.error = true;
                    }

                    this.password.updated = true;
                    window.setTimeout(() => this.password.updated = false, 500);
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
    mounted() {
        $('#chooseLocation').accordion();
        this.fetchLocations();
        console.log('profile.settings mounted')
    }
});