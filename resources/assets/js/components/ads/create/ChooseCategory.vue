<template>
    <div class="ui modal">
        <div class="header">Choose Category</div>
        <div class="content two column grid">
            <div class="column">
                <categories></categories>
            </div>
            <div class="column">
                <sub-categories></sub-categories>
            </div>
        </div>
    </div>
</template>

<script>
    import Categories from './Categories.vue'
    import SubCategories from './SubCategories.vue'

    export default{
        data(){
            return{

            }
        },
        components:{
            'categories': Categories,
            'sub-categories': SubCategories,
        },
        mounted(){
            this.$on('open', () => {
                console.log('opening');
            })
        }
    }
</script>
