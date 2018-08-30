<template>
    <div>
        <router-link :to="{name: 'serviceCreate'}">Create</router-link>
        <vue-good-table
                :columns="columns"
                :rows="rows"
                :search-options="{enabled: false}"
                :pagination-options="{
                    enabled: true,
                    perPage: 20,
                }"
                styleClass="uk-table uk-table-small uk-table-striped uk-table-hover">
            <template slot="table-row" slot-scope="props">
                <div v-if="props.column.field == 'buttons'">
                    <router-link :to="{name: 'serviceUpdate', params: {id: props.row.id}}">
                        <i class="mdi mdi-pencil"></i>
                    </router-link>
                    <a href="#" @click="deleteRow(props.row.id)">
                        <i class="mdi mdi-delete"></i>
                    </a>
                </div>
                <div v-else-if="props.column.field == 'portfolio'">
                    <router-link :to="{name: 'servicePortfolioUpdate', params: {id: props.row.id}}">Портфолио</router-link>
                </div>
                <span v-else>
                  {{props.formattedRow[props.column.field]}}
                </span>
            </template>
        </vue-good-table>
    </div>
</template>

<script>
    import {API} from "../../js/api";
    import _ from 'lodash';

    export default {
        mounted() {
            this.loadData();
        },
        data() {
            return {
                columns: [
                    {
                        label: 'Имя',
                        field: 'name',
                        filterOptions: {
                            enabled: false
                        }
                    },
                    {
                        label: 'Специализация',
                        field: 'specialization.name',
                        type: 'text'
                    },
                    {
                        label: 'Цена',
                        field: 'price',
                        type: 'currency'
                    },
                    {
                        label: 'Длительность',
                        field: 'duration',
                        type: 'number'
                    },
                    {
                        label: '',
                        field: 'portfolio',
                        html: true
                    },
                    {
                        label: 'id',
                        field: 'id'
                    },
                    {
                        label: '',
                        field: 'buttons',
                        html: true
                    }
                ],
                rows: []
            };
        },
        methods: {
            deleteRow(id) {
                let self = this,
                    index = _.findIndex(this.rows, {id: id});

                if (index !== -1) {
                    API.serviceDelete(id, data => {
                        if (data.success) {
                            self.rows.splice(index, 1);
                        }
                    });
                }
            },
            loadData() {
                API.serviceGetItems(data => {
                    this.rows = data;
                });
            }
        }
    };
</script>