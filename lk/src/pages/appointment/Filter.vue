<template>
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <v-text-field
                    v-model="attributes.surname"
                    append-icon="search"
                    label="Фамилия"
                    single-line
                    hide-details
            ></v-text-field>
        </div>

        <div class="uk-width-1-2">
            <v-text-field
                    v-model="attributes.phone"
                    append-icon="search"
                    label="Телефон"
                    single-line
                    hide-details
            ></v-text-field>
        </div>

        <div class="uk-margin-small-top">
            <v-btn small @click="search()">Поиск</v-btn>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "AppointmentListFilter",
        data() {
            return {
                attributes: {
                    surname: null,
                    phone: null
                }
            }
        },
        methods: {
            search() {
                if (this.attributes.surname === null && this.attributes.phone === null) {
                    alert('Заполните')
                } else {
                    this.$apollo.query({
                        query: gql`query($filter: ClientFilter) {
                        clients(filter: $filter) {id}
                    }`,
                        variables: {
                            filter: {
                                surname_contains: this.attributes.surname,
                                phone_contains: this.attributes.phone,
                            },
                        }
                    }).then(({data}) => {
                        this.$emit('submit', data.clients.map(item => {
                            return item.id;
                        }));
                    });
                }
            }
        },
    }
</script>