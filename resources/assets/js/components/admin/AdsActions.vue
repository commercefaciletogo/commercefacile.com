<template>
    <div v-show="show" class="ads-actions">
        <button v-if="pending" class="mini compact ui button" @click="itemAction('review', rowData, rowIndex)">{{ $t("actions.review") }}</button>
        <button v-else class="mini compact ui button" @click="itemAction('view', rowData, rowIndex)">{{ $t("actions.view") }}</button>
        <button v-if="adminCanDelete" class="mini compact ui button" @click="itemAction('delete', rowData, rowIndex)">{{ $t("actions.delete") }}</button>
    </div>
</template>
<style>

</style>
<script type="text/babel">

    import axios from 'axios';

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
                confirm: "Are you sure?",
                actions: {
                    review: 'Review',
                    view: 'View',
                    delete: 'Delete'
                }
            },
            fr: {
                confirm: "Êtes-vous sûr?",
                actions: {
                    review: 'Réviser',
                    view: 'Voir',
                    delete: 'Effacer'
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
            },
            adminCanDelete(){
                return Number.parseInt(window.adminRoleId) !== 2;
            }
        },
        methods: {
            itemAction(action, data, index){
                let url = window.adsUrl;
                if(action === 'delete'){
                    if(confirm(this.$t("confirm"))){
                        return this.delete(data.id);
                    }
                    return;
                }
                if(action === 'review'){
                    url = `${url}/${data.uuid}?action=review`;
                }
                if(action === 'view'){
                    url = `${url}/${data.uuid}?action=view`;
                }
                window.location = url;
            },
            delete(id){
                axios.delete(`${window.adsApiUrl}/${id}`).then(({data: {deleted}}) => {
                    if(deleted) window.location.reload(true);
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        mounted(){
            console.log(window.adminRoleId);
        }
    }
</script>
