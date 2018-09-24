<template>
    <div class="content-block p-40 content-block_shadow">
        <v-btn @click="$router.push({name: 'tariffList'})" round outline color="primary" depressed>Купить</v-btn>
        <v-data-table
                :headers="headers"
                :items="items"
                hide-actions
        >
            <template slot="items" slot-scope="props">
                <td width="30%">{{ props.item.name }}</td>
                <td>{{ props.item.start_date }}</td>
                <td>{{ props.item.end_date }}</td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "TariffManager",
        mounted() {
            this.loadData();
        },
        data() {
            return {
                headers: [
                    {text: 'Название', value: 'name'},
                    {text: 'Начало', value: 'start_date'},
                    {text: 'Окончание', value: 'end_date'},
                ],
                items: []
            };
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query {
                        accountTariffs {
                            id, tariff_id, price_id, start_date, end_date, tariff {id, name}
                        }
                    }`
                }).then(({data}) => {
                    if (data.accountTariffs) {
                        Array.from(data.accountTariffs).forEach(item => {
                            this.items.push({
                                name: item.tariff.name,
                                start_date: item.start_date,
                                end_date: item.end_date
                            });
                        });
                    }
                });
            }
        }
    }
</script>