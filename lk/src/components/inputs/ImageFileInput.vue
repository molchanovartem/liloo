<template>
    <div class="uk-margin-small">
        <label v-if="label !== null">{{label}}</label>
        <div v-if="isImage()" class="uk-margin-small-bottom">
            <div class="uk-card uk-card-default uk-padding-small uk-overflow-hidden" style="width: 200px;">
                <div class="uk-text-right uk-margin-small-bottom">
                    <label>
                        <small>Удалить</small>
                        <input type="hidden" :name="getInputName(getDeleteAttribute())" value="0"/>
                        <input type="checkbox" :name="getInputName(getDeleteAttribute())" value="1"
                               class="uk-checkbox"/>
                    </label>
                </div>
                <img :src="getImageUrl()" style="width: 100%"/>
            </div>
        </div>
        <div>
            <div uk-form-custom>
                <input type="file" :name="getInputName()"/>
                <span class="uk-link">Выбрать файл</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ImageFileInput",
        props: {
            formName: {
                type: String,
                required: true
            },
            attribute: {
                type: String,
                required: true
            },
            deleteAttribute: null,
            label: {
                type: String,
                default: null
            },
            value: null,
            pathUrl: {
                type: String,
                required: true
            }
        },
        methods: {
            getInputName(attribute) {
                attribute = attribute || this.attribute;

                return this.formName + '[' + attribute + ']'
            },
            getDeleteAttribute() {
                return this.deleteAttribute || this.attribute + 'Delete';
            },
            isImage() {
                return this.value !== null && this.value !== '';
            },
            getImageUrl() {
                let fileName = this.value,
                    dir = fileName.substr(0, 1);

                return this.pathUrl + '/' + dir + '/' + fileName;
            },
        }
    }
</script>