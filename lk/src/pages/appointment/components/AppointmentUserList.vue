<template>
    <div>
        <div v-for="user in users" class="uk-display-inline-block uk-margin-right uk-margin-bottom uk-card uk-card-default uk-padding-small">
            <div>Фотка</div>
            <div>Данные</div>
            <router-link :to="{name: 'appointmentManager', query: {salon_id: salonId, user_id: user.id}}">
                {{user.id}}
            </router-link>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "AppointmentUserList",
        props: {
            salonId: null
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                users: []
            }
        },
        methods: {
            loadData() {
                if (this.salonId) {
                    this.$apollo.query({
                        query: gql`query ($salonId: ID!) {
                            salon(id: $salonId) {
                                id, name, users {id, login}
                            }
                        }`,
                        variables: {
                            salonId: this.salonId
                        }
                    }).then(({data}) => {
                        this.users = data.salon.users;
                    });
                } else {
                    this.users = [];
                }
            }
        },
        watch: {
            salonId() {
                this.loadData();
            }
        }
    }
</script>