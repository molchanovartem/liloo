<template>
    <div class="content-block p-40 content-block_shadow">
        <div>
            <v-btn @click="$router.push({name: 'serviceCreate'})" round outline color="primary" depressed>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </div>
        <v-data-table
                :headers="headers"
                :items="items"
                :rows-per-page-items="[rowsPerPage]"
        >
            <template slot="items" slot-scope="{item}">
                <td width="300px">{{ item.name }}</td>
                <td>{{ item.price }}</td>
                <td>{{ item.duration }}</td>
                <td width="150px" align="right">
                    <v-btn fab small depressed @click.prevent="$router.push({name: 'serviceUpdate', params: {id: item.id}})">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn fab small depressed @click.prevent="deleteItem(item.id)">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {EVENT_DELETE} from "../../js/eventCollection";
    import {managerMixin} from "../js/mixins/managerMixin";

    export default {
        mixins: [managerMixin],
        mounted() {
            this.loadData();
        },
        data() {
            return {
                headers: [
                    {text: "Имя", value: 'name', sortable: false},
                    {text: "Цена", value: 'price', sortable: false},
                    {text: "Длительность", value: 'duration', sortable: false},
                    {text: null, value: null, sortable: false}
                ],
            };
        },
        methods: {
            updateItem(id) {
                  this.$router.push({name: 'serviceUpdate', params: {id: id}});
            },
            deleteItem(id) {
                let index = this.getItemIndex(id);

                if (index !== -1 && confirm('Удалить')) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            serviceDelete(id: $id)
                        }`,
                        variables: {
                            id: id
                        }
                    }).then(({data}) => {
                        if (data.serviceDelete) {
                            this.items.splice(index, 1)

                            this.$emit(EVENT_DELETE, id);
                        }
                    });
                }
            },
            loadData() {
                this.$apollo.query({
                    query: gql`query {
                        services {id, name, price, duration}
                    }`
                }).then(({data}) => {
                    this.items = Array.from(data.services);
                });
            }
        }
    };
</script>