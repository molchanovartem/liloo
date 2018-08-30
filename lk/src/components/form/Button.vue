<template>
    <div class="uk-margin">
        <button class="uk-button uk-button-primary uk-button-small" @click.prevent="onSubmit">Сохранить</button>
    </div>
</template>

<script>
    export default {
        name: "Button",
        methods: {
            onSubmit() {
                this.$emit('submit');
            }
        }
    }
</script>