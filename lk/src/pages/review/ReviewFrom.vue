<template>
    <div>
        <v-error-summary :errors="errors"/>

        <v-select
                label="Статус"
                :items="statusItems"
                v-model="attributes.status"
                :errors="errors"
                attribute="status"
                valueAttribute="value"
                textAttribute="text"
        />
        <v-text-area label="Текст" :errors="errors" attribute="text" v-model="attributes.text"/>
        <v-text-input label="Имя" :errors="errors" attribute="name" v-model="attributes.name"/>

        @todo
        Загрузка картинок
        <br/>
        <input type="file"/>
        <br/>
        @todo Картинки
        <ul>
            <li v-for="item in imageItems">{{item.name}}</li>
        </ul>

        <v-button @submit="onSubmit()"/>
    </div>
</template>

<script>
    import validate from 'validate.js';
    import VErrorSummary from '../../components/form/ErrorSummary.vue';
    import VButton from '../../components/form/Button.vue';
    import VTextInput from '../../components/inputs/TextInput.vue';
    import VSelect from '../../components/inputs/Select.vue';
    import VTextArea from '../../components/inputs/TextArea.vue';

    export default {
        name: "ReviewFrom",
        components: {
            VErrorSummary, VButton, VTextInput, VSelect, VTextArea
        },
        data() {
            return {
                attributes: {
                    account_id: 1,
                    appointment_id: null,
                    user_id: null,
                    status: null,
                    text: null,
                    name: null,
                    uploadImage: null
                },
                deleteItems: null, // ???
                imageItems: [
                    {name: 'one'},
                    {name: 'two'}
                ],
                statusItems: [
                    {value: 0, text: 'Не активный'},
                    {value: 1, text: 'Активный'}
                ],
                errors: []
            }
        },
        methods: {
            onSubmit() {
                let constraints = {
                    text: {
                        presence: ' ',
                        length: {minimum: 10}
                    },
                    status: {
                        presence: ' ',
                        length: {minimum: 10}
                    },
                    name: {
                        presence: ' ',
                        length: {minimum: 10}
                    }
                };

                this.errors = validate(this.attributes, constraints);
            }
        }
    }
</script>