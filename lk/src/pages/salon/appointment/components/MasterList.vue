<template>
    <div class="uk-grid uk-grid-small">
        <div class="uk-width-small">
            <div @click.prevent="selectedMaster(null)" class="uk-padding-small uk-box-shadow-small uk-text-center">
                Все
            </div>
        </div>
        <div class="uk-width-small" v-for="master in masters">
            <div @click.prevent="selectedMaster(master.id)" class="uk-padding-small uk-box-shadow-small uk-text-center">
                {{master.name}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MasterList",
        props: {
            masters: {
                type: Array,
                required: true
            }
        },
        methods: {
            selectedMaster(masterId) {
                this.$router.push({query: {master_id: masterId}});
            }
        },
    }
</script>