
<style scoped>
    img.ui.mini.right.spaced.image{
        width: 20px;
    }
    div.title{
        color: #4a597d !important;
    }

    div.ui.link.celled.relaxed.selection.list .item:hover{
        color: #4a597d !important;
        background: white !important;
    }
</style>


<template>

    <div>
        <template v-if="hasSub">
            <div class="title">
                <i class="dropdown icon"></i>
                <img class="ui mini right spaced image" :src="item.icon">
                {{ item.name }}
            </div>
            <div class="content">
                <div class="ui link celled relaxed selection list">
                    <a v-for="sub in item.children" class="item" @click="select(sub.id, sub.name)" v-text="sub.name"/>
                </div>
            </div>
        </template>
        <div v-else class="title" @click="select(item.id, item.name)">
            <img class="ui mini right spaced image" style="width: 20px;" :src="item.icon">
            {{ item.name }}
        </div>
    </div>

</template>


<script>
    import _ from 'lodash';

    export default {
        props: ['item'],
        computed: {
            hasSub(){
                if(_.isEmpty(this.item.children)){
                    return false;
                }
                return true;
            }
        },
        methods: {
            select(id, name){
                this.$emit('selected', {id, name});
            }
        }
    }
</script>