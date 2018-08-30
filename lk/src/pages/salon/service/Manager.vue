<template>
    <div class="content-block p-40 content-block_shadow">
        <ul>@todo
            <li>Валидация</li>
        </ul>

        <div class="uk-grid uk-grid-small">
            <div class="uk-width-2-5">
                <div class="uk-flex">
                    <div class="uk-width-expand">
                        <h4>Услуги</h4>
                    </div>
                    <div class="uk-width-auto">
                        <v-menu dense offset-x :close-on-content-click="false">
                            <v-btn fab small depressed outline slot="activator">
                                <v-icon>mdi-magnify</v-icon>
                            </v-btn>
                            <v-text-field v-model="serviceSearch" solo hide-details clearable/>
                        </v-menu>
                        <v-btn fab depressed small outline color="primary">
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                        <v-btn fab depressed small outline :disabled="selected.length === 0"
                               @click="onAdd">
                            <v-icon>mdi-arrow-right</v-icon>
                        </v-btn>
                    </div>
                </div>

                <ul class="uk-list uk-list-divider">
                    <li v-for="(item, index) in cpdServiceItems">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-auto">
                                <input type="checkbox" :value="item.id" v-model="selected"/>
                            </div>
                            <div class="uk-width-expand">{{item.name}}</div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="uk-width-3-5">
                <h4>Мастера салона</h4>
                <ul v-if="salonServices.length > 0" class="uk-list uk-list-divider">
                    <li v-for="(item, index) in salonServices">
                        <div class="uk-flex uk-flex-middle">
                            <div class="uk-width-expand">
                                <div>{{item.service.name}}</div>
                                <div>Цена: <span v-if="!item.edit">{{item.service_price | currency}}</span>
                                    <v-text-field
                                            v-model="item.attributes.price.value"
                                            :error="item.attributes.price.error"
                                            :error-messages="item.attributes.price.errorMessage"
                                            v-if="item.edit"
                                    />
                                </div>
                                <div>Длительность: <span v-if="!item.edit">{{item.service_duration}}</span>
                                    <v-text-field
                                            v-model="item.attributes.duration.value"
                                            :error="item.attributes.duration.error"
                                            :error-messages="item.attributes.duration.errorMessage"
                                            mask="###"
                                            v-if="item.edit"
                                    />
                                </div>
                            </div>
                            <div class="uk-width-auto">
                                <v-btn fab small depressed v-if="!item.edit" @click="item.edit = !item.edit">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <v-btn fab small depressed v-else @click="onSaveItemAttributes(item)">
                                    <v-icon>mdi-content-save</v-icon>
                                </v-btn>

                                <v-btn fab small depressed class="uk-margin-small-right"
                                       @click.prevent="onDelete(item.id)">
                                    <v-icon>mdi-minus</v-icon>
                                </v-btn>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul v-else class="uk-list uk-list-divider">
                    <li>Нет услуг</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {formRules} from "../../../js/formRules";
    import {commonFilters} from "../../../js/mixins/commonFilters";

    export default {
        name: "Manager",
        props: {
            salonId: {
                type: String,
                required: true
            }
        },
        mixins: [commonFilters],
        mounted() {
            this.loadData();
        },
        data() {
            return {
                commonServiceItems: [],
                serviceItems: [],
                selected: [],
                serviceSearch: null,
                salonServices: []
            }
        },
        computed: {
            cpdServiceItems() {
                if (this.serviceSearch) {
                    let string = this.serviceSearch.toLowerCase();

                    return this.serviceItems.filter(item => {
                        return item.name.toLowerCase().indexOf(string) > -1
                    })
                }
                return this.serviceItems;
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query ($salonId: ID!) {
                        services {id, name, price, duration},
                        salonServices(salon_id: $salonId) {id, service_id, service_price, service_duration, service {id, name}}
                    }`,
                    variables: {
                        salonId: this.salonId
                    }
                }).then(({data}) => {
                    this.commonServiceItems = Array.from(data.services);
                    this.salonServices = Array.from(data.salonServices).map(item => {
                        return this.assignItem(item);
                    });

                    this.refreshServiceItems();
                });
            },
            refreshServiceItems() {
                this.serviceItems = this.commonServiceItems.filter(item => {
                    return !this.hasSalonService(item.id);
                });
            },
            onAdd() {
                if (this.selected.length === 0) {
                    alert('Выберите услугу');
                    return;
                }

                let servicesSelected = this.getServiceItemsSelected();

                /*
                 * @todo
                 * Сделать проверку дублирование записей
                 */

                this.$apollo.mutate({
                    mutation: gql`mutation ($items: [SalonServiceCreateInput]!) {
                            salonServicesCreate(items: $items) {
                                id, service_id, service_price, service_duration, service {id, name}
                            }
                        }`,
                    variables: {
                        items: servicesSelected.map(item => {
                            return {
                                salon_id: this.salonId,
                                service_id: item.id,
                                service_price: item.price,
                                service_duration: item.duration
                            }
                        })
                    }
                })
                    .then(({data}) => {
                        if (data.salonServicesCreate) {
                            let items = Array.from(data.salonServicesCreate);

                            items.forEach(item => {
                                this.salonServices.push(this.assignItem(item));
                            });

                            this.refreshServiceItems();
                            this.$emit('createItems', items);
                        }
                    });
            },
            onSaveItemAttributes(item) {
                if (!this.isItemAttributesChange(item)) {
                    item.edit = false;
                    return;
                }

                if (this.validateItemAttributes(item)) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!, $attributes: SalonServiceUpdateInput!) {
                        salonServiceUpdate(id: $id, attributes: $attributes) {
                            id, service_price, service_duration
                        }
                    }`,
                        variables: {
                            id: item.id,
                            attributes: {
                                service_price: item.attributes.price.value,
                                service_duration: item.attributes.duration.value
                            }
                        }
                    })
                        .then(({data}) => {
                            if (data.salonServiceUpdate) {
                                item.edit = false;
                                // @todo форматирование
                                item.service_price = data.salonServiceUpdate.service_price;
                                item.service_duration = data.salonServiceUpdate.service_duration;

                                this.$emit('save', data.salonServiceUpdate);
                            }
                        });
                }
            },
            onDelete(id) {
                let index = this.getSalonServiceIndex(id);

                if (confirm('Удалить') && index !== -1) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($id: ID!) {
                            salonServiceDelete(id: $id)
                        }`,
                        variables: {id: id}
                    })
                        .then(({data}) => {
                            if (data.salonServiceDelete) {
                                this.$emit('delete');
                                this.salonServices.splice(index, 1);

                                this.refreshServiceItems();
                            }
                        })
                }
            },
            isItemAttributesChange(item) {
                return +item.service_price !== +item.attributes.price.value || +item.service_duration !== +item.attributes.duration.value;
            },
            validateItemAttributes(item) {
                let valid = true,
                    rules = [
                        {attributes: ['price', 'duration'], validator: formRules.required, param: null},
                        {attributes: ['price', 'duration'], validator: formRules.number, param: {strict: true}},
                        {attributes: 'duration', validator: formRules.length, param: {max: 3}},
                    ];

                for (let i = 0, rule; rule = rules[i]; i++) {
                    if (!valid) break;

                    if (Array.isArray(rule.attributes)) {
                        for (let ii = 0, attributeName; attributeName = rule.attributes[ii]; ii++) {
                            if (!validAttribute(item, attributeName, rule.validator, rule.param || null)) {
                                valid = false;
                            } else {
                                clearValidParam(item, attributeName);
                            }
                        }
                    } else {
                        if (!validAttribute(item, rule.attributes, rule.validator, rule.param || null)) {
                            valid = false;
                        } else {
                            clearValidParam(item, rule.attributes);
                        }
                    }
                }

                function validAttribute(item, attributeName, validator, param = null) {
                    let message;

                    if (param !== null) message = validator(item.attributes[attributeName].value, param);
                    else message = validator(item.attributes[attributeName].value);

                    if (message !== true) {
                        item.attributes[attributeName].error = true;
                        item.attributes[attributeName].errorMessage = message;
                    }
                    return message === true;
                }

                function clearValidParam(item, attributeName) {
                    item.attributes[attributeName].error = false;
                    item.attributes[attributeName].errorMessage = null;
                }

                return valid;
            },
            getService(serviceId) {
                for (let i = 0, service; service = this.services[i]; i++) {
                    if (+service.id === +serviceId) return service;
                }
                return null;
            },
            getSalonServiceIndex(id) {
                return this.salonServices.findIndex(item => {
                    return +item.id === +id;
                });
            },
            getServiceItemsSelected() {
                return this.serviceItems.filter(item => {
                    return this.selected.indexOf(item.id) !== -1;
                })
            },
            hasSalonService(serviceId) {
                return this.salonServices.findIndex(item => {
                    return +item.service_id === +serviceId;
                }) !== -1;
            },
            assignItem(item) {
                return Object.assign({
                    edit: false,
                    attributes: {
                        price: {
                            value: item.service_price,
                            error: false,
                            errorMessage: null
                        },
                        duration: {
                            value: item.service_duration,
                            error: false,
                            errorMessage: null
                        },
                    }
                }, item);
            },
        },
        watch: {
            salonId() {
                this.loadData();
            }
        }
    }
</script>