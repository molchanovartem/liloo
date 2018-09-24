<template>
    <div class="content-block p-40 content-block_shadow">
        <ul>
            <li>Баланс: {{account.balance}}</li>
            <li>Тариф: {{tariff.name}}</li>
            <li>Описание: {{tariff.description}}</li>
            <li>Длительность: {{tariff.price.day}} дней</li>
            <li>Количество использований: {{tariff.quantity}}</li>
            <li>Цена: {{tariff.price.price}}</li>
        </ul>
        <v-btn @click="onSubmit">Купить</v-btn>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "Checkout",
        props: {
            tariffId: {
                type: String,
                required: true,
            },
            priceId: {
                type: String,
                required: true
            }
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                account: {
                    balance: null
                },
                tariff: {
                    name: null,
                    description: null,
                    quantity: null,
                    price: {
                        price: null,
                        day: null
                    },
                }
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query ($tariffId: ID!, $priceId: ID!) {
                        account {balance},
                        tariff (id: $tariffId) {
                            id, name, description, type, quantity, price(id: $priceId) {id, price, day}
                        },
                    }`,
                    variables: {
                        tariffId: this.tariffId,
                        priceId: this.priceId
                    }
                }).then(({data}) => {
                    if (data.tariff) this.tariff = data.tariff;
                    if (data.account) this.account = data.account;
                });
            },
            onSubmit() {
                if (+this.account.balance < +this.tariff.price.price)  {
                    alert('Недостаточно средств');
                    return null;
                }

                this.$apollo.mutate({
                    mutation: gql`mutation ($priceId: ID!) {
                        tariffBuy(price_id: $priceId) {
                            id, tariff_id, price_id, start_date, end_date
                        }
                    }`,
                    variables: {
                        priceId: this.priceId
                    }
                }).then(({data}) => {
                    alert('Ok');
                    this.$router.push({name: 'tariffManager'});
                });
            }
        }
    }
</script>