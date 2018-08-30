<template>
    <button @click="emitClick()">{{label}}</button>
</template>

<script>
    export default {
        name: "Button",
        props: {
            label: {
                type: String,
                required: true
            }
        },
        methods: {
            emitClick() {
                this.$emit('click');
            }
        }
    }
</script>