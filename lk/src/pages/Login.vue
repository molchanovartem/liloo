<template>
    <div class="uk-position-center uk-width-xlarge">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header uk-padding-small">
                <h2>Авторизация</h2>
            </div>
            <div class="uk-card-body uk-padding-small">
                <v-form ref="form" v-model="valid">
                    <v-text-field v-model="login" label="Телефон" outline :rules="rules.login"/>
                    <v-text-field v-model="password" label="Пароль" outline :rules="rules.password"/>
                </v-form>
            </div>
            <div class="uk-card-footer uk-padding-small">
                <v-btn @click="onSubmit" round outline color="primary" depressed>Войти</v-btn>
            </div>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {formRules} from "../js/formRules";

    export default {
        name: "Login",
        data() {
            return {
                valid: false,

                login: null,
                password: null,

                rules: {
                    login: [
                        v => formRules.required(v),
                    ],
                    password: [
                        v => formRules.required(v),
                    ]
                }
            };
        },
        methods: {
            onSubmit() {
                if (!this.$refs.form.validate()) return false;

                this.$apollo.mutate({
                    mutation: gql`mutation ($login: String!, $password: String!) {
                        userLogin(login: $login, password: $password)
                    }`,
                    client: 'common',
                    variables: {
                        login: this.login,
                        password: this.password
                    }
                }).then(({data}) => {
                   if (data.userLogin) {
                       localStorage.setItem('authenticate', true);
                       localStorage.setItem('token', data.userLogin);

                       this.$router.push({name: 'home'});
                   }
                });
            }
        }
    }
</script>