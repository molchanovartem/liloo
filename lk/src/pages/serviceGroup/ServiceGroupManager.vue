<template>
    <div>
        <router-link :to="{name: 'serviceGroupCreate'}">Create</router-link>
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
                    <router-link :to="{name: 'serviceGroupUpdate', params: {id: props.row.id}}">
                        <i class="mdi mdi-pencil"></i>
                    </router-link>
                    <a href="#" @click.prevent="deleteRow(props.row.id)">
                        <i class="mdi mdi-delete"></i>
                    </a>
                </div>
                <span v-else>
                  {{props.formattedRow[props.column.field]}}
                </span>
            </template>
        </vue-good-table>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

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
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            serviceGroupDelete(id: $id)
                        }`,
                        variables: {
                            id: id
                        }
                    }).then(({data}) => {
                        self.rows.splice(index, 1)
                    });
                }
            },
            loadData() {
                this.$apollo.query({
                    query: gql`query {
                        serviceGroups {id, parent_id, name}
                    }`
                }).then(({data}) => {
                    this.rows = Array.from(data.serviceGroups);
                });
            }
        }
    };
</script>