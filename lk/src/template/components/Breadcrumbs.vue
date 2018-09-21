<template>
    <div>
        <div class="row-categories">
            <div class="row-categories__item">
                <router-link :to="{name: 'home'}" class="row-categories__link">Главная</router-link>
            </div>
            <div class="row-categories__item" v-for="item in items">
                <router-link :to="item.to" v-if="item.to" class="row-categories__link">{{item.label}}</router-link>
                <a @click.prevent href="#" v-else class="row-categories__link">{{item.label}}</a>
            </div>
        </div>
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