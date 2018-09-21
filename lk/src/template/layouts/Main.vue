<template>
    <div>
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
    </div>
</template>

<script>
    import VHeader from '../Header.vue'
    import VSidebar from '../components/Sidebar.vue';
    import VHeading from '../components/Heading.vue';

    export default {
        name: "MainLayout",
        components: {
            VHeader, VSidebar, VHeading
        },
    }
</script>