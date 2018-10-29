<template>
    <div class="content-block p-40 content-block_shadow">
        <v-form ref="form" v-model="valid">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-3">
                    <v-autocomplete
                            label="Статус"
                            v-model="attributes.status"
                            :items="statusList"
                            :rules="rules.status"
                            required
                            outline
                    />
                </div>
                <div class="uk-width-2-3">
                    <v-text-field
                            v-model="attributes.phone"
                            label="Телефон"
                            :mask="phoneMask"
                            :rules="rules.phone"
                            outline
                    />
                </div>
            </div>
            <div class="uk-grid uk-grid-small uk-child-width-1-3">
                <div>
                    <v-text-field v-model="attributes.surname" label="Фамилия" outline/>
                </div>
                <div>
                    <v-text-field v-model="attributes.name" :rules="rules.name" label="Имя" outline/>
                </div>
                <div>
                    <v-text-field v-model="attributes.patronymic" label="Отчество" outline/>
                </div>

            </div>
            <div class="uk-grid uk-grid-small uk-child-width-1-3">
                <div>
                    <v-autocomplete
                            v-model="attributes.country_id"
                            :items="countryList"
                            :rules="rules.countryId"
                            item-text="name"
                            item-value="id"
                            label="Страна"
                            @change="loadCitiesData"
                            outline
                    />
                </div>
                <div>
                    <v-autocomplete
                            label="Город"
                            v-model="attributes.city_id"
                            :items="cityList"
                            item-text="name"
                            item-value="id"
                            :disabled="cityList.length === 0"
                            outline
                    />
                </div>
                <div>
                    <v-text-field v-model="attributes.address" label="Адрес" outline/>
                </div>
            </div>

            <div class="uk-margin-small-top">
                <v-btn round outline large color="primary" @click="submit()">
                    Сохранить
                    <v-icon right>mdi-content-save</v-icon>
                </v-btn>
            </div>
        </v-form>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {formRules} from "../../js/formRules";
    import {formMixin} from "../../js/mixins/formMixin";
    import {EVENT_SAVE} from "../../js/eventCollection";

    export default {
        props: {
            type: {
                type: String,
                required: true
            },
            id: {
                type: String
            }
        },
        mixins: [formMixin],
        created() {
            this.$on(EVENT_SAVE, () => {
                this.$router.push({name: 'clientManager'});
            });
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                valid: false,
                countryList: [],
                cityList: [],
                statusList: [
                    {value: 1, text: 'Активный'},
                    {value: 2, text: 'Не активный'}
                ],
                attributes: {
                    country_id: null,
                    city_id: null,
                    status: null,
                    surname: null,
                    name: null,
                    patronymic: null,
                    phone: null,
                    date_birth: null,
                    address: null
                },
                rules: {
                    countryId: [
                        v => formRules.required(v),
                    ],
                    status: [
                        v => formRules.required(v),
                    ],
                    name: [
                        v => formRules.required(v),
                        v => formRules.length(v, {maximum: 255})
                    ],
                    phone: [
                        v => formRules.required(v),
                        v => formRules.length(v, {maximum: 15})
                    ]
                },
                phoneMaskList: [
                    {countryId: 1, mask: '+7-##########'},
                    {countryId: 2, mask: '+7-###-#######'},
                ]
            }
        },
        computed: {
            phoneMask() {
                if (!this.attributes.country_id) return null;
                let item = this.phoneMaskList.find(item => {
                    return item.countryId === +this.attributes.country_id
                });

                return item.mask;
            }
        },
        methods: {
            loadData() {
                if (this.type === 'update') {
                    this.requestQuery(gql`query ($id: ID!) {
                         client(id: $id) {
                            id, country_id, city_id, status, surname, name, patronymic, date_birth, phone, address
                         },
                         countries {id, name, currency_code, phone_code},
                    }`).then(({data}) => {
                        Object.keys(data.client).map((param) => {
                            if (this.attributes[param] !== undefined) this.attributes[param] = data.client[param];
                        });
                        this.countryList = data.countries;

                        this.loadCitiesData();
                    });
                } else {
                    this.requestQuery(gql`query {
                        countries {id, name, phone_code},
                    }`).then(({data}) => {
                        this.countryList = Array.from(data.countries);
                    });
                }
            },
            loadCitiesData() {
                this.requestQuery(gql`query ($countryId: ID!) {
                    cities(country_id: $countryId) {id, name}
                }`).then(({data}) => {
                    this.cityList = data.cities;
                });
            },
            submit() {
                if (this.$refs.form.validate()) {
                    if (this.type === 'create') {
                        this.addClient()
                            .then((data) => {
                                this.$emit(EVENT_SAVE, data);
                            });
                    } else {
                        this.updateClient()
                            .then((data) => {
                                this.$emit(EVENT_SAVE, data);
                            });
                    }
                }
            },
            addClient() {
                return this.requestMutate(gql`mutation ($attributes: ClientCreateInput!) {
                        clientCreate(attributes: $attributes) {
                            id, country_id, city_id, surname, name, patronymic, date_birth, phone, address
                        }
                    }`);
            },
            updateClient() {
                return this.requestMutate(gql`mutation ($id: ID!, $attributes: ClientUpdateInput!) {
                        clientUpdate(id: $id, attributes: $attributes) {
                            id, country_id, city_id, surname, name, patronymic, date_birth, phone, address
                        }
                    }`);
            },
            requestQuery(ql) {
                return this.$apollo.query({
                    query: ql,
                    variables: {
                        id: this.id,
                        attributes: this.attributes,
                        countryId: this.attributes.country_id
                    }
                });
            },
            requestMutate(ql) {
                return this.$apollo.mutate({
                    mutation: ql,
                    variables: {
                        id: this.id,
                        attributes: this.attributes,
                    }
                });
            }
        }
    }
</script>