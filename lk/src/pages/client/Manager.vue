<template>
    <div class="content-block p-40 content-block_shadow">
        <div>
            <v-btn @click="$router.push({name: 'clientCreate'})" round outline color="primary" depressed>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </div>

        <v-data-table
                :headers="headers"
                :items="items"
                hide-actions
        >
            <template slot="items" slot-scope="{item}">
                <td>{{ item.name }}</td>
                <td align="right">
                    <v-btn fab small depressed @click.prevent="$router.push({name: 'clientUpdate', params: {id: item.id}})">
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
    import {managerMixin} from "../../js/mixins/managerMixin";

    export default {
        mixins: [managerMixin],
        mounted() {
            this.loadData();
        },
        data() {
            return {
                headers: [
                    {text: "Имя", value: 'name'},
                    {text: null, value: null, sortable: false}
                ],
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`{clients {id, surname, name, patronymic, date_birth}}`
                }).then(({data}) => {
                    this.items = Array.from(data.clients);
                });
            },
            deleteItem(id) {
                let index = this.getItemIndex(id);

                if (index !== -1 && confirm('Удалить')) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            clientDelete(id: $id)
                        }`,
                        variables: {
                            id: id
                        }
                    }).then(({data}) => {
                        if (data.clientDelete) {
                            this.items.splice(index, 1);

                            this.$emit(EVENT_DELETE, id);
                        }
                    });
                }
            },
        }
    }
</script>