<template>
    <div class="item"  v-if="hasSub">
        <i class="dropdown icon"></i>
        <span class="text" v-text="item.name"></span>
        <div class="menu">
            <div v-for="sub in item.children" :key="sub.id" :data-value="sub.id" class="item" v-text="sub.name"></div>
        </div>
    </div>
    <div class="item" :data-value="item.id" v-else v-text="item.name"></div>
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
        }
    }
</script>