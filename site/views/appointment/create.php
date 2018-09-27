<div class="uk-container">
    <div id="form">
        {{attributes.servicesId}}
        <div class="uk-grid uk-grid-small uk-grid-divider">
            <div class="uk-width-1-3 uk-first-column">
                <ul v-for="item in services" v-if="item.items.length > 0">{{item.specialization}}
                    <li v-for="service in item.items">
                        <div class="uk-float-left">
                            {{service.name}}
                        </div>
                        <div class="uk-float-right">
                            <input type="checkbox" :value="service.id" v-model="attributes.servicesId">
                        </div>
                    </li>
                </ul>
            </div>
            <div class="uk-width-2-3">
                <div>date</div>
                <div>time</div>
            </div>
        </div>
    </div>
</div>

<script>
    catalogFormInit(1234);

    function catalogFormInit(userId = null, salonId = null, date = null) {
        const SCENARIO_MASTER = 'master';
        const SCENARIO_SALON = 'salon';

        let wm = null;

        (() => {
            wm = new Vue({
                el: '#form',
                created() {
                    if (userId) this.scenario = SCENARIO_MASTER;
                    else if (salonId) this.scenario = SCENARIO_SALON;

                    this.attributes.userId = userId;
                    this.attributes.salonId = salonId;
                    this.attributes.date = date;
                },
                beforeMount() {
                    this.loadServices();
                },
                data: {
                    scenario: null,
                    services: [],
                    masters: [],

                    attributes: {
                        userId: null,
                        salonId: null,
                        masterId: null,
                        date: null,
                        time: null,
                        servicesId: [],
                    }
                },
                methods: {
                    loadServices() {
                        if (this.isScenarioMaster()) {
                            this.services = [
                                {
                                    specialization: 'Стрижка', items: [
                                        {id: 1, specialization_id: 1, name: 'Канадка', price: 200, duration: 20},
                                        {
                                            id: 3,
                                            specialization_id: 1,
                                            name: 'Покраска волос',
                                            price: 1500,
                                            duration: 120
                                        },
                                    ]
                                },
                                {
                                    specialization: 'Ногти', items: [
                                        {id: 2, specialization_id: 2, name: 'Маникюр', price: 300, duration: 40},
                                    ]
                                },
                            ];
                        }
                    },
                    isScenarioMaster() {
                        return this.scenario === SCENARIO_MASTER;
                    },
                    isScenarioSalon() {
                        return this.scenario === SCENARIO_SALON;
                    }
                }
            })
        })();
    }
</script>