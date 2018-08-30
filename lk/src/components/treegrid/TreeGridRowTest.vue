<script>
    import TreeGridSerialColumn from './TreeGridSerialColumn.vue';
    import TreeGridCheckboxColumn from './TreeGridCheckboxColumn.vue';
    import TreeGridDataColumn from './TreeGridDataColumn.vue';
    import TreeGridButtonsColumn from './TreeButtonsColumn.vue';
    import {HTTP} from "../../js/http";

    export default {
        name: "TreeGridRowTest",
        props: ['rows', 'columns'],
        components: {
            TreeGridSerialColumn,
            TreeGridCheckboxColumn,
            TreeGridDataColumn,
            TreeGridButtonsColumn
        },
        render(createElement) {
            return createElement('tbody', this.rows.map((row, index) => {
                let self = this;

                return createElement('tr',
                    {
                        on: {
                            click() {
                                row.state  = 'open';
                                HTTP.get('data/index')
                                    .then((response) => {
                                        response.data.reverse().forEach(item => {
                                            self.rows.splice(index + 1, 0, item);
                                        });
                                    });
                            }
                        }
                    },

                    this.columns.map(column => {
                        if (this.isTypeSerial(column)) {
                            return createElement('tree-grid-serial-column', {props: {row: row, column: column}});
                        }

                        if (this.isTypeCheckbox(column)) {
                            return createElement('tree-grid-checkbox-column', {props: {row: row, column: column}});
                        }

                        if (this.isTypeData(column)) {
                            return createElement('tree-grid-data-column', {props: {row: row, column: column}});
                        }

                        if (this.isTypeButtons(column)) {
                            return createElement('tree-grid-buttons-column', {props: {row: row, column: column}});
                        }
                    })
                );
            }));
        },
        methods: {
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
        }
    }
</script>