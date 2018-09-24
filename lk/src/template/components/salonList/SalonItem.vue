<template>
    <li class="uk-margin-remove-top">
        <div class="uk-padding-small uk-text-center">
            <a href="javascript:void(0)" @click="open = open ? false : true">
                <span class="menu-blocks__item-name">{{salon.name}}</span>
            </a>
            <salon-action-list :salon="salon" v-if="open"/>
        </div>
    </li>
</template>

<script>
    import SalonActionList from './SalonActionList.vue';

    export default {
        name: "SalonItem",
        props: {
            salon: {
                type: Object,
                required: true
            }
        },
        components: {
            SalonActionList
        },
        data() {
            return {
                open: false
            }
        },
    }
</script>

<style scoped>

</style>