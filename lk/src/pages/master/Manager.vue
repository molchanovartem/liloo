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
                <td width="150px" align="right">
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
        name: "MasterManager",
        mounted() {
            this.loadData();
        },
        data() {
            return {
                headers: [
                    {text: 'Имя', value: 'name'},
                    {text: null, value: null, sortable: false}
                ],
                items: []
            };
        },
        methods: {
            onCreate() {
              this.$router.push({name: 'masterCreate'});
            },
            loadData() {
                this.$apollo.query({
                    query: gql`query {
                        masters {id, surname, name, patronymic, date_birth}
                    }`
                }).then(({data}) => {
                    this.items = Array.from(data.masters);
                });
            },
            updateItem(id) {
                this.$router.push({name: 'masterUpdate', params: {id: id}});
            },
            deleteItem(id) {
                let index = this.items.findIndex(item => {
                    return +item.id === +id;
                });

                if (index !== -1 && confirm('Удалить')) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            masterDelete(id: $id)
                        }`,
                        variables: {id: id}
                    }).then(({data}) => {
                        this.items.splice(index, 1);
                    });
                }
            },
        }
    }
</script>