<template>
    <div class="menu-blocks">
        <router-link :to="{name: 'appointmentList'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Записи</span>
        </router-link>
        <router-link :to="{name: 'appointmentManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Журнал</span>
        </router-link>
        <router-link :to="{name: 'userScheduleManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">График работы</span>
        </router-link>
        <router-link class="menu-blocks__item" :to="{name: 'serviceManager'}">
            <span class="menu-blocks__item-name">Услуги</span>
        </router-link>
        <router-link class="menu-blocks__item" :to="{name: 'clientManager'}">
            <span class="menu-blocks__item-name">Клиенты</span>
        </router-link>
<!--        <router-link :to="{name: 'portfolioManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Портфолио</span>
        </router-link>-->
  <!--      <router-link :to="{name: 'reviewManager'}" class="menu-blocks__item">
            <span class="menu-blocks__item-name">Отзывы</span>
        </router-link>-->

        <div class="uk-text-center uk-margin-large-top"><h4>Справочник</h4></div>
        <hr/>
        <div class="menu-blocks">
            <!--<li><router-link :to="{name: 'serviceGroupManager'}">Группы услуг</router-link></li>-->
            <router-link class="menu-blocks__item" :to="{name: 'masterManager'}">
                <span class="menu-blocks__item-name">Мастера</span>
            </router-link>
            <router-link class="menu-blocks__item" :to="{name: 'salonManager'}">
                <span class="menu-blocks__item-name">Салоны</span>
            </router-link>
        </div>

        <div class="uk-text-center uk-margin-large-top"><h4>Салоны</h4></div>
        <hr/>
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