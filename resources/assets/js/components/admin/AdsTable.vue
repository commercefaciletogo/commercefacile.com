<template>
    <div>
        <vuetable
            ref="vuetable"
            :api-url="apiUrl"
            :fields="fields"
            :per-page="20"
            pagination-path=""
            :query-params="{filter: 'filter', q: 'query'}"
            :css="css.table"
            :sort-order="sortOrder"
            :multi-sort="true"
            :append-params="moreParams"
            @vuetable:cell-clicked="onCellClicked"
            @vuetable:pagination-data="onPaginationData"
        ></vuetable>
        <div class="vuetable-pagination">
            <!--<vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>-->
            <vuetable-pagination
                    ref="pagination"
                    :css="css.pagination"
                    :icons="css.icons"
                    @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
    </div>
</template>

<style>

</style>
<script type="text/babel">
    import Vuetable from 'vuetable-2/src/components/Vuetable.vue';
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue';
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue';
    import { fr } from '../../helpers/locales';
    import moment from 'moment';
    import AdsActions from './AdsActions.vue';
    import Vue from 'vue';
    import VueEvents from 'vue-events';
    const VueI18n = require('vue-i18n');
    moment.locale(window.locale);

    Vue.use(VueEvents);
    Vue.use(VueI18n);
    Vue.component('ads-actions', AdsActions);

    const locales = {
        en: {
            fields: {
                author: 'Author',
                title: 'Title',
                date: 'Date',
                category: 'Category',
                status: 'Status'
            },
            status: {
                pending: "Pending",
                rejected: "Rejected",
                offline: "Offline",
                online: "Online",
            }
        },
        fr: {
            fields: {
                author: 'Auteur',
                title: 'Titre',
                date: 'Date',
                category: 'Categorie',
                status: 'Statue'
            },
            status: {
                pending: "En attente",
                rejected: "Rejetée",
                offline: "Hors ligne",
                online: "En line",
            }
        }
    };

    Vue.config.lang = window.locale;

    export default{
        props: ['api-url', 'status'],
        data(){
            return{
                query: '',
                filter: '',
                fields: [
                    {name: 'code', title: `# Code`, titleClass: 'center aligned', dataClass: 'center aligned' },
                    {name: 'author', title: this.$t("fields.author"), titleClass: 'center aligned', dataClass: 'center aligned' },
                    {name: 'title', title: this.$t("fields.title"), titleClass: 'center aligned', dataClass: 'center aligned' },
                    {name: 'date', title: this.$t("fields.date"), titleClass: 'center aligned', dataClass: 'center aligned', callback: 'formatDate|DD-MM-YYYY' },
                    {name: 'category.name', title: this.$t("fields.category"), titleClass: 'center aligned', dataClass: 'center aligned' },
                    {name: 'status', title: this.$t("fields.status"), titleClass: 'center aligned', dataClass: 'center aligned', callback: 'formatStatus' },
                    {name: '__component:ads-actions', title: 'Actions', titleClass: 'center aligned', dataClass: 'center aligned' },
                ],
                moreParams: {},
                css: {
                    table: {
                        tableClass: 'ui very basic table',
                        ascendingIcon: 'icon sort content ascending',
                        descendingIcon: 'icon sort content descending'
                    },
                    pagination: {
                        wrapperClass: 'pagination',
                        activeClass: 'active',
                        disabledClass: 'disabled',
                        pageClass: 'page',
                        linkClass: 'link',
                    },
                    icons: {
                        first: 'icon angle double left',
                        prev: 'icon angle left',
                        next: 'icon angle right',
                        last: 'icon angle double right'
                    }
                }
            }
        },
        watch: {
            status(val){
                this.filter = val;
                this.setFilter(val);
            }
        },
        methods: {
            setFilter(filterType){
                this.moreParams = {filter: this.filter, q: this.query};
                console.log(this.filter, this.query);
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
            setSearchQuery(query){
                this.moreParams = {filter: this.filter, q: this.query};
                console.log(this.filter, this.query);
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                // this.$refs.paginationInfo.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            onCellClicked (data, field, event) {
                // this.$refs.vuetable.toggleDetailRow(data.id)
            },
            formatStatus (value) {
                let label = null;
                switch(value){
                    case 'pending':
                        label = `<div class="ui mini compact blue horizontal label">${this.$t("status.pending")}</div>`;
                        break;
                    case 'rejected':
                        label = `<div class="ui mini compact red horizontal label">${this.$t("status.rejected")}</div>`;
                        break;
                    case 'online':
                        label = `<div class="ui mini compact green horizontal label">${this.$t("status.online")}</div>`;
                        break;
                }
                return label;
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value).calendar();
            }
        },
        components:{
            Vuetable, VuetablePagination, VuetablePaginationInfo
        },
        beforeCreate(){
            Object.keys(locales).forEach(function (lang) {
                Vue.locale(lang, locales[lang])
            })
        },
        mounted(){
            this.$events.$on('reload', () => {
                this.setFilter(this.status);
            });

            this.$events.$on('search', ({query}) => {
                this.query = query;
                console.log(this.query);
                this.setSearchQuery(query);
            })
        }
    }
</script>
