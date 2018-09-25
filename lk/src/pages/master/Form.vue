<template>
    <div class="content-block p-40 content-block_shadow">
        <ul>@todo
            <li>Дата рождения</li>
        </ul>
        <v-form ref="form" v-model="valid">
            <v-autocomplete
                    v-model="attributes.specializationsId"
                    :items="specializationItems"
                    :rules="rules.specializationsId"
                    item-text="name"
                    item-value="id"
                    label="Специализация"
                    outline
                    required
                    multiple
            />
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
        name: "Form",
        props: {
            type: {
                type: String,
                required: true
            },
            id: null
        },
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
                    specializationsId: [],
                    surname: null,
                    name: null,
                    patronymic: null,
                    date_birth: null
                },
                specializationItems: [],
                rules: {
                    specializationsId: [
                        v => formRules.required(v)
                    ],
                    name: [
                        v => formRules.required(v)
                    ]
                }
            }
        },
        methods: {
            loadData() {
                let ql;

                if (this.type === 'update') {
                    ql = gql`query ($id: ID!) {
                            specializations {id, name},
                            master(id: $id) {id, surname, name, patronymic, date_birth},
                            masterSpecializations(master_id: $id) {specialization_id}
                        }`;
                } else {
                    ql = gql`query {
                            specializations {id, name},
                        }`;
                }

                this.$apollo.query({
                    query: ql,
                    variables: {id: this.id}
                }).then(({data}) => {
                    this.specializationItems = data.specializations;

                    console.log(data);

                    if (data.masterSpecializations) {
                        this.attributes.specializationsId = Array.from(data.masterSpecializations).map(item => {
                            return item.specialization_id;
                        });
                    }

                    if (data.master) {
                        for (let param in data.master) {
                            if (this.attributes[param] !== undefined) this.attributes[param] = data.master[param];
                        }
                    }
                });
            },
            submit() {
                if (this.$refs.form.validate()) {
                    if (this.type === 'create') {
                        this.add()
                            .then((data) => {
                                this.$emit(EVENT_SAVE, data);
                            });
                    } else {
                        this.update()
                            .then((data) => {
                                this.$emit(EVENT_SAVE, data);
                            });
                    }
                }
            },
            add() {
                return this.request(gql`mutation ($attributes: MasterCreateInput!) {
                        masterCreate(attributes: $attributes) {id, surname, name}
                    }`
                );
            },
            update() {
                return this.request(gql`mutation ($id: ID!, $attributes: MasterUpdateInput!) {
                        masterUpdate(id: $id, attributes: $attributes) {id, surname, name}
                    }`
                );
            },
            request(ql) {
                return this.$apollo.mutate({
                    mutation: ql,
                    variables: {
                        id: this.id,
                        attributes: {
                            surname: this.attributes.surname,
                            name: this.attributes.name,
                            patronymic: this.attributes.patronymic,
                            date_birth: this.attributes.date_birth,
                            specializations_id: this.attributes.specializationsId
                        }
                    }
                });
            }
        }
    }
</script>