<template>
    <div>
        <ul>
            <li>
                <a href="#" @click.prevent="selectedMaster(null)">Все</a>
            </li>
            <li v-for="master in masters">
                <a href="#" @click.prevent="selectedMaster(master.id)">{{master.name}} id: {{master.id}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "MasterList",
        props: {
            masters: {
                type: Array,
                required: true
            }
        },
        methods: {
            selectedMaster(masterId) {
                this.$router.push({query: {master_id: masterId}});
            }
        },
    }
</script>