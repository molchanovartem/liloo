<template>
    <div>
        <h1>dashboard</h1>
        <ul>
            <li>
                Схемы
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$store.commit('setHeading', null);
            this.$store.commit('addBreadcrumbItems', null);
        }
    }
</script>