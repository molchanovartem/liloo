<template>
    <div class="menu-blocks">
        <router-link :to="{name: 'appointmentManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Журнал</span>
        </router-link>
        <router-link :to="{name: 'userScheduleManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">График работы</span>
        </router-link>
        <router-link :to="{name: 'portfolioManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Портфолио</span>
        </router-link>
        <router-link :to="{name: 'userProfileView'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Профиль</span>
        </router-link>
        <router-link :to="{name: 'reviewManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Отзывы</span>
        </router-link>

        <h5>Справочник</h5>
        <ul>
            <li><router-link :to="{name: 'serviceManager'}">Услуги</router-link></li>
            <li><router-link :to="{name: 'serviceGroupManager'}">Группы услуг</router-link></li>
            <li><router-link :to="{name: 'masterManager'}">Мастера</router-link></li>
            <li><router-link :to="{name: 'salonManager'}">Салоны</router-link></li>
            <li><router-link :to="{name: 'clientManager'}">Клиенты</router-link></li>
        </ul>

        <h5 class="uk-heading-divider">Салоны</h5>
        <v-salon-items/>
    </div>
</template>

<script>
    import VSalonItems from './salonList/SalonItems.vue';

    export default {
        name: 'sidebar',
        components: {VSalonItems}
    }
</script>