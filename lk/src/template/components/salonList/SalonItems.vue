<template>
    <div>
        <salon-item :salon="salon" v-for="salon in salons"/>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import SalonItem from './SalonItem';

    export default {
        name: "SalonItems",
        components: {
            SalonItem
        },
        created() {
            this.loadItems();
        },
        data() {
            return {
                salons: []
            }
        },
        methods: {
            loadItems() {
                this.$apollo.query({
                    query: gql`query {
                        salons {id, name}
                    }`
                }).then(({data}) => {
                    this.salons = data.salons;
                });

            }
        }
    }
</script>