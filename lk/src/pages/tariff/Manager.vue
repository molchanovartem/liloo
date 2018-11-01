<template>
    <div class="content-block p-40 content-block_shadow">
        <v-btn @click="$router.push({name: 'tariffList'})" round outline color="primary" depressed>Купить</v-btn>
        <v-data-table
                :headers="headers"
                :items="items"
                :total-items="total"
                :pagination.sync="pagination"
                :rows-per-page-items="[rowsPerPage]"
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
    import {managerMixin} from "../js/mixins/managerMixin";

    export default {
        mixins: [managerMixin],
        name: "TariffManager",
        mounted() {
            this.loadData();
        },
        data() {
            return {
                headers: [
                    {text: 'Название', value: 'name', sortable: false},
                    {text: 'Начало', value: 'start_date', sortable: false},
                    {text: 'Окончание', value: 'end_date', sortable: false},
                ],
            };
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query($limit: Int, $offset: Int) {
                        accountTariffs(limit: $limit, offset: $offset) {
                            id, tariff_id, price_id, start_date, end_date, tariff {id, name}
                        }
                        ${this.total === 0 ? 'accountTariffsTotalCount' : ''}
                    }`,
                    variables: {
                        limit: this.rowsPerPage,
                        offset: this.getOffset(),
                    }
                }).then(({data}) => {
                    if (data.accountTariffsTotalCount !== undefined) this.total = data.accountTariffsTotalCount;
                    if (data.accountTariffs) {
                        this.items =  Array.from(data.accountTariffs).map(item => {
                            return {
                                name: item.tariff.name,
                                start_date: item.start_date,
                                end_date: item.end_date
                            };
                        });
                    }
                });
            }
        },
        watch: {
            'pagination.page': function () {
                this.loadData();
            }
        }
    }
</script>