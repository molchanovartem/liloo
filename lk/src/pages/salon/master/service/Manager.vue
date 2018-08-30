<template>
    <div class="content-block p-40 content-block_shadow">
        <div>
            <v-checkbox v-for="item in services" hide-details :label="item.name" :value="item.id"
                        v-model="selected"></v-checkbox>
        </div>

        <div class="uk-margin-small-top">
            <v-btn round outline large color="primary" @click="onSubmit()">
                Сохранить
                <v-icon right>mdi-content-save</v-icon>
            </v-btn>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "MasterServiceManager",
        props: {
            masterId: {
                type: String,
                required: true
            },
            salonId: {
                type: String,
                required: true
            }
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                services: [],
                selected: [],
                masterServices: []
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query ($masterId: ID!, $salonId: ID!) {
                        salonServices(salon_id: $salonId) {
                            id, service_id, service_price, service_duration, service {id, name, price, duration}
                        },
                        masterServices(master_id: $masterId, salon_id: $salonId) {
                            id, master_id, salon_id, service_id
                        }
                    }`,
                    variables: {
                        masterId: this.masterId,
                        salonId: this.salonId
                    }
                }).then(({data}) => {
                    Array.from(data.salonServices).forEach(item => {
                        this.services.push({id: item.service_id, name: item.service.name});
                    });

                    this.selected = Array.from(data.masterServices).map(item => {
                        return item.service_id;
                    });
                    this.masterServices = Array.from(data.masterServices);
                });
            },
            onSubmit() {
                if (this.selected.length === 0) {
                    alert('Выберите услуги');
                    return;
                }

                this.$apollo.mutate({
                    mutation: gql`mutation ($masterId: ID!, $salonId: ID!, $servicesId: [ID]!) {
                        masterServicesUpdate(master_id: $masterId, salon_id: $salonId, services_id: $servicesId)
                    }`,
                    variables: {masterId: this.masterId, salonId: this.salonId, servicesId: this.selected}
                }).then(({data}) => {
                    if (data.masterServicesUpdate) {
                        this.$emit('save');
                    }
                });
            }
        }
    }
</script>