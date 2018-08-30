<template>
    <div>
        <a href="javascript:void(0)" @click="open = open ? false : true">{{salon.name}}</a>
        <salon-action-list :salon="salon" v-if="open"/>
    </div>
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