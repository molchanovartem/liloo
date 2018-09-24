<template>
    <div class="uk-card uk-card-default uk-card-hover uk-box-shadow-medium">
        <div class="uk-card-header uk-padding-small">
            <h4 class="uk-card-title">{{item.name}}</h4>
        </div>
        <div class="uk-card-body uk-padding-small uk-height-small uk-position-relative">
            <p>
                {{item.description}}
            </p>
            <div class="uk-position-bottom uk-position-small">
                <v-select v-model="selected" :items="priceList"/>
            </div>
        </div>
        <div class="uk-card-footer uk-padding-small">
            <v-btn :disabled="selected === null" @click="onSubmit">Купить</v-btn>
        </div>
    </div>
</template>

<script>
    import {commonFilters} from "../../js/mixins/commonFilters";

    export default {
        name: "ListItem",
        props: {
            item: {
                type: Object,
                required: true
            }
        },
        mixins: [commonFilters],
        mounted() {
            if (this.item.prices.length > 0) this.selected = this.item.prices[0].id;

            this.item.prices.forEach(item => {
                this.priceList.push({
                    text: item.price + ' руб. (' + item.day +' дней)',
                    value: item.id
                });
            });
        },
        data() {
            return {
                selected: null,
                priceList: []
            };
        },
        methods: {
            onSubmit() {
                this.$router.push({name: 'tariffCheckout', query: {tariff_id: this.item.id, price_id: this.selected}});
            }
        }
    }
</script>