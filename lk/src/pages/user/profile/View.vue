<template>
    <div class="content-block p-40 content-block_shadow">
        <div>
            <v-btn @click="$router.push({name: 'userProfileUpdate'})" round outline color="primary" depressed>
                Редактировать
            </v-btn>
        </div>
        <table class="uk-table uk-table-small uk-table-divider">
            <tbody>
            <tr>
                <td>Фамилия</td><td>{{data.profile.surname}}</td>
            </tr>
            <tr>
                <td>Имя</td><td>{{data.profile.name}}</td>
            </tr>
            <tr>
                <td>Отчество</td><td>{{data.profile.patronymic}}</td>
            </tr>
            <tr>
                <td>Телефон</td><td>{{data.profile.phone}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: 'UserProfileView',
        created() {
            this.loadData();
        },
        data() {
            return {
                data: {
                    profile: {
                        surname: null,
                        name: null,
                        patronymic: null,
                        phone: null,
                        date_birth: null
                    }
                }
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query {
                        user {login, profile {surname, name, patronymic, phone, date_birth}}
                    }`
                }).then(({data}) => {
                    if (data.user) {
                        this.data = data.user;
                    }
                });
            },
            isAvatar() {
                return this.attributes.avatar !== null && this.attributes.avatar !== '';
            },
            getAvatarUrl() {
                return this.isAvatar() ? 'http://lilu//public/uploads/' + this.attributes.avatar.substr(0, 1) + '/' + this.attributes.avatar : '';
            },
        }
    }
</script>