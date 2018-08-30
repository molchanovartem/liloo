<template>
    <div>
        <v-form @success="successForm" :request="request">
            <v-select formName="ServiceForm" attribute="specialization_id" label="Специализация"
                      :value="attributes.specialization_id"
                      :items="specializations" textAttribute="name" :prompt="false"/>

            <v-text-input formName="ServiceForm" attribute="name" label="Название" :value="attributes.name"/>
            <v-text-input formName="ServiceForm" attribute="price" label="Цена" :value="attributes.price"/>
            <v-text-input formName="ServiceForm" attribute="duration" label="Длительность"
                          :value="attributes.duration"/>
        </v-form>
    </div>
</template>

<script>
    import {API} from "../../js/api";
    import _ from 'lodash'
    import VForm from '../Form.vue';
    import VTextInput from '../inputs/TextInput.vue';
    import VSelect from '../inputs/Select.vue';

    export default {
        mounted() {
            this.loadData();
        },
        props: {
            type: {
                type: String,
                required: true
            }
        },
        components: {
            VForm, VTextInput, VSelect
        },
        data() {
            return {
                specializations: [],
                attributes: {
                    specialization_id: null,
                    name: null,
                    price: null,
                    duration: null
                }
            }
        },
        methods: {
            loadData() {
                if (this.type === 'update') {
                    this.loadAttributes();
                }

                if (this.specializations.length === 0) {
                    API.specializationGetItems((response) => {
                        if (response) this.specializations = response;
                    });
                }
            },
            loadAttributes() {
                let id = this.$route.params.id;

                API.serviceGetItem(id, response => {
                    _.forIn(response, (value, param) => {
                        if (this.attributes[param] !== undefined) this.attributes[param] = value;
                    });
                });
            },
            successForm() {
                this.$router.push({name: 'serviceManager'});
            },
            request(formData, callback) {
                if (this.type === 'create') {
                    API.serviceCreate(formData, callback);
                } else if (this.type === 'update') {
                    let id = this.$route.params.id;

                    API.serviceUpdate(id, formData, callback);
                }
            }
        },
        watch: {
            '$route' () {
                this.loadData();
            }
        }
    }
</script>