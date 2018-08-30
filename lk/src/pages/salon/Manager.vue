<template>
    <div class="content-block p-40 content-block_shadow">
        <div>
            <v-btn @click="onCreate()" round outline color="primary" depressed>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </div>
        <v-data-table
                :headers="headers"
                :items="items"
                hide-actions
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td align="right">
                    <v-menu offset-y flat>
                        <v-btn
                                slot="activator"
                                fab small depressed
                        >
                            <v-icon>more_vert</v-icon>
                        </v-btn>
                        <v-list>
                            <v-list-tile @click="onMasterManager(props.item.id)">
                                <v-list-tile-title>Мастера</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="onServicemanager(props.item.id)">
                                <v-list-tile-title>Услуги</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                    <v-btn fab small depressed @click.prevent="updateItem(props.item.id)">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn fab small depressed @click.prevent="deleteItem(props.item.id)">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </td>
            </template>
        </v-data-table>
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
                headers: [
                    {text: 'Имя', value: 'name'},
                    {text: null, value: null},
                ],
                items: []
            };
        },
        methods: {
            onCreate() {
                this.$router.push({name: 'salonCreate'});
            },
            onMasterManager(branchId) {
                this.$router.push({name: 'salonMasterManager', params: {id: branchId}});
            },
            onServicemanager(branchId) {
                this.$router.push({name: 'salonServiceManager', params: {id: branchId}});
            },
            updateItem(id) {
                this.$router.push({name: 'salonUpdate', params: {id: id}});
            },
            deleteItem(id) {
                let index = this.items.findIndex(item => {
                    return +item.id === +id;
                });

                if (index !== -1 && confirm('Удалить')) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            salonDelete(id: $id)
                        }`,
                        variables: {id: id}
                    }).then(({data}) => {
                        this.items.splice(index, 1);
                    });
                }
            },
            loadData() {
                this.$apollo.query({
                    query: gql`{salons {id, name}}`
                }).then(({data}) => {
                    this.items = Array.from(data.salons);
                });
            }
        }
    };
</script>