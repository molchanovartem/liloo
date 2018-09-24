<template>
    <div class="content-block p-40 content-block_shadow">
        @todo

        <ul>
            <li>Изображение</li>
            <li>Часы работы</li>
        </ul>

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
                    <v-text-field v-model="attributes.name" label="Название" outline :rules="rules.name"/>
                </div>
            </div>
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-4">
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
                <div class="uk-width-1-4">
                    <v-autocomplete
                            label="Город"
                            v-model="attributes.city_id"
                            :items="cityList"
                            item-text="name"
                            item-value="id"
                            :disabled="cityList.length === 0"
                            :rules="rules.cityId"
                            outline
                    />
                </div>
                <div class="uk-width-1-2">
                    <v-text-field v-model="attributes.address" label="Адрес" outline/>
                </div>
            </div>

            <v-select
                    label="Специализация"
                    v-model="attributes.specializations_id"
                    :items="specializationItems"
                    item-value="id"
                    item-text="name"
                    multiple
                    :rules="rules.specializationsId"
                    outline
            />
            <v-select
                    label="Удобства"
                    v-model="attributes.conveniences_id"
                    :items="convenienceItems"
                    item-value="id"
                    item-text="name"
                    multiple
                    :rules="rules.conveniencesId"
                    outline
            />

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

    const EVENT_SAVE = 'save';

    export default {
        created() {
            this.$on(EVENT_SAVE, (data) => {
                alert('ok');
            });
        },
        mounted() {
            this.loadData();
        },
        props: {
            type: {
                type: String,
                required: true
            },
            id: null
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
                    name: null,
                    address: null,
                    specializations_id: [],
                    conveniences_id: [],
                },
                specializationItems: [],
                convenienceItems: [],
                rules: {
                    countryId: [
                        v => formRules.required(v),
                    ],
                    cityId: [
                        v => formRules.required(v),
                    ],
                    status: [
                        v => formRules.required(v),
                    ],
                    name: [
                        v => formRules.required(v),
                        v => formRules.length(v, {maximum: 255})
                    ],
                    specializationsId: [
                        v => formRules.required(v),
                    ],
                    conveniencesId: [
                        v => formRules.required(v),
                    ]
                },
            }
        },
        methods: {
            loadData() {
                if (this.type === 'update') {
                    this.requestQuery(gql`query ($id: ID!) {
                            specializations {id, name},
                            conveniences {id, name},
                            countries {id, name, currency_code, phone_code},
                            salon(id: $id) { id, country_id, city_id, status, name, address, specializations {id}, conveniences {id}}
                        }`).then(({data}) => {
                        this.specializationItems = data.specializations;
                        this.convenienceItems = data.conveniences;
                        this.countryList = data.countries;

                        this.attributes.country_id = data.salon.country_id;
                        this.attributes.city_id = data.salon.city_id;
                        this.attributes.status = data.salon.status;
                        this.attributes.name = data.salon.name;
                        this.attributes.address = data.salon.address;
                        this.attributes.specializations_id = Array.from(data.salon.specializations).map(item => {
                            return item.id
                        });
                        this.attributes.conveniences_id = Array.from(data.salon.conveniences).map(item => {
                            return item.id
                        });

                        this.loadCitiesData();
                    });
                } else {
                    this.$apollo.query({
                        query: gql`query {
                        countries {id, name, currency_code, phone_code},
                        specializations {id, name},
                        conveniences {id, name}
                    }`
                    }).then(({data}) => {
                        this.countryList = data.countries;
                        this.specializationItems = data.specializations;
                        this.convenienceItems = data.conveniences;
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
                        this.add().then((data) => {
                            this.$emit(EVENT_SAVE, data);
                        });
                    } else {
                        this.update().then((data) => {
                            this.$emit(EVENT_SAVE, data);
                        });
                    }
                }
            },
            add() {
                return this.requestMutate(gql`mutation ($attributes: SalonCreateInput!) {
                        salonCreate(attributes: $attributes) {id, name}
                    }`);
            },
            update() {
                return this.requestMutate(gql`mutation ($id: ID!, $attributes: SalonUpdateInput!) {
                        salonUpdate(id: $id, attributes: $attributes) {id, name}
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
            },
        }
    }
</script>