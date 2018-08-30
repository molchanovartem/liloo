<template>
    <tr>
        <td
                :width="getWidth(column)"
                :align="getAlign(column)"
                :class="getCssClass(column)"
                v-for="column in $parent.columns"
        >
            <tree-grid-checkbox-column v-if="isTypeCheckbox(column)" :row="row" :column="column"/>
            <tree-grid-serial-column v-if="isTypeSerial(column)" :row="row" :column="column"/>
            <tree-grid-data-column @click="test(row)" v-if="isTypeData(column)" :row="row" :column="column"/>
            <tree-grid-buttons-column v-if="isTypeButtons(column)" :row="row" :column="column"/>
        </td>
    </tr>
</template>

<script>
    /*
    <tree-grid-row :row="item" v-for="item in child"/>
    */

    import TreeGridSerialColumn from './TreeGridSerialColumn.vue';
    import TreeGridCheckboxColumn from './TreeGridCheckboxColumn.vue';
    import TreeGridDataColumn from './TreeGridDataColumn.vue';
    import TreeGridButtonsColumn from './TreeButtonsColumn.vue';
    import {HTTP} from "../../js/http";

    export default {
        name: "TreeGridRow",
        props: {
            row: {
                type: Object,
                required: true
            },
            depth: {
                type: Number,
                default: 0
            }
        },
        components: {
            TreeGridSerialColumn,
            TreeGridCheckboxColumn,
            TreeGridDataColumn,
            TreeGridButtonsColumn
        },
        mounted() {
            //console.log(this.row);
        },
        data() {
            return {
                group: false,
                openGroup: false,
                child: [],
                loop: '</tr><tr>'
            }
        },
        methods: {
            test(row) {
                console.log(row);
            },
            /*
            isGroup() {
                return this.row.is_group !== undefined && this.row.is_group;
            },
            onClick() {
                if (!this.isOpen) {
                    HTTP.get('data/index')
                        .then((response) => {
                            this.child = response.data;
                            this.isOpen = true;
                        });
                } else {
                    this.isOpen = false;
                    this.child = [];
                }
            },
            increaseDepth() {
                return this.depth + 1;
            },
            */
            getWidth(column) {
                return column.width || null
            },
            getAlign(column) {
                return column.align || 'left';
            },
            getCssClass(column) {
                return column.cssClass || null;
            },
            isTypeSerial(column) {
                return column.type == 'serial';
            },
            isTypeCheckbox(column) {
                return column.type == 'checkbox';
            },
            isTypeData(column) {
                return column.type == 'data';
            },
            isTypeButtons(column) {
                return column.type == 'buttons';
            }
        },
        filters: {
            test(value, depth) {
                return '-'.repeat(depth) + value
            }
        }
    }
</script>