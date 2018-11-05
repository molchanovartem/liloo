<template>
    <div class="content-block p-40 content-block_shadow">
        <v-filter @submit="onSearch"/>
        <v-data-table
                :headers="headers"
                :items="items"
                :total-items="total"
                :pagination.sync="pagination"
                :rows-per-page-items="[rowsPerPage]"
        >
            <template slot="items" slot-scope="{item}">
                <td>{{ item.id }}</td>
                <td>
                    <a @click.prevent="$router.push({name: 'clientUpdate', params: {id: item.client.id}})">
                        {{ getShortName(item.client) }}
                    </a>
                </td>
                <td>{{ item.start_date }}</td>
                <td>{{ item.client.phone }}</td>
                <td>{{ item.client.items.service_name }}</td>
                <td>{{ getStatusName(item.status) }}</td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {managerMixin} from "../js/mixins/managerMixin";
    import {appointmentStatus, APPOINTMENT_STATUS_CONFIRMED} from "./status";
    import VFilter from './Filter.vue';

    export default {
        mixins: [managerMixin],
        components: {
            VFilter
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                headers: [
                    {text: "", value: 'id', sortable: false},
                    {text: "Клиент", value: 'client', sortable: false},
                    {text: "Дата", value: 'start_date', sortable: false},
                    {text: "Телефон", value: 'phone', sortable: false},
                    {text: "Услуга", value: 'service_name', sortable: false},
                    {text: "Стоимось", value: 'service_price', sortable: false},
                    {text: "Статус", value: 'status', sortable: false}
                ],
                filter: {
                    client_id_in: [],
                }
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query($filter: AppointmentFilter, $limit: Int, $offset: Int) {
                        appointments(filter: $filter, limit: $limit, offset: $offset)
                            {
                                id,
                                client {
                                    id,
                                    name,
                                    surname,
                                    phone,
                                    items {
                                        service_name,
                                        service_price
                                    }
                                },
                                start_date,
                                status
                            }
                        ${this.total === 0 ? 'appointmentTotalCount(filter: $filter)' : ''}
                    }`,
                    variables: {
                        filter: this.filter,
                        limit: this.rowsPerPage,
                        offset: this.getOffset(),
                    }
                }).then(({data}) => {
                    if (data.appointmentTotalCount !== undefined) this.total = data.appointmentTotalCount;
                    this.items = Array.from(data.appointments);
                });
            },
            onSearch(data) {
                this.filter.client_id_in = data;
                this.total = 0;
                if (this.filter.client_id_in.length === 0) this.items = [];
                else this.loadData();
            },
            getStatusName(status) {
                return appointmentStatus.getStatusName(status);
            },
            getShortName(client) {
                return client.surname + ' ' + client.name.charAt(0) + '.'
            },
            getSum(data) {
                data.map(item => {
                        return item.id;
                    })
            }

        },
        watch: {
            'pagination.page': function () {
                this.loadData();
            }
        }
    }
</script>