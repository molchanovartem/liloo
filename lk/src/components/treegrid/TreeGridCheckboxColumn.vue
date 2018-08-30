<template>
    <td>
        <input type="checkbox" :checked="checked" @change="change($event.target)"/>
    </td>
</template>

<script>
    import {TREE_GRID_SERVICE} from "./TreeGridService";

    export default {
        name: "TreeGridCheckboxColumn",
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
        data() {
            return {
                checked: false
            }
        },
        methods: {
            change(target) {
                /*
                this.checked = this.checked ? false : true;

                if (this.checked) {
                    // добавить запись в список
                    //TREE_GRID_SERVICE.addRowSelected(this.row);
                } else {
                    // удалить запись из списка
                    //TREE_GRID_SERVICE.deleteRowSelected(row);
                    //target.checked = false;
                }

                if (TREE_GRID_SERVICE.canSelected(this.row)) {
                    target.checked = false;
                }

                if (!TREE_GRID_SERVICE.canSelected(this.row)) {
                    target.checked = false;
                    this.checked = false;
                }
                */
            }
        }
    }
</script>