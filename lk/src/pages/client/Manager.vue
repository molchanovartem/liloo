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
                    <v-btn fab small depressed @click.prevent="updateItem(props.item.id)">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn fab small depressed @click.prevent="deleteItem(props.item.id)">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </td>
            </template>
        </v-data-table>

        <input type="file" @change="processData($event)">
    </div>
</template>

<script>
    import axios from 'axios';
    import gql from 'graphql-tag';

    export default {
        mounted() {
            this.loadData();
        },
        data() {
            return {
                headers: [
                    {text: "Имя", value: 'name'},
                    {text: null, value: null, sortable: false}
                ],
                items: [],

                file: null
            }
        },
        methods: {
            processData(event) {
                let form = new FormData;

                form.append("query", 'mutation {' +
                    'convenienceCreate(attributes: {name: "asdasdasd", file: "123123"}) {id, name}' +
                    '}');
                form.append("file", event.target.files[0]);

                let res = axios.post('http://liloo/api/graphql/index', form, {
                    headers: {'Authorization': "Bearer " + 12345}
                });

                console.log(res);
            },

            onCreate() {
              this.$router.push({name: 'clientCreate'});
            },
            loadData() {
                this.$apollo.query({
                    query: gql`{clients {id, surname, name, patronymic, date_birth}}`
                }).then(({data}) => {
                    this.items = Array.from(data.clients);
                });
            },
            updateItem(id) {
                this.$router.push({name: 'clientUpdate', params: {id: id}})
            },
            deleteItem(id) {
                let index = this.items.findIndex(item => {
                        return +item.id === +id;
                    });

                if (index !== -1 && confirm('Удалить')) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            clientDelete(id: $id)
                        }`,
                        variables: {
                            id: id
                        }
                    }).then(({data}) => {
                        if (data.clientDelete) this.items.splice(index, 1);
                    });
                }
            },
        }
    }
</script>