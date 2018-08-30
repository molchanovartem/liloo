<template>
    <td>
        <div v-if="isFormatHtml(column)" v-html="showValue(column)"></div>
        <div v-else>
            {{showValue(column)}}
        </div>
    </td>
</template>

<script>
    export default {
        name: "TreeGridDataColumn",
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
        methods: {
            isFormatHtml(column) {
                return column.format == 'html';
            },
            showValue(column) {
                if (column.value !== undefined) {
                    if (typeof column.value === 'function') {
                        return column.value(this.row);
                    } else {
                        return column.value;
                    }
                }
                return this.row[column.attribute];
            },
        }
    }
</script>