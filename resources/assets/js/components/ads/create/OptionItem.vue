<template>

    <div>
        <template v-if="hasSub">
            <div class="title">
                <i class="dropdown icon"></i>
                {{ item.name }}
            </div>
            <div class="content">
                <div class="ui link divided list">
                    <a v-for="sub in item.children" class="item" @click="select(sub.id, sub.name)" v-text="sub.name"/>
                </div>
            </div>
        </template>
        <div v-else class="title" @click="select(item.id, item.name)">
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