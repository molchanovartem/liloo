<template>
    <v-app>
        <router-view></router-view>
    </v-app>
</template>

<script>
    import {errorCollection} from "../js/errorCollection";
    import 'uikit';
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

    export default {
        created() {
            // Вешаем обработчик
            errorCollection.subscribe((category, error) => {
                if (category === errorCollection.CATEGORY_UNAUTHORIZED) {
                    this.$router.push({name: 'login'});
                }

                if (category === errorCollection.CATEGORY_GRAPHQL) {
                    alert('Ошибка запроса');
                }

                if (category === errorCollection.CATEGORY_VALIDATION) {
                    alert(error);
                }

                if (category === errorCollection.CATEGORY_ATTRIBUTE_VALIDATION) {
                    if (Array.isArray(error) && error.length > 0) {
                        error.forEach(item => {
                            if (typeof item === 'string') alert(item);
                        });
                    } else {
                        for (let param in error) {
                            if (typeof error[param] === 'string') alert(error[param]);

                            if (Array.isArray(error[param]) && error[param].length > 0) {
                                error[param].forEach(item => {
                                    if (typeof item === 'string') alert(item);
                                });
                            }
                        }
                    }
                }

            });
        },
        mounted() {
            // Загрузка настроек
            // Сетим настройки
            //
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