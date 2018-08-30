<template>
    <div>
        <!--
        <table :class="cssClass">
            <tree-grid-head :columns="columns"/>
            <tbody>
            <tree-grid-row
                    :row="row"
                    v-for="(row, index) in rows"
            />
            </tbody>
        </table>
        -->

        <table :class="cssClass">
            <tree-grid-head :columns="columns"/>
            <tree-grid-row-test :rows="rows" :columns="columns"/>
        </table>
    </div>
</template>

<script>
    import TreeGridHead from './TreeGridHead.vue';
    import TreeGridRow from './TreeGridRow.vue';
    import TreeGridRowTest from './TreeGridRowTest.vue';
    import {HTTP} from "../../js/http";
    import {TREE_GRID_SERVICE} from "./TreeGridService";

    export default {
        name: "TreeGrid",
        props: {
            columns: {
                type: Array,
                required: true
            },
            groupAttribute: {
                type: String,
                required: true
            },
            url: {
                type: String,
                required: true
            },
            cssClass: {
                type: String,
                default: null
            },
            singleSelected: {
                type: Boolean,
                default: false
            }
        },
        components: {
            TreeGridHead, TreeGridRow, TreeGridRowTest
        },
        created() {
            this.normalizeColumns();
            this.loadRows();

            /*
            TREE_GRID_SERVICE.groupAttribute = this.groupAttribute;
            TREE_GRID_SERVICE.singleSelected = this.singleSelected;
            TREE_GRID_SERVICE.init();
            */
        },
        data() {
            return {
                rows: []
            }
        },
        methods: {
            loadRows() {
                let self = this;

                HTTP.get(this.url)
                    .then((response) => {
                        self.rows = response.data;
                    });
            },
            normalizeColumns() {
                this.columns.forEach(column => {
                    if (column.label === undefined) {
                        column.label = '';
                    }
                    if (column.format === undefined) {
                        column.format = 'raw';
                    }
                    if (column.type === undefined) {
                        column.type = 'data';
                    }
                });
            },
            getGroupSelected() {
                //Object.keys(this.rowsGroupSelected);
            },
            getItemSelected() {
                //Object.keys(this.rowsItemSelected);
            }
        }
    }
</script>