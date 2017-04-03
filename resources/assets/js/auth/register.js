import Vue from 'vue';
import axios from 'axios';
import _ from 'lodash';



Vue.component('user-info', {
    template: '#userInfo',
    data(){
        return {
            form: {
                name: '',
                phone: '',
                password: '',
                passwordConfirmation: ''
            },
            errors: {
                name: false,
                phone: false,
                password: false,
                passwordConfirmation: false,
            },

            loading: false
        }
    },
    computed: {
        field(fieldName){
            if(_.has(this.error, _.snakeCase(fieldName))){
                return "field error";
            }
            return "field";
        }
    },
    methods: {
        handleSubmit(){
            if(this.form.password && this.form.name && this.form.phone && this.form.passwordConfirmation){
                this.loading = true;
                let data = new FormData;
                data.append("name", this.form.name);
                data.append("phone", this.form.phone);
                data.append("password", this.form.password);
                data.append("password_confirmation", this.form.passwordConfirmation);
                data.append("_token", window.crsf_token);

                axios.post(window.postUserInfoUrl, data)
                    .then(response => {
                        if(response.data.sent){
                            this.$emit('userinfo', response.data.sent);
                        }
                        this.loading = false;
                    })
                    .catch(error => {
                        _.keys(error.response.data).forEach(key => {
                            this.errors[_.camelCase(key)] = true;
                        });
                        this.loading = false;
                    });
            }
        }
    }
});

Vue.component('phone-auth', {
    template: '#phoneAuth',
    data(){
        return {
            code: '',
            loading: false,
            errors: {
                code: false
            }
        }
    },
    methods: {
        handleSubmit(){
            if(this.code){
                this.loading = true;
                let data = new FormData;
                data.append("code", this.code);
                data.append("_token", window.crsf_token);

                axios.post(window.postCodeUrl, data)
                    .then(response => {
                        this.loading = false;
                        if(response.data.done){
                            return this.$emit('phoneauth', {done: true, url: response.data.url});
                        }
                    })
                    .catch(error => {
                        _.keys(error.response.data).forEach(key => {
                            this.errors[_.camelCase(key)] = true;
                        });
                        this.loading = false;
                    });
            }
        }
    }
});

new Vue({
    el: '#main',
    data: {
        current: 'user-info'
    },
    methods: {
        handleRegister(done){
            if(done){
                this.current = 'phone-auth';
            }
        },
        handlePhoneAuth({done, url}){
            if(done){
                window.location = url;
            }
        }
    },
    mounted(){
        console.log('register user mounted')
    }
});