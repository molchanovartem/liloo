<template>
    <div class="uk-margin-small">
        <label>{{label}}</label>
        <datepicker
                format="yyyy-MM-dd"
                v-model="model"
                input-class="uk-input uk-form-small"
        />
        <div class="uk-text-small" v-if="error">
            <span class="uk-text-danger">{{error}}</span>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import mixins from './mixins';

    export default {
        name: "DateInput",
        mixins: [mixins],
        components: {
            Datepicker
        },
        props: ['model']
    }
</script>