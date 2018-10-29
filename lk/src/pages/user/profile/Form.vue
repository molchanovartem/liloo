<template>
    <div class="content-block p-40 content-block_shadow">
        <v-form ref="form" v-model="valid">
            <div class="uk-grid uk-grid-small uk-child-width-1-3">
                <div>
                    <v-text-field v-model="attributes.surname" label="Фамилия" :rules="rules.surname" outline/>
                </div>
                <div>
                    <v-text-field v-model="attributes.name" label="Имя" :rules="rules.name" outline/>
                </div>
                <div>
                    <v-text-field v-model="attributes.patronymic" label="Отчество" :rules="rules.patronymic" outline/>
                </div>
            </div>
            <v-text-field v-model="attributes.phone" label="Телефон" :rules="rules.phone" outline/>
            <v-textarea rows="3" v-model="attributes.description" label="Описание" outline/>

            <div class="uk-grid uk-grid-small uk-child-width-1-3">
                <div>
                    <v-autocomplete
                            v-model="attributes.country_id"
                            :items="countryList"
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

            <v-select
                    label="Специализация"
                    v-model="attributes.specializations_id"
                    :items="specializationItems"
                    item-value="id"
                    item-text="name"
                    :rules="rules.specializationsId"
                    multiple
                    outline
            />
            <v-select
                    label="Удобства"
                    v-model="attributes.conveniences_id"
                    :items="convenienceItems"
                    item-value="id"
                    item-text="name"
                    :rules="rules.conveniencesId"
                    multiple
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
    import {formRules} from "../../../js/formRules";
    import {formMixin} from "../../../js/mixins/formMixin";
    import {EVENT_SAVE} from "../../../js/eventCollection";

    export default {
        mixins: [formMixin],
        created() {
            this.$on(EVENT_SAVE, () => {
                this.$router.push({name: 'userProfileView'});
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
                attributes: {
                    country_id: null,
                    city_id: null,
                    surname: null,
                    name: null,
                    patronymic: null,
                    date_birth: null,
                    description: null,
                    address: null,
                    phone: null,
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
                    phone: [
                        v => formRules.required(v),
                        v => formRules.number(v, {strict: true}),
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
                this.$apollo.query({
                    query: gql`query {
                            specializations {id, name},
                            conveniences {id, name},
                            countries {id, name, currency_code, phone_code},
                            user {id, specializations {id}, conveniences {id}, profile {country_id, city_id, surname, name, patronymic, description, date_birth, phone, address}}
                        }`

                }).then(({data}) => {
                    this.specializationItems = data.specializations;
                    this.convenienceItems = data.conveniences;
                    this.countryList = data.countries;

                    this.attributes.country_id = data.user.profile.country_id;
                    this.attributes.city_id = data.user.profile.city_id;
                    this.attributes.surname = data.user.profile.surname;
                    this.attributes.name = data.user.profile.name;
                    this.attributes.description = data.user.profile.description;
                    this.attributes.patronymic = data.user.profile.patronymic;
                    this.attributes.date_birth = data.user.profile.date_birth;
                    this.attributes.phone = data.user.profile.phone;
                    this.attributes.address = data.user.profile.address;
                    this.attributes.specializations_id = Array.from(data.user.specializations).map(item => {
                        return item.id
                    });
                    this.attributes.conveniences_id = Array.from(data.user.conveniences).map(item => {
                        return item.id
                    });
                });
            },
            loadCitiesData() {
                this.$apollo.query({
                    query: gql`query ($countryId: ID!) {
                            cities(country_id: $countryId) {id, name}
                        }`,
                    variables: {
                        countryId: this.attributes.country_id
                    }
                }).then(({data}) => {
                    this.cityList = data.cities;
                });
            },
            submit() {
                if (this.$refs.form.validate()) {
                    this.$apollo.mutate({
                        mutation: gql`mutation ($specializationsId: [ID], $conveniencesId: [ID], $profile: UserProfileUpdateInput) {
                            userUpdate(attributes: {
                                    specializations_id: $specializationsId,
                                    conveniences_id: $conveniencesId,
                                    profile: $profile
                                }
                            ) {id}
                        }`,
                        variables: {
                            specializationsId: this.attributes.specializations_id,
                            conveniencesId: this.attributes.conveniences_id,
                            profile: {
                                country_id: this.attributes.country_id,
                                city_id: this.attributes.city_id,
                                surname: this.attributes.surname,
                                name: this.attributes.name,
                                patronymic: this.attributes.patronymic,
                                description: this.attributes.description,
                                phone: this.attributes.phone,
                                address: this.attributes.address
                            }
                        }
                    }).then(({data}) => {
                        if (data.userUpdate) {
                            this.$emit(EVENT_SAVE, data);
                        }
                    });
                }
            },
        }
    }
</script>