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
    import {API} from "../../js/api";

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
                    API.salonUserGetItems({salon_id: this.salonId}, response => {
                        if (Array.isArray(response)) this.users = response;
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