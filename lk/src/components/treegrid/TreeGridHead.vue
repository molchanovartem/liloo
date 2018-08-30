<template>
    <thead>
    <tr>
        <th v-for="column in columns">
            {{column.label}}
        </th>
    </tr>
    </thead>
</template>

<script>
    export default {
        name: "TreeGridHead",
        props: {
            columns: {
                type: Array,
                required: true
            }
        }
    }
</script>