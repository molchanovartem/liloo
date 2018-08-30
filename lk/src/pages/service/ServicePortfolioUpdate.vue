<template>
    <div>
        <service-portfolio-form></service-portfolio-form>
    </div>
</template>

<script>
    import ServicePortfolioForm from './ServicePortfolioForm';

    let text = 'Портфолио';

    export default {
        mounted() {
            this.$store.commit('setHeading', text);
            this.$store.commit('addBreadcrumbItems', [{label: 'Услуги', url: '/service/manager'}, {label: text}]);
        },
        components: {
            ServicePortfolioForm
        }
    }
</script>