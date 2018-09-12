<template>
    <div class="content-block p-40 content-block_shadow">
        <div>
            <router-link :to="{name: 'userProfileUpdate'}"><i class="mdi mdi-pencil"></i></router-link>
        </div>
        {{content}}
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
                content: null
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
                        this.content = data.user;
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