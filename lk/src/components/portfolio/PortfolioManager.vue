<template>
    <div>
        <router-link :to="{name: 'portfolioCreate', query: {salon_id: salonId}}">Создать</router-link>
        <div class="uk-margin">
            <div :id="params.sortableContainerId" class="uk-grid uk-grid-small uk-grid-match" uk-margin uk-sortable="handle: .portfolio-item_move">
                <portfolio-item v-for="(item, index) in items" :item="item" :index="index" :deleteItemHandler="deleteItem"/>
            </div>
        </div>
    </div>
</template>

<script>
    import PortfolioItem from './PortfolioItem.vue';

    let text = 'Портфолио';

    export default {
        props: {
          salonId: {
              type: String,
              default: null
          }
        },
        mounted() {
            this.$store.commit('setHeading', text);
            this.$store.commit('addBreadcrumbItems', [{label: text}]);
            this.loadData();
            this.initEventSortable();
        },
        components: {
            PortfolioItem
        },
        data() {
            return {
                params: {
                  sortableContainerId: 'pm_sortable_container'
                },
                items: []
            }
        },
        methods: {
            loadData() {
            },
            initEventSortable() {
                let sortable = document.getElementById(this.params.sortableContainerId);

                sortable.addEventListener('stop', (event) => {
                    let items = document.getElementById(this.params.sortableContainerId).children;

                    let itemsSort = [];
                    for (let i = 0; i < items.length; i++) {
                        let index = items[i].dataset.index;
                        itemsSort.push({id: this.items[index].id, sort: i});
                    }

                    if (itemsSort.length > 0) {
                        API.portfolioSetItemsSort(itemsSort);
                    }
                });
            },
            deleteItem(id) {
                let index = _.findIndex(this.items, {id: id});

                if (index !== -1 && confirm('Удалить?')) {
                    API.portfolioDelete(id, response => {
                        if (response.success) {
                            this.items.splice(index, 1);
                        }
                    });
                }
            }
        },
        watch: {
          salonId() {
              this.loadData();
          }
        }
    }
</script>