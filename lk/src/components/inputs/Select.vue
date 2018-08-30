<template>
    <div class="uk-margin-small">
        <label v-if="label">{{label}}</label>
        <select
                class="uk-select uk-form-small"
                :class="{'uk-form-danger': error}"
                :multiple="multiple"
                @change="emitInput($event)"
        >
            <option v-for="item in computeItems" :value="item[valueAttribute]"
                    :selected="hasSelected(item[valueAttribute])">{{item[textAttribute]}}
            </option>
        </select>
        <div class="uk-text-small" v-if="error">
            <span class="uk-text-danger">{{error}}</span>
        </div>
    </div>
</template>

<script>
    import mixins from './mixins';

    export default {
        name: "Select",
        mixins: [mixins],
        props: {
            items: {
                type: Array,
                default: []
            },
            valueAttribute: {
                type: String,
                default: 'value'
            },
            textAttribute: {
                type: String,
                default: 'text'
            },
            multiple: {
                type: Boolean,
                default: false
            },
            size: null,
            prompt: {
                type: Boolean,
                default: true
            }
        },
        computed: {
            computeItems() {
                /*
                if (this.prompt && this.items.length > 0) {
                    let obj = {};

                    obj[this.valueAttribute] = null;
                    obj[this.textAttribute] = 'Выбрать';

                    this.items.unshift(obj);
                }
                */
                return this.items;
            }
        },
        methods: {
            hasSelected(value) {
                if (this.multiple && Array.isArray(this.value)) {
                    return this.value.find((el) => {
                        return String(el) === String(value);
                    }) !== undefined;
                }

                return String(this.value) === String(value);
            },
            emitInput(event) {
                let value = event.target.value;

                if (this.multiple) {
                    value = Array.from(event.target.selectedOptions).map(item => {
                        return item.value
                    });
                }
                this.$emit('input', value);
            }
        }
    }
</script>