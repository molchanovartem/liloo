<template>
    <div>
        <ul v-if="items" class="uk-breadcrumb">
            <li v-for="item in items">
                <router-link :to="item.to" v-if="item.to">{{item.label}}</router-link>
                <span v-else>{{item.label}}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
          main: {
              type: Object,
              default: () => {return {
                  label: 'Главная',
                  url: '/'
              }}
          }
        },
        data() {
            return {}
        },
        computed: {
            items() {
                let breadcrumbItems = this.$store.state.breadcrumbItems;

                return breadcrumbItems ? [this.main].concat(this.$store.state.breadcrumbItems) : null;
            }
        }
    }
</script>