<template>
    <div>
        <div><router-link :to="{name: 'salonAppointment', params: {id: salon.id}}">Журнал</router-link></div>
        <!--<li><router-link :to="{name: 'portfolioManager', query: {salon_id: salon.id}}">Портфолио</router-link></li>-->
        <div><router-link :to="{name: 'salonMasterManager', params: {id: salon.id}}">Мастера</router-link></div>
        <div><router-link :to="{name: 'masterScheduleList', params: {id: salon.id}}">График работы мастеров</router-link></div>
        <div><router-link :to="{name: 'salonServiceManager', params: {id: salon.id}}">Услуги</router-link></div>
        <div>Настройки</div>
    </div>
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