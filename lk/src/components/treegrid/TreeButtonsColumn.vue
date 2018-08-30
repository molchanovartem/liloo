<template>
    <td>
        <span v-for="(name) in template" v-if="isShowButton(name)" v-html="showButton(name)"></span>
    </td>
</template>

<script>
    export default {
        name: "TreeButtonsColumn",
        props: {
            row: {
                type: Object,
                required: true
            },
            column: {
                type: Object,
                required: true
            }
        },
        created() {
            this.initButtons();
        },
        data() {
            return {
                template: ['view', 'update', 'delete'],
                visibleButtons: {},
                buttons: {
                    view() {
                        return '<button>view</button>'
                    },
                    update() {
                        return '<button>update</button>'
                    },
                    delete() {
                        return '<button>delete</button>'
                    }
                }
            }
        },
        methods: {
            initButtons() {
                if (this.column.template !== undefined) {
                    this.template = this.column.template;
                }

                if (this.column.buttons !== undefined) {
                    this.buttons = this.column.buttons;
                }

                if (this.column.visibleButtons !== undefined) {
                    this.visibleButtons = this.column.visibleButtons;
                }
            },
            isShowButton(name) {
                if (this.buttons[name] === undefined) return false;

                if (this.template.indexOf(name) === -1) return false;

                let visible = true;

                if (this.visibleButtons[name] !== undefined) {
                    let handler = this.visibleButtons[name];

                    visible = handler(this.row);
                }
                return visible;
            },
            showButton(name) {
                for (let index = 0, buttonName; buttonName = this.template[index]; index++) {
                    if (buttonName == name) {
                        let handlerButton = this.buttons[buttonName];

                        return handlerButton(this.row);
                    }
                }
                return null;
            }
        }
    }
</script>