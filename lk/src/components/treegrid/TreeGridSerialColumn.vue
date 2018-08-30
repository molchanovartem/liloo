<template>
    <td>
        123
    </td>
</template>

<script>
    export default {
        name: "TreeGridSerialColumn",
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
    }
</script>