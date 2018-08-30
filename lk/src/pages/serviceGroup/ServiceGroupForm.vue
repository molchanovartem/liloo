<template>
    <div>
        <v-error-summary :errors="errors"/>

        <v-select
                attribute="parent_id"
                label="Группа"
                v-model="attributes.parent_id"
                :items="groups"
                :errors="errors"
                valueAttribute="id"
                textAttribute="name"
                :prompt="false"
        />

        <v-text-input attribute="name" label="Название" v-model="attributes.name" :errors="errors"/>

        <v-button @submit="onSubmit()"/>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import validate from 'validate.js';

    import VErrorSummary from '../../components/form/ErrorSummary.vue';
    import VButton from '../../components/form/Button.vue';
    import VTextInput from '../../components/inputs/TextInput.vue';
    import VSelect from '../../components/inputs/Select.vue';

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
        components: {
            VErrorSummary, VButton, VTextInput, VSelect
        },
        data() {
            return {
                attributes: {
                    parent_id: null,
                    name: null,
                },
                groups: [],
                errors: []
            }
        },
        methods: {
            loadData() {
                let query = {};

                if (this.type === 'update') {
                    query = {
                        query: gql`query ($id: ID!) {
                            serviceGroups {id, name, parent_id},
                            serviceGroup(id: $id) {id, parent_id, name}
                        }`
                    };
                } else {
                    query = {
                        query: gql`query {
                            serviceGroups {id, name, parent_id},
                        }`
                    };
                }

                query.variables = {
                    id: this.id
                };

                this.$apollo.query(query).then(({data}) => {
                    this.groups = Array.from(data.serviceGroups);

                    if (data.serviceGroup) {
                        Object.keys(data.serviceGroup).map((param) => {
                            if (this.attributes[param] !== undefined) this.attributes[param] = data.serviceGroup[param];
                        });
                    }
                });
            },
            onSubmit() {
                let constraints = {
                    parent_id: {
                        numericality: true,
                    },
                    name: {
                        presence: {allowEmpty: false},
                        length: {maximum: 255}
                    }
                };

                this.errors = validate(this.attributes, constraints);

                if (this.errors === undefined) {
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
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                        $parentId: ID,
                        $name: String!,
                    ) {
                        serviceGroupCreate(
                            attributes: {
                                parent_id: $parentId,
                                name: $name
                            }
                        ) {
                            id, parent_id, name
                        }
                    }`,
                    variables: {
                        parentId: this.attributes.parent_id,
                        name: this.attributes.name
                    }
                })
            },
            update() {
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                        $id: ID!,
                        $parentId: ID,
                        $name: String,
                    ) {
                        serviceGroupUpdate(
                            id: $id,
                            attributes: {
                                parent_id: $parentId,
                                name: $name
                            }
                        ) {
                            id, parent_id, name
                        }
                    }`,
                    variables: {
                        id: this.id,
                        parentId: this.attributes.parent_id,
                        name: this.attributes.name
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