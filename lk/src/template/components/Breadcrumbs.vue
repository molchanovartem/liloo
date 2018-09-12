<template>
    <div>
        <ul class="uk-breadcrumb">
            <li>
                <router-link :to="{name: 'home'}">Главная</router-link>
            </li>
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
        mounted() {
            console.log(this.$route);
        },
        computed: {
            items() {
                let breadcrumbs = this.$route.meta && this.$route.meta.breadcrumbs ? this.$route.meta.breadcrumbs : null,
                    items = [];

                if (typeof breadcrumbs === 'function') {
                    items = breadcrumbs(this.$route);
                } else {
                    items = breadcrumbs;
                }
                return items;
            }
        }
    }
</script>