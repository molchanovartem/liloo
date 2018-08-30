<template>
    <div>
        <!--
        <div v-if="isErrors" class="uk-alert uk-alert-danger uk-text-small">
            <div v-for="(error, index) in errors">{{error.text}}</div>
        </div>
        <slot></slot>
        <div class="uk-margin">
            <slot name="buttons">
                <button class="uk-button uk-button-primary uk-button-small">Сохранить</button>
            </slot>
        </div>
        -->
        <div v-if="errors.length > 0" class="uk-alert uk-alert-danger uk-text-small">
            <div v-for="error in errors">{{error}}</div>
        </div>
        <slot></slot>
        <div class="uk-margin">
            <button @click="onSubmit" class="uk-button uk-button-primary uk-button-small">Сохранить</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            /*
            request: {
                type: Function,
                required: true
            }
            */
            errors: {
                type: Array,
                default: Array
            }
        },
        data() {
            return {
                //errors: [],
                //formId: this.getId()
            }
        },
        methods: {
            onSubmit() {
                this.$emit('submit');
            }
        }
        /*
        computed: {
            isErrors() {
                return this.errors.length > 0;
            }
        },
        methods: {
            submit() {
                let form = document.getElementById(this.formId);

                this.request(new FormData(form), response => {
                    if (response.success) this.$emit('success', response);
                    if (response.errors) this.addErrors(response.errors);
                    //if (data.messages) vm.showMessages(data.errors);
                });
            },
            addErrors(formErrors) {
                let errors = [];

                for (var attribute in formErrors) {
                    let fErrors = formErrors[attribute];
                    for (var index = 0, text; text = fErrors[index]; index++) {
                        errors.push({text: text});
                    }
                }
                this.errors = errors;
            },
            getId() {
                let randomInteger = function (min, max) {
                    var rand = min - 0.5 + Math.random() * (max - min + 1);
                    rand = Math.round(rand);
                    return rand;
                };
                return randomInteger(10000000, 99999999);
            }
        }
        */
    }
</script>