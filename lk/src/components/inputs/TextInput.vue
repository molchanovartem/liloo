<template>
    <div class="uk-margin-small">
        <label>{{label}}</label>
        <input
                type="text"
                :value="value"
                class="uk-input uk-form-small"
                :class="{'uk-form-danger': error}"
                @input="$emit('input', $event.target.value)"
                autocomplete="off"/>
        <div class="uk-text-small" v-if="error">
            <span class="uk-text-danger">{{error}}</span>
        </div>
    </div>
</template>

<script>
    import mixins from './mixins';

    export default {
        name: "TextInput",
        mixins: [mixins]
    }
</script>