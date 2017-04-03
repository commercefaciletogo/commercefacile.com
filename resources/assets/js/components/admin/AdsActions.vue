<template>
    <div v-show="show" class="ads-actions">
        <button v-if="pending" class="mini compact ui button" @click="itemAction('review', rowData, rowIndex)">{{ $t("actions.review") }}</button>
        <button v-else class="mini compact ui button" @click="itemAction('view', rowData, rowIndex)">{{ $t("actions.view") }}</button>
    </div>
</template>
<style>

</style>
<script type="text/babel">
// import Vue from 'vue';
// const VueI18n = require('vue-i18n');
//
// Vue.use(VueI18n);
//
// Vue.config.lang = window.locale;



    export default{
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            }
        },
        locales: {
            en: {
                actions: {
                    review: 'Review',
                    view: 'View'
                }
            },
            fr: {
                actions: {
                    review: 'Réviser',
                    view: 'Voir'
                }
            }
        },
        computed: {
            show(){
                if(this.rowData.status === 'rejected') return false;
                return true;
            },
            pending(){
                return this.rowData.status === 'pending';
            }
        },
        methods: {
            itemAction(action, data, index){
                let url = window.adsUrl;
                if(action === 'review'){
                    url = `${url}/${data.uuid}?action=review`;
                }
                if(action === 'view'){
                    url = `${url}/${data.uuid}?action=view`;
                }
                window.location = url;
            }
        },
        beforeCreate(){
            // Object.keys(locales).forEach(function (lang) {
            //     Vue.locale(lang, locales[lang])
            // });
        }
    }
</script>
