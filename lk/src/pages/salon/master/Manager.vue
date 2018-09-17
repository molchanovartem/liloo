<template>
    <div class="content-block p-40 content-block_shadow">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-1-1 uk-margin">
                <v-btn round outline depressed class="uk-margin-remove" @click="toggleMasterItems">
                    <span v-if="!showMasterItems"><i class="mdi mdi-eye"></i> Показать список мастеров</span>
                    <span v-else><i class="mdi mdi-eye-off"></i> Скрыть список мастеров</span>
                </v-btn>
            </div>
            <div :class="[showMasterItems ? 'uk-width-2-5': 'uk-hidden']">
                <div class="uk-flex">
                    <div class="uk-width-expand">
                        <h4>Мастера</h4>
                    </div>
                    <div class="uk-width-auto">
                        <v-menu dense offset-x :close-on-content-click="false">
                            <v-btn fab small depressed outline slot="activator">
                                <v-icon>mdi-magnify</v-icon>
                            </v-btn>
                            <v-text-field v-model="masterSearch" solo hide-details clearable/>
                        </v-menu>
                        <v-btn fab depressed small outline color="primary">
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                        <v-btn fab depressed small outline :disabled="mastersSelected.length === 0"
                               @click="onAddMasters">
                            <v-icon>mdi-arrow-right</v-icon>
                        </v-btn>
                    </div>
                </div>

                <ul class="uk-list uk-list-divider">
                    <li v-for="(item, index) in cpdMasterItems">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-auto">
                                <input type="checkbox" :value="item.id" v-model="mastersSelected"/>
                            </div>
                            <div class="uk-width-expand">{{item.name}}</div>
                        </div>
                    </li>
                </ul>
            </div>
            <div :class="[showMasterItems ? 'uk-width-3-5': 'uk-width-1-1']">
                <h4>Мастера салона</h4>
                <ul v-if="salonMasters.length > 0" class="uk-list uk-list-divider">
                    <li v-for="(item, index) in salonMasters">
                        <div class="uk-flex uk-flex-middle">
                            <div class="uk-width-expand">
                                {{item.master.name}}
                            </div>
                            <div class="uk-width-auto">
                                <v-menu offset-y flat>
                                    <v-btn
                                            slot="activator"
                                            fab small depressed
                                            class="uk-margin-small-right"
                                    >
                                        <v-icon>more_vert</v-icon>
                                    </v-btn>
                                    <v-list>
                                        <v-list-tile @click="onServiceManager(item.master_id)">
                                            <v-list-tile-title>Услуги</v-list-tile-title>
                                        </v-list-tile>
                                        <v-list-tile @click="onScheduleManager(item.master_id)">
                                            <v-list-tile-title>График работы</v-list-tile-title>
                                        </v-list-tile>
                                    </v-list>
                                </v-menu>

                                <v-btn fab small depressed class="uk-margin-small-right"
                                       @click.prevent="onDeleteServiceMaster(item.master_id)">
                                    <v-icon>mdi-minus</v-icon>
                                </v-btn>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul v-else class="uk-list uk-list-divider">
                    <li>Нет мастеров</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import gql from 'graphql-tag';

    export default {
        name: "SalonMasterManager",
        props: {
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
                commonMasterItems: [],
                masterItems: [],
                mastersSelected: [],
                masterSearch: null,
                salonMasters: [],
                showMasterItems: false,
            }
        },
        computed: {
            cpdMasterItems() {
                if (this.masterSearch) {
                    let string = this.masterSearch.toLowerCase();

                    return this.masterItems.filter(item => {
                        return item.name.toLowerCase().indexOf(string) > -1
                    })
                }
                return this.masterItems;
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query ($salonId: ID!) {
                        salonMasters(salon_id: $salonId) {salon_id, master_id, master {id, name}}
                    }`,
                    variables: {
                        salonId: this.salonId
                    }
                }).then(({data}) => {
                    this.salonMasters = Array.from(data.salonMasters);
                });
            },
            loadMasters() {
                this.$apollo.query({
                    query: gql`query {
                        masters {id, surname, name, patronymic}
                    }`,
                    variables: {
                        salonId: this.salonId
                    }
                }).then(({data}) => {
                    this.commonMasterItems = Array.from(data.masters);

                    this.refreshMasterItems();
                });
            },
            toggleMasterItems() {
                this.showMasterItems = !this.showMasterItems;

                if (this.showMasterItems && this.commonMasterItems.length === 0) {
                    this.loadMasters();
                }
            },
            refreshMasterItems() {
                this.masterItems = this.commonMasterItems.filter(item => {
                    return !this.hasSalonMasterId(item.id);
                });
            },
            onAddMasters() {
                if (this.mastersSelected.length === 0) {
                    alert('Выберите мастера');
                    return;
                }

                let mastersSelected = this.getMasterItemsSelected();

                for (let i = 0, item; item = mastersSelected[i]; i++) {
                    if (this.hasSalonMasterId(item.id)) {
                        alert('Мастер есть в списке');
                        return;
                    }
                }

                this.$apollo.mutate({
                    mutation: gql`mutation ($salonId: ID!, $mastersId: [ID]!) {
                        salonMastersCreate (salon_id: $salonId, masters_id: $mastersId)
                    }`,
                    variables: {
                        salonId: this.salonId,
                        mastersId: this.mastersSelected
                    }
                }).then(({data}) => {
                    if (data.salonMastersCreate) {
                        mastersSelected.forEach(item => {
                            let master = {
                                master_id: item.id,
                                salon_id: this.salonId,
                                master: {id: item.id, name: item.name}
                            };
                            this.salonMasters.push(master);
                        });

                        this.mastersSelected = [];
                        this.refreshMasterItems();
                    }
                });
            },
            onServiceManager(masterId) {
                this.$router.push({name: 'masterServiceManager', params: {id: this.salonId, masterId: masterId}});
            },
            onScheduleManager(masterId) {
                this.$router.push({name: 'masterScheduleManager', params: {id: this.salonId, masterId: masterId}});
            },
            onDeleteServiceMaster(masterId) {
                let index = this.getSalonMasterIndex(masterId);

                if (index !== -1 && confirm('Удалить?')) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($salonId: ID!, $masterId: ID!) {
                            salonMasterDelete(salon_id: $salonId, master_id: $masterId)
                        }`,
                        variables: {salonId: this.salonId, masterId: masterId}
                    })
                        .then(({data}) => {
                            if (data.salonMasterDelete) {
                                this.$emit('delete');
                                this.salonMasters.splice(index, 1);

                                this.refreshMasterItems();
                            }
                        });
                }
            },
            hasSalonMasterId(masterId) {
                return this.salonMasters.findIndex(item => {
                    return +item.master_id === +masterId;
                }) !== -1;
            },
            hasMasterSelected(masterId) {
                return this.mastersSelected.indexOf(masterId) !== -1;
            },
            getMasterItemsSelected() {
                return this.masterItems.filter(item => {
                    return this.hasMasterSelected(item.id);
                })
            },
            getSalonMasterIndex(masterId) {
                return this.salonMasters.findIndex(item => {
                    return +item.master_id === +masterId;
                });
            },
        },
        watch: {
            salonId() {
                this.loadData();
            },
        }
    }
</script>