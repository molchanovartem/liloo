<template>
    <div>
        <div>
            <router-link :to="{name: 'userProfileUpdate'}"><i class="mdi mdi-pencil"></i></router-link>
        </div>
        <div v-if="isAvatar()" class="uk-display-inline-block uk-overflow-hidden" style="width: 200px;">
            <img :src="getAvatarUrl()" class="uk-border-circle" alt="" style="width: 100%"/>
        </div>
        <div class="uk-display-inline-block">
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';

    let text = 'Профиль';

    export default {
        mounted() {
            this.$store.commit('setHeading', text);
            this.$store.commit('addBreadcrumbItems', [{label: text}]);
        },
        components: {
        },
        data() {
            return {
                attributes: {surname: null, name: null, patronymic: null, avatar: null}
            }
        },
        methods: {
            isAvatar() {
                return this.attributes.avatar !== null && this.attributes.avatar !== '';
            },
            getAvatarUrl() {
                return this.isAvatar() ? 'http://lilu//public/uploads/' + this.attributes.avatar.substr(0, 1) + '/' + this.attributes.avatar : '';
            },
        }
    }
</script>