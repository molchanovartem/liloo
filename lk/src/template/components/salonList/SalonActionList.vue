<template>
    <ul class="uk-list uk-margin-left">
        <li><router-link :to="{name: 'salonAppointment', params: {id: salon.id}}">Журнал</router-link></li>
        <li><router-link :to="{name: 'portfolioManager', query: {salon_id: salon.id}}">Портфолио</router-link></li>
        <li><router-link :to="{name: 'salonMasterManager', params: {id: salon.id}}">Мастера</router-link></li>
        <li><router-link :to="{name: 'masterScheduleManager', params: {id: salon.id}}">График работы мастеров</router-link></li>
        <li><router-link :to="{name: 'salonServiceManager', params: {id: salon.id}}">Услуги</router-link></li>
        <li>Настройки</li>
    </ul>
</template>

<script>
    export default {
        name: "SalonActionList",
        props: {
            salon: {
                type: Object,
                required: true
            }
        }
    }
</script>