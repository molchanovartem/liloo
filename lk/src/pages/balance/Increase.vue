<template>
    <div class="content-block p-40 content-block_shadow">
        <v-text-field v-model="sum" label="Сумма"/>

        <v-btn @click="onSubmit">Ok</v-btn>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "BalanceIncrease",
        data() {
            return {
                sum: null
            };
        },
        methods: {
            onSubmit() {
                this.$apollo.mutate({
                    mutation: gql`mutation ($sum: Decimal) {
                        balanceIncrease (sum: $sum)
                    }`,
                    variables: {sum: this.sum}
                }).then(({data}) => {
                    if (data.balanceIncrease) alert ('Ok');
                });
            }
        }
    }
</script>