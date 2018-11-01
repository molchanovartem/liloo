<template>
    <div class="content-block p-40 content-block_shadow">
        <div>
            <v-btn @click="$router.push({name: 'salonCreate'})" round outline color="primary" depressed>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </div>
        <v-data-table
                :headers="headers"
                :items="items"
                :rows-per-page-items="[rowsPerPage]"
        >
            <template slot="items" slot-scope="{item}">
                <td>{{ item.name }}</td>
                <td align="right">
                    <v-menu offset-y flat>
                        <v-btn
                                slot="activator"
                                fab small depressed
                        >
                            <v-icon>more_vert</v-icon>
                        </v-btn>
                        <v-list>
                            <v-list-tile @click="onMasterManager(item.id)">
                                <v-list-tile-title>Мастера</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="onServicemanager(item.id)">
                                <v-list-tile-title>Услуги</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                    <v-btn fab small depressed @click.prevent="$router.push({name: 'salonUpdate', params: {id: item.id}})">
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
                    {text: 'Имя', value: 'name', sortable: false},
                    {text: null, value: null, sortable: false},
                ],
            };
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query{
                        salons {id, name}
                    }`,
                }).then(({data}) => {
                    this.items = Array.from(data.salons);
                });
            },
            onMasterManager(branchId) {
                this.$router.push({name: 'salonMasterManager', params: {id: branchId}});
            },
            onServicemanager(branchId) {
                this.$router.push({name: 'salonServiceManager', params: {id: branchId}});
            },
            deleteItem(id) {
                let index = this.getItemIndex(id);

                if (index !== -1 && confirm('Удалить')) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            salonDelete(id: $id)
                        }`,
                        variables: {id: id}
                    }).then(({data}) => {
                        this.items.splice(index, 1);

                        this.$emit(EVENT_DELETE, id);
                    });
                }
            },
        }
    };
</script>