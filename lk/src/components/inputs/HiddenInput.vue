<template>
    <div>
        <input type="hidden" :name="getInputName()" :value="value"/>
    </div>
</template>

<script>
    export default {
        name: "HiddenInput",
        props: {
            formName: {
                type: String,
                required: true
            },
            attribute: {
                type: String,
                required: true
            },
            value: null
        },
        methods: {
            getInputName() {
                return this.formName  + '[' + this.attribute + ']'
            },
        }
    }
</script>