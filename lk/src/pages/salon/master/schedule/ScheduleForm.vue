<template>
    <div>
        <v-error-summary :errors="errors"/>

        <v-text-input attribute="type" label="Type" v-model="attributes.type" :errors="errors"/>
        <v-text-input attribute="start_date" label="Start date" v-model="attributes.start_date" :errors="errors"/>
        <v-text-input attribute="end_date" label="End date" v-model="attributes.end_date" :errors="errors"/>

        <v-button @submit="onSubmit()"/>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import validate from 'validate.js';

    import VErrorSummary from '../../../components/form/ErrorSummary.vue';
    import VButton from '../../../components/form/Button.vue';
    import VTextInput from '../../../components/inputs/TextInput.vue';

    const EVENT_SAVE = 'save';

    export default {
        name: "ScheduleForm",
        props: {
            id: {
                type: String
            },
            type: {
                required: true,
                type: String,
            },
            userId: {
                type: Number,
                default: 1 // @todo
            }
        },
        components: {
            VErrorSummary, VButton, VTextInput
        },
        created() {
            this.$on(EVENT_SAVE, data => {
                alert('save');
            });
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                attributes: {
                    type: null,
                    start_date: null,
                    end_date: null
                },
                errors: []
            };
        },
        methods: {
            loadData() {
                if (this.type === 'update') {
                    this.$apollo.query({
                        query: gql`query ($id: ID!) {
                            userSchedule(id: $id) {id, type, start_date, end_date},
                        }`,
                        variables: {
                            id: this.id
                        }
                    }).then(({data}) => {
                        Object.keys(data.userSchedule).map((param) => {
                            if (this.attributes[param] !== undefined) this.attributes[param] = data.userSchedule[param];
                        });
                    });
                }
            },
            onSubmit() {
                let constraints = {
                    type: {
                        presence: {allowEmpty: false},
                        numericality: true
                    },
                    start_date: {
                        presence: {allowEmpty: false},
                        //datetime: true
                    },
                    end_date: {
                        presence: {allowEmpty: false},
                        //datetime: true
                    }
                };

                this.errors = validate(this.attributes, constraints);

                if (this.errors === undefined) {
                    if (this.type === 'create') {
                        this.create()
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
            create() {
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                        $userId: ID!,
                        $type: Int!,
                        $startDate: DateTime!
                        $endDate: DateTime!
                    ) {
                        userScheduleCreate(
                            user_id: $userId,
                            type: $type,
                            start_date: $startDate,
                            end_date: $endDate
                        ) {
                            id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        userId: 1,
                        type: this.attributes.type,
                        startDate: this.attributes.start_date,
                        endDate: this.attributes.end_date
                    }
                })
            },
            update() {
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                        $id: ID!
                        $type: Int!,
                        $startDate: DateTime!
                        $endDate: DateTime!
                    ) {
                        userScheduleUpdate(
                            id: $id,
                            type: $type,
                            start_date: $startDate,
                            end_date: $endDate
                        ) {
                            id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        id: this.id,
                        type: this.attributes.type,
                        startDate: this.attributes.start_date,
                        endDate: this.attributes.end_date
                    }
                })
            }
        }
    }
</script>