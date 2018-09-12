<template>
    <div>
        <ul>
            <li v-for="master in masters">
                <a href="#" @click.prevent="selectedMaster(master.id)">{{master.name}} id: {{master.id}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "MasterList",
        props: {
            salonId: {
                type: String,
                required: true
            }
        },
        mounted() {
            this.loadData();
            this.setSelectedMaster();
        },
        data() {
            return {
                masters: [],
                masterSelected: null
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query ($salonId: ID!) {
                       salon(id: $salonId) {
                            id, name, masters {id, surname, name, patronymic}
                       }
                    }`,
                    variables: {
                        salonId: this.salonId
                    }
                }).then(({data}) => {
                    this.masters = data.salon.masters;
                });
            },
            setSelectedMaster() {
                this.masterSelected = this.$route.query.master_id || null;
            },
            selectedMaster(masterId) {
                this.$router.push({name: 'masterScheduleManager', params: {masterId: masterId}});
            }
        },
        watch: {
            'salonId': function () {
                this.loadData();
            },
            '$route.query.master_id': function () {
                this.setSelectedMaster();
            }
        }
    }
</script>