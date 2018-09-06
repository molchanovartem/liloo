<template>
    <v-app>
        <v-header/>
        <div class="content-width content-columns">
            <div class="content-columns__column content-column__column_main">
                <router-view></router-view>
            </div>

            <div class="content-columns__column content-column__column_side">

                <div class="content-block content-block_shadow">
                    <v-sidebar/>
                </div>
            </div>
        </div>
    </v-app>
</template>

<script>
    import 'uikit';
    import VHeader from './Header.vue'
    import VSidebar from './components/Sidebar.vue';
    import VHeading from './components/Heading.vue';
    import VBreadcrumbs from './components/Breadcrumbs.vue';

    import 'uikit/dist/css/uikit.min.css';
    import '@mdi/font/css/materialdesignicons.min.css';
    import 'vuetify/dist/vuetify.min.css';
    import '../assets/css/slick.css';
    import '../assets/css/slick-theme.css';
    import '../assets/css/fonts.css';
    import '../assets/css/additional.css';
    import '../assets/css/elements.css';
    import '../assets/css/init.css';
    import '../assets/css/main.css';
    import '../assets/css/responsive.css';

    //import '../stylus/main.styl';

    export default {
        components: {
            VHeader, VSidebar, VHeading, VBreadcrumbs
        },
        mounted() {
            document.body.style.opacity = 1;
        }
    }
</script>

<style>
    .application .theme--light.v-text-field--outline .v-input__slot, .theme--light .v-text-field--outline .v-input__slot {
        border: 2px solid #E4EFF9 !important;
    }

    .v-datatable th {
        height: 70px;
    }

    .v-datatable td {
        height: 70px !important;
    }

    table.v-table tbody td:first-child, table.v-table tbody td:not(:first-child), table.v-table tbody th:first-child, table.v-table tbody th:not(:first-child), table.v-table thead td:first-child, table.v-table thead td:not(:first-child), table.v-table thead th:first-child, table.v-table thead th:not(:first-child) {
        padding: 0 10px;
    }
</style>