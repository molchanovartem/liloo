<template>
    <div>
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-padding-small">
                <v-text-field label="login" v-model="attributes.login"/>
                <v-text-field label="login" v-model="attributes.password"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                attributes: {
                    login: null,
                    password: null
                }
            };
        }
    }
</script>