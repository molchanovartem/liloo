<template>
    <div class="uk-margin-small">
        <label>{{label}}</label>
        <textarea
                :name="getInputName()"
                :value="value"
                @input="$emit('input', $event.target.value)"
                class="uk-textarea uk-form-small"
                :class="{'uk-form-danger': error}"
        ></textarea>
        <div class="uk-text-small" v-if="error">
            <span class="uk-text-danger">{{error}}</span>
        </div>
    </div>
</template>

<script>
    import mixins from './mixins.js';

    export default {
        name: "TextArea",
        mixins: [mixins]
    }
</script>