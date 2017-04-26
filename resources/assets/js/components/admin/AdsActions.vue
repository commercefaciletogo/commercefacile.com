<template>
    <div v-show="show" class="ads-actions">
        <button v-if="pending" class="mini compact ui button" @click="itemAction('review', rowData, rowIndex)">{{ $t("actions.review") }}</button>
        <button v-else class="mini compact ui button" @click="itemAction('view', rowData, rowIndex)">{{ $t("actions.view") }}</button>
    </div>
</template>
<style>

</style>
<script type="text/babel">

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
        }
    }
</script>
