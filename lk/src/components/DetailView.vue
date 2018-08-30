<template>
    <div>
        <table class="uk-table uk-table-small uk-table-striped">
            <tbody>
                <tr v-for="(value, param) in attributes">
                    <td><b>{{param}}</b></td>
                    <td>{{value}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: {
            attributes: {
                type: Object,
                required: true
            }
        }
    }
</script>