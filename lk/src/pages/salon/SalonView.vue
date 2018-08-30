<template>
    <div>
        <v-detail-view :attributes="{id: attributes.id, name: attributes.name}"></v-detail-view>
    </div>
</template>

<script>
    import {API} from "../../js/api";
    import VDetailView from '../../components/DetailView.vue';

    let text = 'Просмотр салона';

    export default {
        mounted() {
            this.$store.commit('setHeading', text);
            this.$store.commit('addBreadcrumbItems', [{label: 'Салоны', url: '/salon/manager'}, {label: text}]);

            let id = this.$route.params.id;

            API.salonGetItem(id, response => {
                this.attributes = response;
            })
        },
        data() {
            return {
                attributes: {}
            }
        },
        components: {
            VDetailView
        }
    }
</script>