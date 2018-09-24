<template>
    <div>
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-1-3 uk-margin-small-top" v-for="item in items">
                <v-list-item :item="item"/>
            </div>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import VListItem from './ListItem.vue';

    export default {
        name: "TariffList",
        components: {
            VListItem
        },
        mounted() {
            this.loadItems();
        },
        data() {
            return {
                items: [],
                selected: null,
            };
        },
        methods: {
            loadItems() {
                this.$apollo.query({
                    query: gql`query {
                        tariffs (status: 1) {id, name, description, type, status, quantity, prices {id, price, day}}
                    }`
                }).then(({data}) => {
                    this.items = data.tariffs;
                })
            },
        }
    }
</script>
