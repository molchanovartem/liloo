<template>
    <div class="content-block p-40 content-block_shadow">
        <v-form ref="form" v-model="valid">
            <v-text-field v-model="attributes.surname" label="Фамилия" :rules="rules.surname"/>
            <v-text-field v-model="attributes.name" label="Имя" :rules="rules.name"/>
            <v-text-field v-model="attributes.patronymic" label="Отчество" :rules="rules.patronymic"/>
            <v-text-field v-model="attributes.phone" label="Телефон" :rules="rules.phone"/>
            <v-textarea rows="3" v-model="attributes.description" label="Описание"/>

            <v-select
                    label="Специализация"
                    v-model="attributes.specializations_id"
                    :items="specializationItems"
                    item-value="id"
                    item-text="name"
                    multiple
                    :rules="rules.specializationsId"
            />
            <v-select
                    label="Удобства"
                    v-model="attributes.conveniences_id"
                    :items="convenienceItems"
                    item-value="id"
                    item-text="name"
                    multiple
                    :rules="rules.conveniencesId"
            />

            <v-btn color="primary" @click="submit()">
                Сохранить
                <v-icon right>mdi-content-save</v-icon>
            </v-btn>
        </v-form>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {formRules} from "../../../js/formRules";

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
        data() {
            return {
                valid: false,
                attributes: {
                    surname: null,
                    name: null,
                    patronymic: null,
                    date_birth: null,
                    description: null,
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
                            user {id, specializations {id}, conveniences {id}, profile {surname, name, patronymic, description, date_birth, phone}}
                        }`

                }).then(({data}) => {
                    this.specializationItems = data.specializations;
                    this.convenienceItems = data.conveniences;

                    this.attributes.surname = data.user.profile.surname;
                    this.attributes.name = data.user.profile.name;
                    this.attributes.patronymic = data.user.profile.patronymic;
                    this.attributes.date_birth = data.user.profile.date_birth;
                    this.attributes.phone = data.user.profile.phone;
                    this.attributes.description = data.user.profile.description;
                    this.attributes.specializations_id = Array.from(data.user.specializations).map(item => {
                        return item.id
                    });
                    this.attributes.conveniences_id = Array.from(data.user.conveniences).map(item => {
                        return item.id
                    });
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
                                surname: this.attributes.surname,
                                name: this.attributes.name,
                                patronymic: this.attributes.patronymic,
                                description: this.attributes.description,
                                phone: this.attributes.phone
                            }
                        }
                    }).then(({data}) => {
                        this.$emit(EVENT_SAVE, data);
                    });
                }
            },
        }
    }
</script>