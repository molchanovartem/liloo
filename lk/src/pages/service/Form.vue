<template>
    <div class="content-block p-40 content-block_shadow">
        <v-form ref="form" v-model="valid">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-3">
                    <v-autocomplete
                            label="Специализация"
                            v-model="attributes.specialization_id"
                            :items="specializations"
                            :rules="rules.specialization_id"
                            item-value="id"
                            item-text="name"
                            required
                            outline
                    />
                </div>
                <div class="uk-width-2-3">

                    <v-text-field
                            v-model="attributes.name"
                            :rules="rules.name"
                            label="Название"
                            outline
                    />
                </div>
            </div>
            <div class="uk-grid uk-grid-small uk-child-width-1-2">
                <div>
                    <v-text-field
                            v-model="attributes.price"
                            :rules="rules.price"
                            label="Цена"
                            outline
                    />
                </div>
                <div>
                    <v-text-field
                            v-model="attributes.duration"
                            :rules="rules.duration"
                            label="Длительность"
                            mask="###"
                            outline
                    />
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
        created() {
            this.$on(EVENT_SAVE, data => {
                alert('save');
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
            id: {
                type: String,
                default: null
            }
        },
        data() {
            return {
                valid: false,
                attributes: {
                    parent_id: null,
                    specialization_id: null,
                    name: null,
                    price: null,
                    duration: null
                },
                specializations: [],
                groups: [],
                rules: {
                    specialization_id: [
                        v => formRules.required(v),
                    ],
                    name: [
                        v => formRules.required(v),
                        v => formRules.length(v, {max: 255})
                    ],
                    price: [
                        v => formRules.required(v)
                        // @todo валидировать как цену
                    ],
                    duration: [
                        v => formRules.required(v),
                        v => formRules.number(v, {strict: true}),
                        v => formRules.length(v, {maximum: 3}),
                    ]
                }
            }
        },
        methods: {
            loadData() {
                let query = {};
                if (this.type === 'update') {
                    query = {
                        query: gql`query ($id: ID!) {
                            specializations {id, name},
                            service(id: $id) {id, specialization_id, name, price, duration}
                        }`
                    };
                } else {
                    query = {
                        query: gql`query {
                            specializations {id, name},
                        }`
                    };
                }

                query.variables = {
                    id: this.id
                };

                this.$apollo.query(query).then(({data}) => {
                    this.specializations = data.specializations;

                    if (data.service) {
                        Object.keys(data.service).map((param) => {
                            if (this.attributes[param] !== undefined) this.attributes[param] = data.service[param];
                        });
                    }
                });
            },
            submit() {
                if (this.$refs.form.validate()) {
                    if (this.type === 'create') {
                        this.add()
                            .then(({data}) => {
                                if (data.serviceCreate) {
                                    this.$emit(EVENT_SAVE, data.serviceCreate);
                                }
                            });
                    } else {
                        this.update()
                            .then(({data}) => {
                                if (data.serviceUpdate) {
                                    this.$emit(EVENT_SAVE, data.serviceUpdate);
                                }
                            });
                    }
                }
            },
            add() {
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                        $specializationId: ID!,
                        $name: String!,
                        $price: Decimal!,
                        $duration: Int!,
                    ) {
                        serviceCreate(
                            attributes: {
                                specialization_id: $specializationId
                                name: $name,
                                price: $price
                                duration: $duration,
                            }
                        ) {
                            id, specialization_id, name, price, duration
                        }
                    }`,
                    variables: {
                        specializationId: this.attributes.specialization_id,
                        name: this.attributes.name,
                        price: this.attributes.price,
                        duration: this.attributes.duration
                    }
                })
            },
            update() {
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                        $id: ID!,
                        $specializationId: ID!,
                        $name: String!,
                        $price: Decimal!,
                        $duration: Int!,
                    ) {
                        serviceUpdate(
                            id: $id,
                            attributes: {
                                specialization_id: $specializationId
                                name: $name,
                                price: $price
                                duration: $duration,
                            }
                        ) {
                            id, specialization_id, name, price, duration
                        }
                    }`,
                    variables: {
                        id: this.id,
                        specializationId: this.attributes.specialization_id,
                        name: this.attributes.name,
                        price: this.attributes.price,
                        duration: this.attributes.duration
                    }
                })
            }
        },
        watch: {
            'id'() {
                this.loadData();
            }
        }
    }
</script>